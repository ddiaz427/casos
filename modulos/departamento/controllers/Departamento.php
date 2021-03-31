<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamento extends MX_Controller {

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

			$datos['select'] = 'd.id, d.departamento, p.pais';
			$datos['tabla'] = 'departamento d';
			$datos['join'] = array(0 => array("tabla" => "pais p", "condicion" => "p.id = d.pais_id", "tipo" => "INNER"));//Permite realizar joins;
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(departamento,' ',pais)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','departamento','pais');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "d.id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = $filas->departamento;
		            $row[] = $filas->pais;

		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['select'] = '*';
			$datoscontador['tabla'] = 'departamento d';
			$datoscontador['join'] = array(0 => array("tabla" => "pais p", "condicion" => "p.id = d.pais_id", "tipo" => "INNER"));//Permite realizar joins;
	        
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(departamento,' ',pais)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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

				 $datos['tabla'] = 'pais';
				 $datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));//
				 $data['pais'] = $this->Global_model->mostrar($datos);
				 $this->load->view('nuevo',$data);
			}else{

				$this->form_validation->set_rules('pais_id', 'Pais', 'trim|required');
				$this->form_validation->set_rules('departamento', 'Departamento', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'departamento';
					   $datainsert['departamento'] = $this->input->post('departamento');
					   $datainsert['pais_id'] = $this->input->post('pais_id');
					   $datainsert_id = $this->Global_model->agregar($datos,$datainsert);

					   if ($datainsert_id){
					   	    echo json_encode(array('success'=> true, 'mensages' => 'Departamento Registrado Correctamente'));
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
				
				 $datos['tabla'] = 'pais';
				 $datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));//
				 $data['pais'] = $this->Global_model->mostrar($datos);	

				$datos2['select'] = '*';
				$datos2['tabla'] = 'departamento';
				$datos2['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['departamento'] = $this->Global_model->mostrar($datos2);
				$this->load->view('editar',$data);
			}else{
				$this->form_validation->set_rules('pais_id', 'Pais', 'trim|required');
				$this->form_validation->set_rules('departamento', 'Departamento', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'departamento';
					   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $datosactualizar['departamento'] = $this->input->post('departamento');
					   $datosactualizar['pais_id'] = $this->input->post('pais_id');
					   $resultado = $this->Global_model->actualizar($datos,$datosactualizar);

					   if (!is_null($resultado)){
					   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
					   }else{
					   	echo json_encode(array('success'=> false, 'mensages' => 'Los Datos ya an sido Actualizado'));
					   }  
				}
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
				$datos['tabla'] = 'departamento';
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
