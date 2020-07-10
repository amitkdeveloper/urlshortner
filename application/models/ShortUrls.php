<?php

class ShortUrls extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Checks if url exists in database
	*/
	function urlExistsInDb($long_url)
	{
		$long_url=trim($long_url);
		$this->db->where('long_url',$long_url);
		$query = $this->db->get('short_urls');
		if ($query->num_rows() > 0){
			$ret = $query->row();
			return $ret->short_code;
		}
		else{
			return false;
		}
	}

	/*
	* Inserts shortcode in database
	*/
	function insertShortCodeInDb($long_url,$short_url,$date_created)
	{
		$data['short_code'] =$short_url;
		$data['long_url'] = $long_url;
		$data["date_created"]=$date_created;
		$this->db->insert('short_urls', $data);
		return true;
	}

	/*
	* Gets long url from database
	*/
	function get_url_from_shorturl($short_url)
	{
		$short_url=trim($short_url);
		$this->db->where('short_code',$short_url);
		$query = $this->db->get('short_urls');
		if ($query->num_rows() > 0){
			$ret = $query->row();
			return $ret->long_url;
		}
		else{
			return false;
		}
	}

}
