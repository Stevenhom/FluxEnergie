<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panneau_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function panneau(){
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
        //$data=$this->models->getData('panneau',['id_panneau','nom','prenom','date_naissance','adresse','contact']);
        $data = $this->models->getPanneau();
        $data2 = $this->models->getPourcentagePanneau();

        $user['pourcentage']=$data2;
        $user['datas']=$data;
        $this->session->flashdata('success', 'Insertion réussie');
        $this->load->view('Back-Office/templates/template-panneau', $user);
    }

    public function panneau_trait(){
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
        $data = $this->models->getpanneau();
        $user['datas']=$data;
        $idpanneau=$this->input->get('id');
        $capacite= $this->input->post('capacite');
        $tarif= $this->input->post('tarif');
        $this->models->update('panneausolaire',['capacitemax','tarifenwatt'],[$capacite,$tarif],['id'],[$idpanneau]);
        //$this->load->view('Back-Office/templates/template-panneau', $user);
        redirect('Back-Office/panneau_Controller/panneau');
    }

    
    public function pourcentagepanneau_trait(){
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
        $data = $this->models->getpanneau();
        $user['datas']=$data;
        $idpourcentage=$this->input->get('id');
        $pourcentage= $this->input->post('pourcentage');
        $this->models->update('pourcentagepanneausolaire',['pourcentage'],[$pourcentage],['id'],[$idpourcentage]);
        //$this->load->view('Back-Office/templates/template-panneau', $user);
        redirect('Back-Office/panneau_Controller/panneau');
    }

}

