<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{	
		$datos['menu'] = $this->menu();	
		$this->load->view('index',$datos);
	}

	public function listar(){
		if($this->input->is_ajax_request()){

			$datos['select'] = 'id, nombre, codigo, created_at, updated_at';
			$datos['tabla'] = 'zet_icono';

			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datos['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',nombre,' ', codigo, ' ',created_at, ' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
				); //both	
	        }

		    $datos['limit'] = $this->input->post("length");
			$datos['offset'] = $this->input->post("start");	
			
			if($this->input->post("order") != NULL){

	        	$columnas = array('','id','nombre','codigo','created_at','updated_at');//Ordenado Segun filtro

	            $datos['order_by'] =  array(0 => array("campo" => $columnas[$this->input->post("order")['0']['column']], "valor" => $_POST['order']['0']['dir'], "tipo" => "NORMAL"));

	        }else{

	        	$datos['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// Ordenado por Defecto
	        } 
	       
			$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

	        if (!is_null($consulta)){
	        	
	        	$data = array();
	        	$no = $this->input->post("start");
		        foreach ($consulta as $icono) {
		        	$no++;
		            $row = array();
		            $row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$icono->id.'"/>';
		            $row[] = $icono->id;
		            $row[] = $icono->nombre;
		            $row[] = $icono->codigo;
		            $row[] = $icono->created_at;
		            $row[] = $icono->updated_at;
		            
		            $data[] = $row; 
		        }
		        
	        }else{
	        	$data = array();
	        }     

	        $datoscontador['select'] = 'id, nombre, codigo, created_at, updated_at';
			$datoscontador['tabla'] = 'zet_icono';

			if($this->input->post("search")['value'] != NULL) //si tiene un valor la busqueda
	        {
	    		$datoscontador['like'] = array(
				0 => array("campo" => "CONCAT(id,' ',nombre,' ', codigo, ' ',created_at, ' ',updated_at)", "valor" => $this->input->post("search")['value'], "comodin" => "both", "tipo" => "like")
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

	function menu($padre_id = NULL){

		$datos['select'] = '*';
		$datos['tabla'] = 'zet_menu';
		$datos['where'] = array(0 => array("campo" => "padre_id", "valor" => $padre_id, "tipo" => "where"));
		$consulta = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta

		$html = '';
		if (!is_null($consulta)) {

			if ($padre_id == NULL) {
				$class = 'nav navbar-nav';
				$class2 = 'dropdown';
				$condicion = '';
			}else{
				$class = 'dropdown-menu multi-level';
				$class2 = 'dropdown-submenu';
				$condicion = '<span class="caret"/>';
			}

			$html.= '<ul class="'.$class.'">';
			foreach ($consulta as $menu) {
				$html.='<li class="'.$class2.'">';

				$html.= '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="#">'.$menu->nombre.' '.$condicion.'</a>';

				$html.= $this->menu($menu->id);
				$html.="</li>";
			}
			$html.="</ul>";
		}
		return $html;	
	}

}
