<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ciudad extends MX_Controller {

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

			$datos['select'] = 'c.id, c.ciudad, d.departamento, p.pais';
			$datos['tabla'] = 'ciudad c';
			//$datos['tabla'] = 'departamento d';
			$datos['join'] = array(
								   0 => array("tabla" => "departamento d", "condicion" => "d.id = c.departamento_id", "tipo" => "INNER"),
								   1 => array("tabla" => "pais p", "condicion" => "p.id = d.pais_id", "tipo" => "INNER"),
			);//Permite realizar joins;
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(ciudad,' ',departamento,' ',pais)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','pais','departamento','ciudad');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "c.id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = $filas->pais;
		            $row[] = $filas->departamento;
		            $row[] = $filas->ciudad;

		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	    
	        $datoscontador['tabla'] = 'ciudad c';
			$datoscontador['join'] = array(
								   0 => array("tabla" => "departamento d", "condicion" => "d.id = c.departamento_id", "tipo" => "INNER"),
								   1 => array("tabla" => "pais p", "condicion" => "p.id = d.pais_id", "tipo" => "INNER"),
			);//Permite realizar joins;
	        
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(ciudad,' ',departamento,' ',pais)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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
				$this->form_validation->set_rules('distrito_id', 'Departamento', 'trim|required');
				$this->form_validation->set_rules('ciudad', 'Ciudad', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'ciudad';
					   $datainsert['ciudad'] = $this->input->post('ciudad');
					   $datainsert['departamento_id'] = $this->input->post('distrito_id');
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


				$datos2['select'] = 'c.id, c.ciudad, c.departamento_id, p.id as pais_id';
				$datos2['tabla'] = 'ciudad c';
				//$datos['tabla'] = 'departamento d';
				$datos2['join'] = array(
								   0 => array("tabla" => "departamento d", "condicion" => "d.id = c.departamento_id", "tipo" => "INNER"),
								   1 => array("tabla" => "pais p", "condicion" => "p.id = d.pais_id", "tipo" => "INNER"),
								   );

				$datos2['where'] = array(0 => array("campo" => "c.id", "valor" => $this->input->post('id'), "tipo" => "where"));

				$data['ciudad'] = $this->Global_model->mostrar($datos2);
				$this->load->view('editar',$data);
			}else{

				$this->form_validation->set_rules('pais_id', 'Pais', 'trim|required');
				$this->form_validation->set_rules('distrito_id', 'Departamento', 'trim|required');
				$this->form_validation->set_rules('ciudad', 'Ciudad', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'ciudad';
					   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $datosactualizar['ciudad'] = $this->input->post('ciudad');
					   $datosactualizar['departamento_id'] = $this->input->post('distrito_id');
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
				$datos['tabla'] = 'ciudad';
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

	public function distritos(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, departamento';
        $data['tabla'] = 'departamento'; 
        $data['where'] = array(0 => array("campo" => "pais_id", "valor" => $this->input->post('pais_id'), "tipo" => "where"));
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'departamento' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }
}
