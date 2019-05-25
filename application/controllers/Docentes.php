<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docentes extends CI_Controller {

	public function __construct(){
		parent::__construct();
        if (!$this->session->userdata('login')) {
            redirect(base_url());
        }
	}


	public function index()
	{
		$contenido_interno = array(
            'docentes' => $this->Backend_model->get_records('docentes'),
        );

        $contenido_exterior = array(
            'title'     => 'Listado de docentes',
            'contenido' => $this->load->view('docentes/list', $contenido_interno, true),
        );

        $this->load->view('template', $contenido_exterior);
	}

	public function add(){
        $contenido_exterior = array(
            'title'     => 'Agregar Docente',
            'contenido' => $this->load->view('docentes/add', '', true),
        );

        $this->load->view('template', $contenido_exterior);
	}

	public function store(){
        $nombres        = $this->input->post("nombres");
        $apellidos        = $this->input->post("apellidos");
        $dni        = $this->input->post("dni");

        $this->form_validation->set_rules('dni', 'DNI', 'trim|required|is_unique[docentes.dni]', array('required' => 'Debes proporcionar un %s.', 'is_unique' => 'El %s ya existe'));
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == false) {
            $this->add();
        } else {
            $dataDocente = array(
                'nombres'        	=> $nombres,
                'apellidos'            => $apellidos,
                'dni'            => $dni,
            );

            if ($this->Backend_model->insert('docentes',$dataDocente)) {
            	$this->session->set_flashdata("success","El Docente fue registrado exitosamente");
                redirect(base_url() . "docentes");
            } else {
                //$this->session->set_flashdata("error","No se pudo registrar al usuario");
                redirect(base_url() . "docentes/add");
            }
        }
	}

	public function edit($id)
    {
        $contenido_interno = array(
            'docente'      => $this->Backend_model->get_record('docentes',"id=$id"),
            
        );

        $contenido_exterior = array(
            'title'     => 'Editar Docente',
            'contenido' => $this->load->view('docentes/edit', $contenido_interno, true),
        );

        $this->load->view('template', $contenido_exterior);
    }

    public function update(){
        $idDocente      = $this->input->post("idDocente");
    	$nombres      = $this->input->post("nombres");
        $apellidos      = $this->input->post("apellidos");
        $dni      = $this->input->post("dni");
        $docenteActual = $this->Backend_model->get_record('docentes',"id=$idDocente");
        $is_unique_dni = '';
        if ($docenteActual->dni != $dni) {
            $is_unique_dni = '|is_unique[docentes.dni]';
        }

        $this->form_validation->set_rules('dni', 'DNI', 'trim|required'.$is_unique_dni, array('required' => 'Debes proporcionar un %s.', 'is_unique' => 'El %s ya existe'));
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == false) {
            $this->edit($idDocente);
        } else {
          
            $datadocente = array(
                'nombres'            => $nombres,
                'apellidos'            => $apellidos,
                'dni'            => $dni,
            );

            if ($this->Backend_model->update('docentes',"id=$idDocente",$datadocente)) {
            	$this->session->set_flashdata("success","La informacion de la docente fue actualizada correctamente");
                redirect(base_url() . "docentes");
            } else {
                //$this->session->set_flashdata("error","No se pudo registrar al usuario");
                redirect(base_url() . "docentes/edit/".$iddocente);
            }
        }
    }

}
