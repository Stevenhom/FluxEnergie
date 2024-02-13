<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consommation_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function consommation(){
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
        //$data=$this->models->getData('consommation',['id_consommation','nom','prenom','date_naissance','adresse','contact']);
        $data = $this->models->getConsommation();
        $user['datas']=$data;
        $this->session->flashdata('success', 'Insertion réussie');
        $this->load->view('Back-Office/templates/template-consommation', $user);
    }

    public function consommation_trait(){
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
        $data = $this->models->getConsommation();
        $user['datas']=$data;
        $nombre= $this->input->post('nombre');
        $puissance= $this->input->post('puissance');
        $consommation= $this->input->post('consommation');

        if($data != null){
            $this->models->update('consommation',['nombreeleve','puissancemachine','consoFixe'],[$nombre,$puissance,$consommation],['id'],[1]);
            $this->session->set_flashdata('success', 'update réussi');
            redirect('Back-Office/Consommation_Controller/consommation');
        }else{
            $this->models->insert('consommation',['nombreeleve','puissancemachine','consoFixe'],[$nombre,$puissance,$consommation]);
            $this->session->set_flashdata('success', 'insertion réussi');
            //$this->load->view('Back-Office/templates/template-consommation', $user);
            redirect('Back-Office/Consommation_Controller/consommation');
        }
    }

}

