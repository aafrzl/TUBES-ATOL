<?php

function curl($url)
{
    //Inisiasi session CURL
    $init = curl_init();

    //Set URL
    curl_setopt($init, CURLOPT_URL, $url);

    //Return as string
    curl_setopt($init, CURLOPT_RETURNTRANSFER, 1);

    //Execution session
    $result = curl_exec($init);

    //Close session
    curl_close($init);

    //Decode result
    $result = json_decode($result, true);
    return $result;
}

function curlYT($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    return json_decode($result, true);
}
