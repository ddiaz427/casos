<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Casos extends MX_Controller {

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

			$datos['select'] = 'cs.id, cs.nombre_caso, cs.descripcion, cs.estado, cs.created_at, cs.updated_at, cl.nombres as cliente, sp.nombre as tipo, cs.permanet_link';
			$datos['tabla'] = 'casos cs';
			$datos['join'] = array(
                    0 => array("tabla" => "clientes cl", "condicion" => "cs.cliente_id = cl.id", "tipo" => "INNER"),
                    1 => array("tabla" => "sub_procesos sp", "condicion" => "cs.tipo_sub_proceso_id = sp.id", "tipo" => "INNER"),
                    );
			$datos['where'] = array(0 => array("campo" => "cs.usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"));
			//print_r($consulta);

			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(cs.nombre_caso,'', cl.nombres,' ',cl.created_at,' ',cl.updated_at,' ',cs.estado,' ',cs.descripcion)", "valor" => $this->input->post("search", TRUE)['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','cl.nombres','cs.nombre_caso','sp.nombre','cs.descripcion','cs.estado','cs.created_at','cs.updated_at');//Ordenado Segun filtro
	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order", TRUE)['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "cs.updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {

	        	 $datosajax = 'caso_id='.$filas->id.'&url='.$filas->permanet_link;
                 $div = 'resultado';
                 $url = base_url().$filas->permanet_link; 
                 $datatipo = 'html'; 
                 $titulo = $filas->nombre_caso;
                 $parametros = "'$datosajax','$url','$div','$datatipo','$titulo'"; 

		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = '<a href="javascript:void(0);" onclick="obj_casos.menu('.$parametros.');">'.$filas->cliente.'</a>';
		            $row[] = '<a href="javascript:void(0);" onclick="obj_casos.menu('.$parametros.');">'.$filas->nombre_caso.'</a>';
		            $row[] = $filas->tipo;
		            $row[] = $filas->descripcion;
		            $row[] = $filas->estado;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'casos cs';
			$datoscontador['join'] = array(
                    0 => array("tabla" => "clientes cl", "condicion" => "cs.cliente_id = cl.id", "tipo" => "INNER"),
                    1 => array("tabla" => "sub_procesos sp", "condicion" => "cs.tipo_sub_proceso_id = sp.id", "tipo" => "INNER"),
                    );
			$datoscontador['where'] = array(0 => array("campo" => "cs.usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"));
		
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(cs.nombre_caso,'', cl.nombres,' ',cl.created_at,' ',cl.updated_at,' ',cs.estado,' ',cs.descripcion)", "valor" => $this->input->post("search", TRUE)['value'], "comodin" => "both", "tipo" => "like")
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

				$datos['select'] = 'id, nombres';
				$datos['tabla'] = 'clientes';
				$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));
				$data['clientes'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
				$this->load->view('nuevo',$data);
			}else{
				$this->form_validation->set_rules('cliente_id', 'Cliente', 'trim|required');
				$this->form_validation->set_rules('nombre', 'Nombre del Caso', 'trim|required');
				$this->form_validation->set_rules('caso_id', 'Tipo Caso', 'trim|required');
				$this->form_validation->set_rules('proceso_id', 'Tipo Proceso', 'trim|required');
				$this->form_validation->set_rules('subproceso_id', 'Sub Proceso', 'trim|required');
				$this->form_validation->set_rules('rol', 'Rol del Cliente', 'trim|required');

				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
				   $datos['tabla'] = 'casos';
				   $inser['cliente_id'] = $this->input->post('cliente_id', TRUE);
				   $inser['nombre_caso'] = $this->input->post('nombre', TRUE);
				   $inser['descripcion'] = $this->input->post('descripcion', TRUE);
				   $inser['tipo_caso_id'] = $this->input->post('caso_id', TRUE);
				   $inser['tipo_proceso_id'] = $this->input->post('proceso_id', TRUE);
				   $inser['tipo_sub_proceso_id'] = $this->input->post('subproceso_id', TRUE);
				   $inser['rol'] = $this->input->post('rol');
				   $inser['permanet_link'] = url_title(convert_accented_characters(slug($this->input->post('nombre'))));
				   $inser['created_at'] = FECHAGESTOR;
				   $inser['usuario_id'] =$this->session->userdata('usuariosesion')['usuario_id'];
				   $insert_id =  $this->Global_model->agregar($datos,$inser);

				   if (!is_null($insert_id)){

				   		$datos2['select'] = 'id';
						$datos2['tabla'] = 'actividades';
						$datos2['where'] = array(0 => array("campo" => "sub_proceso_id", "valor" => $this->input->post('subproceso_id', TRUE), "tipo" => "where"));
						$actividades = $this->Global_model->mostrar($datos2);// Le paso los datos de la consulta

						if (!empty($actividades)) {
							foreach ($actividades as $a) {
								$datos3['select'] = 'id, actividad_id';
								$datos3['tabla'] = 'detalleactividad';
								$datos3['where'] = array(0 => array("campo" => "actividad_id", "valor" =>  $a->id, "tipo" => "where"));
								$detalleactividad = $this->Global_model->mostrar($datos3);// Le paso los datos de la consulta

								if (!empty($detalleactividad)) {
									foreach ($detalleactividad as $da) {
									   $datosinsert2['tabla'] = 'procesos';
									   $inser2['caso_id'] = $insert_id;
									   $inser2['actividad_id'] = $da->actividad_id;
									   $inser2['detalleactividad_id'] = $da->id;
									   $inser2['created_at'] =FECHAGESTOR;
									   $inser2['usuario_id'] =$this->session->userdata('usuariosesion')['usuario_id'];
									   $insert_id2= $this->Global_model->agregar($datosinsert2,$inser2);
									}
								}else{

								}
								//print_r($detalleactividad);
							}

				   	   	echo json_encode(array('success'=> true, 'mensages' => 'Caso Creado Correctamente','caso_id' => $insert_id,'url'=> url_title(convert_accented_characters(slug($this->input->post('nombre'))))));
						}else{
							echo json_encode(array('success'=> false, 'mensages' => 'error al guardar el Caso'));
						}	

						//print_r($actividades);	
				   }else{
				   		echo json_encode(array('success'=> false, 'mensages' => 'Error al Insertar <b>Comuniquese con el administrador</b>'));
				   }
				}		   
			}
		}else{
			show_404();
		}
	}

	function ver(){
		if($this->input->is_ajax_request()){
			$datos['select'] = '*';
			$datos['tabla'] = 'tipo_casos';
			$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('caso_id', TRUE), "tipo" => "where"));
			$data['casos'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
			$data['caso_id'] = $this->input->post('caso_id');
			$data['proceso_id'] = $this->input->post('proceso_id');
			$data['subproceso_id'] = $this->input->post('sub_proceso_id');
			$this->load->view('procesos',$data);
		}else{
			show_404();
		}
	}

	public function procesos($id=null){
		//echo $id;
		/*Datos del Caso y Cliente*/

		if ($id) {
			$valor = $id;
		}else{
			$valor = $this->input->post('caso_id', TRUE);
		}

		$datos['select'] = 'cs.id, cs.nombre_caso, cs.descripcion, cs.estado, cs.created_at, cs.updated_at, cl.nombres as cliente, sp.nombre as tipo, cs.permanet_link, cl.email, cl.movil, cl.avatar';
		$datos['tabla'] = 'casos cs';
		$datos['join'] = array(
                0 => array("tabla" => "clientes cl", "condicion" => "cs.cliente_id = cl.id", "tipo" => "INNER"),
                1 => array("tabla" => "sub_procesos sp", "condicion" => "cs.tipo_sub_proceso_id = sp.id", "tipo" => "INNER"),
                );
		$datos['where'] = array(0 => array("campo" => "cs.id", "valor" => $valor, "tipo" => "where"));
		$data['infocaso'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
		/*Datos del Caso y Cliente din */

		$data['caso_id'] = $valor;
		$dataCuerpo['cuerpo'] = $this->load->view('procesos_casos', $data, true);// seteo la vista correspondiente

        if ($this->input->is_ajax_request()){
            echo $dataCuerpo['cuerpo'];// si viene por ajax la peticion
        }else{

             $dataCuerpo['head'] = $this->load->view('panel/template/head', ['titulo' => 'Panel de administración'], true);
             $dataCuerpo['nav'] = $this->load->view('panel/template/nav', null, true);
             $dataCuerpo['footer'] = $this->load->view('panel/template/footer', ['jsvista' => ['assets/js/casos.js']], true);
             $this->load->view('panel/template/template',$dataCuerpo);
        }
	}

	public function seguimiento(){
		if($this->input->is_ajax_request()){
			/*Datos Proceso*/
			$datos2['select'] = 'p.caso_id, p.actividad_id, p.id, at.nombre as actividad, p.estado, p.created_at';
			$datos2['tabla'] = 'procesos p';
			$datos2['join'] = array(
	                0 => array("tabla" => "actividades at", "condicion" => "p.actividad_id = at.id", "tipo" => "INNER"),
	                //1 => array("tabla" => "sub_procesos sp", "condicion" => "cs.tipo_sub_proceso_id = sp.id", "tipo" => "INNER"),
	                );
			$datos2['where'] = array(0 => array("campo" => "p.caso_id", "valor" => $this->input->post('caso_id', TRUE), "tipo" => "where"),
									 1 => array("campo" => "p.estado", "valor" => 'Creado', "tipo" => "where")
				);
			$datos2['order_by'] =  array(0 => array("campo" => "p.id", "valor" => "ASC", "tipo" => "NORMAL"));// Ordenado por Defecto
			$data['procesosarealizar'] = $this->Global_model->mostrar($datos2);// Le paso los datos de la consulta
			/*Datos procesos */

			$datos3['select'] = 'p.caso_id, p.actividad_id, p.id, at.nombre as actividad, p.estado, p.created_at';
			$datos3['tabla'] = 'procesos p';
			$datos3['join'] = array(
	                0 => array("tabla" => "actividades at", "condicion" => "p.actividad_id = at.id", "tipo" => "INNER"),
	                //1 => array("tabla" => "sub_procesos sp", "condicion" => "cs.tipo_sub_proceso_id = sp.id", "tipo" => "INNER"),
	                );
			$datos3['where'] = array(0 => array("campo" => "p.caso_id", "valor" => $this->input->post('caso_id', TRUE), "tipo" => "where"),
									 1 => array("campo" => "p.estado", "valor" => 'Finalizado', "tipo" => "where")
				);
			$datos3['order_by'] =  array(0 => array("campo" => "p.id", "valor" => "ASC", "tipo" => "NORMAL"));// Ordenado por datos3
			$data['actuazionesproceso'] = $this->Global_model->mostrar($datos3);// Le paso los datos de la consulta

			$this->load->view('seguimiento_caso',$data);
		}else{
			show_404();
		}	
	}

	public function info_caso(){
		if($this->input->is_ajax_request()){

			if (!$this->input->post('enviado')) {

				$datos0['select'] = 'id, nombre';
				$datos0['tabla'] = 'tipo_casos';
				$datos0['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));
				$data['casos'] = $this->Global_model->mostrar($datos0);// Le paso los datos de la consulta

				$datos1['select'] = 'id, nombres';
				$datos1['tabla'] = 'clientes';
				$datos1['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));
				$data['clientes'] = $this->Global_model->mostrar($datos1);// Le paso los datos de la consulta

				$datos['select'] = '*';
				$datos['tabla'] = 'casos';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('caso_id'), "tipo" => "where"));
				$data['casosinfo'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
				$this->load->view('editar_caso',$data);
			}else{
				$this->form_validation->set_rules('cliente_id', 'Cliente', 'trim|required');
				$this->form_validation->set_rules('nombre', 'Nombre del Caso', 'trim|required');
				$this->form_validation->set_rules('id', 'Id', 'trim|required');
				$this->form_validation->set_rules('rol', 'Rol del Cliente', 'trim|required');

				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{

					$datos['select'] = '*';
					$datos['tabla'] = 'casos';
					$datos['where'] = array(0 => array("campo" => "expediente", "valor" => $this->input->post('expediente'), "tipo" => "where"),
											1 => array("campo" => "id !=", "valor" => $this->input->post('id'), "tipo" => "where")
						);
					$expediente = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta	

					if (is_null($expediente)) {
						
					   $datossql['tabla'] = 'casos';
					   $datossql['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $actualizar['cliente_id'] = $this->input->post('cliente_id');
					   $actualizar['nombre_caso'] = $this->input->post('nombre');
					   $actualizar['descripcion'] = $this->input->post('descripcion');
					   $actualizar['expediente'] = $this->input->post('expediente');
					   $actualizar['rol'] = $this->input->post('rol');
					   //$inser['permanet_link'] = url_title(convert_accented_characters(slug($this->input->post('nombre'))));
					   $actualizar['updated_at'] = FECHAGESTOR;
					   $actualizar['usuario_id'] =$this->session->userdata('usuariosesion')['usuario_id'];
					   $datosactualizar = $this->Global_model->actualizar($datossql,$actualizar);

					   if (!is_null($datosactualizar)){
					   		echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
					   }else{
					   		echo json_encode(array('success'=> false, 'mensages' => 'Los Datos Ya Fueron Actualizados'));
					   }
					}else{
						echo json_encode(array('success'=> false, 'mensages' => 'El Nuemero '.$this->input->post('expediente').' Ya se encuentra Asignado'));
					}
				}
			}
		}else{
			show_404();
		}
	}

	public function generarCodigoExpediente(){
		if($this->input->is_ajax_request()){
	     srand ((double) microtime( )*1000000);
	     $random_number = rand(0,50000);
	     echo json_encode(array('success'=> true, 'nro_expediente' =>  'E-'.$random_number));
		}else{
			show_404();
		}
	}

	public function documentos(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')) {
				$data['caso_id'] = $this->input->post('caso_id');
				$this->load->view('form_documentos',$data);
			}else{
				$rules = array(
		            array(
		                'field' => 'nombre[]',
		                'label' => 'Nombre del Archivo',
		                'rules' => 'required',
		            ),  

		           	array(
		                'field' => 'caso_id',
		                'label' => 'Caso_id',
		                'rules' => 'required',
		            ),          
		        );
		        $this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
		        $this->form_validation->set_rules($rules);

				if ($this->form_validation->run($this) == FALSE) {
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{
						if(!empty($_FILES["files"]["name"][0])) {
							   			
			   				$this->load->library("upload");

				   		   $ruta = 'assets/casosarchivos/'.$this->input->post('caso_id'); 	
						   if (!is_dir($ruta) ){
						        if (!mkdir($ruta, 0777, TRUE) ){
						          //
						         echo json_encode(array('success'=> false, 'mensages' => 'Error al Crear el Directorio'));
						         }
					        }

							$config = array(
								"upload_path" => $ruta,
								//'allowed_types' => "jpg|png|pdf|word|excel",
								'allowed_types' => "*",
							);
							$variablefile= $_FILES;
							$info = array();
							$contador = 0;
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

								   $datos['tabla'] = 'documentos_caso';
			   					   $insert['caso_id'] = $this->input->post('caso_id');
								   $insert['titulo'] = $this->input->post('nombre')[$i];
								   $insert['documento'] = $data['upload_data']['file_name'];
								   $insert['created_at'] = FECHAGESTOR;
			   					   $insert['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];

			   					   $this->Global_model->agregar($datos,$insert);

			   					   $info[$i] = array(
										"archivo" => $data['upload_data']['file_name'],
										"mensaje" => "Archivo subido y guardado"
									);
							}
							else{
								$info[$i] = array(
										"archivo" => $_FILES['files']['name'],
										"mensaje" => $this->upload->display_errors()
								);
							}
						}

						$envio = "";
						foreach ($info as $key) {
							$envio .= "Archivo : ".$key['archivo']." - ".$key["mensaje"]."\n";
						}

						echo json_encode(array('success'=> true, 'mensages' => $envio,'caso_id' => $this->input->post('caso_id')));	
					}else{
						echo json_encode(array('success'=> false, 'mensages' => 'seleccione un archivo'));
					}
				}					      
				/*Fin de La subidad de los archivos*/
			}	
		}else{
			show_404();
		}	
	}

	public function editar_documentos(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')) {
				$datos['select'] = '*';
				$datos['tabla'] = 'documentos_caso';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"),
										1 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id'), "tipo" => "where")
					);
				$data['caso_id'] = $this->input->post('caso_id');
				$data['documento'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta	
				$this->load->view('editar_documentos',$data);
			}else{

				$rules = array(
		            array(
		                'field' => 'nombre',
		                'label' => 'Nombre del Archivo',
		                'rules' => 'required',
		            ),  

		           	array(
		                'field' => 'id',
		                'label' => 'ID',
		                'rules' => 'required',
		            ),          
		        );
		        $this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
		        $this->form_validation->set_rules($rules);

				if ($this->form_validation->run($this) == FALSE){
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{
					   if($_FILES['files']['name'] != ''){
							$respuesta = $this->subir_archivo();
							if(!is_array($respuesta)){

							   $datos['tabla'] = 'documentos_caso';
							   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"),
							   						   1 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id'), "tipo" => "where")
							   		);
							   $datosactualizar['titulo'] = $this->input->post('nombre');
							   $datosactualizar['documento'] = $respuesta;
							   $datosactualizar['updated_at'] = FECHAGESTOR;
							   $datosactualizar['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];
							 
							   $datosactualizar = $this->Global_model->actualizar($datos,$datosactualizar);

							   if (!is_null($datosactualizar)){
							   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente', 'caso_id' => $this->input->post('caso_id')));
							   }else{
							   	echo json_encode(array('success'=> false, 'mensages' => 'Error al Actualizar Datos Personales'));
							   }  
							}else{
								$mensaje = '';
								foreach ($respuesta as $m) {
									$mensaje .= $m;
								}
								echo json_encode(array('success'=> false, 'mensages' => $mensaje));
							}
					   }else{
					   		   $datos['tabla'] = 'documentos_caso';
							   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"),
							   						   1 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id'), "tipo" => "where")
							   		);
							   $datosactualizar['titulo'] = $this->input->post('nombre');
							   $datosactualizar['updated_at'] = FECHAGESTOR;
							   $datosactualizar['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];
							   $datosactualizar = $this->Global_model->actualizar($datos,$datosactualizar);

							   if (!is_null($datosactualizar)){
							   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente', 'caso_id' => $this->input->post('caso_id')));
							   }else{
							   	echo json_encode(array('success'=> false, 'mensages' => 'Error al Actualizar Datos Personales'));
							   } 
					   }	
				}
			}
		}else{
			show_404();
		}
	}

	public function listar_documentos(){
		if($this->input->is_ajax_request()){
			sleep(1);
			$datos['select'] = '*';
			$datos['tabla'] = 'documentos_caso';
			$datos['where'] = array(0 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id'), "tipo" => "where"));
			$datos['order_by'] = array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
			$data['documentos'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

			$this->load->view('listar_documentos',$data);
		}else{
			show_404();
		}
	}

	public function visor_documentos(){
		if($this->input->is_ajax_request()){
			sleep(1);
			$datos['select'] = '*';
			$datos['tabla'] = 'documentos_caso';
			$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
			$data['visor'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
			$this->load->view('visor_documento',$data);
		}else{
			show_404();
		}
	}

	function borrar_documentos(){
		if($this->input->is_ajax_request()){
				
			$datos['tabla'] = 'documentos_caso';
			$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
			$datosconsulta = $this->Global_model->borrar($datos);

			if (!is_null($datosconsulta)){
				echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente','caso_id' => $this->input->post('caso_id')));
			}else{
				echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar la Nota Comuniquese con el administrador'));
			}	
		}else{
			show_404();
		}
	}

	public function notas(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')) {
				$data['caso_id'] = $this->input->post('caso_id');
				$this->load->view('form_notas',$data);
			}else{
				$this->form_validation->set_rules('nombre', 'Titulo', 'trim|required');
				$this->form_validation->set_rules('notas', 'Nota', 'trim|required');
				$this->form_validation->set_rules('caso_id', 'Caso', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{
				   $datos['tabla'] = 'notas';
				   $inser['caso_id'] = $this->input->post('caso_id');
				   $inser['titulo'] = $this->input->post('nombre');
				   $inser['nota'] = $this->input->post('notas');
				   $inser['created_at'] = FECHAGESTOR;
				   $inser['updated_at'] = FECHAGESTOR;
				   $inser['usuario_id'] =$this->session->userdata('usuariosesion')['usuario_id'];
				   $insert_id =  $this->Global_model->agregar($datos,$inser);

				   if (!is_null($insert_id)){
				   	echo json_encode(array('success'=> true, 'mensages' => 'Nota Creada Correctamente','caso_id' => $this->input->post('caso_id')));
				   }else{
				   		echo json_encode(array('success'=> false, 'mensages' => 'Error al Guardar la Nota'));
				   }
				}
			}	
		}else{
			show_404();
		}	
	}

	public function editar_notas(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')) {
				$datos['select'] = '*';
				$datos['tabla'] = 'notas';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id', TRUE), "tipo" => "where"),
										1 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id', TRUE), "tipo" => "where")
					);
				$data['caso_id'] = $this->input->post('caso_id');
				$data['nota'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta	
				$this->load->view('editar_notas',$data);
			}else{

				$rules = array(
		            array(
		                'field' => 'titulo',
		                'label' => 'Título de la Nota',
		                'rules' => 'required',
		            ), 

		            array(
		                'field' => 'notas',
		                'label' => 'Nota',
		                'rules' => 'required',
		            ),  

		            array(
		                'field' => 'caso_id',
		                'label' => 'Caso Id',
		                'rules' => 'required',
		            ),  

		           	array(
		                'field' => 'id',
		                'label' => 'ID',
		                'rules' => 'required',
		            ),          
		        );
		        $this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
		        $this->form_validation->set_rules($rules);

				if ($this->form_validation->run($this) == FALSE){
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{
					   $datos['tabla'] = 'notas';
					   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id', TRUE), "tipo" => "where"),
					   						   1 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id', TRUE), "tipo" => "where")
					   		);
					   $datosactualizar['titulo'] = $this->input->post('titulo', TRUE);
					   $datosactualizar['nota'] = $this->input->post('notas', TRUE);;
					   $datosactualizar['updated_at'] = FECHAGESTOR;
					   $datosactualizar['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];
					 
					   $datosactualizar = $this->Global_model->actualizar($datos,$datosactualizar);

					   if (!is_null($datosactualizar)){
					   	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente', 'caso_id' => $this->input->post('caso_id', TRUE)));
					   }else{
					   	echo json_encode(array('success'=> false, 'mensages' => 'Los Datos ya Fueron Actualizados'));
					   }  
				}
			}
		}else{
			show_404();
		}
	}

	public function listar_notas(){
		if($this->input->is_ajax_request()){
			sleep(1);
			$datos['select'] = '*';
			$datos['tabla'] = 'notas';
			$datos['where'] = array(0 => array("campo" => "caso_id", "valor" => $this->input->post('caso_id'), "tipo" => "where"));
			$datos['order_by'] = array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
			$data['notas'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

			$this->load->view('listar_notas',$data);
		}else{
			show_404();
		}
	}

	function borrar_notas(){
		if($this->input->is_ajax_request()){
				
			$datos['tabla'] = 'notas';
			$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
			$datosconsulta = $this->Global_model->borrar($datos);

			if (!is_null($datosconsulta)){
				echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente','caso_id' => $this->input->post('caso_id')));
			}else{
				echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar la Nota Comuniquese con el administrador'));
			}	
		}else{
			show_404();
		}
	}

	public function mostrar_actividad(){
		if($this->input->is_ajax_request()){

			$datos['select'] = 'id, nombre';
			$datos['tabla'] = 'actividades';
			$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('actividad_id'), "tipo" => "where"));
			$data['actividad'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta


			$datos2['select'] = '*';
			$datos2['tabla'] = 'detalleactividad';
			$datos2['where'] = array(0 => array("campo" => "actividad_id", "valor" => $data['actividad'][0]->id, "tipo" => "where"));
			$data['detalleactividad'] = $this->Global_model->mostrar($datos2);// Le paso los datos de la consulta
			/*Datos del Caso y Cliente din */
			$this->load->view('detalle_actividad',$data);
		//echo $this->input->post('caso_id').'<br>'.$this->input->post('actividad_id');
		}else{
			show_404();
		}
	}

	public function equipocaso(){
		echo "equipo del Caso";
	}

	public function facturacion(){
		echo "Facturacion referente al caso";
	}

	 public function subir_archivo(){

 	   $ruta = 'assets/casosarchivos/'.$this->input->post('caso_id'); 	
	   if (!is_dir($ruta) ){
	        if (!mkdir($ruta, 0777, TRUE) ){
	          //
	         echo json_encode(array('success'=> false, 'mensages' => 'Error al Crear el Directorio'));
	         }
        }

        $nombre_archivo = url_title(convert_accented_characters($_FILES['files']['name']),'-',TRUE);
        $config['upload_path'] = $ruta;
        $config['allowed_types'] = '*';
        $config['max_size'] = 6000;
        $config['quality'] = '90%';
        //$config['max_width']  = '1024';
        //$config['max_height']  = '768';
        $config['file_name']  = $nombre_archivo;
        
        $this->load->library('upload');
        $this->upload->initialize($config);
    
        if (!$this->upload->do_upload('files')){
            $error = array('success'  => false, 'mensages' => $this->upload->display_errors());
            return $error;
        }   
        else{
            $data = $this->upload->data();
            return $data['file_name'];
        }
    }

    public function get_clientes(){
        if ($this->input->is_ajax_request()) {
        $data['select'] = 'id, nombres';
        $data['tabla'] = 'clientes'; 
        $datosconsulta = $this->Global_model->mostrar($data);

        if (!is_null($datosconsulta)){
                echo json_encode($datosconsulta);
            }else{
                 $datos[] = array('id' => '', 'nombres' => ''); 
                 echo json_encode($datos);
            }
        }else{
            show_404();
        }
    }
}
