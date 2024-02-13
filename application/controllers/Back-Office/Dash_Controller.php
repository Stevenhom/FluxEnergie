<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }


    public function deconnexion(){
        $this->session->sess_destroy();

        // Rediriger vers la page de connexion
        redirect('Welcome/index');
    }

}

