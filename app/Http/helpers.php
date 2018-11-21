<?php

function lang_toggle_href($lang)
{
    $segmentLang = \Request::segments();
    $segmentLang[0] = $lang;

    return url('/' . implode('/', $segmentLang));
}

function formatUSD($num)
{
    return number_format($num, 2, '.', ' ');
}

function formatVMC($num)
{
    return sprintf('%.4f', floor_f($num, 4));
}

function formatBTC($num)
{
    return sprintf('%.4f', floor_f($num, 4));
}

function formatCurrency($currency, $num, $showCurrency = false)
{
    $format = call_user_func('format' . $currency, $num);
    if ($showCurrency) {
        $format .= ' ' . $currency;
    }
    return $format;
}

function USDtoVMC($amount)
{
    return $amount / config('mlm.currencies.VMC.USD');
}

function USDtoBTC($amount)
{
    return $amount / getPriceBtcUsd();
}

function USDtoRUB($amount)
{
    return floor_f($amount / 1 * getPriceRubUsd(), 2);
}

function VMCtoUSD($amount)
{
    return floor_f($amount / 1 * config('mlm.currencies.VMC.USD'), 2);
}

function VMCtoBTC($amount)
{
    return $amount / config('mlm.currencies.VMC.BTC') * getPriceBtcUsd();
}

function BTCtoVMC($amount)
{
    return $amount / getPriceBtcUsd() * config('mlm.currencies.VMC.BTC');
}

function BTCtoUSD($amount)
{
    return floor_f($amount / 1 * getPriceBtcUsd(), 2);
}

function getPriceBtcUsd()
{
    return 7900;
    $price_usd_btc = (float)Cache::remember('price_usd_btc', 60, function () {
        $ctx = stream_context_create([
            'ssl' => [
                'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT,
                'verify_peer_name' => false,
            ],
        ]);

        $json = file_get_contents("https://bitpay.com/api/rates", false, $ctx);
        $data = json_decode($json, true);

        return $data[1]["rate"];
    });

    return $price_usd_btc;
}


function getPriceRubUsd(): float
{
    return Cache::remember('price_rub_usd', 60, function () {
        $json_daily = file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js');
        $data = json_decode($json_daily);
        return $data->Valute->USD->Value ?? 66.87;
    });
}

function floor_f($num, $dec = 0)
{
    return floor($num * pow(10, $dec)) / pow(10, $dec);
}


function asset_theme($path = '')
{
    return asset(config('app.path_theme') . $path);
}

function mix_theme($path = '')
{
    return mix(config('app.path_theme') . $path);
}

function user(): \App\User
{
    return auth()->user();
}
