<?php

/*
|--------------------------------------------------------------------------
| Get application instance
|--------------------------------------------------------------------------
|
| Here we will get the application instance that serves as
| the central piece of this framework.
|
*/

$f3 = \Base::instance();



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Fat-Free the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$f3->route('GET /','Controllers\Home->index', 86400); // Home, expire in a day
$f3->route('GET /privacy','Controllers\Privacy->index', 86400); // Privacy Policy, expire in a day

$f3->route('GET /placeholder/*','Controllers\Placeholder->render');
$f3->route('GET /ph/*','Controllers\Placeholder->render');

$f3->route('GET /identicon/*','Controllers\Identicon->render');
$f3->route('GET /id/*','Controllers\Identicon->render');

$f3->route('GET /qrcode/*', 'Controllers\QrCode->render');
$f3->route('GET /qr/*','Controllers\QrCode->render');

// TODO: Maybe Background Pattern Generator
// TODO: Maybe Tweet Image Generator with wkhtmltoimage
// TODO: Maybe Captcha Image Generator
// TODO: Maybe File Preview Image Generator (File icon with file extension in the middle; File extension used as seed for random theme color)
