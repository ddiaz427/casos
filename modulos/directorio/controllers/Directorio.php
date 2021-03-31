<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directorio extends MX_Controller {

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
			$datos['tabla'] = 'directorio';
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(nombres,' ',correo,' ',telefono_empresa,' ',movil,' ',direccion,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','nombre','correo','telefono_empresa','movil','direccion','created_at','updated_at');//Ordenado Segun filtro

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
		            $row[] = $filas->nombres;
		            $row[] = $filas->correo;
		            $row[] = $filas->telefono_empresa;
		            $row[] = $filas->movil;
		            $row[] = $filas->direccion;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'directorio';
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(nombres,' ',correo,' ',telefono_empresa,' ',movil,' ',direccion,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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
				$this->load->view('consultar');
			}else{
				$this->form_validation->set_rules('tipo_busqueda', 'Tipo de Busqueda', 'trim|required');
				$this->form_validation->set_rules('buscar', 'Buscar', 'trim|required');
				$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					$this->load->view('consultar');
				}else{	
					$datos['select'] = '*';
					$datos['tabla'] = 'clientes';
					if ($this->input->post('tipo_busqueda') == 'nombres') {
						$datos['like'] = array(
						0 => array("campo" => "nombres", "valor" => $this->input->post('buscar'), "comodin" => "both", "tipo" => "like")
						); //both	
					}elseif($this->input->post('tipo_busqueda') == 'email'){
						$datos['where'] = array(0 => array("campo" => $this->input->post('tipo_busqueda'), "valor" => $this->input->post('buscar'), "tipo" => "where"));
					}
					$data['clientes'] = $this->Global_model->mostrar($datos);

					//echo "existe";
					$datos2['select'] = 'id, nombre';
					$datos2['tabla'] = 'profesion';
					$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
					$data['profesion'] = $this->Global_model->mostrar($datos2);

					$datos3['select'] = 'id, pais';
					$datos3['tabla'] = 'pais';
					$datos3['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
					$data['pais'] = $this->Global_model->mostrar($datos3);

					$datos4['select'] = 'id, nombre';
					$datos4['tabla'] = 'tipo_identificacion';
					$datos4['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
					$data['identificacion'] = $this->Global_model->mostrar($datos4);

					$data['mensaje'] = !is_null($data['clientes'])
					?'<b class="text-success">Contacto encontrado en la base de datos:</b> <b class="text-danger">'.$data['clientes'][0]->nombres.'</b>'
					:'<b class="text-success">El contacto no tiene datos registrados en nuestra base de datos</b>';
					$this->load->view('registrar_contacto_existente',$data);
				}		   
			}
		}else{
			show_404();
		}
	}

	public function registrar(){
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('nacimiento', 'Fecha Naciemiento', 'trim|required');
			$this->form_validation->set_rules('profesion_id', 'Profesión', 'trim|required');
			$this->form_validation->set_rules('empresa', 'Empresa', 'trim|required');
			$this->form_validation->set_rules('telefono', 'Télefono', 'trim|required');
			//$this->form_validation->set_rules('movil', 'Movil', 'trim|required');
			$this->form_validation->set_rules('idetificacion_id', 'identificacion', 'trim|required');
			$this->form_validation->set_rules('nroidentificacion', 'Nro de Identificación', 'trim|required|callback_verificar_cedula');
			$this->form_validation->set_rules('pais_id', 'Pais', 'trim|required');
			$this->form_validation->set_rules('distrito_id', 'Distrito', 'trim|required');
			$this->form_validation->set_rules('ciudad_id', 'Ciudad', 'trim|required');
			$this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');
			$this->form_validation->set_rules('profesion_id', 'Profesión', 'trim|required');
			$this->form_validation->set_rules('cargo', 'Cargo', 'trim|required');

			$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
			if ($this->form_validation->run($this) == FALSE)
			{	
				$datos2['select'] = 'id, nombre';
				$datos2['tabla'] = 'profesion';
				$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['profesion'] = $this->Global_model->mostrar($datos2);

				$datos3['select'] = 'id, pais';
				$datos3['tabla'] = 'pais';
				$datos3['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['pais'] = $this->Global_model->mostrar($datos3);

				$datos4['select'] = 'id, nombre';
				$datos4['tabla'] = 'tipo_identificacion';
				$datos4['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['identificacion'] = $this->Global_model->mostrar($datos4);

				$data['mensaje'] = validation_errors('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>','</div>');
				$this->load->view('registrar_contacto_existente',$data);
			}else{
					   $sql['tabla'] = 'directorio';
					   $insert['nombres'] = $this->input->post('nombre');
					   $insert['correo'] = $this->input->post('email');
					   $insert['profesion_id'] = $this->input->post('profesion_id');
					   $insert['empresa'] = $this->input->post('empresa');
					   $insert['telefono_empresa'] = $this->input->post('telefono');
					   $insert['cargo'] = $this->input->post('cargo');
					   $insert['movil'] = $this->input->post('movil');
					   $insert['tipo_identificacion_id'] = $this->input->post('idetificacion_id');
					   $insert['numero_identificacion'] = $this->input->post('nroidentificacion');
					   $insert['direccion'] = $this->input->post('direccion');
					   $insert['pais_id'] = $this->input->post('pais_id');
					   $insert['departamento_id'] = $this->input->post('distrito_id');
					   $insert['ciudad_id'] = $this->input->post('ciudad_id');
					   $insert['fecha_nacimiento'] = $this->input->post('nacimiento');  
					   $insert['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];          
					   $insert['created_at'] = FECHAGESTOR;
					   $insert['updated_at'] = FECHAGESTOR;

					   if (!is_null($this->Global_model->agregar($sql,$insert))){
					   		$this->listar();
					   }else{
					   	$datos2['select'] = 'id, nombre';
						$datos2['tabla'] = 'profesion';
						$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
						$data['profesion'] = $this->Global_model->mostrar($datos2);

						$datos3['select'] = 'id, pais';
						$datos3['tabla'] = 'pais';
						$datos3['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
						$data['pais'] = $this->Global_model->mostrar($datos3);

						$datos4['select'] = 'id, nombre';
						$datos4['tabla'] = 'tipo_identificacion';
						$datos4['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
						$data['identificacion'] = $this->Global_model->mostrar($datos4);

						$data['mensaje'] = 'error al insertar';
						$this->load->view('registrar_contacto_existente',$data);
					   }  
				}
		}else{
			show_404();
		}
	}

	function verificar_cedula($val)
	{
		$datos['tabla'] = 'directorio';	
		$datos['where'] = array(0 => array("campo" => "numero_identificacion", "valor" => $val, "tipo" => "where"));
		$datosconsulta = $this->Global_model->mostrar($datos);

		if(!is_null($datosconsulta))
        { 
			$this->form_validation->set_message('verificar_cedula', '<i class="fa fa-exclamation-triangle"></i> La Cedula '.$val.' ya existe en nuestra base de datos');
        	return false;
		}
		else
		{
			return true;
		}
	}

	function editar(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')){
				
				$datos2['select'] = 'id, nombre';
				$datos2['tabla'] = 'profesion';
				$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['profesion'] = $this->Global_model->mostrar($datos2);

				$datos3['select'] = 'id, pais';
				$datos3['tabla'] = 'pais';
				$datos3['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['pais'] = $this->Global_model->mostrar($datos3);

				$datos4['select'] = 'id, nombre';
				$datos4['tabla'] = 'tipo_identificacion';
				$datos4['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['identificacion'] = $this->Global_model->mostrar($datos4);	

				$datos['select'] = '*';
				$datos['tabla'] = 'directorio';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['directorio'] = $this->Global_model->mostrar($datos);
				$this->load->view('editar',$data);
			}else{
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datossql['tabla'] = 'Directorio';
					   $datossql['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $actualizar['nombres'] = $this->input->post('nombre');
					   $actualizar['correo'] = $this->input->post('email');
					   $actualizar['profesion_id'] = $this->input->post('profesion_id');
					   $actualizar['empresa'] = $this->input->post('empresa');
					   $actualizar['telefono_empresa'] = $this->input->post('telefono');
					   $actualizar['cargo'] = $this->input->post('cargo');
					   $actualizar['movil'] = $this->input->post('movil');
					   $actualizar['tipo_identificacion_id'] = $this->input->post('idetificacion_id');
					   $actualizar['numero_identificacion'] = $this->input->post('nroidentificacion');
					   $actualizar['direccion'] = $this->input->post('direccion');
					   $actualizar['pais_id'] = $this->input->post('pais_id');
					   $actualizar['departamento_id'] = $this->input->post('distrito_id');
					   $actualizar['ciudad_id'] = $this->input->post('ciudad_id');
					   $actualizar['fecha_nacimiento'] = $this->input->post('nacimiento');  
					   $actualizar['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];          
					   $actualizar['updated_at'] = FECHAGESTOR;
					 
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

	function borrar(){
		if($this->input->is_ajax_request()){
			$ids=array();
			foreach ($this->input->post('id') as $value) {
				$ids[] = $value; 
			}
			if (!empty($ids)) {
				$datos['tabla'] = 'directorio';
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
