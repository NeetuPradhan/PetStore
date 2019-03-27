<?php

class Pet {	
		
	function __construct()
    {
       
    }

    public function store($data = array()) {
    	return true;
    }

    public function update($data = array()) {
    	return true;
    }

    public function delete($id) {
    	return true;
    }

    public function getById($id) {
    	$data = array();
    	/*
			find the data from pet table whose id = $id
    	*/
    	return $data;
    }

    public function getByStatus($status) {
    	$data = array();
    	/*
			find the data from pet table whose status = $status
    	*/
    	return $data;
    }
}
