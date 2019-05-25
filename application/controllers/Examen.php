<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examen extends CI_Controller {

	public function __construct(){
		parent::__construct();
        if (!$this->session->userdata('login')) {
            redirect(base_url());
        }

        $this->load->helper("functions");
	}


	public function index()
	{
		$contenido_interno = array(
            'cadetes' => $this->Backend_model->get_records('cadetes'),
        );

        $contenido_exterior = array(
            'title'     => 'Examen Medico',
            'contenido' => $this->load->view('examen/list', $contenido_interno, true),
        );

        $this->load->view('template', $contenido_exterior);
	}

	public function registrar_cadete(){
        
        $contenido_exterior = array(
            'title'     => 'Agregar Curso',
            'contenido' => $this->load->view('examen/registrar_cadete', "", true),
        );

        $this->load->view('template', $contenido_exterior);
	}

	public function store(){
        $rut        = $this->input->post("rut");
        $nombre        = $this->input->post("nombre");
        $fecha_nacimiento        = $this->input->post("fecha_nacimiento");
        $altura        = $this->input->post("altura");
        $peso        = $this->input->post("peso");
        $resultado_test        = $this->input->post("resultado_test");


 
            $dataCadete = array(
                'nombre'        	=> $nombre,
                'rut'            => $rut,
                'fecha_nacimiento'            => $fecha_nacimiento,
                'altura'            => $altura,
                'peso'            => $peso,
                'resultado_test'            => $resultado_test,
                'estado_final'            => 0,

            );

            if ($this->Backend_model->insert('cadetes',$dataCadete)) {
            	$this->session->set_flashdata("success","El Cadate fue registrado exitosamente");
                redirect(base_url() . "examen");
            } else {
                //$this->session->set_flashdata("error","No se pudo registrar al usuario");
                redirect(base_url() . "examen/registrar_cadete");
            }
        
	}

	public function edit($id)
    {
        $contenido_interno = array(
            'curso'      => $this->Backend_model->get_record('cursos',"id=$id"),
            'docentes' => $this->Backend_model->get_records('docentes')
            
        );

        $contenido_exterior = array(
            'title'     => 'Editar Curso',
            'contenido' => $this->load->view('cursos/edit', $contenido_interno, true),
        );

        $this->load->view('template', $contenido_exterior);
    }

    public function update(){
        $cadetes      = $this->input->post("cadetes");
    	$estados      = $this->input->post("estados");

        if (!empty($cadetes)) {
            for ($i=0; $i <count($cadetes) ; $i++) { 
                $dataCadete = array('estado_final' => $estados[$i] );
                $this->Backend_model->update('cadetes',"id=".$cadetes[$i],$dataCadete);
            }

            redirect(base_url()."examen");
        }
    }

}
