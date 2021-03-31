<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestiondocumental extends MX_Controller {

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
		$dataCuerpo['cuerpo'] = $this->load->view('listar', null, true);// seteo la vista correspondiente
        if ($this->input->is_ajax_request()){
            echo $dataCuerpo['cuerpo'];// si viene por ajax la peticion
        }else{
        	
             $dataCuerpo['head'] = $this->load->view('panel/template/head', ['titulo' => 'Panel de administración'], true);
             $dataCuerpo['nav'] = $this->load->view('panel/template/nav', null, true);
             $dataCuerpo['footer'] = $this->load->view('panel/template/footer', null, true);
             $this->load->view('panel/template/template',$dataCuerpo);
        }
	}

	public function mostrar(){
		if($this->input->is_ajax_request()){

			$datos['select'] = '*';
			$datos['tabla'] = 'gestion_documental';
			$datos['where'] = array(0 => array("campo" => "usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"));
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',titulo,'', descripcion,' ',documento,' ',tipo_documento,' ',estado,' ',created_at,' ', updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','titulo','descripcion','documento','tipo_documento','estado','created_at','updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $this->input->post("order")['0']['dir'], "tipo" => "NORMAL"));

	        }else{
	        	$datos['order_by'] =  array(0 => array("campo" => "updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $filas) {
		        	/*
		        	if ($filas->tipo_documento == 'Img') {
		        		$archivoicon = '<i class="fa fa-picture-o fa-2x text-success" aria-hidden="true"></i>';
		        	}elseif($filas->tipo_documento == 'Excel'){
		        		$archivoicon = '<i class="fa fa-file-excel-o fa-2x text-success" aria-hidden="true"></i>';
		        	}elseif($filas->tipo_documento == 'Word'){
		        		$archivoicon = '<i class="fa fa-file-word-o fa-2x text-info" aria-hidden="true"></i>';
		        	}elseif($filas->tipo_documento == 'Pdf'){
		        		$archivoicon = '<i class="fa fa-file-pdf-o fa-2x text-danger" aria-hidden="true"></i>';
		        	}else{
		        		$archivoicon = '';
		        	}

		        	if ($filas->estado == 'Borrado') {
		        		$estadotipo = '<i title="Archivo Borrado" class="fa fa-trash-o fa-2x" aria-hidden="true"></i>';
		        		$documento = 'data-role="disabled"';
		        	}elseif($filas->estado == 'Subido'){
		        		$estadotipo = '<i title="Archivo Subido" class="fa fa-check fa-2x" aria-hidden="true"></i>';
		        		$documento = '';
		        	}elseif ($filas->estado == 'Editado') {
		        		$estadotipo = '<i title="Archivo Editado" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>';
		        		$documento = 'download';
		        	}else{
		        		$estadotipo = '';
		        		$documento = 'download';
		        	}
		        	*/

		        	$no++;
		            $row = array();
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->id.'"/><i></i></label>';
		            $row[] = $filas->titulo;
		            $row[] = $filas->descripcion;
		            $row[] = '';
		            $row[] = '';
		            $row[] = $filas->estado;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            $data[] = $row; 
		        }
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'gestion_documental';
			$datoscontador['where'] = array(0 => array("campo" => "usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"));
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(titulo,'', descripcion,' ',documento,' ',tipo_documento,' ',estado,' ',created_at,' ', updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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
				$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
				//$this->form_validation->set_rules('tipo_documento', 'Tipo de Documento', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');

				if (empty($_FILES['archivo_1']['name'])){
					$this->form_validation->set_rules('file', 'Documento', 'required');//validacion para el campo file
				}
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
						$data = array();
						foreach ($_FILES as $key => $imagen) {
							if (! empty($imagen['name'])) {

							   $ruta = 'documentos/'.$this->session->userdata('usuariosesion')['usuario']; 	
							   if (!is_dir($ruta) ){
							        if (!mkdir($ruta, 0777, TRUE) ){
							          //
							         echo json_encode(array('success'=> false, 'mensages' => 'Error al Crear el Directorio'));
							         }
						        }

								$nombre_imagen = url_title(convert_accented_characters($imagen['name']),'-',TRUE);
								$nombre_modificado = str_replace('jpg','',$nombre_imagen);        
						    	$nombre_modificado .= '.jpg';
								$config['upload_path'] = $ruta;
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['file_name'] = $nombre_modificado;
								$config['quality'] = '90%';
								$this->load->library('upload');
								$this->upload->initialize($config);

								if (!file_exists($config['upload_path'].$imagen['name'])) {
									
									if (!$this->upload->do_upload($key)){
										 echo json_encode(array('success'=> false, 'mensages' => $this->upload->display_errors()));
									}	
									else{
										$respuesta = true;	
										$data[] = $this->upload->data()['file_name'];
									}
								}
							}
						}

					   $datos['tabla'] = 'gestion_documental';
					   $insert['titulo'] = $this->input->post('titulo');
					   $insert['descripcion'] = $this->input->post('descipcion');
					   $insert['created_at'] = FECHAGESTOR;
					   $insert['updated_at'] = FECHAGESTOR;
					   $insert['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];

					   $datainsert_id = $this->Global_model->agregar($datos,$insert);

					   if (!is_null( $datainsert_id)) {
					   		foreach ($data as $img) {
					   			   $datos2['tabla'] = 'gestion_documental_file';
								   $insert2['archivo'] = $img;
								   $insert2['gestion_documental_id'] = $datainsert_id;
								   $this->Global_model->agregar($datos2,$insert2);
					   		}
					   		echo json_encode(array('success'=> true, 'mensages' => 'Datos Registrados Correctamente'));
					   }else{
					   		echo json_encode(array('success'=> false, 'mensages' => 'Error'));
					   }		

				}		   
			}
		}else{
			show_404();
		}
	}

	/*
	function editar(){
		if($this->input->is_ajax_request()){
			if (!$this->input->post('enviado')){
			
				$datos['select'] = '*';
				$datos['tabla'] = 'gestion_documental';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['perfil'] = $this->Global_model->mostrar($datos);
				$this->load->view('editar',$data);
			}else{
				$this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
				$this->form_validation->set_rules('tipo_documento', 'Tipo de Documento', 'trim|required');
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
	
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'gestion_documental';
					   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('id'), "tipo" => "where"));
					   $insert['titulo'] = $this->input->post('titulo');
					   $insert['descripcion'] = $this->input->post('descipcion');
					   $insert['documento'] = $archivo;
					   $insert['tipo_documento'] = $this->input->post('tipo_documento');
					   $insert['usuario_id'] = $this->session->userdata('usuariosesion')['usuario_id'];
					   $insert['created_at'] = FECHAGESTOR;
					   $insert['updated_at'] = FECHAGESTOR;
					 
					   $datosactualizar = $this->Global_model->actualizar($datos,$insert);

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
	*/
	function borrar(){
		if($this->input->is_ajax_request()){
			$ids=array();
			foreach ($this->input->post('id') as $value) {
				$ids[] = $value; 
			}
			if (!empty($ids)) {
				$datos['tabla'] = 'gestion_documental';
				$datos['where'] = array(0 => array("campo" => "id", "valor" => $ids, "tipo" => "where_in"));
			    $borrar['estado'] = 'Borrado';
			    $borrar['updated_at'] = FECHAGESTOR; 
				$consulta = $this->Global_model->actualizar($datos,$borrar);

				if (!is_null($consulta)){
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

	public function subir_archivo()/// funcion para subir archivos
	{  	
	   $ruta = 'documentos/'.$this->session->userdata('usuariosesion')['usuario']; 	
	   if (!is_dir($ruta) ){
	        if (!mkdir($ruta, 0777, TRUE) ){
	          //
	          $error = array('error' => 'Error al Crear la ruta');
 			  return $error;
	         }
        }

        if ($this->input->post('tipo_documento') == 'Img') {
        	$tipoarchivo = 'gif|jpg|jpeg|png';
        }elseif($this->input->post('tipo_documento') == 'Pdf'){
        	$tipoarchivo = 'pdf';
        }elseif($this->input->post('tipo_documento') == 'Word' or $this->input->post('tipo_documento') == 'Excel'){
        	$tipoarchivo = 'docx|doc|xlsx';
        }else{
        	$tipoarchivo = '';
        }

		$nombre_imagen = url_title(convert_accented_characters($_FILES['file']['name']),'-',TRUE);
		$nombre_modificado = str_replace('jpg','',$nombre_imagen);        
    	$nombre_modificado .= '.jpg';
    	$config['upload_path'] = $ruta;
		$config['allowed_types'] = $tipoarchivo;
		$config['max_size']     = 5000; // 5M
		$config['quality'] = '90%';
		$config['file_name']  = $nombre_modificado;
		
		$this->load->library('upload');
	    $this->upload->initialize($config);
	
		if (!$this->upload->do_upload('file')){
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}	
		else{
			$data = $this->upload->data();
			return $data['file_name'];
		}
	}
}
