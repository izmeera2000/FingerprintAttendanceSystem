<?php


require __DIR__ . '/admin/vendor/autoload.php';

// echo __DIR__ . '/../';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$site_url = $_ENV['site2'];
//          HTTP protocol + Server address(localhost or example.com) + requested uri (/route or /route/home)
if( isset($_SERVER['HTTPS'] ) ) {

    $current_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    else{
    $current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    }
//Current URL = http://localhost/route/something
//Site URL - http://localhost/route

//Requested page = Current URL - Site URL
//Requested page = something
$request = str_replace($site_url, '', $current_url);


//Replacing extra back slash at the end
// $request = str_replace('/', '', $request);
$request = rtrim($request, '/');

//Converting the request to lowercase
$request = strtolower($request);

