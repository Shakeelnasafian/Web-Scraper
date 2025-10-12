<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BBC\BBCNewsService;
use App\Services\NewsApi\NewsApiService;
use App\Services\Guardian\GuardianNewsService;

class NewsController extends Controller
{
    protected NewsApiService $newsApiService;
    protected GuardianNewsService $guardianService;
    protected BBCNewsService $bbcService;

    public function __construct(NewsApiService $newsApiService, GuardianNewsService $guardianService, BBCNewsService $bbcService)
    {
        $this->newsApiService = $newsApiService;
        $this->guardianService = $guardianService;
        $this->bbcService = $bbcService;
    }

    public function index(Request $request)
    {
        $params = [
            'category' => $request->get('category', 'general'),
            'language' => $request->get('language', 'en'),
        ];

        $articles = $this->newsApiService->fetchArticles($params);
        
        $formatted = array_map(fn($dto) => $dto->toArray(), $articles);

        if ($formatted) {
            return response()->json($formatted);
        }

        return response()->json(['error' => 'Failed to fetch BBC news'], 500);
    }

    public function bbc(Request $request)
    {
        $params = [
            'sources' => 'bbc-news',
            'language' => $request->get('language', 'en'),
        ];

        $articles = $this->bbcService->fetchArticles($params);

        $formatted = array_map(fn($dto) => $dto->toArray(), $articles);

        if ($formatted) {
            return response()->json($formatted);
        }

        return response()->json(['error' => 'Failed to fetch BBC news'], 500);
    }

    public function guardian(Request $request)
    {
        $params = [
            'sources' => 'the-guardian-uk',
            'language' => $request->get('language', 'en'),
        ];

        // Step 2. Fetch & normalize the data
        $articles = $this->guardianService->fetchArticles($params);

        $formatted = array_map(fn($dto) => $dto->toArray(), $articles);

        if ($formatted) {
            return response()->json($formatted);
        }

        return response()->json(['error' => 'Failed to fetch Guardian news'], 500);
    }
}
