<?php
/*
   GetEmailTemplates.php

   Marketo REST API Sample Code
   Copyright (C) 2016 Marketo, Inc.

   This software may be modified and distributed under the terms
   of the MIT license.  See the LICENSE file for details.
*/
$templates = new MultipleEmailTemplates();
print_r($templates->getData());


class MultipleEmailTemplates{
	private $host = "CHANGE ME";
	private $clientId = "CHANGE ME";
	private $clientSecret = "CHANGE ME";
	public $offset;//integer offset for paging
	public $maxreturn;//max number of templates to return
	public $status;//optional status filter
	
	public function getData(){
		$url = $this->host . "/rest/asset/v1/emailTemplates.json?access_token=" . $this->getToken();
		if (isset($this->offset)){
			$url .= "&offset=" . $this->offset;
		}
		if (isset($this->maxreturn)){
			$url .= "&maxreturn=" . $this->maxreturn;
		}
		if (isset($this->status)){
			$url .= "&status=" . $this->status;
		}
		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = curl_exec($ch);
		return $response;
	}
	
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
}