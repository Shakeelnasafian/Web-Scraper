<?php

namespace App\Http\Controllers;

use App\Contracts\NewsSourceInterface;
use App\Services\BBC\BBCNewsService;
use App\Services\Guardian\GuardianNewsService;
use App\Services\NewsApi\NewsApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        private NewsApiService $newsApiService,
        private GuardianNewsService $guardianService,
        private BBCNewsService $bbcService,
    ) {}

    // GET /api/news - Fetch from NewsAPI
    public function index(Request $request): JsonResponse
    {
        return $this->fetchAndRespond($this->newsApiService, [
            'category' => $request->get('category', 'general'),
            'language' => $request->get('language', 'en'),
        ], 'Failed to fetch NewsAPI articles');
    }

    // GET /api/bbc - Fetch BBC News
    public function bbc(Request $request): JsonResponse
    {
        return $this->fetchAndRespond($this->bbcService, [
            'language' => $request->get('language', 'en'),
        ], 'Failed to fetch BBC news');
    }

    // GET /api/guardian - Fetch Guardian News
    public function guardian(Request $request): JsonResponse
    {
        return $this->fetchAndRespond($this->guardianService, [
            'category' => $request->get('category'),
            'language' => $request->get('language', 'en'),
        ], 'Failed to fetch Guardian news');
    }

    private function fetchAndRespond(NewsSourceInterface $service, array $params, string $errorMessage): JsonResponse
    {
        $articles = $service->fetchArticles($params);
        $formatted = array_map(fn($dto) => $dto->toArray(), $articles);

        if ($formatted) {
            return response()->json($formatted);
        }

        return response()->json(['error' => $errorMessage], 500);
    }
}
