<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class estoque extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('bd_padaria');
		$this->load->library('session');
		$this->load->helper('url');
		
		$logged_in = $this->session->userdata('logged_in');

		if(!$logged_in){
			redirect('./login');
		}
	}

	
	public function index()
	{


		$notify = $this->bd_padaria->get_estoque();
		foreach($notify as $n){
			if($n->quantidade_disponivel <= $n->quantidade_minima_produto+($n->quantidade_minima_produto*0.5)){
				$notify_all[] = $n;
			} else{
				$notify_all[] = 0;
			}
		}
		$data["notificacoes"] = $notify_all;


		$data["title"] = "Estoque";
		$data["estoque"] = $this->bd_padaria->get_estoque();

		$this->load->helper('url');
		$this->load->view('components/navbar');
		$this->load->view('components/header', $data);
		$this->load->view('estoque',$data);
	}

	public function delete($id){
		
		$this->bd_padaria->delete_estoque($id);
		redirect('./estoque');

	}
}
