<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pourcentage_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function pourcentage(){
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
        $data = $this->models->getEleveParTranche();
        $user['admin']= $user;
        //$data=$this->models->getData('Pourcentage',['id_Pourcentage','nom','prenom','date_naissance','adresse','contact']);
        $user['erreur'] = $this->session->flashdata('erreur');
        $user['success'] = $this->session->flashdata('success');
        $user['datas']=$data;
        $this->load->view('Back-Office/templates/template-pourcentage', $user);
    }

    public function pourcentage_trait(){
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
        $idpourcent=$this->input->get('id');
        $data = $this->models->getEleveParTranche();
        $user['datas']=$data;
        $pourcentage= $this->input->post('pourcentage');
        $debut= $this->input->post('debut');
        $fin= $this->input->post('fin');
        if($data != null)
        {
            $this->models->update('elevepartranchehoraire',['nombre'],[$pourcentage],['heuredebut','heurefin'],[$debut,$fin]);
            $this->session->set_flashdata('success', 'update réussi');
            //$this->load->view('Back-Office/templates/template-Pourcentage', $user);
            redirect('Back-Office/Pourcentage_Controller/pourcentage');
        }else{
            $this->models->insert('elevepartranchehoraire',['heuredebut','heurefin','nombre'],[$debut,$fin,$pourcentage]);
            $this->session->set_flashdata('success', 'insertion réussi');
            //$this->load->view('Back-Office/templates/template-Pourcentage', $user);
            redirect('Back-Office/Pourcentage_Controller/pourcentage');
        }
    }

}

