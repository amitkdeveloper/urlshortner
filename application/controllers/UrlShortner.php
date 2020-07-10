<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UrlShortner extends CI_Controller {

	/**
	 *  UrlShortner page for url shortner system
	 *  Renders default main page of url shortner system
	 */
	public function index()
	{
		$this->load->view('home');
	}

	/**
	 *  Method to convert shortned urls back to original ones
	 *  Reattches query paramaters back to original URL
	 */
	public function shorts($segment)
	{
		$segment=trim($segment); // Short url segment

		$query_params=$_SERVER['QUERY_STRING'];

		// Custom BUrlShortner Library
		$this->load->library('burlshortner');

		// Get Original URL From System
		$orig_url=$this->burlshortner->get_long_url_from_shorturl($segment);

		if(!empty($orig_url))
		{
			$new_url=$orig_url."?".$query_params;

			redirect($new_url, 'refresh');
		}
		else
		{
			echo "URL Not Found in system";
		}

	}

	/**
	 *  Generates Short URL for given Long URL
	 */
	public function generateURL()
	{
		// Custom BUrlShortner Library
		$this->load->library('burlshortner');

		$this->form_validation->set_rules('url_to_shortened','URL','trim|required|callback_valid_url');

		if($this->form_validation->run() == false){
			$this->load->view('home');
		}
		else {
			$url_to_shortened = $this->input->post("url_to_shortened");
			$final_shortned_url=$this->burlshortner->urlToShortCode($url_to_shortened);
			$final_shortned_url=base_url($final_shortned_url);
			$data["generated_url"]=$final_shortned_url;
			$this->load->view('home',$data);
		}
	}

	/*
	* Validation function for checking if entered url is valid url
	* function is used as custom callback to CI form validation
	*/
	public function valid_url($str) {
		return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}

}
