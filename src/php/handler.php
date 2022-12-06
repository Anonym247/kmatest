<?php

const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

function handle($message)
{
    try {
        $body = json_decode($message->body, true);

        $url = $body['url'];

        sendRequest($url, $body['is_retry'] ?? false);
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}

function sendRequest($url, $isRetry = false) {
    try {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $body = (substr($response, $headerSize));
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code !== 200 && !$isRetry) {
            resend(['url' => $url, 'is_retry' => true]);
        }

        insertToLogs(
            $url,
            'GET',
            $code,
            str_replace("\"", "'", $headers),
            str_replace("'", "\'", $body));
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}
