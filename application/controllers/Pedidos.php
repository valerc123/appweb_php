<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Solo se puede acceder a el si las variables de sesion se encuentran activas, como todas las funciones deben preguntar por ellas se validan en el constructor por que es lo primero que se evalua.

class Pedidos extends CI_Controller 
{
    function __construct()
    {
        //Hereda las caracteristicas del constructor
        parent:: __construct();
        //invocar los modelos que se necesitan para todo el controlador
        $this->load->model("productos_model");
        $this->load->model("pedidos_model");
        $this->load->model("clientes_model");

        if (!$this->session->userdata('id')) 
        {
            redirect('login');
        }
    }

    public function index()
    {
        $data["nombreusuario"] = $this->session->userdata('nombre'); 
        $data["fotousuario"] = $this->session->userdata('foto'); 

        $data["facebook"] = $this->session->userdata('facebook'); 
        $data["twitter"] = $this->session->userdata('twitter'); 
        $data["linkedin"] = $this->session->userdata('linkedin'); 


        $data["modulo"] = "Pedidos";
        $data["descripcion"] = "Listado de pedidos";
        $this->load->view('pedidos', $data);
    }

    public function nuevo()
    {
        $data["nombreusuario"] = $this->session->userdata('nombre'); 
        $data["fotousuario"] = $this->session->userdata('foto'); 

        $data["facebook"] = $this->session->userdata('facebook'); 
        $data["twitter"] = $this->session->userdata('twitter'); 
        $data["linkedin"] = $this->session->userdata('linkedin');

        $data["modulo"] = "Pedidos";
        $data["descripcion"] = "Generar nuevo pedido"; 


        //se van a pasar los datos de los productos y el token que se va a usar 
        //para el pedido

        $data["listaproductos"]=$this->productos_model->listar();
        //generar el token . se va a usar session_id y combinando con un valor aprovechando la version 7.0 del php usaremos una funcion que nos genera un valor aleatorio
        $token=base64_encode(random_bytes(32).session_id());
       
        $data["token"]=$token;
        // enviar el listado de los clientes que se van a cargar en el select
        //cliente
        $data["listadoclientes"]=$this->clientes_model->listar();
        $this->load->view('nuevopedido', $data);
    }

    //funcion agregar que nos servira para agregar o quitar productos del pedido 
    function agregar(){
        // cargar el modelo de pedidos con una funcion que nos permita agregar o eliminar de la tabla de pedidos_detalle
        $respuesta = $this->pedidos_model->agregar();
        echo "El pedido va en :" .number_format($respuesta, 0);

    }

    function cargarcliente() {
        //del modelo extraer la funcion que trae el detalle del cliente
        //o del registro y devolver como un json
        $data=$this->clientes_model->detallecliente();
        echo json_encode($data);
    }
}
