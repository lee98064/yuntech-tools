<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Exception;

class IpFlowService
{

    public function humanFileSize($size)
    {
        $size = floatval($size);
        if ($size >= 1) {
            return $size . " GB";
        } else {
            $size *= 1024;
            return $size . " MB";
        }
    }

    public function GetFlow($ip)
    {
        $url = 'http://cnms.yuntech.edu.tw/netflow.pl?action=ShowIP&IP=' . $ip;

        $html = file_get_contents($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        // $flower = $xpath->query('//td//font');
        $flow = $xpath->query('/html/body/table/tbody/tr[2]/td/table /tbody/tr[1]/td[2]/table/tbody/tr/td/table/tbody/tr[3]/td/table/tbody/tr[3]/td');

        try {
            $send = $flow[3]->nodeValue;
            $receive = $flow[4]->nodeValue;
            $flow = floatval($send) + floatval($receive);
        } catch (Exception $e) {
            $flow = 0.0;
        }

        // if (!strpos($flower[8]->nodeValue, '.')) {
        //     $flower = "無法獲取流量，請檢查IP或稍後重試!";
        // } else {
        //     $flower = $flower[8]->nodeValue;
        // }

        return (string)$flow;
    }
}
