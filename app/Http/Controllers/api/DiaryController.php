<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessDiaryAIResponse;
use App\Models\Diary;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DiaryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'content' => 'required_without:audio|string|max:5000',
                'audio' => 'required_without:content|file|mimes:mp3,wav,m4a|max:10240'
            ]);

            if ($request->hasFile('audio')) {
                $audioPath = $request->file('audio')->store('temp');
                $response = OpenAI::audio()->transcribe([
                    'model' => 'whisper-1',
                    'file' => fopen(storage_path('app/' . $audioPath), 'r'),
                    'language' => 'id'
                ]);
                $content = $response->text;
            } else {
                $content = $validated['content'];
            }

            $diary = Diary::create([
                'content' => $content,
                'user_id' => $request->user()->id,
                'is_processed' => false
            ]);

            $diary->load('user');
            ProcessDiaryAIResponse::dispatch($diary);

            return $this->success($diary, 'Diary berhasil dibuat, analisis AI sedang diproses');

        } catch (Exception $e) {
            Log::error('Diary error: ' . $e->getMessage());
            return $this->error($e->getMessage(), 'Gagal memproses diary', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $diaries = Diary::where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return $this->success($diaries, 'Diaries retrieved successfully');
        } catch (Exception $e) {
            Log::error('Get diaries error: ' . $e->getMessage());
            return $this->error(null, 'Failed to get diaries', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request, Diary $diary): JsonResponse
    {
        try {
            if ($diary->user_id !== $request->user()->id) {
                return $this->error(null, 'Unauthorized access', Response::HTTP_FORBIDDEN);
            }

            $diary->load('user');

            return $this->success($diary, 'Diary retrieved successfully');
        } catch (Exception $e) {
            Log::error('Show diary error: ' . $e->getMessage());
            return $this->error(null, 'Failed to retrieve diary', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function success($data, string $message, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    private function error($errors, string $message, int $code): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}