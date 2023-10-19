<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Vung extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->load->model('model_vung');
        }
        public function index () {
            $data = array(
                'Tieu de' => 'WebGIS Trainning',
                'vung' => $this->model_vung->display_data(),
                'content' => 'vung/data'
            );
            $this->load->view('layout/viewunion', $data, false);
        }

        public function add(){
            $this->form_validation->set_rules('tenvung','tenvung','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('tentinh','tentinh','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('donvihanhchinh','donvihanhchinh','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('geojson','geojson','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('dientich','dientich','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('color','color','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            if($this->form_validation->run() == true) {
                $config['upload_path'] = './assets/hinhanh/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 4000;
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('hinhanh')){
                    $data = array(
                        'dữ liệu' => 'Add data',
                        'error_upload' => $this->upload->display_errors(),
                        'content' => 'vung/add'
                    );
                    $this->load->view('layout/viewunion', $data,false);
                } else {
                    $upload_data = array('uploads' => $this->upload->data());
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/hinhanh/' . $upload_data['uploads']['file_name'];
                    $this->load->library('image_lib',$config);
                    $data = array(
                        'tenvung' => $this->input->post('tenvung'),
                        'tentinh' => $this->input->post('tentinh'),
                        'color' => $this->input->post('color'),
                        'geojson' => $this->input->post('geojson'),
                        'donvihanhchinh' => $this->input->post('donvihanhchinh'),
                        'dientich' => $this->input->post('dientich'),
                        'hinhanh' => $upload_data['uploads']['file_name'],
                    );
                    $this->model_vung->add($data);
                    $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                    redirect('vung');
                }

            }
            $data = array (
                'dữ liệu' => 'Add data',
                'content' => 'vung/add'
            );
            $this->load->view('layout/viewunion', $data, false);
        }


        // edit
        public function edit($id_vung=null){
            $this->form_validation->set_rules('tenvung','tenvung','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('tentinh','tentinh','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('donvihanhchinh','donvihanhchinh','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('geojson','geojson','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('dientich','dientich','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('color','color','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));   
                if($this->form_validation->run() == true) {
                $config['upload_path'] = './assets/hinhanh/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 4000;
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('hinhanh')){
                    $data = array(
                        'dữ liệu' => 'edit data',
                        'error_upload' => $this->upload->display_errors(),
                        'vung' => $this->model_vung->detail($id_vung),
                        'content' => 'vung/edit'
                    );
                    $this->load->view('layout/viewunion', $data,false);
                } else {
                    $upload_data = array('uploads' => $this->upload->data());
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/hinhanh/' . $upload_data['uploads']['file_name'];
                    $this->load->library('image_lib',$config);
                    $data = array(
                        'id_vung' => $id_vung,
                        'tenvung' => $this->input->post('tenvung'),
                        'tentinh' => $this->input->post('tentinh'),
                        'color' => $this->input->post('color'),
                        'geojson' => $this->input->post('geojson'),
                        'donvihanhchinh' => $this->input->post('donvihanhchinh'),
                        'dientich' => $this->input->post('dientich'),
                        'hinhanh' => $upload_data['uploads']['file_name'],


                    );
                    $this->model_vung->edit($data);
                    $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                    redirect('vung');
                }
                $data = array (
                        'id_vung' => $id_vung,
                        'tenvung' => $this->input->post('tenvung'),
                        'tentinh' => $this->input->post('tentinh'),
                        'color' => $this->input->post('color'),
                        'geojson' => $this->input->post('geojson'),
                        'donvihanhchinh' => $this->input->post('donvihanhchinh'),
                        'dientich' => $this->input->post('dientich'),
                );
                $this->model_vung->edit($data);
                $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                redirect('vung');

            }
            $data = array(
                'dữ liệu' => 'edit data',
                'vung' => $this->model_vung->detail($id_vung),
                'content' => 'vung/edit'
            );
            
            $this->load->view('layout/viewunion', $data, false);
        }

        // delete
        public function delete($id_vung){
            $data = array('id_vung' => $id_vung);
            $this->model_vung->delete($data);
            $this->session->set_flashdata("Xóa","Xóa thành công rực rỡ");
            redirect('vung');
        }
    }
?>