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
    public static $serverKey;
    /**
     * Your merchant's client key
     * 
     * @static
     */
    public static $clientKey;
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

    const SANDBOX_BASE_URL = 'https://api.sandbox.Finpay.com/v2';
    const PRODUCTION_BASE_URL = 'https://api.Finpay.com/v2';
    const SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.Finpay.com/snap/v1';
    const SNAP_PRODUCTION_BASE_URL = 'https://app.Finpay.com/snap/v1';

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

    /**
     * Get snapBaseUrl
     * 
     * @return string Snap API URL, depends on $isProduction
     */
    public static function getSnapBaseUrl()
    {
        return Config::$isProduction ?
        Config::SNAP_PRODUCTION_BASE_URL : Config::SNAP_SANDBOX_BASE_URL;
    }
}
