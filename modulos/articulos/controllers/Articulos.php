<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends MX_Controller {

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

			$datos['select'] = 'ar.id, ar.nombre as articulo, da.nombre as detalleactividad, a.nombre as actividad, ar.estado, ar.created_at, ar.updated_at, tp.nombre as proceso, tc.nombre as caso, sp.nombre as subproceso';
			$datos['tabla'] = 'articulos ar';
			$datos['join'] = array(
					0 => array("tabla" => "detalleactividad da", "condicion" => "da.id = ar.detalle_actividad_id", "tipo" => "INNER"),
					1 => array("tabla" => "actividades a", "condicion" => "a.id = da.actividad_id", "tipo" => "INNER"),
					2 => array("tabla" => "sub_procesos sp", "condicion" => "a.sub_proceso_id = sp.id", "tipo" => "INNER"),
                    3 => array("tabla" => "tipo_procesos tp", "condicion" => "sp.proceso_id = tp.id", "tipo" => "INNER"),
                    4 => array("tabla" => "tipo_casos tc", "condicion" => "tp.caso_id = tc.id", "tipo" => "INNER"),
                    );
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
					0 => array("campo" => "CONCAT(tc.nombre,' ',tp.nombre,' ',sp.nombre,' ',a.nombre)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','tc.nombre','tp.nombre','','sp.nombre','a.nombre','da.nombre','ar.nombre','ar.estado','ar.created_at','ar.updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "ar.updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = $filas->caso;
		            $row[] = $filas->proceso;
		            $row[] = $filas->subproceso;
		            $row[] = $filas->actividad;
		            $row[] = $filas->detalleactividad;
		            $row[] = $filas->articulo;
		            $row[] = $filas->estado;
		            $row[] = fechaseteada($filas->created_at);
		            $row[] = ($filas->updated_at != NULL)?fechaseteada($filas->updated_at):'';
		           
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	      	$datoscontador['tabla'] = 'articulos ar';
			$datoscontador['join'] = array(
					0 => array("tabla" => "detalleactividad da", "condicion" => "da.id = ar.detalle_actividad_id", "tipo" => "INNER"),
					1 => array("tabla" => "actividades a", "condicion" => "a.id = da.actividad_id", "tipo" => "INNER"),
					2 => array("tabla" => "sub_procesos sp", "condicion" => "a.sub_proceso_id = sp.id", "tipo" => "INNER"),
                    3 => array("tabla" => "tipo_procesos tp", "condicion" => "sp.proceso_id = tp.id", "tipo" => "INNER"),
                    4 => array("tabla" => "tipo_casos tc", "condicion" => "tp.caso_id = tc.id", "tipo" => "INNER"),
                    );
		
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
					0 => array("campo" => "CONCAT(tc.nombre,' ',tp.nombre,' ',sp.nombre,' ',a.nombre)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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

				$datos0['select'] = 'id, nombre';
				$datos0['tabla'] = 'tipo_casos';
				$datos0['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));
				$data['casos'] = $this->Global_model->mostrar($datos0);// Le paso los datos de la consulta
				$this->load->view('nuevo',$data);
			}else{
				$this->form_validation->set_rules('caso_id', 'Caso', 'trim|required');
				$this->form_validation->set_rules('proceso_id', 'Proceso', 'trim|required');
				$this->form_validation->set_rules('subproceso_id', 'Sub Proceso', 'trim|required');
				$this->form_validation->set_rules('actividad_id', 'Actividad', 'trim|required');
				$this->form_validation->set_rules('detalle_actividad_id', 'Detalle Actividad', 'trim|required');
				$this->form_validation->set_rules('articulo', 'Art??culo', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
						$cbd["tabla"] = "articulos";
						$datos = array(
						'detalle_actividad_id' => $this->input->post('detalle_actividad_id'),
						'nombre' => $this->input->post('articulo'),
						'created_at' => FECHAGESTOR,
						'usuario_id' => 1
						);
						$insert_id = $this->Global_model->agregar($cbd, $datos);

					   if ($insert_id > 0){
					   	    echo json_encode(array('success'=> true, 'mensages' => 'Proceso Registrado Correctamente'));
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

					$datos1['select'] = 'ar.id, ar.nombre as articulo, da.id as detalleactividad, a.id as actividad, da.estado, da.created_at, da.updated_at, tp.id as proceso, tc.id as caso, sp.id as subproceso';
					$datos1['tabla'] = 'articulos ar';
					$datos1['join'] = array(
							0 => array("tabla" => "detalleactividad da", "condicion" => "da.id = ar.detalle_actividad_id", "tipo" => "INNER"),
							1 => array("tabla" => "actividades a", "condicion" => "a.id = da.actividad_id", "tipo" => "INNER"),
							2 => array("tabla" => "sub_procesos sp", "condicion" => "a.sub_proceso_id = sp.id", "tipo" => "INNER"),
		                    3 => array("tabla" => "tipo_procesos tp", "condicion" => "sp.proceso_id = tp.id", "tipo" => "INNER"),
		                    4 => array("tabla" => "tipo_casos tc", "condicion" => "tp.caso_id = tc.id", "tipo" => "INNER"),
		                    );
					$datos1['where'] = array(0 => array("campo" => "ar.id", "valor" => $ids, "tipo" => "where_in"));
					$data['articulo'] = $this->Global_model->mostrar($datos1);

					$datos0['select'] = 'id, nombre';
					$datos0['tabla'] = 'tipo_casos';
					$datos0['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));
					$data['casos'] = $this->Global_model->mostrar($datos0);// Le paso los datos de la consulta
					//echo "<pre>";
					//print_r($data['articulo']);
					$this->load->view('editar',$data);
				}else{

				}
			}else{
				$this->form_validation->set_rules('caso_id', 'Caso', 'trim|required');
				$this->form_validation->set_rules('proceso_id', 'Proceso', 'trim|required');
				$this->form_validation->set_rules('subproceso_id', 'Sub Proceso', 'trim|required');
				$this->form_validation->set_rules('actividad_id', 'Actividad', 'trim|required');
				$this->form_validation->set_rules('detalle_actividad_id', 'Detalle Actividad', 'trim|required');
				$this->form_validation->set_rules('articulo', 'Art??culo', 'trim|required');
				$this->form_validation->set_rules('id', 'ID', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');

				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
							$cbd["tabla"] = "articulos";
							$cbd['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
							$datos = array(
							'detalle_actividad_id' => $this->input->post('detalle_actividad_id'),
							'nombre' => $this->input->post('articulo'),
							'updated_at' => FECHAGESTOR
							);

						$this->Global_model->actualizar($cbd,$datos);	
					   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
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
				$datos['tabla'] = 'articulos';
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

	public function get_procesos(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, nombre';
        $data['tabla'] = 'tipo_procesos'; 
        $data['where'] = array(0 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id'), "tipo" => "where"));
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'nombre' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }

    public function get_subprocesos(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, nombre';
        $data['tabla'] = 'sub_procesos'; 
        $data['where'] = array(0 => array("campo" => "proceso_id", "valor" => $this->input->post('proceso_id'), "tipo" => "where"));
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'nombre' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }

    public function get_actividades(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, nombre';
        $data['tabla'] = 'actividades'; 
        $data['where'] = array(0 => array("campo" => "sub_proceso_id", "valor" => $this->input->post('proceso_id'), "tipo" => "where"));
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'nombre' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }

    public function get_detalle_actividades(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, nombre';
        $data['tabla'] = 'detalleactividad'; 
        $data['where'] = array(0 => array("campo" => "actividad_id", "valor" => $this->input->post('actividad_id'), "tipo" => "where"));
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'nombre' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }

    
}
