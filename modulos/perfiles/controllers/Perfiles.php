<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends MX_Controller {

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
			$datos['tabla'] = 'perfiles';
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',nombre,'', estado,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','id','nombre','estado','created_at','updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = $filas->nombre;
		            $row[] = $filas->estado;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'perfiles';
		
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(nombre,'', estado,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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

	function nuevo(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')){
				$this->load->view('nuevo');
			}else{
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required|callback_verificar_perfil');
				$this->form_validation->set_rules('estado', 'Estado', 'trim|required');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'perfiles';
					   $insertpersonal['nombre'] = $this->input->post('nombre');
					   $insertpersonal['estado'] = $this->input->post('estado');
					   $insertpersonal['created_at'] = FECHAGESTOR;
					   $insertpersonal['updated_at'] = FECHAGESTOR;

					   $datainsert_id = $this->Global_model->agregar($datos,$insertpersonal);

					   if ($datainsert_id){
					   	    echo json_encode(array('success'=> true, 'mensages' => 'Perfil Registrado Correctamente'));
					   }
				}		   
			}
		}else{
			show_404();
		}
	}

	function editar(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')){
			
				$datos['select'] = '*';
				$datos['tabla'] = 'perfiles';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['perfil'] = $this->Global_model->mostrar($datos);
				$this->load->view('editar',$data);
			}else{
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required|callback_comprobar_perfil');
				$this->form_validation->set_rules('estado', 'Estado', 'trim|required');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'perfiles';
					   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $personal['nombre'] = $this->input->post('nombre');
					   $personal['estado'] = $this->input->post('estado');
					   $personal['updated_at'] = FECHAGESTOR;
					 
					   $datosactualizar = $this->Global_model->actualizar($datos,$personal);

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

	function borrar(){
		if($this->input->is_ajax_request()){
				
			foreach ($this->input->post('id') as $value) {
				$datospersonal['tabla'] = 'perfiles';
				$datospersonal['where'] = array(0 => array("campo" => "id", "valor" => $value, "tipo" => "where"));
				$datospersona = $this->Global_model->borrar($datospersonal);

				if (!is_null($datospersona)){
					$datospersonales = true;
				}else{
					$datospersonales = false;
				}
			}

			if ($datospersonales == true) {
				echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente'));
			}else{
				echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar Datos'));
			}	
		}else{
			show_404();
		}
	}


	function verificar_perfil($val)
	{
		$datos['tabla'] = 'perfiles';	
		$datos['where'] = array(0 => array("campo" => "nombre", "valor" => $val, "tipo" => "where"));
		$datosconsulta = $this->Global_model->mostrar($datos);

		if(!is_null($datosconsulta))
        { 
			$this->form_validation->set_message('verificar_perfil', '<i class="fa fa-exclamation-triangle"></i> El Perfil '.$val.' ya existe en nuestra base de datos');
        	return false;
		}
		else
		{
			return true;
		}
	}

	
	function comprobar_perfil($val)
	{
		if($this->input->is_ajax_request())
        {
			$datos['tabla'] = 'perfiles';	
			$datos['where'] = array(0 => array("campo" => "nombre", "valor" => $val, "tipo" => "where"),
									1 => array("campo" => "id !=", "valor" => $this->input->post('id'), "tipo" => "where")
				);
			$datosconsulta = $this->Global_model->mostrar($datos);

			if(!is_null($datosconsulta))
	        { 
				$this->form_validation->set_message('comprobar_perfil', '<i class="fa fa-exclamation-triangle"></i> El nuevo perfil '.$val.' que trata de tomar está en uso');
	        	return false;
			}
			else
			{
				return true;
			}
		 }
		 else
		 {
		 	show_404();
		 }	
	}	
}
