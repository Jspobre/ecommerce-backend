<?php

namespace App\Http\Controllers\Pokemon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Observers\Pokemon\PokemonGenerationScraperObserver;
use Spatie\Crawler\Crawler;


class PokemonGenerationScraperController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $url = "https://bulbapedia.bulbagarden.net/wiki/List_of_Pok%C3%A9mon_by_National_Pok%C3%A9dex_number";
    
        try {
            Crawler::create()
                ->setCrawlObserver(new PokemonGenerationScraperObserver())
                ->setMaximumDepth(0)
                ->setTotalCrawlLimit(1)
                ->startCrawling($url);
    
            return response()->json(['message' => 'Crawling finished successfully']);
        } catch (\Exception $e) {
            \Log::error('Crawling failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Crawling failed', 'error' => $e->getMessage()], 500);
        }
    }
    
}
