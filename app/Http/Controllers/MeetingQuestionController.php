<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingQuestionRequest;
use App\Http\Requests\ReplyMeetingQuestionRequest;
use App\Models\Meeting;
use App\Models\MeetingQuestion;

class MeetingQuestionController extends Controller
{
    public function store(StoreMeetingQuestionRequest $request, Meeting $meeting)
    {
        // Otorisasi & validasi sudah ditangani StoreMeetingQuestionRequest

        $question = MeetingQuestion::create([
            'meeting_id' => $meeting->id,
            'user_id'    => auth()->id(),
            'user_name'  => auth()->user()->name,
            'isi'        => strip_tags($request->isi), // pertanyaan plain text, tidak perlu HTML
            'parent_id'  => null,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'question' => [
                    'id'               => $question->id,
                    'isi'              => $question->isi,
                    'user_name'        => $question->user_name,
                    'created_at_human' => $question->created_at->format('d M Y, H:i'),
                ],
            ], 201);
        }

        return back()->with('success', 'Pertanyaan berhasil dikirim.');
    }

    public function reply(ReplyMeetingQuestionRequest $request, MeetingQuestion $question)
    {
        // Otorisasi & validasi sudah ditangani ReplyMeetingQuestionRequest

        $reply = MeetingQuestion::create([
            'meeting_id' => $question->meeting_id,
            'user_id'    => auth()->id(),
            'user_name'  => auth()->user()->name,
            'isi'        => strip_tags($request->isi), // jawaban plain text, tidak perlu HTML
            'parent_id'  => $question->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'reply' => [
                    'id'               => $reply->id,
                    'isi'              => $reply->isi,
                    'user_name'        => $reply->user_name,
                    'created_at_human' => $reply->created_at->format('d M Y, H:i'),
                ],
            ], 201);
        }

        return back()->with('success', 'Jawaban berhasil dikirim.');
    }
}