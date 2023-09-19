<?php

namespace Finpay;

/**
 * Create finpay payment page and return link
 */
class Link
{

    /**
     * Create Snap payment page, with this version returning full API response
     *
     * Example:
     *
     * ```php
     *   $params = array(
     *     'transaction_details' => array(
     *       'order_id' => rand(),
     *       'gross_amount' => 10000,
     *     )
     *   );
     *   $paymentUrl = Snap::getSnapToken($params);
     * ```
     *
     * @param  array $params Payment options
     * @return object Snap response (token and redirect_url).
     * @throws Exception curl error or finpay error
     */
    public static function createTransaction($params)
    {


        // var_dump($params);exit();

        // if (isset($params['item_details'])) {
        //     $gross_amount = 0;
        //     foreach ($params['item_details'] as $item) {
        //         $gross_amount += $item['quantity'] * $item['price'];
        //     }
        //     $params['amount'] = $gross_amount;
        // }

        if (Config::$isSanitized) {
            Sanitizer::jsonRequest($params);
        }

        // $username = Config::$username;
        // var_dump($username);exit();

        $result = ApiRequestor::post(Config::getBaseUrl(), Config::$username, Config::$password, $params);
        // var_dump($result);exit();
        return $result;
    }  
}