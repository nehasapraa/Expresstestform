<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Loginlinkedin extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper('url');

        $this->load->model('jobapplication_model', 'jobapp');
    }

    function index() {





        $this->load->view('link');
    }

    function initiate() {


        $linkedin_config = array(
            'appKey' => '75j1k3gdwpr7v7',
            'appSecret' => 'XjXHhfnd4Y8sElRT',
            'callbackUrl' => 'http://localhost:8888/Expr3ssTest/index.php/loginlinkedin/data'
        );


        $this->load->library('linkedin', $linkedin_config);
        $this->linkedin->setResponseFormat(LINKEDIN::_RESPONSE_JSON);
        $token = $this->linkedin->retrieveTokenRequest();

        $this->session->set_flashdata('oauth_request_token_secret', $token['linkedin']['oauth_token_secret']);
        $this->session->set_flashdata('oauth_request_token', $token['linkedin']['oauth_token']);

        $link = "https://api.linkedin.com/uas/oauth/authorize?oauth_token=" . $token['linkedin']['oauth_token'];
        redirect($link);
    }

    function cancel() {

        // See https://developer.linkedin.com/documents/authentication
        // You need to set the 'OAuth Cancel Redirect URL' parameter to <your URL>/linkedin_signup/cancel

        echo 'Linkedin user cancelled login';
    }

    function logout() {
        session_unset();
        $_SESSION = array();
        echo "Logout successful";
    }

    function data() {

        $linkedin_config = array(
            'appKey' => '75j1k3gdwpr7v7',
            'appSecret' => 'XjXHhfnd4Y8sElRT',
            'callbackUrl' => 'http://localhost:8888/Expr3ssTest/index.php/loginlinkedin/data'
        );

        $this->load->library('linkedin', $linkedin_config);
        $this->linkedin->setResponseFormat(LINKEDIN::_RESPONSE_JSON);

        $oauth_token = $this->session->flashdata('oauth_request_token');
        if (empty($oauth_token)):
            redirect(base_url(), 'refresh');
        else:
            $oauth_token_secret = $this->session->flashdata('oauth_request_token_secret');

            $oauth_verifier = $this->input->get('oauth_verifier');

            $response = $this->linkedin->retrieveTokenAccess($oauth_token, $oauth_token_secret, $oauth_verifier);


            // ok if we are good then proceed to retrieve the data from Linkedin
            if ($response['success'] === TRUE) {

                // From this part onward it is up to you on how you want to store/manipulate the data 
                $oauth_expires_in = $response['linkedin']['oauth_expires_in'];
                $oauth_authorization_expires_in = $response['linkedin']['oauth_authorization_expires_in'];

                $response = $this->linkedin->setTokenAccess($response['linkedin']);
                $profile = $this->linkedin->profile('~:(id,first-name,last-name,picture-url,location,email-address)');
                $profile_connections = $this->linkedin->profile('~/connections:(id,first-name,last-name,picture-url,industry,location,email-address)');
                $user = json_decode($profile['linkedin']);
                
                // For example, print out user data


                $data = array('first_name' => $user->firstName,
                    'last_name' => $user->lastName,
                    'laddress' => $user->location->name,
                    'email' => $user->emailAddress,
                    'lid' => $user->id);

                $country = explode(', ', $user->location->name);
                $data['selected_country'] = $this->jobapp->get_country_social($country['1']);
                $data['countries'] = $this->jobapp->show_countries();
                $this->load->view('jobapplication', $data);
            } else {
                // bad token request, display diagnostic information
                echo "Request token retrieval failed:<br /><br />RESPONSE:<br /><br />" . print_r($response, TRUE);
            }
        endif;
    }

}
