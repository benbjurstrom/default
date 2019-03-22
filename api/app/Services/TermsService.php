<?php
namespace App\Services;

use GuzzleHttp\Client;

class TermsService
{
    public function loadTerms(){

        $client = new Client(['base_uri' => 'https://api.github.com/repos/']);

        $response = $client->request('GET', $this->getUri());
        $body = $response->getBody();

        return json_decode($body->getContents());
    }

    protected function getUri($type = 'terms'){
        $repo  = config('terms.repository');
        $files = config('terms.files');

        return $repo . '/contents/' . $files[$type];
    }
}