<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groupe_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function groupe(){
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
        $data = $this->models->getGroupe();
        $user['admin']= $user;
        //$data=$this->models->getData('groupe',['id_groupe','nom','prenom','date_naissance','adresse','contact']);

        $user['datas']=$data;
        $this->load->view('Back-Office/templates/template-groupe', $user);
    }

    public function groupe_trait(){
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
        $data = $this->models->getgroupe();
        $user['datas']=$data;
        $idgroupe=$this->input->get('id');
        $capacite= $this->input->post('capacite');
        $reservoir= $this->input->post('reservoir');
        $conso= $this->input->post('conso');
        $essence= $this->input->post('essence');
        $heure_groupe = $this->input->post('heure_groupe');
        if($heure_groupe > '07:00:00'){
            $insert_heure = $this->models->insert_heure_groupe($heure_groupe);
            $this->models->update('groupe',['capacitemax','capacitereservoir','consoparlitreheure','prixessence'],[$capacite,$reservoir,$conso,$essence],['id'],[$idgroupe]);
            //$this->load->view('Back-Office/templates/template-groupe', $user);
            redirect('Back-Office/groupe_Controller/groupe');

        }else{
            $this->models->update('groupe',['capacitemax','capacitereservoir','consoparlitreheure','prixessence'],[$capacite,$reservoir,$conso,$essence],['id'],[$idgroupe]);
            //$this->load->view('Back-Office/templates/template-groupe', $user);
            redirect('Back-Office/groupe_Controller/groupe');

        }
        /*
        
        $this->models->update('groupe',['capacitemax','capacitereservoir','consoparlitreheure','prixessence'],[$capacite,$reservoir,$conso,$essence],['id'],[$idgroupe]);
        //$this->load->view('Back-Office/templates/template-groupe', $user);
        redirect('Back-Office/groupe_Controller/groupe');*/
    }

}

