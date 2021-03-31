<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema extends MX_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->library(array('comprobacion','form_validation'));
        $this->comprobacion->check_sesion();
    }

    public function index(){
    	$this->listar();
    }

	public function listar()
	{	
		if($this->input->is_ajax_request()){
			$this->load->view('listar');
		}else{
			redirect(base_url().'panel');
		}
	}

	public function mostrar(){
		if($this->input->is_ajax_request()){

			$datos['select'] = '*';
			$datos['tabla'] = 'configuracion';
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(nombre_sitio,' ',descripcion,' ',correo,' ',estado_sitio,' ',fecha_actualizacion)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','nombre_sitio','descripcion','correo','estado_sitio','fecha_actualizacion');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "fecha_actualizacion", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = $filas->nombre_sitio;
		            $row[] = $filas->descripcion;
		            $row[] = $filas->correo;
		            $row[] = $filas->estado_sitio;
		            $row[] = $filas->fecha_actualizacion;
		            
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'configuracion';
		
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',nombre_sitio,' ',descripcion,' ',correo,' ',estado_sitio,' ',fecha_actualizacion)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }
			$contador = $this->Global_model->mostrar($datoscontador);

	        echo json_encode(array(
	                    "draw" => $this->input->post("draw"),
	                    "recordsTotal" => !is_null($consulta)?$consulta[0]->total:0,
	                    "recordsFiltered" => !is_null($contador)?$contador[0]->subtotal:0,
	                    "data" => $data,
	                ));
	     }else{
	     	show_404();
	     }   
	}

	function editar(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')){
				$datossql['tabla'] = 'configuracion';
				$datossql['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['config'] = $this->Global_model->mostrar($datossql);
				$this->load->view('visualizar',$data);
			}else{
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required');
				$this->form_validation->set_rules('descripcion', 'Descripción', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('estado', 'Estado', 'trim|required');
				//$this->form_validation->set_rules('mision', 'Misión', 'trim|required');
				//$this->form_validation->set_rules('vision', 'Visión', 'trim|required');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datossql['tabla'] = 'configuracion';
					   $datossql['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $actualizar['nombre_sitio'] = $this->input->post('nombre');
					   $actualizar['descripcion'] = $this->input->post('descripcion');
					   $actualizar['correo'] = $this->input->post('email');
					   $actualizar['mision'] = $this->input->post('mision');
					   $actualizar['vision'] = $this->input->post('vision');
					   $actualizar['estado_sitio'] = $this->input->post('estado');
					   $actualizar['palabras_clave'] = $this->input->post('palabras_clave');
					   $actualizar['logo'] = $this->input->post('logo');
					   $actualizar['fecha_actualizacion'] = FECHAGESTOR;
					 
					   $datosactualizar = $this->Global_model->actualizar($datossql,$actualizar);

					   if (!is_null($datosactualizar)){
					   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
					   }else{
					   	echo json_encode(array('success'=> false, 'mensages' => 'Error al Actualizar Datos Personales'));
					   }  
				}
			}
		}else{
			show_404();
		}
	}

	function ver(){
		if($this->input->is_ajax_request()){
				$datos['tabla'] = 'configuracion';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['config'] = $this->Global_model->Mostrar($datos);
				//print_r($data['configuracion']);
				$this->load->view('ver',$data);

		}else{
			show_404();
		}
	}
}
