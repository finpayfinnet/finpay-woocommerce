<?php
/** 
 * Check PHP version.
 */
if (version_compare(PHP_VERSION, '5.4', '<')) {
    throw new Exception('PHP version >= 5.4 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Finpay needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Finpay needs the JSON PHP extension.');
}

// Configurations
require_once 'Finpay/Config.php';

// Finpay API Resources
require_once 'Finpay/Transaction.php';

// Plumbing
require_once 'Finpay/ApiRequestor.php';
// require_once 'Finpay/SnapApiRequestor.php';
require_once 'Finpay/Notification.php';
require_once 'Finpay/CoreApi.php';
// require_once 'Finpay/Snap.php';
require_once 'Finpay/Link.php';

// Sanitization
require_once 'Finpay/Sanitizer.php';
