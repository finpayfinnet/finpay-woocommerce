<?php

namespace Finpay;

use WC_Finpay_Logger;

/**
 * Send request to Finpay API
 * Better don't use this class directly, use CoreApi, Transaction
 */

class ApiRequestor
{
    
    /**
     * Send GET request
     * 
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function get($url, $username, $password, $data)
    {
        return self::remoteCall($url, $username, $password, $data, false);
    }

    /**
     * Send POST request
     * 
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function post($url, $username, $password, $data)
    {
        return self::remoteCall($url, $username, $password, $data, true);
    }

    /**
     * Actually send request to API server
     * 
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     * @param bool    $post
     */
    public static function remoteCall($url, $username, $password, $data, $post = true)
    {
        $ch = curl_init();
        $data['customer']['lastName'] = $data['customer']['lastName']  == "" ? "-" : $data['customer']['lastName'] ;
        WC_Finpay_Logger::log('REQUEST DATA: '.json_encode($data),'response.log');
        

        // var_dump(Config::$username);exit();
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($username . ':'.$password)
            ),
            CURLOPT_RETURNTRANSFER => 1
        );

        // merging with Config::$curlOptions
        // if (count(Config::$curlOptions)) {
        //     // We need to combine headers manually, because it's array and it will no be merged
        //     if (Config::$curlOptions[CURLOPT_HTTPHEADER]) {
        //         $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Config::$curlOptions[CURLOPT_HTTPHEADER]);
        //         $headerOptions = array( CURLOPT_HTTPHEADER => $mergedHeders );
        //     } else {
        //         $mergedHeders = array();
        //     }

        //     $curl_options = array_replace_recursive($curl_options, Config::$curlOptions, $headerOptions);
        // }

        if ($post) {
            $curl_options[CURLOPT_POST] = 1;

            if ($data) {
                $body = json_encode($data);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }
        }

        curl_setopt_array($ch, $curl_options);

        // // For testing purpose
        // if ($stubHttp) {
        //     $result = self::processStubed($curl_options, $url, $server_key, $data_hash, $post);
        // } else {
           
        //     // curl_close($ch);
        // }

        $result = curl_exec($ch);


        if ($result === false) {
            throw new \Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        } else {
            try {
                $result_array = json_decode($result);
                WC_Finpay_Logger::log('RESPONSE: '.$result,'response.log');
            } catch (\Exception $e) {
                throw new \Exception("API Request Error unable to json_decode API response: ".$result . ' | Request url: '.$url);
            }
            // if (!in_array($result_array->status_code, array(200, 201, 202, 407))) {
            //     $message = 'Finpay Error (' . $result_array->status_code . '): '
            //     . $result_array->status_message;
            //     if (isset($result_array->validation_messages)) {
            //         $message .= '. Validation Messages (' . implode(", ", $result_array->validation_messages) . ')';
            //     }
            //     if (isset($result_array->error_messages)) {
            //         $message .= '. Error Messages (' . implode(", ", $result_array->error_messages) . ')';
            //     }
            //     throw new \Exception($message, $result_array->status_code);
            // } else {
            //     return $result_array;
            // }
            return $result_array;
        }
    }

    // private static function processStubed($curl, $url, $server_key, $data_hash, $post)
    // {
    //     $lastHttpRequest = array(
    //         "url" => $url,
    //         "server_key" => $server_key,
    //         "data_hash" => $data_hash,
    //         "post" => $post,
    //         "curl" => $curl
    //     );

    //     return $stubHttpResponse;
    // }
}
