<?php

namespace App\Services;

use GuzzleHttp\Client;

class LineNotifyService
{
    public function get_access_tooken($code)
    {
        $client = new Client([
            'base_uri' => 'https://notify-bot.line.me',
            'timeout'  => 2.0,
        ]);
        $response = $client->request('POST', '/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => ENV('APP_URL') . '/linenotify',
                'client_id' => ENV('LINE_NOTIFY_CLIENT_ID'),
                'client_secret' => ENV('LINE_NOTIFY_CLIENT_SECRET')
            ]
        ]);
        $resjson = json_decode($response->getBody()->getContents());
        return $resjson->access_token;
    }

    public function text_message($text, $notificationDisabled)
    {
        return  [
            'message' => $text,
            'notificationDisabled' => $notificationDisabled
        ];
    }

    public function image_message($text, $imageThumbnail, $imageFullsize, $notificationDisabled)
    {
        return  [
            'message' => $text,
            'imageThumbnail' => $imageThumbnail,
            'imageFullsize' => $imageFullsize,
            'notificationDisabled' => $notificationDisabled
        ];
    }

    public function sticker_message($text, $stickerPackageId, $stickerId, $notificationDisabled)
    {
        return  [
            'message' => $text,
            'stickerPackageId' => $stickerPackageId,
            'stickerId' => $stickerId,
            'notificationDisabled' => $notificationDisabled
        ];
    }

    public function send($data, $accesstoken)
    {
        $client = new Client([
            'base_uri' => 'https://notify-api.line.me',
            'timeout'  => 2.0,
        ]);
        $response = $client->request('POST', '/api/notify', [
            'form_params' => $data,
            'headers' => [
                'Authorization' => "Bearer " . $accesstoken
            ]
        ]);
    }
}
