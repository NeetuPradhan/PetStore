<?php 
include_once('models/Pet.php');
include_once('helpers/validation.php');

class PetController {
	protected $pet;

	function __construct()
    {
       $this->pet  = new Pet();
    }

    function store() {
    	$validate = validate();
    	
		if(!$validate) {
			http_response_code(405);
			echo json_encode(array('message'=>'Invalid input'));
		}

		$data = $this->fetchDataFromPost();
    	$this->pet->store($data);
    	echo json_encode($data);
    }

    function update() {
    	$id 	  = $_REQUEST['id'];
    	$validate = validate();
    	
		if(!$validate) {
			http_response_code(405);
			echo json_encode(array('message'=>'Invalid input'));
		}

		if(!is_numeric($id)){
			http_response_code(400);
			echo json_encode(array('message'=>'Invalid id supplied'));
		}

		if(isset($id) && is_numeric($id) && !empty($id)) {
			$db_data  = '';
			/* 
				Check in db if $id exist or not
				return  $db_data;
			*/

			if(!$db_data) {
				http_response_code(404);
				echo json_encode(array('message'=>'Pet Not Found'));
			}

			$data  = $this->fetchDataFromPost();
			$this->pet->update($data);
    		echo json_encode($data);
		}

    }

    function findByStatus() {
    	$data = array();
    	/*
			1 - Available
			2 - Pending
			3 - Sold
    	*/
    	$status = $_GET['status'];
		if(!in_array($status, ['1', '2', '3'])) {
			http_response_code(400);
			echo json_encode(array('message'=>'Invalid Status Value'));
		}

    	$this->pet->getByStatus($status);
    	echo json_encode($data);
    }

    function findById() {
    	$base_url 		= 'http://' . $_SERVER['HTTP_HOST'] .'/jumbo/';
    	$current_url 	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    	$uri_only 		= str_replace($base_url, '', $current_url);
    	$uri_only 		= rtrim($uri_only, "/");

    	$uris 			= explode('/', $uri_only);
    	$uri_1 			= $uris[0];
    	$uri_count 		= count($uris);

    	$id 	  		= $uris[$uri_count - 1];

		if(!is_numeric($id)){
			http_response_code(400);
			echo json_encode(array('message'=>'Invalid Id Supplied'));
		}

		if(isset($id) && is_numeric($id) && !empty($id)) {

			$data  = $this->pet->getById($id);
			if(empty($data)) {
				http_response_code(404);
				echo json_encode(array('message'=>'Pet Not Found'));
			}

    		echo json_encode($data);
		}
    }

    function delete() {
    	$base_url 		= 'http://' . $_SERVER['HTTP_HOST'] .'/jumbo/';
    	$current_url 	= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    	$uri_only 		= str_replace($base_url, '', $current_url);
    	$uri_only 		= rtrim($uri_only, "/");

    	$uris 			= explode('/', $uri_only);
    	$uri_1 			= $uris[0];
    	$uri_count 		= count($uris);

    	$id 	  		= $uris[$uri_count - 1];

		if(!is_numeric($id)){
			http_response_code(400);
			echo json_encode(array('message'=>'Invalid Id Supplied'));
		}

		if(isset($id) && is_numeric($id) && !empty($id)) {
			$data  = $this->pet->delete($id);
			if(empty($data)) {
				http_response_code(404);
				echo json_encode(array('message'=>'Pet Not Found'));
			}
    		echo json_encode($data);
		}
    }

    function uploadImage($id) {
    	/*
    		code to upload image
	    	
       	}*/
    }

    function fetchDataFromPost() {
    	$data 			= array();

    	$data['id'] 	= $_POST['id'];
    	$data['name'] 	= $_POST['name'];
    	$data['status'] = $_POST['status'];

    	$data['category'] = array();

    	if(isset($_POST['category']) && is_array($_POST['category']) && !empty($_POST['category'])) {
	    	foreach ($_POST['category'] as $key => $value) {
	    		$data['category'][] = $value;
	    	}
    	}

    	$data['photoUrls'] = array();
    	if(isset($_POST['photoUrls']) && is_array($_POST['photoUrls']) && !empty($_POST['photoUrls'])) {
    		$data['photoUrls'][] = $value;
    	}

    	$data['tags'] = array();
    	if(isset($_POST['tags']) && is_array($_POST['tags']) && !empty($_POST['tags'])) {
    		$data['tags'][] = $value;
    	}

    	return $data;
    }
}