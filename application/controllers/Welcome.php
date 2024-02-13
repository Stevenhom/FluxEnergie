<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	 public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }
	
	public function index()
	{
		$this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');

        redirect('Back-Office/SController/login');
	}

	public function userDashboard(){
        $this->load->view('Utilisateur/templates/template');
    }

	public function deconnexion(){
        $this->session->sess_destroy();

        // Rediriger vers la page de connexion
        redirect('Welcome/index');
    }

	public function calendrier(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');

        $data = $this->models->getCalendar();
        $user['datas']=$data;
        $discipline=$this->models->getData('disciplines',['id_disciplines','nom']);
        $user['discipline']=$discipline;
        $site=$this->models->getData('site',['id_site','nom']);
        $user['site']=$site;

        $this->load->view('Utilisateur/templates/template-calendrier', $user);
    }

	public function calendrier_search(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');

		$daty= $this->input->post('daty');
		$discipline= $this->input->post('discipline');

		if($daty == 0){
			if($discipline==0){
				redirect('Welcome/calendrier');
			}
			else{
				$data = $this->models->getCalendarSearchDiscipline($discipline);
				$user['datas']=$data;
				$discipline=$this->models->getData('disciplines',['id_disciplines','nom']);
				$user['discipline']=$discipline;
				$site=$this->models->getData('site',['id_site','nom']);
				$user['site']=$site;
				$this->load->view('Utilisateur/templates/template-calendrier', $user);
			}
		}
		else{
			if($discipline==0){
				$data = $this->models->getCalendarSearchDaty($daty);
				$user['datas']=$data;
				$discipline=$this->models->getData('disciplines',['id_disciplines','nom']);
				$user['discipline']=$discipline;
				$site=$this->models->getData('site',['id_site','nom']);
				$user['site']=$site;
				$this->load->view('Utilisateur/templates/template-calendrier', $user);
			}
			else{
				$data = $this->models->getCalendarSearch($discipline,$daty);
				$user['datas']=$data;
				$discipline=$this->models->getData('disciplines',['id_disciplines','nom']);
				$user['discipline']=$discipline;
				$site=$this->models->getData('site',['id_site','nom']);
				$user['site']=$site;
				$this->load->view('Utilisateur/templates/template-calendrier', $user);
			}
			
		}

    }

	public function medaille(){
        $this->load->model('models');
		$this->load->helper('url');
		$this->load->helper('url_helper');

        $data = $this->models->getDashMedaille();
        $user['datas']=$data;
        $this->load->view('Utilisateur/templates/template-medaille', $user);
    }

	public function dashboard(){
        $this->load->library('session');
        $this->load->model('models');

        $requete=$this->models->getDash_budget();
        $user['datas']=$requete;
        
        $this->load->view('Utilisateur/templates/template-dashboard', $user);
    }

}
