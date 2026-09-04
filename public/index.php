<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// STAGING: auto-set staging_key cookie when ?key=bismillah is present
// so user can navigate freely after first visit (mahadaly pattern).
// Only active when APP_ENV=staging OR APP_URL contains 'tes' subdomain.
if ((isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'staging')
    || (getenv('APP_ENV') === 'staging')
    || (isset($_SERVER['APP_URL']) && str_contains($_SERVER['APP_URL'], 'tes'))
    || (getenv('APP_URL') && str_contains(getenv('APP_URL'), 'tes'))) {
    if (isset($_GET['key']) && $_GET['key'] === 'bismillah'
        && (!isset($_COOKIE['staging_key']) || $_COOKIE['staging_key'] !== 'bismillah')) {
        $cookieDomain = preg_replace('#^https?://([^/]+).*$#', '$1', $_SERVER['APP_URL'] ?? 'teskias.syathiby.id');
        setcookie('staging_key', 'bismillah', [
            'expires' => time() + 86400 * 30,
            'path' => '/',
            'domain' => '.' . $cookieDomain,
            'secure' => true,
            'httponly' => false,
            'samesite' => 'Lax',
        ]);
        $_COOKIE['staging_key'] = 'bismillah';
    }
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
