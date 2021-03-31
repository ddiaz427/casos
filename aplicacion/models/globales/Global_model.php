<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Global_model extends CI_Model
{
	public $todos = "";
	public $total = "";
	public $subtotal = "";

	function __construct()
	{
		parent::__construct(); // Llamado al constructor Modelo
		//$this->db->query("SET lc_time_names = 'es_VE'");// seteo el idioma de la fecha
	}
	
	function mostrar($cbd = array("")) //$this->Bdc_m->consulta($cbd);
	{
		$cbdi = array(
		/*1*/	"bd" => NULL,		// $bd = CONST Indicamos la BD, si se deja NULL tomará la BD por defecto en el archivo database.php de la carpeta configuración
		/*2*/	"tabla" => NULL,			// $c["tabla"] = "tabla"	Seleccionamos la Tabla. Campo Obligatorio
		/*3*/	"select" => NULL,	// $campos = "a.id as aid,a.nombre as nombre"; 	Seleccionamos los campos que consultaremos
		/*3.1*/	"selectfalse" => NULL,	//array();
		/*4*/	"where" => NULL,		// array(0 => array("campo" => "tabla", "valor" => "$var", "tipo" => "where,or_where,where_in,or_where_in,where_not_in,or_where_not_in"))
		/*5*/	"limit" => NULL,		// Limite de la consulta
		/*6*/	"offset" => NULL,	// Compensación de la consulta
		/*7*/	"min" => NULL,		// Selecciona el valor Mínimo del campo en la consulta se personaliza el nombre del campo usando el offset
		/*8*/	"max" => NULL,		// Selecciona el valor Máximo del campo en la consulta se personaliza el nombre del campo usando el offset
		/*9*/	"avg" => NULL,		// Selecciona el valor Average-Promedio del campo en la consulta se personaliza el nombre del campo usando el offset
		/*10*/	"sum" => NULL,		// Selecciona el valor Sumado del campo en la consulta se personaliza el nombre del campo usando el offset
		/*11*/	"group_by" => NULL,	//  array("campo", "campo2")
		/*12*/	"distinct" => NULL,	//  $distinct = "campo"
		/*13*/	"having" => NULL,	//  $having = array(0 => array("campo" => "tabla", "valor" => "$var", "tipo" => "having,or_having"))
		/*14*/	"join" => NULL,		// array(0 => array("tabla" => "moebius_citas b", "condicion" => "b.cedula = a.cedula", "tipo" => "RIGHT"))//Permite realizar joins
		/*15*/	"like" => NULL,		// array(0 => array("campo" => "tabla", "valor" => "$var", "comodin" => "before,after,both", "tipo" => "like,or_like,not_like, or_not_like"))
		/*16*/	"order_by" => NULL,		// array(0 => array("campo" => "tabla", "valor" => "ASC, DESC", "tipo" => "NORMAL,RANDOM"))
		/*17*/	"resultarray" => NULL,		// si queremos con nos returne la consulta en un array
				"query" => NULL,///*18*/	"consulta sql limpia ejemplo select from"
			);
		
			$c = array_replace($cbdi, $cbd);
			//print_r($c);

			if (!$c['query']){ // Consulta query sql

				if ($c["select"])/*3*/		// Seleccionamos campos especificos de la tabla o por defecto todos los campos
				{
				 	$consulta = $this->db->select($c["select"]);

				}elseif ($c["selectfalse"]) {
						foreach ($c["selectfalse"] as $r){
							$consulta =  $this->db->select($r, FALSE);
						}
				}
				else{
					$consulta = $this->db->select("*");
				}	
			}


			if ($c["where"])/*4*/
			{
				foreach ($c["where"] as $k => $r)
				{
					if ($r["tipo"] === "where")
					{
						$this->db->where($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "or_where")
					{
						$this->db->or_where($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "where_in")
					{
						$this->db->where_in($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "or_where_in")
					{
						$this->db->or_where_in($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "where_not_in")
					{
						$this->db->where_not_in($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "or_where_not_in")
					{
						$this->db->or_where_not_in($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "wherefalse")
					{
						$this->db->where($r["campo"], $r["valor"], FALSE);
					}
					if ($r["tipo"] === "wherequery")
					{
						$this->db->where($r["valor"]);
					}
				}
			}
	
			if ($c["min"])/*7*/
			{
				$consulta = $this->db->select_min($c["min"], $c["offset"]);
			}

			if ($c["max"])/*8*/
			{
				$consulta = $this->db->select_max($c["max"], $c["offset"]);
			}

			if ($c["avg"])/*9*/
			{
				$consulta = $this->db->select_avg($c["avg"], $c["offset"]);
			}

			if ($c["sum"])/*10*/
			{
				$consulta = $this->db->select_sum($c["sum"], $c["offset"]);
			}

			if($c["group_by"])/*11*/
			{
				$this->db->group_by($c["group_by"]); 
			}

			if($c["distinct"])/*12*/
			{
				$this->db->distinct($c["distinct"]); 
			}

			if ($c["having"])/*13*/
			{
				foreach ($c["having"] as $k => $r)
				{
					if ($r["tipo"] === "having")
					{
						$this->db->having($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "or_having")
					{
						$this->db->or_having($r["campo"], $r["valor"]);
					}
				}
			}

			if ($c["join"]) /*14*/
			{
				foreach ($c["join"] as $k => $r)
				{
					$this->db->join($r["tabla"], $r["condicion"], $r["tipo"]);
				}
			}

			if ($c["like"] != NULL) /*15*/
			{
				foreach ($c["like"] as $k => $r)
				{
					if ($r["tipo"] === "like")
					{
						$this->db->like($r["campo"], $r["valor"], $r["comodin"]);
					}
					if ($r["tipo"] === "or_like")
					{
						$this->db->or_like($r["campo"], $r["valor"], $r["comodin"]);
					}
					if ($r["tipo"] === "not_like")
					{
						$this->db->not_like($r["campo"], $r["valor"], $r["comodin"]);
					}
					if ($r["tipo"] === "or_not_like")
					{
						$this->db->or_not_like($r["campo"], $r["valor"], $r["comodin"]);
					}
				}
			}

			if ($c["order_by"] != NULL) /*16*/
			{
				foreach ($c["order_by"] as $k => $r){

					if ($r["tipo"] === "NORMAL"){
						$this->db->order_by($r["campo"], $r["valor"]);
					}
					if ($r["tipo"] === "RANDOM"){

						$this->db->order_by($r["campo"], $r["tipo"]);
					}
				}
			}

			if ($c["bd"] != NULL)/*1 y 2 */		// // Seleccionamos la base de datos opcional o tomo la por defecto más su tabla
			{
				if ($c['query']){
					$consulta =	$this->db->query($c["bd"].'.'.$c['querysql']);
					$this->total = $consulta->num_rows();

				}else{	
					$consulta = $this->db->get($c["bd"].'.'.$c["tabla"], $c["limit"], $c["offset"]);
					$this->total = $this->db->count_all_results($c["bd"].'.'.$c["tabla"]);
				}
			}
			else{
				   if ($c['query']){
						$consulta =	$this->db->query($c['query']);
						$this->total = $consulta->num_rows();
					}else{
						$consulta = $this->db->get($c["tabla"], $c["limit"], $c["offset"]);
						$this->total = $this->db->count_all_results($c["tabla"]);
					}
				}			

		//termina la considicion

		if ($consulta->num_rows() > 0){

			$this->subtotal = $consulta->num_rows();
			
			if ($c['resultarray']){

				foreach ($consulta->result_array() as $r){
					$r['subtotal'] = $this->subtotal;
					$r['total'] = $this->total;
					$datos[] = $r;
				}
				
			}else{
				foreach ($consulta->result() as $r){
					$r->subtotal = $this->subtotal;
					$r->total = $this->total;
					$datos[] = $r; 
				}
			}	
		}
		else{
			$datos = NULL;
		}

		return $datos;
	}

	function agregar($cbd = array(""), $datos) //$this->Bdc_m->agregar($cbd);
	{
		$cbdi = array(
		/*1*/	"bd" => NULL,		// $bd = CONST Indicamos la BD, si se deja NULL tomará la BD por defecto en el archivo database.php de la carpeta configuración
		/*2*/	"tabla" => NULL,			// $c["tabla"] = "tabla"	Seleccionamos la Tabla. Campo Obligatorio
			);
		$c = array_replace($cbdi, $cbd);

		if ($c["bd"] != NULL)/*1 y 2 */		// // Seleccionamos la base de datos opcional o tomo la por defecto más su tabla
		{
			$this->db->insert($c["bd"].'.'.$c["tabla"], $datos);

			if ($this->db->affected_rows() === 1) {
				return $this->db->insert_id();
			}
		}
		else
		{
			$this->db->insert($c["tabla"], $datos);

			if ($this->db->affected_rows() === 1) {
				return $this->db->insert_id();
			}
		}

		return NULL;
	}

	function actualizar($cbd = array(""), $datos) //$this->Bdc_m->actualizar($cbd);
	{
		$cbdi = array(
		/*1*/	"bd" => NULL,		// $bd = CONST Indicamos la BD, si se deja NULL tomará la BD por defecto en el archivo database.php de la carpeta configuración
		/*2*/	"tabla" => NULL,			// $c["tabla"] = "tabla"	Seleccionamos la Tabla. Campo Obligatorio
		/*3*/	"where" => NULL,		// array(0 => array("campo" => "tabla", "valor" => "$var", "tipo" => "where,or_where,where_in,or_where_in,where_not_in,or_where_not_in"))
		);

		$c = array_replace($cbdi, $cbd);

		if ($c["where"])/*3*/
		{
			foreach ($c["where"] as $k => $r)
			{
				if ($r["tipo"] === "where")
				{
					$this->db->where($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "or_where")
				{
					$this->db->or_where($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "where_in")
				{
					$this->db->where_in($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "or_where_in")
				{
					$this->db->or_where_in($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "where_not_in")
				{
					$this->db->where_not_in($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "or_where_not_in")
				{
					$this->db->or_where_not_in($r["campo"], $r["valor"]);
				}
			}
		}
		if ($c["bd"])/*1 y 2 */		// // Seleccionamos la base de datos opcional o tomo la por defecto más su tabla
		{
			$this->db->update($c["bd"].'.'.$c["tabla"], $datos);

			if ($this->db->affected_rows() === 1) {
				return TRUE;
			}else{
				return NULL;
			}
		}
		else
		{
			$this->db->update($c["tabla"], $datos);

			if ($this->db->affected_rows() === 1) {
				return TRUE;
			}else{
				return NULL;
			}
		}
		
	}

	function borrar($cbd = array("")) //$this->Bdc_m->borrar($cbd);
	{
		$cbdi = array(
		/*1*/	"bd" => NULL,		// $bd = CONST Indicamos la BD, si se deja NULL tomará la BD por defecto en el archivo database.php de la carpeta configuración
		/*2*/	"tabla" => NULL,			// $c["tabla"] = "tabla"	Seleccionamos la Tabla. Campo Obligatorio
		/*3*/	"where" => NULL,		// array(0 => array("campo" => "tabla", "valor" => "$var", "tipo" => "where,or_where,where_in,or_where_in,where_not_in,or_where_not_in"))
		);

		$c = array_replace($cbdi, $cbd);

		if ($c["where"])/*3*/
		{
			foreach ($c["where"] as $k => $r)
			{
				if ($r["tipo"] === "where")
				{
					$this->db->where($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "or_where")
				{
					$this->db->or_where($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "where_in")
				{
					$this->db->where_in($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "or_where_in")
				{
					$this->db->or_where_in($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "where_not_in")
				{
					$this->db->where_not_in($r["campo"], $r["valor"]);
				}
				if ($r["tipo"] === "or_where_not_in")
				{
					$this->db->or_where_not_in($r["campo"], $r["valor"]);
				}
			}
		}
		if ($c["bd"])/*1 y 2 */		// // Seleccionamos la base de datos opcional o tomo la por defecto más su tabla
		{
			$this->db->delete($c["bd"].'.'.$c["tabla"]);
			if ($this->db->affected_rows() > 0){
				return TRUE;
			}else{
				return NULL;
			}
		}
		else
		{
			$this->db->delete($c["tabla"]);
			if($this->db->affected_rows() > 0){
				return TRUE;
			}else{
				return NULL;
			}
		}
	}

 }
