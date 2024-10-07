<?php

namespace App\Observers\Pokemon;



use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use GuzzleHttp\Client;


class PokemonGenerationScraperObserver extends CrawlObserver
{

    private $content;
    private $client;

    public function __construct()
    {
        $this->content = null;
        $this->client = new Client([
            'verify' => false,
        ]);
    }

    /*
     * Called when the crawler will crawl the url.
     */
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        Log::info('willCrawl', ['url' => $url]);
    }

    /*
     * Called when the crawler has crawled the given url successfully.
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
      $crawler = new Crawler((string) $response->getBody());

        Log::info("Crawled: {$url}" );
        // Log::info("Data: " .substr($fetchedData, 0, 500));

        $tableHtml = $crawler->filter('h3')->reduce(function (Crawler $node) {
          return str_contains((string) $node, 'Generation I');
      })->nextAll()->filter('table')->first()->html();

      
    //   $pokemonData = collect($tableHtml->filter('tr')->each(function (Crawler $tr, $i) {
    //     if (!$tr->filter('th')->count()) {
    //         return (object) [
    //             'name' => $tr->filter('td')->eq(2)->text(),
    //             'image' => $tr->filter('td img')->attr('src')
    //         ];
    //     }
    //     return null;
    // }))->filter()->values();

    echo $tableHtml;
    }

    /*
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::error("Failed: {$url}");
        Log::info("Message: {$requestException}");
    }

    /*
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        Log::info("Finished crawling");
        
    }


}