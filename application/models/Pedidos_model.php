<?php
/*Modelo de productos*/

class Pedidos_model extends CI_model
{
	function __construct()
	{
		//Invocar el helper security
		$this->load->helper('security');
	}

    function agregar()
    {
       //recuperar datos y aplicar la seguridad que esta en el helper
    	$ref=$this->input->post('ref');
    	$token=$this->input->post('token');
    	$cantidad=$this->input->post('cant');
    	$precio=$this->input->post('precio');
    	$impuesto=$this->input->post('impuesto');
    	$subtotal=$this->input->post('subtotal');
    	$tipo=$this->input->post('tipo');

    	$ref=$this->security->xss_clean($ref);
    	$token=$this->security->xss_clean($token);
    	$cantidad=$this->security->xss_clean($cantidad);
    	$precio=$this->security->xss_clean($precio);
    	$impuesto=$this->security->xss_clean($impuesto);
    	$subtotal=$this->security->xss_clean($subtotal);
    	$tipo=$this->security->xss_clean($tipo);


    	$vector = array("ref" => $ref, "token" => $token);
    	$query = $this->db->get_where("pedidos_detalle",$vector);
   
   		$res=$query->result_array();


   		//si la array tiene datos
   		if(count($res) > 0){
   			//actualizar
   			//me sirve tambien para eliminar registro dependiendo si paso 1 o 2
   			// el update se pasa en un vector los datos actualizar, se pide las condiciones 
   			// y luego se ejecuta el update. El mismo principio es para el delete

   			$data= Array(
   				"precio"=>$precio,
   				"impuesto"=>$impuesto,
   				"subtotal"=>$subtotal,
   				"cantidad"=>$cantidad
   			);

   			$this->db->where("token",$token);
   			$this->db->where("ref",$ref);

   			if($tipo==1){ //actualice
   				$this->db->update("pedidos_detalle", $data);
   			}else if($tipo==2){ //elimine
   				$this->db->delete("pedidos_detalle");
   			}
   		
   		}else{

   			//insertar
   			
   			$data= Array(
   				"precio"=>$precio,
   				"impuesto"=>$impuesto,
   				"subtotal"=>$subtotal,
   				"cantidad"=>$cantidad,
   				"ref"=>$ref,
   				"token"=>$token

   			);
   			if($tipo==1){ 
   				$this->db->insert("pedidos_detalle", $data);
   			}

   		}

        //traer el total del carrito
      $totalpedido=$this->carrito();
      return $totalpedido;


   		return $tipo;

    }
    // funcion que me calcula cual es el valor total de lo que lelvo en el pedido detalle
    //basado en el token
    function carrito(){
      $token=$this->input->post('token');
      $token=$this->security->xss_clean($token);
      $vector= array("token"=>$token);
      $query=$this->db->get_where("pedidos_detalle",$vector);
      $total=0;
      $res=$query->result_array();
      foreach($res as $fila){
        $total=$total+$fila["subtotal"];
      }
      return $total;
    }
}


?>