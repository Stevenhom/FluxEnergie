<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jirama_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function jirama(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $email = $this->session->userdata('email');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_adminid($email, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_admindata($user_id);
        $data = $this->models->getJirama();
        $user['admin']= $user;
        //$data=$this->models->getData('Jirama',['id_Jirama','nom','prenom','date_naissance','adresse','contact']);

        $user['datas']=$data;
        $this->load->view('Back-Office/templates/template-jirama', $user);
    }

    public function Jirama_trait(){
        $this->load->model('models');
        $this->load->helper('url');
        $this->load->helper('url_helper');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $email = $this->session->userdata('email');
        $pass = $this->session->userdata('pass');
        $user_id = $this->models->get_adminid($email, $pass);
        $this->session->set_userdata('user_id', $user_id);
        $user=$this->models->get_admindata($user_id);
        $user['admin']= $user;
        $data = $this->models->getJirama();
        $user['datas']=$data;
        $idJirama=$this->input->get('id');
        $cout= $this->input->post('cout');
        $capacite= $this->input->post('capacite');
        $this->models->update('Jirama',['coutparwatt','capacitemax'],[$cout,$capacite],['id'],[$idJirama]);
        //$this->load->view('Back-Office/templates/template-Jirama', $user);
        redirect('Back-Office/Jirama_Controller/jirama');
    }

}

