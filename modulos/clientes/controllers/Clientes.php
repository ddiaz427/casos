<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends MX_Controller {

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
			$datos['tabla'] = 'clientes';
			$data['where'] = array(0 => array("campo" => "usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"));
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(nombres,' ',cedula,' ',email,' ',sexo,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','avatar','nombres','cedula','email','sexo','created_at','updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	if ($filas->avatar == NULL) {
		        		$img = base_url('assets/images/anonimo.jpg');
		        	}else{
		        		$img = $filas->avatar;
		        	}

		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = '<img width="50" class="img-responsive img-circle" src="'.$img.'">';
		            $row[] = $filas->nombres;
		            $row[] = $filas->cedula;
		            $row[] = $filas->email;
		            $row[] = $filas->sexo;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'clientes';
			$datoscontador['where'] = array(0 => array("campo" => "usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"));
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(nombres,' ',cedula,' ',email,' ',sexo,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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
				$datos['select'] = 'id, nombre';
				$datos['tabla'] = 'profesion';
				$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['profesion'] = $this->Global_model->mostrar($datos);

				$datos['select'] = 'id, pais';
				$datos['tabla'] = 'pais';
				$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['pais'] = $this->Global_model->mostrar($datos);

				$this->load->view('nuevo',$data);
			}else{

				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required');
				$this->form_validation->set_rules('tipo_persona', 'Tipo Persona', 'trim|required');
				$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required');
				$this->form_validation->set_rules('genero', 'Genero', 'trim|required');
				$this->form_validation->set_rules('civil', 'Estado Civil', 'trim|required');
				$this->form_validation->set_rules('profesion_id', 'Profesión', 'trim|required');
				$this->form_validation->set_rules('telefono', 'Télefono', 'trim|required');
				//$this->form_validation->set_rules('movil', 'Movil', 'trim|required');
				//$this->form_validation->set_rules('fax', 'Fax', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('estado', 'Estado', 'trim|required');
				$this->form_validation->set_rules('pais_id', 'Pais', 'trim|required');
				$this->form_validation->set_rules('distrito_id', 'Distrito', 'trim|required');
				$this->form_validation->set_rules('ciudad_id', 'Ciudad', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'clientes';
					   $insert['nombres'] = $this->input->post('nombre');
					   $insert['tipo_persona'] = $this->input->post('tipo_persona');
					   $insert['direccion'] = $this->input->post('direccion');
					   $insert['civil'] = $this->input->post('civil');
					   $insert['profesion_id'] = $this->input->post('profesion_id');
					   $insert['telefono'] = $this->input->post('telefono');
					   $insert['movil'] = $this->input->post('movil');
					   $insert['fax'] = $this->input->post('fax');
					   $insert['cedula'] = $this->input->post('cedula');
					   $insert['sexo'] = $this->input->post('genero');
					   $insert['email'] = $this->input->post('email');
					   $insert['observacion'] = $this->input->post('observacion');         
					   $insert['avatar'] = $this->input->post('avatar');
					   $insert['pais_id'] = $this->input->post('pais_id');
					   $insert['departamento_id'] = $this->input->post('distrito_id');
					   $insert['ciudad_id'] = $this->input->post('ciudad_id');
					   $insert['estado'] = $this->input->post('estado');
					   $insert['created_at'] = FECHAGESTOR;
					   $insert['updated_at'] = FECHAGESTOR;
					   $insert['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];

					   $datainsert_id = $this->Global_model->agregar($datos,$insert);

					   if ($datainsert_id){

					   		if(!empty($_FILES["files"]["name"][0])) {
					   			
					   			$this->load->library("upload");
								$config = array(
									"upload_path" => "./assets/archivos",
									'allowed_types' => "jpg|png|pdf|word|excel"
								);
								$variablefile= $_FILES;
								$info = array();
								$files = count($_FILES['files']['name']);
								for ($i=0; $i < $files; $i++) { 
									$_FILES['files']['name'] = $variablefile['files']['name'][$i];
									$_FILES['files']['type'] = $variablefile['files']['type'][$i];
									$_FILES['files']['tmp_name'] = $variablefile['files']['tmp_name'][$i];
									$_FILES['files']['error'] = $variablefile['files']['error'][$i];
									$_FILES['files']['size'] = $variablefile['files']['size'][$i];
									$this->upload->initialize($config);
									if ($this->upload->do_upload('files')) {
										$data = array("upload_data" => $this->upload->data());

										   $datos2['tabla'] = 'archivos';
										   $insert2['cliente_id'] = $datainsert_id;
										   $insert2['nombre_archivo'] = $data['upload_data']['file_name'];
										   $insert2['created_at'] = FECHAGESTOR;
										   $insert2['updated_at'] = FECHAGESTOR;
					   					   $insert2['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];

					   					   $this->Global_model->agregar($datos2,$insert2);

					   					   $info[$i] = array(
												"archivo" => $data['upload_data']['file_name'],
												"mensaje" => "Archivo subido y guardado"
											);
									}
									else{
										//echo $this->upload->display_errors();
										$info[$i] = array(
												"archivo" => $_FILES['files']['name'],
												"mensaje" => "Archivo no subido Pero se actualizo la informacion del cliente"
										);
									}
								}

								$envio = "";
								foreach ($info as $key) {
									$envio .= "Archivo : ".$key['archivo']." - ".$key["mensaje"]."\n";
								}

								echo json_encode(array('success'=> true, 'mensages' => $envio));
					   		}else{
					   			echo json_encode(array('success'=> true, 'mensages' => 'Datos Registrados Correctamente'));
					   		}
					   	    //echo json_encode(array('success'=> true, 'mensages' => 'Perfil Registrado Correctamente'));
					   }else{
					   		echo json_encode(array('success'=> false, 'mensages' => 'Error al guardar el registro intente de nuevo'));
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
				
				$datos['select'] = 'id, nombre';
				$datos['tabla'] = 'profesion';
				$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['profesion'] = $this->Global_model->mostrar($datos);

				$datos['select'] = 'id, pais';
				$datos['tabla'] = 'pais';
				$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$data['pais'] = $this->Global_model->mostrar($datos);	

				$datos['select'] = '*';
				$datos['tabla'] = 'clientes';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['cliente'] = $this->Global_model->mostrar($datos);
				$this->load->view('editar',$data);
			}else{
				$this->form_validation->set_rules('id', 'Id', 'trim|required');
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required');
				$this->form_validation->set_rules('tipo_persona', 'Tipo Persona', 'trim|required');
				$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required');
				$this->form_validation->set_rules('genero', 'Genero', 'trim|required');
				$this->form_validation->set_rules('civil', 'Estado Civil', 'trim|required');
				$this->form_validation->set_rules('profesion_id', 'Profesión', 'trim|required');
				$this->form_validation->set_rules('telefono', 'Télefono', 'trim|required');
				//$this->form_validation->set_rules('movil', 'Movil', 'trim|required');
				//$this->form_validation->set_rules('fax', 'Fax', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('estado', 'Estado', 'trim|required');
				$this->form_validation->set_rules('pais_id', 'Pais', 'trim|required');
				$this->form_validation->set_rules('distrito_id', 'Distrito', 'trim|required');
				$this->form_validation->set_rules('ciudad_id', 'Ciudad', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datossql['tabla'] = 'clientes';
					   $datossql['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $actualizar['nombres'] = $this->input->post('nombre');
					   $actualizar['tipo_persona'] = $this->input->post('tipo_persona');
					   $actualizar['direccion'] = $this->input->post('direccion');
					   $actualizar['civil'] = $this->input->post('civil');
					   $actualizar['profesion_id'] = $this->input->post('profesion_id');
					   $actualizar['telefono'] = $this->input->post('telefono');
					   $actualizar['movil'] = $this->input->post('movil');
					   $actualizar['fax'] = $this->input->post('fax');
					   $actualizar['cedula'] = $this->input->post('cedula');
					   $actualizar['sexo'] = $this->input->post('genero');
					   $actualizar['email'] = $this->input->post('email');
					   $actualizar['observacion'] = $this->input->post('observacion');         
					   $actualizar['avatar'] = $this->input->post('avatar');
					   $actualizar['pais_id'] = $this->input->post('pais_id');
					   $actualizar['departamento_id'] = $this->input->post('distrito_id');
					   $actualizar['ciudad_id'] = $this->input->post('ciudad_id');
					   $actualizar['estado'] = $this->input->post('estado');
					   $actualizar['updated_at'] = FECHAGESTOR;
					   $actualizar['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];
					 
					   $datosactualizar = $this->Global_model->actualizar($datossql,$actualizar);

					   if (!is_null($datosactualizar)){
					   	//print_r($_FILES["files"]["name"]);	
				   		if(!empty($_FILES["files"]["name"][0])) {
				   			
				   			$this->load->library("upload");
							$config = array(
								"upload_path" => "./assets/archivos",
								'allowed_types' => "jpg|png|pdf|word|excel"
							);
							$variablefile= $_FILES;
							$info = array();
							$files = count($_FILES['files']['name']);
							for ($i=0; $i < $files; $i++) { 
								$_FILES['files']['name'] = $variablefile['files']['name'][$i];
								$_FILES['files']['type'] = $variablefile['files']['type'][$i];
								$_FILES['files']['tmp_name'] = $variablefile['files']['tmp_name'][$i];
								$_FILES['files']['error'] = $variablefile['files']['error'][$i];
								$_FILES['files']['size'] = $variablefile['files']['size'][$i];
								$this->upload->initialize($config);
								if ($this->upload->do_upload('files')) {
									$data = array("upload_data" => $this->upload->data());

									   $datos2['tabla'] = 'archivos';
									   $insert2['cliente_id'] = $this->input->post('id');
									   $insert2['nombre_archivo'] = $data['upload_data']['file_name'];
									   $insert2['created_at'] = FECHAGESTOR;
									   $insert2['updated_at'] = FECHAGESTOR;
				   					   $insert2['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];

				   					   $this->Global_model->agregar($datos2,$insert2);

				   					   $info[$i] = array(
											"archivo" => $data['upload_data']['file_name'],
											"mensaje" => "Archivo subido y guardado"
										);
								}
								else{
									//echo $this->upload->display_errors();
									$info[$i] = array(
											"archivo" => $_FILES['files']['name'],
											"mensaje" => "Archivo no subido ni guardado"
									);
								}
							}

							$envio = "";
							foreach ($info as $key) {
								$envio .= "Archivo : ".$key['archivo']." - ".$key["mensaje"]."\n";
							}

							echo json_encode(array('success'=> true, 'mensages' => $envio));
				   		}else{
				   			echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
				   		}	

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
				$datos['tabla'] = 'clientes';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $ids, "tipo" => "where_in"));
				$resultado = $this->Global_model->borrar($datos);

				$datos2['tabla'] = 'archivos';
				$datos2['where'] = array(0 => array("campo" => "cliente_id", "valor" => $ids, "tipo" => "where_in"));
				$resultado2 = $this->Global_model->borrar($datos2);

				if (!is_null($resultado) and !is_null($resultado2)){
					echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente'));
				}else{
					echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar Datos'));
				}
			}else{
				echo json_encode(array('success' => false, 'mensages' => 'No hay id para Borrar'));
			}
		}else{
			show_404();
		}
	}

	public function archivos(){
		if ($this->input->is_ajax_request()) {
	        $data['cliente_id'] = $this->input->post('id');
	        $this->load->view('archivos',$data);
		}else{
			show_404();
		}
	}

	public function archivosmostrar(){
		//echo $this->input->post('id');
		
		if($this->input->is_ajax_request()){

			$datos['select'] = '*';
			$datos['tabla'] = 'archivos';
			$data['where'] = array(0 => array("campo" => "cliente_id", "valor" => $this->input->post('id'), "tipo" => "where"));
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',nombre_archivo,'', estado,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','id','nombre_archivo','estado','created_at','updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	 $parametros = "'$filas->id'"; 
		        	$no++;
		            $row = array();
		            $row[] = '<a onclick="obj_clientes.eliminararchivo('.$parametros.');" href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
		            $row[] = $filas->id;
		            $row[] = $filas->nombre_archivo;
		            $row[] = $filas->estado;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'archivos';
	        $datoscontador['where'] = array(0 => array("campo" => "cliente_id", "valor" => $this->input->post('id'), "tipo" => "where"));
		
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',nombre_archivo,'', estado,' ',created_at,' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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

	function borrararchivo(){
		if($this->input->is_ajax_request()){
				$datos['tabla'] = 'archivos';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$resultado = $this->Global_model->borrar($datos);

				if (!is_null($resultado)){
					echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente'));
				}else{
					echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar Datos'));
				}
			
		}else{
			show_404();
		}
	}

	public function get_distritos(){
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

    public function get_ciudades(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, ciudad';
        $data['tabla'] = 'ciudad'; 
        $data['where'] = array(0 => array("campo" => "departamento_id", "valor" => $this->input->post('departamento_id'), "tipo" => "where"));
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'ciudad' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }

    
}
