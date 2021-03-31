<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MX_Controller {

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

			$datos['select'] = 'u.id, u.usuario, u.estado, u.created_at, u.updated_at, pf.nombre AS perfil, CONCAT(p.nombres," ",p.apellidos) AS nombrescompletos, p.email, p.id as persona_id, p.avatar';
			$datos['tabla'] = 'usuario u';
			$datos['join'] = array(
                    0 => array("tabla" => "persona p", "condicion" => "u.persona_id = p.id", "tipo" => "INNER"),
                    1 => array("tabla" => "perfiles pf", "condicion" => "u.perfil_id = pf.id", "tipo" => "INNER"),
                    );

			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(p.nombres,' ', p.apellidos, ' ',u.created_at, ' ',u.updated_at,' ', p.email,' ',pf.nombre,' ',u.estado)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','nombrescompletos','u.usuario','p.email','pf.nombre','u.estado','u.created_at', 'u.updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $_POST['order']['0']['dir'], "tipo" => "NORMAL"));

	        }else{

	        	$datos['order_by'] =  array(0 => array("campo" => "u.updated_at", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
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
		            $row[] = '<label for="checkbox'.$filas->id.'"><input type="checkbox" class="checkbox1" name="checkbox[]" id="checkbox'.$filas->id.'" value="'.$filas->persona_id.'"/><i></i></label>';
		            $row[] = '<img width="50" class="img-responsive img-circle" src="'.$img.'">';
		            $row[] = $filas->nombrescompletos;
		            $row[] = $filas->usuario;
		            $row[] = $filas->email;
		            $row[] = $filas->perfil;
		            $row[] = $filas->estado;
		            $row[] = $filas->created_at;
		            $row[] = $filas->updated_at;
		            
		            $data[] = $row; 
		        }
		        
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['tabla'] = 'usuario u';
			$datoscontador['join'] = array(
                    0 => array("tabla" => "persona p", "condicion" => "u.persona_id = p.id", "tipo" => "INNER"),
                    1 => array("tabla" => "perfiles pf", "condicion" => "u.perfil_id = pf.id", "tipo" => "INNER")
                    );

	     
			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
				$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(p.nombres,' ', p.apellidos, ' ',u.created_at, ' ',u.updated_at,' ', p.email,' ',pf.nombre,' ',u.estado)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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
				$datos['tabla'] = 'perfiles';
				$datos['where'] = array( 
                             0 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
                );
                $datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
				$data['perfiles'] = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
				$this->load->view('nuevo',$data);
			}else{
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required');
				$this->form_validation->set_rules('apellido', 'Apellidos', 'trim|required');
				$this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|callback_verificar_cedula');
				$this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
				$this->form_validation->set_rules('civil', 'Estado Civi', 'trim|required');
				$this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_verificar_correo');
				//$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required');
				$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|callback_validar_usuario|callback_verificar_usuario');

				$this->form_validation->set_rules('perfil_id', 'Perfil', 'trim|required');
				$this->form_validation->set_rules('clave', 'Clave', 'trim|required|sha1');
				$this->form_validation->set_rules('estado_usuario', 'Estado Usuario', 'trim|required');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'persona';
					   $insertpersonal['nombres'] = $this->input->post('nombre');
					   $insertpersonal['apellidos'] = $this->input->post('apellido');
					   $insertpersonal['cedula'] = $this->input->post('cedula');
					   $insertpersonal['sexo'] = $this->input->post('sexo');
					   $insertpersonal['civil'] = $this->input->post('civil');
					   $insertpersonal['email'] = $this->input->post('email');
					   $insertpersonal['telefono'] = $this->input->post('telefono');
					   $insertpersonal['direccion'] = $this->input->post('direccion');
					   $insertpersonal['descripcion'] = $this->input->post('descripcion');
					   $insertpersonal['created_at'] = FECHAGESTOR;
					   $insertpersonal['updated_at'] = FECHAGESTOR;

					   $datainsert_id = $this->Global_model->agregar($datos,$insertpersonal);

					   if ($datainsert_id){
					   	   $datos['tabla'] = 'usuario';
						   $insertusuario['usuario'] = $this->input->post('usuario');
						   $insertusuario['password'] = $this->input->post('clave');
						   $insertusuario['estado'] = $this->input->post('estado_usuario');
						   $insertusuario['persona_id'] = $datainsert_id;
						   $insertusuario['perfil_id'] = $this->input->post('perfil_id');
						   $insertusuario['created_at'] = FECHAGESTOR;
						   $insertusuario['updated_at'] = FECHAGESTOR;

					   	   $datainsertuser = $this->Global_model->agregar($datos,$insertusuario);

					   	    if ($datainsertuser){
					   	    	echo json_encode(array('success'=> true, 'mensages' => 'Datos Registrados Correctamente'));
					   	    }else{
					   	    	echo json_encode(array('success'=> false, 'mensages' => 'Error al Insertar Datos del Usuario'));
					   	    }
					   }else{
					   	echo json_encode(array('success'=> false, 'mensages' => 'Error al Insertar Datos Personales'));
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
			
				$datos['select'] = 'u.id as usuario_id, u.usuario, u.estado, u.perfil_id, p.nombres, p.apellidos, p.email, p.cedula, p.sexo, p.civil, p.telefono, p.direccion, p.avatar, p.descripcion, p.id as persona_id';
				$datos['tabla'] = 'usuario u';
				$datos['join'] = array(
	                    0 => array("tabla" => "persona p", "condicion" => "u.persona_id = p.id", "tipo" => "INNER"),
	                    );
				$datos['where'] = array(0 => array("campo" => "p.id", "valor" => $this->input->post('id'), "tipo" => "where"));
				$data['usuario'] = $this->Global_model->mostrar($datos);
				//print_r($data['usuario']);
				
				$datosperfiles['tabla'] = 'perfiles';
				$datosperfiles['where'] = array( 
	                         0 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
	            );
	            $datosperfiles['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
				$data['perfiles'] = $this->Global_model->mostrar($datosperfiles);// Le paso los datos de la consulta
				$this->load->view('editar',$data);

			}else{
				$this->form_validation->set_rules('nombre', 'Nombres', 'trim|required');
				$this->form_validation->set_rules('apellido', 'Apellidos', 'trim|required');
				$this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|callback_comprobar_cedulaedit');
				$this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
				$this->form_validation->set_rules('civil', 'Estado Civi', 'trim|required');
				$this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_chekear_correo');
				//$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required');
				$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|callback_validar_usuario|callback_chekear_usuario');

				$this->form_validation->set_rules('perfil_id', 'Perfil', 'trim|required');
				//$this->form_validation->set_rules('clave', 'Clave', 'trim|required|sha1');
				$this->form_validation->set_rules('estado_usuario', 'Estado Usuario', 'trim|required');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> El Campo %s es obligatorio');
				
				if ($this->form_validation->run($this) == FALSE)
				{
					echo json_encode(array('success'=> false, 'mensages' => validation_errors()));
				}else{	
					   $datos['tabla'] = 'persona';
					   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('persona_id'), "tipo" => "where"));
					   $personal['nombres'] = $this->input->post('nombre');
					   $personal['apellidos'] = $this->input->post('apellido');
					   $personal['cedula'] = $this->input->post('cedula');
					   $personal['sexo'] = $this->input->post('sexo');
					   $personal['civil'] = $this->input->post('civil');
					   $personal['email'] = $this->input->post('email');
					   $personal['telefono'] = $this->input->post('telefono');
					   $personal['direccion'] = $this->input->post('direccion');
					   $personal['descripcion'] = $this->input->post('descripcion');
					   $personal['updated_at'] = FECHAGESTOR;
					   if ($this->input->post('avatar') != NULL) {
						   	$personal['avatar'] = $this->input->post('avatar');
						}

					   $datosactualizar = $this->Global_model->actualizar($datos,$personal);

					   if (!is_null($datosactualizar)){

					   	   $datos['tabla'] = 'usuario';
					   	   $datos['where'] = array(0 => array("campo" => "id", "valor" => $this->input->post('usuario_id'), "tipo" => "where"));
						   $insertusuario['usuario'] = $this->input->post('usuario');
						   if ($this->input->post('clave') != NULL) {
						   	$insertusuario['password'] = sha1($this->input->post('clave'));
						   }
						   
						   $insertusuario['estado'] = $this->input->post('estado_usuario');
						   $insertusuario['perfil_id'] = $this->input->post('perfil_id');
						   $insertusuario['updated_at'] = FECHAGESTOR;

					   	   $dataactualizaruser = $this->Global_model->actualizar($datos,$insertusuario);

					   	    if (!is_null($dataactualizaruser)){
					   	    	echo json_encode(array('success'=> true, 'mensages' => 'Datos Actualizados Correctamente'));
					   	    }else{
					   	    	echo json_encode(array('success'=> false, 'mensages' => 'Error al Actualizar Datos del Usuario'));
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
				
			foreach ($this->input->post('id') as $value) {
				$datospersonal['tabla'] = 'persona';
				$datospersonal['where'] = array(0 => array("campo" => "id", "valor" => $value, "tipo" => "where"));
				$datospersona = $this->Global_model->borrar($datospersonal);

				if (!is_null($datospersona)){
					$datospersonales = true;
				}else{
					$datospersonales = false;
				}

				$datosuser['tabla'] = 'usuario';	
				$datosuser['where'] = array(0 => array("campo" => "persona_id", "valor" => $value, "tipo" => "where"));
				$datosusuario = $this->Global_model->borrar($datosuser);

				if (!is_null($datosusuario)){
					$datosusuario = true;
				}else{
					$datosusuario = false;
				}
			}

			if ($datospersonales == true and $datosusuario == true) {
				echo json_encode(array('success' => true, 'mensages' => 'Registro Eliminados Correctamente'));
			}else{
				echo json_encode(array('success' => false, 'mensages' => 'Error al Borrar Datos'));
			}	
		}else{
			show_404();
		}
	}

	function verificar_correo($val)
	{
		$datos['tabla'] = 'persona';	
		$datos['where'] = array(0 => array("campo" => "email", "valor" => $val, "tipo" => "where"));
		$datosconsulta = $this->Global_model->mostrar($datos);

		if(!is_null($datosconsulta))
        {
			$this->form_validation->set_message('verificar_correo', '<i class="fa fa-exclamation-triangle"></i> El Correo '.$val.' ya existe en nuestra base de datos');
        	return false;
		}
		else
		{
			return true;
		}
	}

	function verificar_usuario($val)
	{
		$datos['tabla'] = 'usuario';	
		$datos['where'] = array(0 => array("campo" => "usuario", "valor" => $val, "tipo" => "where"));
		$datosconsulta = $this->Global_model->mostrar($datos);

		if(!is_null($datosconsulta))
        { 
			$this->form_validation->set_message('verificar_usuario', '<i class="fa fa-exclamation-triangle"></i> El Nombre de Usuario '.$val.' ya existe en nuestra base de datos');
        	return false;
		}
		else
		{
			return true;
		}
	}

	function chekear_usuario($usuario)
	{
		if($this->input->is_ajax_request())
        {
			$datos['tabla'] = 'usuario';	
			$datos['where'] = array(0 => array("campo" => "usuario", "valor" => $usuario, "tipo" => "where"),
									1 => array("campo" => "id !=", "valor" => $this->input->post('usuario_id'), "tipo" => "where")
				);
			$datosconsulta = $this->Global_model->mostrar($datos);

			if(!is_null($datosconsulta))
	        { 
				$this->form_validation->set_message('chekear_usuario', '<i class="fa fa-exclamation-triangle"></i> El nuevo Usuario '.$usuario.' que trata de tomar está en uso');
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

	function chekear_correo($correo)
	{
		if($this->input->is_ajax_request())
        {
			$datos['tabla'] = 'persona';	
			$datos['where'] = array(0 => array("campo" => "email", "valor" => $correo, "tipo" => "where"),
									1 => array("campo" => "id !=", "valor" => $this->input->post('persona_id'), "tipo" => "where")
				);
			$datosconsulta = $this->Global_model->mostrar($datos);

			if(!is_null($datosconsulta))
	        { 
				$this->form_validation->set_message('chekear_correo', '<i class="fa fa-exclamation-triangle"></i> El nuevo Correo '.$correo.' que trata de tomar está en uso');
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
		
    function validar_usuario($val)
	{
	    if(!preg_match("/^\w+$/", $val)){

	    	$this->form_validation->set_message('validar_usuario', '<i class="fa fa-exclamation-triangle"></i> Indique su nombre de usuario (no se aceptan espacios en blanco ni tildes)');
	        return false;
	    }
	    else{
	    	 return true;
	    }
	}

	function verificar_cedula($val)
	{
		$datos['tabla'] = 'persona';	
		$datos['where'] = array(0 => array("campo" => "cedula", "valor" => $val, "tipo" => "where"));
		$datosconsulta = $this->Global_model->mostrar($datos);

		if(!is_null($datosconsulta))
        { 
			$this->form_validation->set_message('verificar_cedula', '<i class="fa fa-exclamation-triangle"></i> La cedula '.$val.' ya existe en nuestra base de datos');
        	return false;
		}
		else
		{
			return true;
		}
	}

	function comprobar_cedulaedit($val)
	{
		if($this->input->is_ajax_request())
        {
			$datos['tabla'] = 'persona';	
			$datos['where'] = array(0 => array("campo" => "cedula", "valor" => $val, "tipo" => "where"),
									1 => array("campo" => "id !=", "valor" => $this->input->post('persona_id'), "tipo" => "where")
				);
			$datosconsulta = $this->Global_model->mostrar($datos);

			if(!is_null($datosconsulta))
	        { 
				$this->form_validation->set_message('comprobar_cedulaedit', '<i class="fa fa-exclamation-triangle"></i> La nueva cédula '.$val.' que trata de tomar está en uso');
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
