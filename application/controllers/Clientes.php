<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
    Aplicar el CRUD grocery => para hacerlo es necesario modificar una variable del config.php del codigniter, esa variable
    es csrf regenerate
*/

class Clientes extends CI_Controller 
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
        $data["modulo"] = "Clientes";
        $data["descripcion"] = "Listado de roles para los usuarios";

        $data["facebook"] = $this->session->userdata('facebook'); 
        $data["twitter"] = $this->session->userdata('twitter'); 
        $data["linkedin"] = $this->session->userdata('linkedin'); 



        $this->crud->set_theme('flexigrid');
        $this->crud->set_table('clientes');
        $this->crud->set_subject("Listado de clientes");
        //si queremos relacionar dos tablas y que podamos por medio de un selct asociar un dato de una de ellas usamos set_relation (campo de la tabla set table, la tabla a asociar que campo mostrar de la tabla a asociar)
        $this->crud->set_relation("tipocliente","tiposdeclientes","nombre");
        $this->crud->fields("tipocliente","nit","nombre","comercial","telefono","direccion","correo","rut","estadosfinancieros");
        $this->crud->required_fields("tipocliente","nit","nombre","telefono","direccion","correo");

        $this->crud->display_as("tipocliente","Seleccione el tipo de cliente");
        $this->crud->display_as("nit","Digite su nit o CC");
        $this->crud->display_as("nombre","Digite su razon social");
        $this->crud->display_as("telefono", "Digite su telefono");
        $this->crud->display_as("direccion","Digite du direccion");
        $this->crud->display_as("correo","Email");
        $this->crud->display_as("rut","Cargar el rut");
        $this->crud->display_as("estadosfinancieros","Cargar los estados financieros");
           $data["fotousuario"] = $this->session->userdata("foto");

        //se puede subir archivos a determinados campos
        //usando set_field_upload ("campo","ruta donde se cargara el archivo")

        $this->crud->set_field_upload("rut","assets/uploads/clientes/");
        $this->crud->set_field_upload("estadosfinancieros","assets/uploads/clientes/");
        $this->crud->columns("tipocliente","nit","nombre","telefono","direccion","correo");

         
        

      /*  $this->crud->required_fields("nombre");
        $this->crud->fields("nombre");
        $this->crud->display_as("nombre","Rol del usuario");
        $this->crud->display_as("fecharegistro","Fecha de registro");
        $this->crud->display_as("fechamodificacion","Ultima modificación");*/


        $tabla = $this->crud->render();
        $data["contenido"] = $tabla->output;
        $data["js_files"]  = $tabla->js_files;
        $data["css_files"] = $tabla->css_files;

        $this->load->view('crud', $data);
    }
}

