<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos extends MX_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->library(array('comprobacion','form_validation'));
        $this->comprobacion->check_sesion();
    }

    public function index(){
    	$this->getperfildata();
    }

	public function getperfildata()
	{	
		if($this->input->is_ajax_request()){
			$datos['select'] = 'id, nombre';
			$datos['tabla'] = 'perfiles';
			$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "ASC", "tipo" => "NORMAL"));// 
			$data['perfiles'] = $this->Global_model->mostrar($datos);

			$datos2['select'] = '*';
			$datos2['tabla'] = 'menu';
			$datos2['where'] = array(0 => array("campo" => "tipo_relacion", "valor" => 'Modulo', "tipo" => "where"));
			$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "ASC", "tipo" => "NORMAL"));// 
			$data['menu'] = $this->Global_model->mostrar($datos2);
			$this->load->view('permisos',$data);
		}else{
			redirect(base_url().'panel');
		}
	}

	public function getperfildatapermisos(){
		if($this->input->is_ajax_request()){
			$datos['select'] = 'perfil_id';
			$datos['tabla'] = 'detallepermiso';
			$datos['where'] = array(0 => array("campo" => "perfil_id", "valor" => $this->input->post('perfil_id'), "tipo" => "where"),
				);
			$permisos = $this->Global_model->mostrar($datos);
		
			$datos2['select'] = '*';
			$datos2['tabla'] = 'menu';
			$datos2['where'] = array(0 => array("campo" => "tipo_relacion", "valor" => 'Modulo', "tipo" => "where"));
			$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "ASC", "tipo" => "NORMAL"));// 
			
			$data['permisos'] = $permisos;
			$data['perfil_id'] = $this->input->post('perfil_id');
			$data['menu'] = $this->Global_model->mostrar($datos2);
			$this->load->view('detellepermiso',$data);
		}else{
			show_404();
		}
	}

	public function procesarpermisos(){
		if($this->input->is_ajax_request()){	
			$array1 = !empty($this->input->post('modulos'))?$this->input->post('modulos'):array();	
			$array2 = !empty($this->input->post('menu'))?$this->input->post('menu'):array();
			$array3 = !empty($this->input->post('boton'))?$this->input->post('boton'):array();	
			$ids = array_merge($array1, $array2, $array3);
			sort($ids);//ordeno el array

			$datos['select'] = '*';
			$datos['tabla'] = 'detallepermiso';
			$datos['where'] = array(0 => array("campo" => "perfil_id", "valor" => $this->input->post('perfil_id'), "tipo" => "where"),
				);
			$permisos = $this->Global_model->mostrar($datos);

			if (!is_null($permisos)) {

				$idspermiso = array();
				foreach ($permisos as $p) {
					$idspermiso[] = $p->permiso_id;
				}

				$arraymenu = array(); 
			  	foreach ($ids as $idpermisos) 
			  	{
			  		if (in_array($idpermisos, $idspermiso)) 
					{
						$respuesta = true;
					}else{
						  $arraymodulos[] = $idpermisos;	
						  foreach ($arraymodulos as $idnuevos) {
							   $datos['tabla'] = 'detallepermiso';
							   $insert['perfil_id'] = $this->input->post('perfil_id');
							   $insert['permiso_id'] = $idnuevos;
							   $insert['created_at'] = FECHAGESTOR;
							   $insert['updated_at'] = FECHAGESTOR;
							   $datainsert_id = $this->Global_model->agregar($datos,$insert);

							  if (!is_null($datainsert_id)) {
							    $respuesta = true;
							  }else{
							  	$respuesta = false;
							  }
						 } 
					}
				}

			   //$idsborrar = array();
				foreach ($idspermiso as $r3) 
			    {	
			    	if (in_array($r3, $ids)) {
			 			//$respuesta == true;
			  		}
			  		else{
			  			$cbd["tabla"] = "detallepermiso";
			            $cbd["where"] = array(
			                    0 => array("campo" => "permiso_id", "valor" =>  $r3, "tipo" => "where"),
			                    1 => array("campo" => "perfil_id", "valor" =>  $this->input->post('perfil_id'), "tipo" => "where"),
			                );
			       		$this->Global_model->borrar($cbd);
			       		//$respuesta == true;
			  		}
			    }
	
			 if (@$respuesta == true) {
			  	echo json_encode(array('mensages' => '<div class="alert alert-success  alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-check-square"/> Felicidades! Se guardaron los Permisos para el Perfil "<b>'.$this->nombre_perfil($this->input->post('perfil_id')).'</b>"</div>'));
			  }else{
			  	echo json_encode(array('mensages' => '<div class="alert alert-danger  alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-check-square"/> Error! no se pudierón guardar los permiso para el Perfil "<b>'.$this->nombre_perfil($this->input->post('perfil_id')).'</b>"</div>' ));
			  }

		  }else{
		  		 foreach ($ids as $idsnuevos) {
				   $datos['tabla'] = 'detallepermiso';
				   $insert['perfil_id'] = $this->input->post('perfil_id');
				   $insert['permiso_id'] = $idsnuevos;
				   $insert['created_at'] = FECHAGESTOR;
				   $insert['updated_at'] = FECHAGESTOR;
				   $datainsert_id = $this->Global_model->agregar($datos,$insert);

			   		if (!is_null($datainsert_id)) {
				   	   $respuesta = true;
				  	}else{
				  		$respuesta = false;
				    }
		  		 }		
				 if ($respuesta == true) {
				  	echo json_encode(array('mensages' => '<div class="alert alert-success  alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-check-square"/> Felicidades! Se guardaron los Permisos para el Perfil "<b>'.$this->nombre_perfil($this->input->post('perfil_id')).'</b>"</div>'));
				  }else{
				  	echo json_encode(array('mensages' => '<div class="alert alert-danger  alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-check-square"/> Error! no se pudierón guardar los permiso para el Perfil "<b>'.$this->nombre_perfil($this->input->post('perfil_id')).'</b>"</div>' ));
				  }
		  	}
		}else{
			show_404();
		}	
	}

	function nombre_perfil($perfil_id){
		$datos['select'] = '*';
		$datos['tabla'] = 'perfiles';
		$datos['where'] = array(0 => array("campo" => "id", "valor" => $perfil_id, "tipo" => "where"),
			);
		$perfil = $this->Global_model->mostrar($datos);

		if (!is_null($perfil)) {
			return $perfil[0]->nombre;
		}else{
			return 'No hay resultados';
		}
	}
}
