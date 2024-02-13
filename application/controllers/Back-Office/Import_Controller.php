<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_Controller extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->helper(array('form','url'));
    }

    public function import(){
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
        $this->load->view('Back-Office/templates/template-import', $user);
    }

    /*public function importer_csv(){
		if (isset($_FILES['fichier_csv']) && $_FILES['fichier_csv']['error'] == UPLOAD_ERR_OK) {
            
            //fgets($handle);

			$csv_file = $_FILES['fichier_csv']['tmp_name'];
			$handle = fopen($csv_file, 'r');
            $content = file_get_contents($csv_file);
            //var_dump($_FILES['fichier_csv']);
			$this->load->model('models');

			while (($data = fgetcsv($handle)) !== false) {
				$array = explode(";", $data[0]);

				$val=$this->models->getdepensebycode($array[1]);
                $date = date("Y-m-d", strtotime($array[0])); // Formater la date en AAAA-MM-JJ
                $montant = is_numeric($array[2]) ? $array[2] : 0; 
				$this->models->ajoutDepenseP(
					$val[0]['id_type_depense'],
					$date,
					$montant
				);
			}
			fclose($handle);
			header('Location:'.base_url().'Front-Office/Depense_Controller/succes_import');
		} else {
			echo 'Erreur lors de l\'importation du fichier CSV.';
		} 
    }*/


    public function importer_csv(){
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
        if (isset($_FILES['fichier_csv']) && $_FILES['fichier_csv']['error'] == UPLOAD_ERR_OK) {
            $csv_file = $_FILES['fichier_csv']['tmp_name'];
            $handle = fopen($csv_file, 'r');
            $this->load->model('models');
    
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                // Assurez-vous que le CSV a le bon nombre de colonnes
                if (count($data) != 2) {
                    echo 'Erreur: Format CSV incorrect.';
                    return;
                }
    
                if($data[0]=='GRP1'){
                    $this->models->update('groupe',['capacitemax'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='GRP2'){
                    $this->models->update('groupe',['capacitereservoir'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='GRP3'){
                    $this->models->update('groupe',['consoparlitreheure'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='GRP4'){
                    $this->models->update('groupe',['prixessence'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='SOL1'){
                    $this->models->update('panneausolaire',['capacitemax'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='SOL2'){
                    $this->models->update('pourcentagepanneausolaire',['pourcentage'],[$data[1]],['id'],[3]);
                }
                if($data[0]=='SOL3'){
                    $this->models->update('pourcentagepanneausolaire',['pourcentage'],[$data[1]],['id'],[2]);
                }
                if($data[0]=='SOL4'){
                    $this->models->update('pourcentagepanneausolaire',['pourcentage'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='SOL5'){
                    $this->models->update('panneausolaire',['tarifenwatt'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='JIR1'){
                    $this->models->update('jirama',['capacitemax'],[$data[1]],['id'],[1]);
                }
                if($data[0]=='JIR2'){
                    $this->models->update('jirama',['coutparwatt'],[$data[1]],['id'],[1]);
                }

            }
            fclose($handle);
            $this->session->set_flashdata('success', 'Importation réussie');
            $this->load->view('Back-Office/templates/template-import', $user);
        } else {
            echo 'Erreur lors de l\'importation du fichier CSV.';
        }
    }

}

