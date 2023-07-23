<?php

namespace Finpay;

/**
 * Finpay Configuration
 */
class Config
{

    /**
     * Your merchant's server key
     * 
     * @static
     */
    public static $username;
    /**
     * Your merchant's client key
     * 
     * @static
     */
    public static $password;
    /**
     * True for production
     * false for sandbox mode
     * 
     * @static
     */
    public static $isProduction = false;
    /**
     * Set it true to enable 3D Secure by default
     * 
     * @static
     */
    public static $is3ds = false;
    /**
     * Enable request params sanitizer (validate and modify charge request params).
     * See Finpay_Sanitizer for more details
     * 
     * @static
     */
    public static $isSanitized = false;
    /**
     * Default options for every request
     * 
     * @static
     */
    public static $curlOptions = array();

    const SANDBOX_BASE_URL      = 'https://devo.finnet.co.id/pg/payment/card/initiate';
    const PRODUCTION_BASE_URL   = 'https://live.finnet.co.id/pg/payment/card/initiate';

    /**
     * Get baseUrl
     * 
     * @return string Finpay API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        return Config::$isProduction ?
        Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
    }
    
}
