<?php

namespace app\integrations;

use app\helpers\HttpHelper;

abstract class BaseIntegration {
    protected $http;


     /**
     * URL base da API.
     *
     * @var string
     */
    private $api_root_url = "";

    public function __construct() {
        $this->http = new HttpHelper();
    }

    protected function set_api_root_url($api_root_url)
    {
        $this->http->set_api_root_url($api_root_url);
    }

    protected function get($url, $options = []) {
        return $this->http->get($url, $options);
    }

    protected function put($url, $options = []) {
        return $this->http->put($url, $options);
    }

    protected function post($url, $options = []) {
        return $this->http->post($url, $options);
    }


    /**
     * Retorna os valores dos atributos desejados de um conjunto de objetos.
     *
     * Esta função procura pelos rótulos especificados dentro de um conjunto de objetos
     * e retorna um array associativo com os rótulos e seus valores correspondentes.
     *
     * @param array $item Um conjunto de objetos contendo atributos.
     * @param array $labels Um array de rótulos dos atributos desejados.
     *
     * @return array Um array associativo com os rótulos e valores dos atributos encontrados.
     */
    protected function filter_attributes($item, $labels)
    {
        $result = array();

        foreach ($labels as $label) {
            foreach ($item as $attribute) {
                if ($attribute->label === $label) {
                    $result[$label] = $attribute->conteudo;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Converte todos os valores de um array de ISO-8859-1 para UTF-8 de forma recursiva.
     *
     * Esta função percorre recursivamente um array e converte os valores de strings 
     * de ISO-8859-1 para UTF-8. Se um valor for booleano, ele será mantido inalterado.
     *
     * @param array $array O array de entrada contendo valores a serem convertidos.
     *
     * @return array O array convertido, onde todas as strings foram convertidas para UTF-8.
     */
    public function array_iso_encode_recursive($array)
    {
        $utf8_array = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $utf8_array[$key] = $this->array_iso_encode_recursive($value);
            } elseif (is_bool($value)) {
                // Se o valor for booleano, mantenha-o como est�
                $utf8_array[$key] = $value;
            } else {
                // Converta o valor para UTF-8
                $utf8_array[$key] = isoConvert($value);
            }
        }
        return $utf8_array;
    }

}