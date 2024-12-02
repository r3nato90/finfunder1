<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class FinfunderService {
    private $api_url;
    private $api_key;
    private $currentPath;
    private $rootPath;

    public function __construct() {
        $this->api_url = 'https://license.kloudinnovation.com/api/';
        $this->api_key = 'B77MsI9905rTCtdoWy8v06WkeMgrsiXDpZH3WDpO';
        $this->currentPath = realpath(__DIR__);
        $this->rootPath = realpath($this->currentPath . '/../../../../..');
    }

    private function getServerUrl(): string
    {
        $serverName = getenv('SERVER_NAME') ?: $_SERVER['SERVER_NAME'] ?: getenv('HTTP_HOST') ?: $_SERVER['HTTP_HOST'];
        $https = ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on")) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) ? 'https://' : 'http://';
        return $https . $serverName . $_SERVER['REQUEST_URI'];
    }

    private function getIpAddress(): string
    {
        return $this->getIpFromThirdParty() ?: gethostbyname(gethostname());
    }

    private function getIpFromThirdParty(): string
    {
        return Http::timeout(10)->get('http://ipecho.net/plain')->body();
    }

    public function callApi($method, $url, $data = null)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-key' => $this->api_key,
            'Item-Id' => $this->getItemId(),
            'Url' => $this->getServerUrl(),
            'IP' => $this->getIpAddress(),
            'Root-Path' => $this->rootPath,
        ])->{$method}($this->api_url.$url, $data);

        return $response->json();
    }

    public function getItemId(): int
    {
        return 51672333;
    }
}
