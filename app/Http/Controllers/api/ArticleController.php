<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $articles = Article::query()
                ->where('is_published', true)
                ->select('id', 'title', 'slug', 'content', 'image_url', 'views_count', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();
            return $this->success($articles, 'Articles Retrieved Successfully!');
        } catch (Exception $e) {
            Log::error('Get articles error: ' . $e->getMessage());
            return $this->error(null, 'Failed to Get Articles!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Article $article): JsonResponse
    {
        try {
            if (!$article->is_published) {
                return $this->error(null, 'Article Not Found!', Response::HTTP_NOT_FOUND);
            }
            $article->increment('views_count');
            return $this->success($article, 'Article Retrieved Successfully!');
        } catch (Exception $e) {
            Log::error('Get article error: ' . $e->getMessage());
            return $this->error(null, 'Failed to Get Article!', Response::HTTP_INTERNAL_SERVER_ERROR);
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
