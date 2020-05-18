<?php
// Load the autoloader
require 'vendor/autoload.php';

$router = new AltoRouter();

$router->map( 'GET', '/', function () {
     require 'front-page.php';
});

$router->map( 'GET', '/process-data/', function () {
     $key = 'ini_kunci';
     if ( isset( $_GET['key'] ) && $_GET['key'] === $key ) {
          require 'process-data-covid.php';
          $process = new Covid19;
          $process->create_json_total_data_covid();
          $process->create_json_per_kecamatan();
     } else {
          echo "what are you doing here?";
     }
});

$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}