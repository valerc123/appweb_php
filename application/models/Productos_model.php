<?php
/*Modelo de productos*/

class Productos_model extends CI_model
{
	function __construct()
	{
		//Invocar el helper security
		$this->load->helper('security');
	}

    function listar()
    {
        $query = $this->db->get("productos");
        return $query->result_array();
    }

  

}

?>