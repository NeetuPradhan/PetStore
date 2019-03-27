<?php

include_once(__DIR__ . '/controllers/PetController.php');


$base_url 		= 'http://' . $_SERVER['HTTP_HOST'] .'/petstore/';
$current_url 	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$uri_only 		= str_replace($base_url, '', $current_url);
$uri_only 		= rtrim($uri_only, "/");

$uris 			= explode('/', $uri_only);
$uri_1 			= $uris[0];
$uri_count 		= count($uris);

$method 		= $_SERVER['REQUEST_METHOD'];

switch($uri_1)
{
    case 'pet': 
		$pet    = new PetController();
        if(($method == 'POST') && ($uri_count == 1))
        {
            $pet->store();
        }
        else if(($method == 'PUT') && ($uri_count == 1))
        {
            $pet->update();
        }
        else if(($method == 'GET') && ($uri_count == 2))
        {
            $arr = explode('?', $uris[1]);
            $status_uri = $arr[0];
            if($status_uri == 'findByStatus')
            {
                $pet->findByStatus();
            }
            else
            {
                $pet->findById();
            }
        }
        else if(($method == 'DELETE') && ($uri_count == 2))
        {
            $headers = array();
            foreach ($_SERVER as $key => $value) {
                if (strpos($key, 'HTTP_') === 0) {
                    $headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
                }
            }
            
            $api_key = $headers['ApiKey']; 
            /*
                Code to validate api_key
                check $api_key = data from db
                if same return true else false
             */

            $pet->delete();
        }
        else if(($method == 'POST') && ($uri_count == 3) && ($uris[2] == 'uploadImage'))
        {
            echo "Code to upload image for a pet by id"; die;
            /*
                Code to upload image for a pet by id
            */
        }
        break;
    default:
        http_response_code(405);
        echo "Method Not Found"; die;
}