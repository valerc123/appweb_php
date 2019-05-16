<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
    Aplicar el CRUD grocery => para hacerlo es necesario modificar una variable del config.php del codigniter, esa variable
    es csrf regenerate
*/

class Productos extends CI_Controller 
{
    function __construct()
    {
        //Hereda las caracteristicas del constructor
        parent:: __construct();
        //Cargar libreria
        $this->load->library('grocery_CRUD');
        //instanciar la libreria
        $this->crud = new grocery_CRUD();

        if (!$this->session->userdata('id')) 
        {
            redirect('login');
        }
    }

    public function index()
    {
        $data["nombreusuario"] = $this->session->userdata('nombre'); 
        $data["modulo"] = "Tipos de clientes";
        $data["descripcion"] = "Listado de tipos de clientes";
        $data["fotousuario"] = $this->session->userdata('foto'); 

        $data["facebook"] = $this->session->userdata('facebook'); 
        $data["twitter"] = $this->session->userdata('twitter'); 
        $data["linkedin"] = $this->session->userdata('linkedin'); 

        $this->crud->set_theme('flexigrid');

       
        $this->crud->set_table('productos');

        $this->crud->set_relation('categoria',"categoriaproductos","nombre");
        $this->crud->fields('categoria',"ref","nombre","foto1","foto2","descripcion","precio","iva","cant");
        $this->crud->required_fields("ref","nombre","foto1","precio","iva","cant");
        $this->crud->display_as("categoria","Seleccione la categoria");
        $this->crud->display_as("ref","digite la referencia");
        $this->crud->display_as("nombre","digita el nombre");
        $this->crud->display_as("descripcion","Resumen detalle del producto");
        $this->crud->display_as("precio","precio");
        $this->crud->display_as("iva","% iva");
        $this->crud->display_as("cant","Cantidad disponible");
        $this->crud->display_as("foto1","Imagen 1");
        $this->crud->display_as("foto2","Imagen 2");
        $this->crud->set_field_upload("foto1","assets/uploads/productos/");
        $this->crud->set_field_upload("foto2","assets/uploads/productos/");
        $this->crud->columns("foto1","categoria","ref","nombre","precio","iva","cant");
        $this->crud->set_subject("Listado de productos");
        $this->crud->change_field_type("precio","integer");
        $this->crud->change_field_type("iva","integer");
        $this->crud->change_field_type("cant","integer");




        $tabla = $this->crud->render();

        //Los tres componentes se llaman output, js_files y css_files
        $data["contenido"] = $tabla->output;
        $data["js_files"]  = $tabla->js_files;
        $data["css_files"] = $tabla->css_files;

        $this->load->view('crud', $data);
    }
}

