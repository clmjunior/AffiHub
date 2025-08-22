<?php

namespace app\helpers;

use app\helpers\LoggerHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class HttpHelper
{

    /**
     * URL base da API.
     *
     * @var string
     */
    private $api_root_url = "";

    public function set_api_root_url($api_root_url)
    {
        $this->api_root_url = $api_root_url;
    }

    /**
     * Constrói a URL completa para a requisição na API.
     *
     * Este método recebe o caminho da requisição e parâmetros adicionais, e constr�i a URL completa
     * para a requisição na API, levando em consideração a URL base e os parâmetros passados.
     *
     * @param  string  $path
     * O caminho específico para a requisição na API.
     * @param  array  $params
     * parâmetros adicionais a serem inclu�dos na requisição (opcional).
     *
     * @return string
     * Retorna a URL completa para a requisição na API.
     */
    protected function make_path($path, $params = array())
    {
        $uri = preg_replace('/^\//', '', $path);

        if (!preg_match("/^http/", $path)) {
            if (!preg_match("/^\//", $path)) {
                $path = '/' . $path;
            }

            $uri = rtrim($this->api_root_url, '/') . $path;
        }

        if (!empty($params)) {
            $paramsJoined = array();

            foreach ($params as $param => $value) {
                $paramsJoined[] = "$param=$value";
            }
            $params = '?' . implode('&', $paramsJoined);
            $uri = $uri . $params;
        }

        // LoggerHelper::msgAPI("Endpoint: " . $uri, "info");
        return $uri;
    }


    /**
     * Gera um comando cURL em formato de string para uma requisição HTTP GET.
     *
     * Esta função cria uma string representando um comando cURL com base na URL e nos cabe�alhos fornecidos.
     * O comando cURL gerado pode ser utilizado para realizar uma requisição GET com os cabe�alhos especificados.
     *
     * @param string $url A URL para a qual a requisição GET será feita.
     * @param array $headers Um array associativo contendo os cabe�alhos a serem inclu�dos na requisição.
     *
     * @return string A string do comando cURL gerado.
     */
    protected function generate_curl_command($url, $headers)
    {
        $curl = "curl -X GET '{$url}' \\\n";
        foreach ($headers as $key => $value) {
            $curl .= "  -H '{$key}: {$value}' \\\n";
        }
        return rtrim($curl, "\\\n"); // Remover a �ltima quebra de linha
    }




    // *** REQUISIÇÕES *** //
    /**
     * Realiza uma requisição HTTP PUT.
     *
     * Este método monta a URL com base no caminho e nas opções fornecidas,
     * executa uma requisição PUT utilizando Guzzle e trata possíveis exceções.
     *
     * @param string $path Caminho (URI) utilizado para a requisição.
     * @param array $options parâmetros passados para a requisição, contendo os índices 'headers' e 'json'.
     *
     * @return object Objeto contendo informações da resposta: corpo, opções, erro e código HTTP.
     *
     * @throws \GuzzleHttp\Exception\ClientException Em caso de erro na requisição HTTP.
     * @throws \Throwable Para quaisquer outros erros inesperados.
     */
    public function put(string $path, array $options) 
    {

        try {
            if(!empty($options["json"])) {

                $url = $this->make_path($path, $options);

                $client = new Client();

                $response = $client->put($url, $options);
                $responseBody = json_decode($response->getBody()->getContents(), true);

                $response = [
                    "body" => $responseBody,
                    "options" => $options,
                    "error" => "",
                    "httpCode" => $response->getStatusCode(),
                ];

            } else {
                LoggerHelper::msgAPI("Array de dados esta vazio, requisicao nao efetuada", "atencao");
                $response = [
                    "body" => null,
                    "options" => null,
                    "error" => "Nenhum dado dispon�vel para envio.",
                    "httpCode" => 204,
                ];
            }
        } catch (ClientException $e) {

            // ERRO DA requisição HTTP
            $resp = $e->getResponse()->getBody()->getContents();
            LoggerHelper::msgAPI($resp, "erro");

            $response = [
                "body" => $resp,
                "options" => $options,
                "error" => $resp,
                "httpCode" => $e->getResponse()->getStatusCode(),
            ];

        } catch (\Throwable $ex) {

            // ERRO INESPERADO
            $resp = utf8Convert($ex->getMessage());
            LoggerHelper::msgAPI($resp, "erro");

            $response = [
                "body" => $resp,
                "options" => [],
                "error" => $resp,
                "httpCode" => 500,
            ];
        }


        return (object) $response;

    }


    /**
     * Realiza uma requisição HTTP POST.
     *
     * Este método monta a URL com base no caminho e nas opções fornecidas,
     * executa uma requisição POST utilizando Guzzle e trata possíveis exceções.
     *
     * @param string $path Caminho (URI) utilizado para a requisição.
     * @param array $options parâmetros passados para a requisição, contendo os índices 'headers' e 'json'.
     *
     * @return object Objeto contendo informações da resposta: corpo, opções, erro e código HTTP.
     *
     * @throws \GuzzleHttp\Exception\ClientException Em caso de erro na requisição HTTP.
     * @throws \Throwable Para quaisquer outros erros inesperados.
     */
    public function post(string $path, array $options) 
    {

        try {
            if(!empty($options["json"])) {

                $url = $this->make_path($path, $options);

                $client = new Client();

                $response = $client->post($url, $options);
                $responseBody = json_decode($response->getBody()->getContents(), true);

                $response = [
                    "body" => $responseBody,
                    "options" => $options,
                    "error" => "",
                    "httpCode" => $response->getStatusCode(),
                ];

            } else {
                LoggerHelper::msgAPI("Array de dados esta vazio, requisicao nao efetuada", "atencao");
                $response = [
                    "body" => null,
                    "options" => null,
                    "error" => "Nenhum dado dispon�vel para envio.",
                    "httpCode" => 204,
                ];
            }
        } catch (ClientException $e) {

            // ERRO DA requisição HTTP
            $resp = $e->getResponse()->getBody()->getContents();
            LoggerHelper::msgAPI($resp, "erro");

            $response = [
                "body" => $resp,
                "options" => $options,
                "error" => $resp,
                "httpCode" => $e->getResponse()->getStatusCode(),
            ];

        } catch (\Throwable $ex) {

            // ERRO INESPERADO
            $resp = utf8Convert($ex->getMessage());
            LoggerHelper::msgAPI($resp, "erro");

            $response = [
                "body" => $resp,
                "options" => [],
                "error" => $resp,
                "httpCode" => 500,
            ];
        }


        return (object) $response;

    }


    /**
     * Realiza uma requisição HTTP GET.
     *
     * Este método monta a URL com base no caminho e nas opções fornecidas,
     * executa uma requisição GET utilizando Guzzle e trata possíveis exceções.
     *
     * @param string $path Caminho (URI) utilizado para a requisição.
     * @param array $options Parâmetros passados para a requisição, podendo conter 'headers' e 'query'.
     *
     * @return object Objeto contendo informações da resposta: corpo, opções, erro e código HTTP.
     *
     * @throws \GuzzleHttp\Exception\ClientException Em caso de erro na requisição HTTP.
     * @throws \Throwable Para quaisquer outros erros inesperados.
     */
    public function get(string $path, array $options)
    {
        try {
            $url = $this->make_path($path, $options);

            $client = new Client();

            $response = $client->get($url, $options);
            $responseBody = json_decode($response->getBody()->getContents(), true);

            $response = [
                "body" => $responseBody,
                "options" => $options,
                "error" => "",
                "httpCode" => $response->getStatusCode(),
            ];

        } catch (ClientException $e) {

            // ERRO DA REQUISIÇÃO HTTP
            $resp = $e->getResponse()->getBody()->getContents();
            LoggerHelper::msgAPI($resp, "erro");

            $response = [
                "body" => $resp,
                "options" => $options,
                "error" => $resp,
                "httpCode" => $e->getResponse()->getStatusCode(),
            ];

        } catch (\Throwable $ex) {

            // ERRO INESPERADO
            $resp = utf8Convert($ex->getMessage());
            LoggerHelper::msgAPI($resp, "erro");

            $response = [
                "body" => $resp,
                "options" => [],
                "error" => $resp,
                "httpCode" => 500,
            ];
        }

        return (object) $response;
    }


}