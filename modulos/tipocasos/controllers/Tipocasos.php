<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipocasos extends MX_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->helper(array('ayuda_helper'));
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
			$datos['tabla'] = 'tipo_casos';
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datos['like'] = array(
				0 => array("campo" => "CONCAT(nombre,' ',codigo,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','nombre','estado','created_at','updated_at');//Ordenado Segun filtro

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
		            $row[] = fechaseteada($filas->created_at);
		            $row[] = ($filas->updated_at != NULL)?fechaseteada($filas->updated_at):'';
		           
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'tipo_casos';
		
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$$datos['like'] = array(
				0 => array("campo" => "CONCAT(nombre,' ',codigo,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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
				$this->form_validation->set_rules('caso[]', 'Proceso', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
						foreach($this->input->post('caso') as $value){
							$cbd["tabla"] = "tipo_casos";
							$datos = array(
							'nombre' => $value,
							'created_at' => FECHAGESTOR
							);
							$insert_id = $this->Global_model->agregar($cbd, $datos);
	                 	}

					   if ($insert_id > 0){
					   	    echo json_encode(array('success'=> true, 'mensages' => 'Casos Registrado Correctamente'));
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
				
				$ids=array();
				foreach ($this->input->post('id') as $value) {
					$ids[] = $value; 
				}
				if (!empty($ids)){

					$datos1['select'] = '*';
					$datos1['tabla'] = 'tipo_casos';
					$datos1['where'] = array(0 => array("campo" => "id", "valor" => $ids, "tipo" => "where_in"));
					$data['casos'] = $this->Global_model->mostrar($datos1);
					$this->load->view('editar',$data);
				}else{

				}
			}else{
				$this->form_validation->set_rules('caso[]', 'Proceso', 'trim|required');
				$this->form_validation->set_rules('id[]', 'ID', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');

				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					  	$contador = 0;
						foreach($this->input->post('caso') as $key => $value){
							$cbd["tabla"] = "tipo_casos";
							$cbd['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id')[$key], "tipo" => "where"));
							
							$datos = array(
							'nombre' => $value,
							'updated_at' => FECHAGESTOR
							);

							$this->Global_model->actualizar($cbd,$datos);
	                 	}	
					   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
				}
			}
		}else{
			show_404();
		}
	}

	function ver(){
		if($this->input->is_ajax_request()){
			
			if (!empty($this->input->post('id'))) {
				$ids=array();
				foreach ($this->input->post('id') as $value) {
					$ids[] = $value; 
				}
				$datos['select'] = '*';
				$datos['tabla'] = 'tipo_casos';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $ids, "tipo" => "where_in"));
				$data['casos'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
				$this->load->view('ver',$data);
			}else{
				//echo json_encode(array('success' => false, 'mensages' => 'No hay id'));
				$datos['select'] = '*';
				$datos['tabla'] = 'tipo_casos';
				//$datos['where'] = array(0 => array("campo" => "id", "valor" => $ids, "tipo" => "where_in"));
				$data['casos'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
				$this->load->view('ver',$data);
				}
		}else{
			show_404();
		}
	}

	function borrar(){
		if($this->input->is_ajax_request()){
			$ids=array();
			foreach ($this->input->post('id') as $value) {
				$ids[] = $value; 
			}
			if (!empty($ids)) {
				$datos['tabla'] = 'tipo_casos';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $ids, "tipo" => "where_in"));
				$resultado = $this->Global_model->borrar($datos);

				if (!is_null($resultado)){
					echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente'));
				}else{
					echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar Datos'));
				}
			}else{
				echo json_encode(array('success' => false, 'mensages' => 'No hay id para Actualizar'));
			}
		}else{
			show_404();
		}
	}
}
