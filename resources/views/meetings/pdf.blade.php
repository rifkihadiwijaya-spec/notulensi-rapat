<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notulensi – {{ $meeting->judul }}</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 10pt;
      color: #000000;
      background: #ffffff;
      line-height: 1.6;
      margin: 25mm 28mm 28mm 28mm;
    }

    @page {
      margin: 25mm 28mm 28mm 28mm;
    }

    /* ── Footer ── */
    .footer {
      position: fixed;
      bottom: -20mm;
      left: 0; right: 0;
      border-top: 0.5px solid #000000;
      padding-top: 5px;
    }
    .footer table { width: 100%; border-collapse: collapse; }
    .footer td { font-size: 7.5pt; color: #555555; padding: 0; }
    .footer td:last-child { text-align: right; }

    /* ── Judul ── */
    .judul-wrap {
      text-align: center;
      margin-bottom: 22px;
      padding: 16px 0 18px;
      border-bottom: 0.5px solid #cccccc;
    }
    .judul-wrap .doc-label {
      font-size: 7pt;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #666666;
      margin-bottom: 7px;
    }
    .judul-wrap .judul {
      font-size: 15pt;
      font-weight: bold;
      color: #000000;
      line-height: 1.3;
    }

    /* ── Info ── */
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 22px;
      font-size: 9.5pt;
    }
    .info-table tr { border-bottom: 0.5px solid #e8e8e8; }
    .info-table tr:last-child { border-bottom: none; }
    .info-table td { padding: 6px 0; vertical-align: top; }
    .info-label { width: 110px; color: #555555; font-size: 8.5pt; }
    .info-sep   { width: 12px; color: #999999; }
    .info-value { font-weight: bold; color: #000000; }
    .info-value.normal { font-weight: normal; color: #111111; }

    /* ── Section Title ── */
    .section-title {
      font-size: 7.5pt;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #000000;
      border-bottom: 1px solid #000000;
      padding-bottom: 5px;
      margin-bottom: 12px;
      margin-top: 26px;
    }

    /* ── Partisipan ── */
    .partisipan-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 9pt;
    }
    .partisipan-table th {
      text-align: left;
      font-size: 7.5pt;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #000000;
      padding: 6px 8px;
      border-top: 0.5px solid #000000;
      border-bottom: 0.5px solid #000000;
      background: #f5f5f5;
    }
    .partisipan-table th:first-child { width: 24px; text-align: center; }
    .partisipan-table td {
      padding: 7px 8px;
      border-bottom: 0.5px solid #e8e8e8;
      vertical-align: top;
    }
    .partisipan-table td:first-child { text-align: center; color: #888888; font-size: 8pt; }
    .partisipan-table tr:last-child td { border-bottom: 0.5px solid #000000; }

    .td-nama    { font-weight: bold; color: #000000; }
    .td-detail  { font-size: 8.5pt; color: #444444; }

    .peran-pill {
      font-size: 7.5pt;
      font-weight: bold;
      padding: 2px 8px;
      border-radius: 2px;
      display: inline-block;
      border: 0.5px solid #888888;
      color: #000000;
      background: #ffffff;
    }

    /* ── Notulensi ── */
    .notulensi-wrap {
      font-size: 10pt;
      color: #111111;
      line-height: 1.8;
    }
    .notulensi-wrap h1 { font-size: 12pt; color: #000000; font-weight: bold; margin: 16px 0 6px; }
    .notulensi-wrap h2 { font-size: 11pt; color: #000000; font-weight: bold; margin: 14px 0 5px; }
    .notulensi-wrap h3 { font-size: 10pt; color: #000000; font-weight: bold; margin: 10px 0 4px; }
    .notulensi-wrap p  { margin: 0 0 8px; }
    .notulensi-wrap ul,
    .notulensi-wrap ol { margin: 4px 0 10px 22px; }
    .notulensi-wrap li { margin-bottom: 4px; }
    .notulensi-wrap strong { color: #000000; }
    .notulensi-wrap table {
      width: 100%;
      border-collapse: collapse;
      margin: 10px 0;
      font-size: 9.5pt;
    }
    .notulensi-wrap table td,
    .notulensi-wrap table th {
      border: 0.5px solid #999999;
      padding: 6px 9px;
    }
    .notulensi-wrap table th {
      background: #f0f0f0;
      font-weight: bold;
      color: #000000;
    }

    .empty {
      color: #888888;
      font-size: 9pt;
      font-style: italic;
      padding: 12px 0;
    }

    /* ── Divider ── */
    .divider {
      border: none;
      border-top: 0.5px solid #cccccc;
      margin: 4px 0;
    }
  </style>
</head>
<body>

{{-- Footer tiap halaman --}}
<div class="footer">
  <table><tr>
    <td>Notulensi Rapat &mdash; {{ $meeting->judul }}</td>
    <td>Dicetak {{ \Carbon\Carbon::now()->setTimezone('Asia/Makassar')->format('d M Y, H:i') }} WITA</td>
  </tr></table>
</div>

{{-- Judul --}}
<div class="judul-wrap">
  <div class="doc-label">Notulensi Rapat</div>
  <div class="judul">{{ $meeting->judul }}</div>
</div>

{{-- Info --}}
<table class="info-table">
  <tr>
    <td class="info-label">Tanggal</td>
    <td class="info-sep">:</td>
    <td class="info-value">{{ \Carbon\Carbon::parse($meeting->tanggal)->translatedFormat('l, d F Y') }}</td>
    <td style="width:32px;"></td>
    <td class="info-label">Waktu</td>
    <td class="info-sep">:</td>
    <td class="info-value">{{ \Carbon\Carbon::parse($meeting->waktu)->format('H:i') }} WITA</td>
  </tr>
  <tr>
    <td class="info-label">Lokasi</td>
    <td class="info-sep">:</td>
    <td class="info-value normal" colspan="5">{{ $meeting->lokasi }}</td>
  </tr>
  @if($meeting->jenis)
  <tr>
    <td class="info-label">Jenis</td>
    <td class="info-sep">:</td>
    <td class="info-value normal" colspan="5">{{ $meeting->jenis }}</td>
  </tr>
  @endif
  @if($meeting->topik)
  <tr>
    <td class="info-label">Topik</td>
    <td class="info-sep">:</td>
    <td class="info-value normal" colspan="5">{{ $meeting->topik }}</td>
  </tr>
  @endif
  <tr>
    <td class="info-label">Notulis</td>
    <td class="info-sep">:</td>
    <td class="info-value normal" colspan="5">{{ $meeting->display_notulen_name }}</td>
  </tr>
</table>

{{-- Partisipan --}}
@php
  $partisipanRows = [];
  if ($meeting->partisipan) {
    $decoded = json_decode($meeting->partisipan, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
      $partisipanRows = array_values(array_filter($decoded, fn($r) =>
        !empty($r['nama']) || !empty($r['peran'])
      ));
    }
  }
@endphp

@if(count($partisipanRows))
<div class="section-title">Daftar Partisipan</div>
<table class="partisipan-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th style="width:130px;">Peran</th>
      <th style="width:130px;">Jabatan</th>
      <th style="width:145px;">Bidang / Unit Kerja</th>
    </tr>
  </thead>
  <tbody>
    @foreach($partisipanRows as $i => $p)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td class="td-nama">{{ $p['nama'] ?? '—' }}</td>
      <td>
        @if(!empty($p['peran']))
          <span class="peran-pill">{{ $p['peran'] }}</span>
        @else
          <span style="color:#cccccc;">—</span>
        @endif
      </td>
      <td class="td-detail">{{ $p['jabatan'] ?? '—' ?: '—' }}</td>
      <td class="td-detail">{{ $p['bidang'] ?? '—' ?: '—' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endif

{{-- Notulensi --}}
<div class="section-title">Notulensi Rapat</div>
@if($meeting->notulensi)
  <div class="notulensi-wrap">{!! $meeting->notulensi !!}</div>
@else
  <div class="empty">Notulensi belum tersedia.</div>
@endif

</body>
</html>