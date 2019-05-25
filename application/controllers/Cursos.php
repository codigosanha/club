<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos extends CI_Controller {

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
            'cursos' => $this->Backend_model->get_records('cursos'),
        );

        $contenido_exterior = array(
            'title'     => 'Listado de cursos',
            'contenido' => $this->load->view('cursos/list', $contenido_interno, true),
        );

        $this->load->view('template', $contenido_exterior);
	}

	public function add(){
        $contenido_interno = array(
            'docentes' => $this->Backend_model->get_records('docentes')
            
        );
        $contenido_exterior = array(
            'title'     => 'Agregar Curso',
            'contenido' => $this->load->view('cursos/add', $contenido_interno, true),
        );

        $this->load->view('template', $contenido_exterior);
	}

	public function store(){
        $nombre        = $this->input->post("nombre");
        $docente_id        = $this->input->post("docente_id");

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|is_unique[cursos.nombre]', array('required' => 'Debes proporcionar un %s.', 'is_unique' => 'El %s ya existe'));
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == false) {
            $this->add();
        } else {
            $dataCurso = array(
                'nombre'        	=> $nombre,
                'docente_id'            => $docente_id,
            );

            if ($this->Backend_model->insert('cursos',$dataCurso)) {
            	$this->session->set_flashdata("success","El Curso fue registrado exitosamente");
                redirect(base_url() . "cursos");
            } else {
                //$this->session->set_flashdata("error","No se pudo registrar al usuario");
                redirect(base_url() . "cursos/add");
            }
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
        $idCurso      = $this->input->post("idCurso");
    	$nombre      = $this->input->post("nombre");
        $docente_id      = $this->input->post("docente_id");

        $CursoActual = $this->Backend_model->get_record('cursos',"id=$idCurso");
        $is_unique_nombre = '';
        if ($CursoActual->nombre != $nombre) {
            $is_unique_nombre = '|is_unique[cursos.nombre]';
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required'.$is_unique_nombre, array('required' => 'Debes proporcionar un %s.', 'is_unique' => 'El %s ya existe'));
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == false) {
            $this->edit($idCurso);
        } else {
          
            $dataCurso = array(
                'nombre'            => $nombre,
                'docente_id'            => $docente_id,
            );

            if ($this->Backend_model->update('cursos',"id=$idCurso",$dataCurso)) {
            	$this->session->set_flashdata("success","La informacion de la Curso fue actualizada correctamente");
                redirect(base_url() . "cursos");
            } else {
                //$this->session->set_flashdata("error","No se pudo registrar al usuario");
                redirect(base_url() . "cursos/edit/".$idCurso);
            }
        }
    }

}
