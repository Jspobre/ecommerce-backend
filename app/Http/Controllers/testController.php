<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;


use Illuminate\Http\Request;

class testController extends Controller
{
  public function fetchData()
  {
      // Create a new Guzzle client
      $client = new Client();

      $response = $client->request('GET', 'https://bulbapedia.bulbagarden.net/wiki/List_of_Pok%C3%A9mon_by_National_Pok%C3%A9dex_number');

      // Get the body content of the response
      $html = $response->getBody()->getContents();

      // Optionally decode JSON if the response is in JSON format
      // $data = json_decode($content, true);

            // Step 2: Load the HTML into DOMDocument
            $dom = new \DOMDocument();
            @$dom->loadHTML($html); // Suppress warnings for invalid HTML
    
            // Step 3: Use DOMXPath to query the specific parts
            $xpath = new \DOMXPath($dom);
    
          // Step 4: Initialize an array to store generations and their Pokémon
        $generationsWithPokemon = [];

        // Step 5: Extract all generations with their Pokémon tables
        $generationNodes = $xpath->query('//h3/span[@class="mw-headline"]');
        
        foreach ($generationNodes as $generationNode) {
            // Extract the generation title (e.g., "Generation I")
            $generationTitle = $generationNode->textContent;

            // Find the next table after the generation header (which contains the Pokémon)
            $pokemonTable = $generationNode->parentNode->nextSibling->nextSibling;

            if ($pokemonTable && $pokemonTable->nodeName == 'table') {
                // Extract Pokémon names from the table
                $pokemonNodes = (new \DOMXPath($dom))->query('.//tr[td[@style="font-family:monospace,monospace"]]/td[3]/a', $pokemonTable);

                $pokemonList = [];
                foreach ($pokemonNodes as $node) {
                    $pokemonList[] = $node->textContent;
                }

                // Add generation and Pokémon to the array
                $generationsWithPokemon[] = [
                    'generation' => $generationTitle,
                    'pokemon' => $pokemonList,
                ];
            }
        }

        // Return the extracted data
        return response()->json($generationsWithPokemon);
  }
}
