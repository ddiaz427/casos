<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('comprobacion','form_validation'));
        $this->comprobacion->check_sesion();
    }

	public function index(){
        //$this->session->sess_destroy(); 
        //echo 'panel';
        //echo "<pre>";
        //print_r($this->session->userdata('usuariosesion'));
        $dataCuerpo['cuerpo'] = $this->load->view('panel', null, true);// seteo la vista correspondiente

        if ($this->input->is_ajax_request()){
            echo $dataCuerpo['cuerpo'];// si viene por ajax la peticion
        }else{

             $dataCuerpo['head'] = $this->load->view('template/head', ['titulo' => 'Panel de administración'], true);
             $dataCuerpo['nav'] = $this->load->view('template/nav', null, true);
             $dataCuerpo['footer'] = $this->load->view('template/footer', null, true);
             $this->load->view('template/template',$dataCuerpo);
        }
	}

    public function consolidadoajax(){
     if ($this->input->is_ajax_request()){  // Consolido toda la data para usarla en el javascrips
        echo json_encode(array(
                               'getProfileUser' => $this->ProfileUser(), 
                               'getdatosempresa' => $this->DataCompany(),
                               'getdatosmodulo' => $this->DataModulo(), 
                               'getclientes' => $this->misclientes(),
                               'getcasoshoy' => $this->casoshoy(),
                               'getcasossemana' => $this->casossemana(),
                               'getcasosmes' => $this->casosmes(), 
                               'getcasosanio' => $this->casosanio(), 
                                )
                          );
        }
        else{
            show_404();
        }
    }

    public function ProfileUser(){
        if($this->input->is_ajax_request()){    
             $datauser = array('data1' => $this->session->userdata('usuariosesion'),
                               'data2' => null,
                );
            return $datauser;
        }
        else{
            show_404();
        }   
    }

    public function DataCompany()
    {
        if ($this->input->is_ajax_request()){
            
            $datos = array(
            'select'=> '*',
            'tabla' => 'configuracion',
            );
            $data = $this->Global_model->mostrar($datos);
            if (!is_null($data)){    
                $datacompany = array('logo' => $data[0]->logo,
                                     'descripcion' => $data[0]->descripcion,
                                     'nombre' => $data[0]->nombre_sitio,
                                     'estado' => $data[0]->estado_sitio,
                                     'mision' => $data[0]->mision,
                                     'vision' => $data[0]->vision,
                                     'email' => $data[0]->correo,
                    );

                 return $datacompany;
            }
            else{
                return array(); 
            }
        }
        else{
            show_404();
        }
    }

    public function DataModulo()
    {
        if ($this->input->is_ajax_request()){
            
            $datos['select'] = 'm.id, m.nombre, i.codigo';
            $datos['tabla'] = 'detallepermiso d';
            $datos['join'] = array(
                                0 => array("tabla" => "menu m", "condicion" => "d.permiso_id = m.id", "tipo" => "INNER"),
                                1 => array("tabla" => "iconos i", "condicion" => "m.icono_id = i.id", "tipo" => "RIGHT")
                            );
            $datos['where'] = array( 
                         0 => array("campo" => "d.perfil_id", "valor" => $this->session->userdata('usuariosesion')['perfilid'], "tipo" => "where"),
                         1 => array("campo" => "m.tipo_relacion", "valor" => "Modulo", "tipo" => "where"), // Condiciones
            );
            $datos['order_by'] =  array(0 => array("campo" => "m.jerarquia", "valor" => "ASC", "tipo" => "NORMAL"));// 
            $datamenu = $this->Global_model->mostrar($datos);
            if (!is_null($datamenu)){    
               $html = ''; 
               foreach ($datamenu as $menu) {

                $datos2['select'] = 'm.id, m.nombre, i.codigo, m.controller, m.method';
                $datos2['tabla'] = 'detallepermiso d';
                $datos2['join'] = array(
                    0 => array("tabla" => "menu m", "condicion" => "d.permiso_id = m.id", "tipo" => "INNER"),
                    1 => array("tabla" => "iconos i", "condicion" => "m.icono_id = i.id", "tipo" => "RIGHT")
                                );
                $datos2['where'] = array( 
                             0 => array("campo" => "d.perfil_id", "valor" => $this->session->userdata('usuariosesion')['perfilid'], "tipo" => "where"),
                             1 => array("campo" => "m.menu_id", "valor" => $menu->id, "tipo" => "where"),
                             2 => array("campo" => "m.tipo_relacion", "valor" => "Menu", "tipo" => "where"), // Condiciones
                              // Condiciones            
                );
                $datos2['order_by'] =  array(0 => array("campo" => "m.jerarquia", "valor" => "ASC", "tipo" => "NORMAL"));// 
                $datamenu2 = $this->Global_model->mostrar($datos2); 
               
                   $html.='<li class="dropdown">';
                   $html.= '<a href="javascript:void(0);"class="dropdown-toggleclear" data-toggle="dropdown"><b><i class="'.$menu->codigo.'"></i> '.$menu->nombre.' <i class="fa fa-caret-down"></i></b></a>'; 
                   
                   if (!is_null($datamenu2)){    
                       $html.= '<ul class="dropdown-menu animated fadeInRight scrollable-menu">';  
                       foreach ($datamenu2 as $menu2){
                         //print_r($menu2);
                         $datosajax = 'idmenu='.$menu2->id.'&controlador='.$menu2->controller.'&metodo='.$menu2->method;
                         $div = 'resultado';
                         $url = base_url().$menu2->controller.'/'.$menu2->method; 
                         $parametros = "'$datosajax','$url','$div'"; 

                         $html.= '<li class="dropdown">'; 
                         $html.= '<a href="javascript:void(0);" onclick="obj_panel.menu('.$parametros.');"><i class="'.$menu2->codigo.'"></i> '.$menu2->nombre.'</a>'; 
                         $html.='</li>';
                        }
                        $html.= '</ul>';
                    }
                    $html.='</li>'; 
               }     

              return $html;
            }
            else{
                return array(); 
            }
        }
        else{
            show_404();
        }
    }

    public function botones(){
        if ($this->input->is_ajax_request()){
                $datos['select'] = 'm.id, m.nombre, i.codigo, m.controller, m.method, m.funcion';
                $datos['tabla'] = 'detallepermiso d';
                $datos['join'] = array(
                    0 => array("tabla" => "menu m", "condicion" => "d.permiso_id = m.id", "tipo" => "INNER"),
                    1 => array("tabla" => "iconos i", "condicion" => "m.icono_id = i.id", "tipo" => "RIGHT")
                                );
                $datos['where'] = array( 
                             0 => array("campo" => "d.perfil_id", "valor" => $this->session->userdata('usuariosesion')['perfilid'], "tipo" => "where"),
                             1 => array("campo" => "m.menu_id", "valor" => $this->input->post('idmenu'), "tipo" => "where"),
                             2 => array("campo" => "m.tipo_relacion", "valor" => "Boton", "tipo" => "where"), // Condiciones
                              // Condiciones            
                );
                $datos['order_by'] =  array(0 => array("campo" => "m.jerarquia", "valor" => "ASC", "tipo" => "NORMAL"));// 
                $databotones = $this->Global_model->mostrar($datos); 

                if (!is_null($databotones)){
                    $html = ''; 
                    foreach($databotones as $boton){
                        $html.= ' <a href="javascript:void(0);" onclick="'.$boton->funcion.'" class="btn btn-raised btn-default btn-sm">';
                        $html.= '<i class="'.$boton->codigo.'"></i> ';
                        $html.= $boton->nombre;
                        $html.= '</a>';
                    }
                    echo json_encode(array('botones' => $html));
                }else{
                     echo json_encode(array('botones' => null));
                }

                //print_r($databotones);
        }else{
            show_404();
        }
    }

    public function misclientes(){
         if($this->input->is_ajax_request()){
            $datos['select'] = '*';
            $datos['tabla'] = 'clientes';
            $datos['where'] = array( 
                         0 => array("campo" => "usuario_id", "valor" => $this->session->userdata('usuariosesion')['usuario_id'], "tipo" => "where"), // Condiciones
                          // Condiciones            
            );
            $datos['limit'] = 5;
            $dataconsulta = $this->Global_model->mostrar($datos);

            if (!is_null($dataconsulta)) {
               return $dataconsulta;
            }
            else{
                return array();
            }
         }
        else{
           show_404();
        }   
    }

    public function casoshoy(){
         if($this->input->is_ajax_request()){
            $datos['select'] = 'co.nombre_caso, co.id, co.permanet_link, date_format(co.created_at,"%d %M %Y") AS fechacreado, co.estado, ci.nombres as cliente, tc.nombre as tipocaso, DATEDIFF(NOW(), co.created_at) AS diastranscurridos';
            $datos['tabla'] = 'casos co';
            $datos['join'] = array(
                                0 => array("tabla" => "clientes ci", "condicion" => "co.cliente_id = ci.id", "tipo" => "INNER"),
                                1 => array("tabla" => "tipo_casos tc", "condicion" => "co.tipo_caso_id = tc.id", "tipo" => "INNER"),
                            );
            $datos['where'] = array( 
                         0 => array("campo" => "DAYOFMONTH(co.created_at)", "valor" => 'DAYOFMONTH(NOW())', "tipo" => "wherefalse"), // Condiciones
                          // Condiciones            
            );
            $datos['limit'] = 5;
            $dataconsulta = $this->Global_model->mostrar($datos);

            if (!is_null($dataconsulta)) {
                return $dataconsulta;
            }else{
                return array();
            }    

         }else{
            show_404();
         }
    }

    public function casossemana(){
         if($this->input->is_ajax_request()){
            $datos['select'] = 'co.nombre_caso, co.id, co.permanet_link, date_format(co.created_at,"%d %M %Y") AS fechacreado, co.estado, ci.nombres as cliente, tc.nombre as tipocaso';
            $datos['tabla'] = 'casos co';
            $datos['join'] = array(
                                0 => array("tabla" => "clientes ci", "condicion" => "co.cliente_id = ci.id", "tipo" => "INNER"),
                                1 => array("tabla" => "tipo_casos tc", "condicion" => "co.tipo_caso_id = tc.id", "tipo" => "INNER"),
                            );
            $datos['where'] = array( 
                         0 => array("campo" => "YEARWEEK(co.created_at)", "valor" => 'YEARWEEK(NOW())', "tipo" => "wherefalse"), // Condiciones
                          // Condiciones            
            );
            $datos['limit'] = 5;
            $dataconsulta = $this->Global_model->mostrar($datos);

            if (!is_null($dataconsulta)) {
                return $dataconsulta;
            }else{
                return array();
            }    

         }else{
            show_404();
         }
    }

    public function casosmes(){
         if($this->input->is_ajax_request()){
            $datos['select'] = 'co.nombre_caso, co.id, co.permanet_link, date_format(co.created_at,"%d %M %Y") AS fechacreado, co.estado, ci.nombres as cliente, tc.nombre as tipocaso';
            $datos['tabla'] = 'casos co';
            $datos['join'] = array(
                                0 => array("tabla" => "clientes ci", "condicion" => "co.cliente_id = ci.id", "tipo" => "INNER"),
                                1 => array("tabla" => "tipo_casos tc", "condicion" => "co.tipo_caso_id = tc.id", "tipo" => "INNER"),
                            );
            $datos['where'] = array( 
                         0 => array("campo" => "MONTH(co.created_at)", "valor" => 'MONTH(NOW())', "tipo" => "wherefalse"), // Condiciones
                          // Condiciones            
            );
            $datos['limit'] = 5;
            $dataconsulta = $this->Global_model->mostrar($datos);

            if (!is_null($dataconsulta)) {
                return $dataconsulta;
            }else{
                return array();
            }    

         }else{
            show_404();
         }
    }

    public function casosanio(){
         if($this->input->is_ajax_request()){
            $datos['select'] = 'co.nombre_caso, co.id, co.permanet_link, date_format(co.created_at,"%d %M %Y") AS fechacreado, co.estado, ci.nombres as cliente, tc.nombre as tipocaso, DATEDIFF(NOW(), co.created_at) AS diastranscurridos';
            $datos['tabla'] = 'casos co';
            $datos['join'] = array(
                                0 => array("tabla" => "clientes ci", "condicion" => "co.cliente_id = ci.id", "tipo" => "INNER"),
                                1 => array("tabla" => "tipo_casos tc", "condicion" => "co.tipo_caso_id = tc.id", "tipo" => "INNER"),
                            );
            $datos['where'] = array( 
                         0 => array("campo" => "YEAR(co.created_at)", "valor" => 'YEAR(NOW())', "tipo" => "wherefalse"), // Condiciones
                          // Condiciones            
            );
            $datos['limit'] = 5;
            $dataconsulta = $this->Global_model->mostrar($datos);

            if (!is_null($dataconsulta)) {
                return $dataconsulta;
            }else{
                return array();
            }    

         }else{
            show_404();
         }
    }

    public function salir(){
        if($this->input->is_ajax_request()){
            $this->session->sess_destroy();
            echo json_encode(array('success'=>true,'mensages' =>base_url()));   
        }
        else{
            $this->session->sess_destroy();
            redirect(base_url().'login');
        }   
    }
}
