<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
    Aplicar el CRUD grocery => para hacerlo es necesario modificar una variable del config.php del codigniter, esa variable
    es csrf regenerate
*/

class Usuarios extends CI_Controller 
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
        $data["modulo"] = "Usuarios";
        $data["descripcion"] = "Listado de usuarios en el sistema";

        $data["facebook"] = $this->session->userdata('facebook'); 
        $data["twitter"] = $this->session->userdata('twitter'); 
        $data["linkedin"] = $this->session->userdata('linkedin'); 



        $this->crud->set_theme('flexigrid');
        $this->crud->set_table('usuarios');
       
        $this->crud->set_relation("perfil","roles","nombre");
        $this->crud->fields("perfil","nombre","clave","correo","telefono","foto","facebook","twitter","linkedin");
        $this->crud->required_fields("perfil","nombre","clave","correo","telefono");

        $this->crud->display_as("perfil","Rol asociado");
        $this->crud->display_as("nombre","Nombre");
        $this->crud->display_as("telefono", "Telefono");
        $this->crud->display_as("clave","Clave de acceso");
        $this->crud->display_as("correo","Email de acceso");
        $this->crud->display_as("fechaingreso","Registro");
        $this->crud->display_as("fechamodificacion","ultimo cambio");
        $this->crud->columns("foto","perfil","nombre","correo","telefono","fechaingreso","fechamodificacion");
        $this->crud->set_field_upload("foto","assets/uploads/usuarios/");
        $data["fotousuario"] =$this->session->userdata('foto');

         //se pueden realizar operaciones o funciones ANTES de GUARDAR en la tabla cargada
        //para eso usamos callbacks, estos piden llamar una funcion y ellos internamente pasan el vector
        //con los datos del formulario
        $this->crud->callback_before_insert(array($this,"encriptar"));

        //se puede cambiar los tipos de campos tipo text usando change_field_type
        $this->crud->change_field_type("clave","password");
      //se puede dependiendo de la accion que se ejecute, realizar algun proceso adicional
        if($this->crud->getState()=="edit")
        {
            $this->crud->field_type("clave","hidden");
        }


        $this->crud->set_subject("Listado de usuarios");
        $tabla = $this->crud->render();
        $data["contenido"] = $tabla->output;
        $data["js_files"]  = $tabla->js_files;
        $data["css_files"] = $tabla->css_files;

        $this->load->view('crud', $data);
    }


    function encriptar($post_array)
    {
        $post_array["clave"]=md5($post_array["clave"]);
        return $post_array;

    }
}

