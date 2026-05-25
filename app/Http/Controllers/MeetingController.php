<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\MeetingDokumentasi;
use Barryvdh\DomPDF\Facade\Pdf;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::with(['creator'])
            ->withCount('questions');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $sort = $request->input('sort', 'desc');
        $query->orderBy('tanggal', in_array($sort, ['asc', 'desc']) ? $sort : 'desc');

        $meetings = $query->paginate(10)->withQueryString();
        $totalAll = Meeting::count();

        return view('meetings.index', compact('meetings', 'totalAll'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'notulis') {
            abort(403);
        }
        return view('meetings.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'notulis') {
            abort(403);
        }

        $request->validate([
            'judul'           => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'waktu'           => 'required',
            'lokasi'          => 'required|string|max:255',
            'jenis'           => 'required|string|max:255',
            'topik'           => 'nullable|string',
            'partisipan'      => 'nullable|string',
            'notulensi'       => 'nullable|string',
            'dokumentasi'     => 'nullable|array',
            'dokumentasi.*'   => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            // ── Surat Undangan ──────────────────────────────────────
            'surat_undangan'  => 'nullable|file|mimes:pdf|max:5120', // maks 5 MB
        ]);

        $suratPath = null;
        $suratNama = null;
        if ($request->hasFile('surat_undangan')) {
            $file      = $request->file('surat_undangan');
            $suratPath = $file->store('surat_undangan', 'public');
            $suratNama = $file->getClientOriginalName();
        }

        // Status otomatis 'completed' hanya jika notulensi sudah diedit dari template default.
        // Normalisasi: hapus semua whitespace agar perbedaan spasi/newline dari TinyMCE diabaikan.
        $notulensiDefault = '<h2><strong>Latar Belakang</strong></h2><p>Uraikan latar belakang dan tujuan diselenggarakannya rapat ini.</p><h2><strong>Peserta Rapat</strong></h2><p>Daftar peserta yang hadir dalam rapat ini.</p><h2><strong>Isi Rapat</strong></h2><h3>1. Pembahasan Agenda Pertama</h3><p>Uraikan hasil pembahasan agenda pertama secara singkat dan jelas.</p><h3>2. Pembahasan Agenda Kedua</h3><p>Uraikan hasil pembahasan agenda kedua secara singkat dan jelas.</p><h2><strong>Kesimpulan</strong></h2><p>Tuliskan kesimpulan dan tindak lanjut yang disepakati dalam rapat.</p>';
        $normalize        = fn(string $s): string => preg_replace('/\s+/', '', $s);
        $submitted        = $normalize($request->notulensi ?? '');
        $isDefault        = $submitted === '' || $submitted === $normalize($notulensiDefault);
        $status           = $isDefault ? 'scheduled' : 'completed';

        $meeting = Meeting::create([
            'judul'               => $request->judul,
            'tanggal'             => $request->tanggal,
            'waktu'               => $request->waktu,
            'lokasi'              => $request->lokasi,
            'jenis'               => $request->jenis,
            'topik'               => $request->topik,
            'partisipan'          => $request->partisipan,
            'notulensi'           => $request->notulensi,
            'status'              => $status,
            'created_by'          => auth()->id(),
            'creator_name'        => auth()->user()->name,
            'notulen'             => auth()->id(),
            'notulen_name'        => auth()->user()->name,
            // ── Surat Undangan ──────────────────────────────────────
            'surat_undangan'      => $suratPath,
            'surat_undangan_nama' => $suratNama,
        ]);

        // Simpan foto dokumentasi jika ada
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                MeetingDokumentasi::create([
                    'meeting_id' => $meeting->id,
                    'nama_file'  => $file->getClientOriginalName(),
                    'path_file'  => $path,
                ]);
            }
        }

        return redirect()->route('meetings.index')->with('success', 'Rapat Berhasil Dibuat');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load([
            'questions.user',
            'questions.replies.user'
        ]);
        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $this->authorize('update', $meeting);
        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $request->validate([
            'judul'           => 'required|string|max:255',
            'tanggal'         => 'required|date',
            'waktu'           => 'required',
            'lokasi'          => 'required|string|max:255',
            'jenis'           => 'nullable|string|max:255',
            'topik'           => 'nullable|string',
            'partisipan'      => 'nullable|string',
            'notulensi'       => 'nullable|string',
            'status'          => 'required|in:scheduled,completed',
            'dokumentasi'     => 'nullable|array',
            'dokumentasi.*'   => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            // ── Surat Undangan ──────────────────────────────────────
            'surat_undangan'  => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $updateData = [
            'judul'      => $request->judul,
            'tanggal'    => $request->tanggal,
            'waktu'      => $request->waktu,
            'lokasi'     => $request->lokasi,
            'jenis'      => $request->jenis,
            'topik'      => $request->topik,
            'partisipan' => $request->partisipan,
            'notulensi'  => $request->notulensi,
            'status'     => $request->status,
        ];

        // Jika ada file surat baru diunggah → hapus lama, simpan baru
        if ($request->hasFile('surat_undangan')) {
            if ($meeting->surat_undangan) {
                \Storage::disk('public')->delete($meeting->surat_undangan);
            }
            $file = $request->file('surat_undangan');
            $updateData['surat_undangan']      = $file->store('surat_undangan', 'public');
            $updateData['surat_undangan_nama'] = $file->getClientOriginalName();
        }

        $meeting->update($updateData);

        // Simpan foto dokumentasi baru jika ada
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $file) {
                $path = $file->store('dokumentasi', 'public');
                MeetingDokumentasi::create([
                    'meeting_id' => $meeting->id,
                    'nama_file'  => $file->getClientOriginalName(),
                    'path_file'  => $path,
                ]);
            }
        }

        return redirect()->route('meetings.index')
            ->with('success', 'Rapat berhasil diupdate');
    }

    /**
     * Hapus surat undangan dari sebuah rapat.
     * Route: DELETE /meetings/{meeting}/surat
     * Name:  meetings.surat.delete
     */
    public function deleteSurat(Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        if ($meeting->surat_undangan) {
            \Storage::disk('public')->delete($meeting->surat_undangan);
        }

        $meeting->update([
            'surat_undangan'      => null,
            'surat_undangan_nama' => null,
        ]);

        return back()->with('success', 'Surat undangan berhasil dihapus');
    }

    public function destroy(Meeting $meeting)
    {
        // Hanya notulis yang membuat rapat ini yang boleh menghapus
        if (auth()->id() !== $meeting->created_by) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus rapat ini.');
        }

        // Hapus surat undangan jika ada
        if ($meeting->surat_undangan) {
            \Storage::disk('public')->delete($meeting->surat_undangan);
        }

        // Hapus semua foto dokumentasi
        foreach ($meeting->dokumentasi as $dok) {
            \Storage::disk('public')->delete($dok->path_file);
            $dok->delete();
        }

        $meeting->delete();

        return redirect()->route('meetings.index')
            ->with('success', 'Rapat berhasil dihapus.');
    }

    public function exportPdf(Meeting $meeting)
    {
        $pdf = Pdf::loadView('meetings.pdf', compact('meeting'));
        return $pdf->download('notulensi-' . $meeting->judul . '.pdf');
    }

    public function deleteDokumentasi(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $dok = MeetingDokumentasi::where('id', $request->dok_id)
                                ->where('meeting_id', $meeting->id)
                                ->firstOrFail();

        \Storage::disk('public')->delete($dok->path_file);
        $dok->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}