<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
    Aplicar el CRUD grocery => para hacerlo es necesario modificar una variable del config.php del codigniter, esa variable
    es csrf regenerate
*/

class Categoriaproductos extends CI_Controller 
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
        $data["modulo"] = "Categorias de productos";
        $data["descripcion"] = "Listado de categorias donde se ubican los productos";
         $data["fotousuario"] = $this->session->userdata('foto'); 


        $data["facebook"] = $this->session->userdata('facebook'); 
        $data["twitter"] = $this->session->userdata('twitter'); 
        $data["linkedin"] = $this->session->userdata('linkedin'); 

   
        $this->crud->set_theme('flexigrid');

        //2- Cargar la tabla
        $this->crud->set_table('categoriaproductos');

        //3 - Se le definde un titulo a la tabla
        $this->crud->set_subject("Listado de Categoria de productos");

        //Otras configuraciones
        //Definir que campos son requeridos
        $this->crud->required_fields("nombre");

        //Definir que campos se deben cargar en editar o en el ingresar
        $this->crud->fields("nombre");

        //Cambiar el nombre del campo en la pantalla
        $this->crud->display_as("nombre","Categoria");
        $this->crud->display_as("fecharegistro","Fecha de registro");
        $this->crud->display_as("fechamodificacion","Ultima modificación");

        //4 - Aplicar el render, que es ejecutar estas variables y esperar los tres componentes para cargar en la vista.
        $tabla = $this->crud->render();

        //Los tres componentes se llaman output, js_files y css_files
        $data["contenido"] = $tabla->output;
        $data["js_files"]  = $tabla->js_files;
        $data["css_files"] = $tabla->css_files;

        $this->load->view('crud', $data);
    }
}

