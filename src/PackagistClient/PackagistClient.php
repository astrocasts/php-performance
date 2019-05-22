<?php

namespace App\PackagistClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PackagistClient
{

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getVendorPackages(string $vendor): array
    {
        $url = sprintf(
            'https://packagist.org/packages/list.json?vendor=%s',
            $vendor
        );

        $response = $this->httpClient->request('GET', $url)->toArray();

        return $response['packageNames'];
    }
}