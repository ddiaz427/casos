<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	function __construct()
	{
		parent::__construct(); 
		$this->load->library(array('comprobacion','form_validation'));
		if ($this->session->userdata('usuariosesion')['login'] == TRUE){
			redirect(base_url().'panel');
		}
	}

	function index(){
		$this->login();
	}

	function login()
	{	
		$datos = [
				'head' => $this->load->view('login/head', ['titulo' => 'login'], true),
				'cuerpo' => $this->load->view('login/form', null, true),
				'footer' => $this->load->view('login/footer', null, true),
			   ];	
        return $this->load->view('login/template',$datos);
	}

	function checkLogin(){
		//sleep(5);
		if($this->input->is_ajax_request()){	

			$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required');
			$this->form_validation->set_rules('clave', 'Clave', 'trim|required|sha1');

		 	if($this->form_validation->run($this) == FALSE){
                 $datos = array(
             		 'success'  => false,
             		 'mensages' => validation_errors()
             		 );
	             echo json_encode($datos);	 
			}
			else{	
				$respuesta = $this->comprobacion->auth($this->input->post('usuario'), $this->input->post('clave'));

				if(!isset($respuesta['error'])){
					$datos = array(
							'success'   => true,
							'mensages'  => $respuesta['success'],
							'respuesta' => base_url().'panel'
						);
					echo json_encode($datos);	
				}
				else{ 	
					$datos = array(
							'success'  => false,
							'mensages' => $respuesta['error']
						);
					echo json_encode($datos);
				}
			}
		}
        else{
        	show_404();	
        }
	}
}
