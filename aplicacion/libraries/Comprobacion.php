<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso direccto a este script Su IP ha sido rastreada');

class Comprobacion
{
	public function __construct()
	{
		$this->CI = & get_instance();
	}

     public function auth($usuario, $clave){  

     	//$data['querysql'] = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND 
     	$datos = array();
     	$data['select'] = 'u.id as iduser, u.perfil_id, u.usuario, u.fecha_ult_ingreso, u.created_at, p.email, u.estado as estadouser, CONCAT(p.nombres," ",p.apellidos) as nombresapellidos, p.avatar, p.descripcion';
     	$data['tabla'] = 'usuario u';// Tabla de la base de datos
     	$data['join'] = array(0 => array("tabla" => "persona p", "condicion" => "p.id = u.persona_id", "tipo" => "RIGHT"));//Permite realizar joins
     	$data['where'] = array( 
     					 0 => array("campo" => "", "valor" => "(u.usuario = '$usuario' OR p.email = '$usuario') 
	               		 AND password = '$clave'", "tipo" => "wherequery"), // Condiciones
     		);
		$userchek = $this->CI->Global_model->mostrar($data);
		if(!is_null($userchek)){

			 if($this->ComprobarEstadoSitio() == 'Desactivado' && $userchek[0]->perfil_id !=1 or $this->ComprobarEstadoSitio() == 'Inactivo' && $userchek[0]->perfil_id !=1){

			 	switch(ESTADO_SITIO){
			 		case 'Desactivado':
		  	   				$datos['error'] = '<b>Lo Sentimos</b> Pero El <b>Sistema</b> Se Encuentra en <b>Mantenimiento.</b>';
		  	   				break;

		  	   				case 'Inactivo':
		  	   				$datos['error'] = '<b>Lo Sentimos</b> Pero El <b>Sistema</b> Se Encuentra <b>Inactivo.</b';
		  	   				break;
			 	}
			 }
		  	   else{
		  	   		switch ($userchek[0]->estadouser){
			  			case 'Activado':
			  				 $data = array('usuariosesion' => array(
                            'login' => TRUE,
                            'usuario_id' => $userchek[0]->iduser,
                            'avatar' => $userchek[0]->avatar,
                            'nombres' => $userchek[0]->nombresapellidos,
                            'perfilid' => $userchek[0]->perfil_id,
                            'usuario' => $userchek[0]->usuario,
                            'email' => $userchek[0]->email,
                            'fecha_registro' => str_replace('-', '/', $userchek[0]->created_at),
                            'fecha_ult_ingreso' => str_replace('-', '/', $userchek[0]->fecha_ult_ingreso),
                            'estado' => $userchek[0]->estadouser,
                            'perfilnombre' => $this->perfil($userchek[0]->perfil_id),
                            'descripcion' => $userchek[0]->descripcion,
                        	)
			  				);
			  				 $this->CI->session->set_userdata($data);

			  				 $datosupdate['tabla'] = 'usuario';
			  				 $datosupdate['where'] = array( 
				     					 0 => array("campo" => "id", "valor" => $userchek[0]->iduser, "tipo" => "where"), // Condiciones
				     		 );
				     		 $datosactualizar = ['fecha_ult_ingreso' => FECHAGESTOR];
			  				 $this->CI->Global_model->actualizar($datosupdate, $datosactualizar);

			  				 $datos['success'] = '<b>Datos Correctos!</b> bienvenido estimado Usuario. Ingresando a administraci&oacute;ne.</b>';

			  				break;
			  			
			  			case 'Desactivado':
			  				$datos['error'] = 'Usuario <b>'.$usuario.'</b> se encuentra <b>Desactivado</b>';
			  				break;

			  				case 'Bloqueado':
			  				$datos['error'] = 'Usuario <b>'.$usuario.'</b> se encuentra <b>Bloquedo</b>';
			  				break;

			  			default:
			  				$datos['error'] = 'No <b>existe</b> Ningun <b>estado</b> Comuniquese con el <b>administrador</b>';
			  				break;
			  		}
		 		}	
		}else{

			$data['tabla'] = 'usuario u';// Tabla de la base de datos
     		$data['join'] = array(0 => array("tabla" => "persona p", "condicion" => "p.id = u.persona_id", "tipo" => "RIGHT"));//Permite realizar joins
     		$data['where'] = array( 
     					 0 => array("campo" => "", "valor" => "(u.usuario = '$usuario' OR p.email = '$usuario')", "tipo" => "wherequery"), // Condiciones
     		);

			$userintent = $this->CI->Global_model->mostrar($data);
			if (!is_null($userintent)) {
				$datos['error'] = 'La <b>Contraseña</b> Ingresada no es la correcta';
			}else{
				$datos['error'] = 'El Usuario <b>'.$usuario.'</b> No <b>existe</b> en nuestra <b>Base de Datos</b>';
			}
		}

		return $datos;
     }

    function ComprobarEstadoSitio(){
    	$data['select'] = 'estado_sitio';
     	$data['tabla'] = 'configuracion';// Tabla de la base de datos
     	$data['where'] = array( 
     					 0 => array("campo" => "id", "valor" => "1", "tipo" => "where"), // Condiciones
     		);
		$check_estado = $this->CI->Global_model->mostrar($data);

		if (!is_null($check_estado)){
			return $check_estado[0]->estado_sitio;
		}else{
			return false;
		}
    } 

    function perfil($id){
    	$data['select'] = 'nombre';
     	$data['tabla'] = 'perfiles';// Tabla de la base de datos
     	$data['where'] = array( 
     					 0 => array("campo" => "id", "valor" => $id, "tipo" => "where"), // Condiciones
     		);
		$check_estado = $this->CI->Global_model->mostrar($data);

		if (!is_null($check_estado)){
			return $check_estado[0]->nombre;
		}else{
			return false;
		}
    }
      
	function check_sesion()
	{
		if ($this->CI->session->userdata('usuariosesion')['login'] == TRUE){
			return TRUE;
		}else{
			$uri = base_url().'login';
			echo "<script>javascript:window.location = '".$uri."'</script>";
		}
	}	
}	

