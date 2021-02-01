<?php

/**
 * base request class
 */
class Request
{
    function __construct()
    {
        $this->bootstrapSelf();
    }

    /**
     * handle bootstrap
     *
     * @return void
     */
    private function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    /**
     * handle param casing
     *
     * @param string $string
     * @return void
     */
    private function toCamelCase(string $string) : string
    {
            $result = strtolower($string);
                
            preg_match_all('/_[a-z]/', $result, $matches);

            foreach($matches[0] as $match) {
                $c = str_replace('_', '', strtoupper($match));
                $result = str_replace($match, $c, $result);
            }
            return $result;
    }

    /**
     * get rq body
     *
     * @return array the rq body
     */
    public function getBody() : array
    {
        if($this->requestMethod === "GET") {
            return [];
        }

        if ($this->requestMethod == "POST") {
            $postVars = json_decode(file_get_contents("php://input"),true);
            $body = [];
            foreach ($postVars as $key => $value) {
                if (is_array($value)) {
                    $tempAr = [];
                    foreach ($value as $arKey => $arVal) {
                        $tempAr[] = $arVal;
                    }
                    $body[$key] = $tempAr;
                } else {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

        return $body;
        }
    }
}