<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BUrlShortner {
	private $_CI;

	public function __construct() {
		$this->_CI =& get_instance();
		$this->_CI->load->model('shorturls');
	}


	/*
	* Converts given url to shortcode using md5 and inserts it into database
	* Also checks in system if its already generated and dont regenerate if already generated.
	*/
	public function urlToShortCode($url) {
		if (empty($url)) {
			throw new Exception("No URL was supplied.");
		}

		if ($this->validateUrlFormat($url) == false) {
			throw new Exception(
				"URL does not have a valid format.");
		}


		$shortCode = $this->urlExistsInDb($url);
		if ($shortCode == false) {
			$shortCode = $this->createShortCode($url);
		}

		return $shortCode;
	}

	/*
	* Generate original url from short url
	*/
	public function get_long_url_from_shorturl($url)
	{
		$org_url=$this->_CI->shorturls->get_url_from_shorturl($url);
		return $org_url;
	}

	/*
	* Validation function for checking if it is valid URL
	*/
	protected function validateUrlFormat($url) {
		return filter_var($url, FILTER_VALIDATE_URL);
	}

	/*
	* Function that checks in database if url is already generated by system
	*/
	protected function urlExistsInDb($long_url) {
		$result = 	$this->_CI->shorturls->urlExistsInDb($long_url);
		return (empty($result)) ? false : $result;
	}

	/*
	* Function that created shortcode of url using MD5 and math random method.
	*/
	protected function createShortCode($long_url) {
		$short_url=substr(md5($long_url.mt_rand()),0,8);
		$this->_CI->shorturls->insertShortCodeInDb($long_url,$short_url,$_SERVER["REQUEST_TIME"]);
		return $short_url;
	}

}
