<?php

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

$retorno = CallAPI("GET", "https://www.mercadobitcoin.net/api/BTC/ticker/");
$retorno = json_decode($retorno);

$teste = $retorno->ticker;
$cotacao_bitcoin = $teste->buy;

$retorno = CallAPI("GET", "https://economia.awesomeapi.com.br/json/USD-BRL/1");
$retorno = json_decode($retorno);

$teste = $retorno[0];
$cotacao_dolar = $teste->bid;

$resultado["dolar"] = $cotacao_dolar;
$resultado["bitcoin"] = $cotacao_bitcoin;

echo json_encode($resultado);


