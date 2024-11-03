<?php

namespace App\Modules;

class Ghasedak
{
    public static function sendOTP(
        $API_key,
        $template,
        $param,
        $receptor
    ) {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "https://api.ghasedak.me/v2/verification/send/simple",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPAUTH => CURLAUTH_ANY,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "receptor=" . $receptor . "&template=" . $template . "&type=1&param1=" . $param,
                CURLOPT_HTTPHEADER => array(
                    "apikey: " . $API_key,
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                )
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);
        if (isset($response['result'])) {
            if($response['result']['code'] == 200 && $response['result']['message'] == "success"){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}
