<?php

namespace KavehnegarLookup;

class Kavehnegar
{
    public function sendKavenegarVerificationSMS($receptor, $token, $template, $apiKey, $token2 = null, $token3 = null, $verifySSL = true)
    {
        $url = "https://api.kavenegar.com/v1/$apiKey/verify/lookup.json";

        $params = [
            "receptor" => $receptor,
            "token" => $token,
            "template" => $template
        ];

        if (!empty($token2)) {
            $params["token2"] = $token2;
        }

        if (!empty($token3)) {
            $params["token3"] = $token3;
        }


        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url . '?' . http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => $verifySSL,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return false;
        } else {
            $result = json_decode($response, true);
            if (isset($result['return']['status']) && $result['return']['status'] == 200) {
                return true;
            } else {
                return false;
            }
        }
    }
}

