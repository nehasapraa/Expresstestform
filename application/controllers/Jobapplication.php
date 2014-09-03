<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Jobapplication extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();

        parse_str($_SERVER['QUERY_STRING'], $_REQUEST);
        $CI = & get_instance();
        $CI->config->load("facebook", TRUE);
        $config = $CI->config->item('facebook');

        $this->load->library('Facebook', $config);
        $this->load->model('jobapplication_model', 'jobapp');
        
    }

    public function index() {
        $userId = $this->facebook->getUser();


        // If user is not yet authenticated, the id will be zero
        if ($userId == 0) {
            // Generate a login url


            $data['url'] = $this->facebook->getLoginUrl(array('scope' => 'email,user_location'));
        } else {
            // Get user's data and print it
            try {
                $data = $this->facebook->api('/me', 'GET');
            } catch (FacebookApiException $e) {
                
            }
            $country = explode(', ', $data['location']['name']);
            $data['selected_country'] = $this->jobapp->get_country_social($country['1']);
        }


        $data['countries'] = $this->get_countries();
        $this->load->view('jobApplication', $data);
    }

    public function get_countries() {

        $result = $this->jobapp->show_countries();
        return $result;
    }

    public function save_userinfo() {
        if (empty($_POST)):
            $data['countries'] = $this->get_countries();
            $this->load->view('jobapplication', $data);
        else:
            $data = $_POST;


            $save = $this->jobapp->save_user_info($data);
            if ($save):
                $data['country'] = $this->jobapp->get_country($data['countries']);
                $data['success_msg'] = 'You have Successfully entered your info';
                $this->load->view('userInfo', $data);
            endif;
        endif;
    }

}
