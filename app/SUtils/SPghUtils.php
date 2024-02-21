<?php

namespace App\SUtils;

use Illuminate\Support\Arr;
use GuzzleHttp\Client;
use GuzzleHttp\Request;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

class SPghUtils{
    public static function loginToPGH(){
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => '*/*'
        ];

        $config = \App\SUtils\SConfiguration::getConfigurations();
    
        $client = new Client([
            'base_uri' => $config->pghApiRoute,
            'timeout' => 30.0,
            'headers' => $headers,
            'verify' => false
        ]);
    
        $pghUser = $config->pghUser;
        $body = '{
                "username": "'. $pghUser->username .'",
                "password": "'. $pghUser->password .'"
        }';
        // $body = '{"username":"admin","password":"Super2023!"}';
        
        $request = new \GuzzleHttp\Psr7\Request('POST', 'login', $headers, $body);
        $response = $client->sendAsync($request)->wait();
        $jsonString = $response->getBody()->getContents();
        $data = json_decode($jsonString);
    
        return $data;
    }

    public static function globalUpdatePassword($token_type, $access_token, $user){
        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $token_type.' '.$access_token
            ];

            $config = \App\SUtils\SConfiguration::getConfigurations();
            $client = new Client([
                'base_uri' => $config->pghApiRoute,
                'timeout' => 30.0,
                'headers' => $headers
            ]);
    
            $body = json_encode(['user' => $user, 'fromSystem' => $config->evalIdSystem]);
    
            $request = new \GuzzleHttp\Psr7\Request('POST', 'updateGlobal', $headers, $body);
            $response = $client->sendAsync($request)->wait();
            $jsonString = $response->getBody()->getContents();
            $data = json_decode($jsonString);
    
            return $data;
        } catch (\Throwable $th) {
            \Log::error($th);
            return json_decode(json_encode(['status' => 'error', 'message' => $th->getMessage(), 'data' => null]));
        }
    }
}
?>