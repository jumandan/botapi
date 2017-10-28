<?php
namespace BotApi;

use GuzzleHttp\Client as HttpClient;

class ClientImpl
{
    /** @var array Default client options. */
    protected $config;

    public function __construct(array $config = [])
    {
        $this->configureDefaults($config);
    }

    /**
     * The base API call method.
     *
     * @param string $method The API method.
     * @param array $params Prepaired parameters for API method.
     *
     * @rerurn array Decoded API response.
     */
    protected function apiCall(string $method, array $params = [])
    {
        $httpClient = new HttpClient([
            'base_uri' => $this->config['base_uri']
        ]);

        $response = $httpClient->request('POST', $method, [
            'form_params' => $params
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception\ResponseException('Bad response code.', [
                'Http code' => $response->getStatusCode(),
                'response' => $response
            ]);
        }

        $stringBody = (string)$response->getBody();
        $res = json_decode($stringBody, true);
        if (is_null($res) ||
            !array_key_exists('ok', $res) ||
            $res['ok'] !== true ||
            !array_key_exists('result', $res)
        ) {
            throw new Exception\ResponseException('Unrecognized response.', [
                'response' => $response
            ]);
        }

        if (!is_array($res['result'])) {
            throw new Exception\ResponseException('Bad type of result', [
                [
                    'result' => $res['result']
                ]
            ]);
        }

        return $res['result'];
    }

    /**
     * Configure the default options for a client.
     *
     * @param array $config
     */
    private function configureDefaults(array $config)
    {
        $defaults = [
            'timeout' => 10,
            'base_uri' => 'https://api.telegram.org/bot<token>/',
        ];

        $this->config = $config + $defaults;
    }
}
