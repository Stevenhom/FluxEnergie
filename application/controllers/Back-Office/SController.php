<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SController extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function login(){
        $this->load->view('Back-Office/login');
    }    

    public function authentification(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');
        $this->load->library('session');
		
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        
        if ($this->models->isAdmin($email, $pass) == true) 
        {
            $user_id = $this->models->get_adminid($email, $pass);
            $this->session->set_userdata('user_id', $user_id);
            $this->session->set_userdata('email', $email);
            $this->session->set_userdata('pass', $pass);
            $user=$this->models->get_admindata($user_id);
            $consommation = $this->models->getV_Consommation_Production();
            $user['conso']= $consommation;
            $user['admin']= $user;
            //site_url('votre-page?email='.$email);
            $this->load->view('Back-Office/templates/template', $user);  
        }
        else
        {
            $this->session->set_flashdata('error', 'Erreur de connexion !');
            redirect(site_url('Back-Office/SController/login').'?error=Erreur de connexion !');
        }
    }

    public function home(){
        $this->load->library('session');
        $this->load->model('models');
    
        $user_id = $this->session->userdata('user_id');
        $email = $this->session->userdata('email');
        $pass = $this->session->userdata('pass');
        
        $user_id = $this->models->get_adminid($email, $pass);
        $this->session->set_userdata('user_id', $user_id);
        
        $user = $this->models->get_admindata($user_id);
        $consommation = $this->models->getV_Consommation_Production();
        $couts = $this->models->getv_cout();
        $couts_t = $this->models->getv_cout_detail();
        $user['cout']= $couts;
        $user['conso']= $consommation;
        $user['admin'] = $user;
        
        $this->load->view('Back-Office/templates/template', $user);
    }

    public function link_prod(){
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
        $heure=$this->input->get('heure');
        $user['admin']= $user;
        $data= $this->models->getDataConditionated2('heure_conso_prod_detail2',
        ['heure','panneau_capacite_max','pourcentage_pourcentage','groupe_capacite_max'
        ,'jirama_capacite_max','capacite_panneau','resultat_production','groupe','production_res'],['heure'],[$heure]);
        $user['datas']=$data;
        $this->load->view('Back-Office/templates/template-link-prod', $user); 

    }

    public function link_conso(){
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
        $heure=$this->input->get('heure');
        $user['admin']= $user;
        $data= $this->models->getDataConditionated2('heure_conso_detail',['heure','nombre_eleve','puissance_machine','conso_fixe','resultat_consommation'],['heure'],[$heure]);
        $user['datas']=$data;
        $this->load->view('Back-Office/templates/template-link-conso', $user);

    }

    public function link_conso2(){
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
        $heure=$this->input->get('heure');
        $user['admin']= $user;

        $consommation= $this->models->getDataConditionated2('v_combined',['resultat_consommation'],['heure'],[$heure]);
        $conso = $consommation[0]['resultat_consommation'];
        $capacitemax= $this->models->getV_combine_heure($heure);
        $panneauMax = $capacitemax[0]['capacite_panneau'];
        
        if($conso < $panneauMax){
            $conso = $conso;
        }else{
            $conso = $panneauMax;
        }
        $conso;
        $somme = $panneauMax + $capacitemax[0]['groupe'] + $capacitemax[0]['jirama_capacite_max'];
        echo $somme;
        /*
        if($somme < $consommation[0]['resultat_consommation']){
            $panneau = $panneauMax;
            $groupe = $capacitemax[0]['groupe_capacite_max'];
            $jirama =  $capacitemax[0]['jirama_capacite_max'];
        }else{
            $groupe = 0;
            $jirama = 0;
        }*/
        /*
        $user['datas']=$data;
        $this->load->view('Back-Office/templates/template-link-conso', $user);*/

    }

    public function graphique(){
        $this->load->library('session');
        $this->load->model('models');
    
        $user_id = $this->session->userdata('user_id');
        $email = $this->session->userdata('email');
        $pass = $this->session->userdata('pass');
        
        $user_id = $this->models->get_adminid($email, $pass);
        $this->session->set_userdata('user_id', $user_id);
        
        $user = $this->models->get_admindata($user_id);

        $consommation = $this->models->getV_Consommation_Production();
        $user['consoprod']= $consommation;
        $user['admin'] = $user;
        
        $this->load->view('Back-Office/templates/template-graphique', $user);
    }

    public function cout(){
        $this->load->library('session');
        $this->load->model('models');
    
        $user_id = $this->session->userdata('user_id');
        $email = $this->session->userdata('email');
        $pass = $this->session->userdata('pass');
        
        $user_id = $this->models->get_adminid($email, $pass);
        $this->session->set_userdata('user_id', $user_id);
        
        $user = $this->models->get_admindata($user_id);

        $couts = $this->models->getv_cout();
        $couts_t = $this->models->getv_cout_detail();
        $user['cout']= $couts;
        $user['cout_t']= $couts_t;
        $user['admin'] = $user;
        
        $this->load->view('Back-Office/templates/template-cout', $user);
    }
}

