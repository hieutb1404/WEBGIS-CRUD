<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Duong extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->load->model('model_duong');
        }
        public function index () {
            $data = array(
                'Tieu de' => 'WebGIS Trainning',
                'duong' => $this->model_duong->display_data(),
                'content' => 'duong/data'
            );
            $this->load->view('layout/viewunion', $data, false);
        }

        public function add(){
            $this->form_validation->set_rules('tenduong','tenduong','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('kieuduong','kieuduong','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('color','color','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('geojson','geojson','required',array(
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
                        'content' => 'duong/add'
                    );
                    $this->load->view('layout/viewunion', $data,false);
                } else {
                    $upload_data = array('uploads' => $this->upload->data());
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/hinhanh/' . $upload_data['uploads']['file_name'];
                    $this->load->library('image_lib',$config);
                    $data = array(
                        'tenduong' => $this->input->post('tenduong'),
                        'kieuduong' => $this->input->post('kieuduong'),
                        'color' => $this->input->post('color'),
                        'geojson' => $this->input->post('geojson'),
                        'hinhanh' => $upload_data['uploads']['file_name'],
                    );
                    $this->model_duong->add($data);
                    $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                    redirect('duong');
                }

            }
            $data = array (
                'dữ liệu' => 'Add data',
                'content' => 'duong/add'
            );
            $this->load->view('layout/viewunion', $data, false);
        }


        // edit
        public function edit($id_duong=null){
            $this->form_validation->set_rules('tenduong','tenduong','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('kieuduong','kieuduong','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('color','color','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('geojson','geojson','required',array(
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
                        'duong' => $this->model_duong->detail($id_duong),
                        'content' => 'duong/edit'
                    );
                    $this->load->view('layout/viewunion', $data,false);
                } else {
                    $upload_data = array('uploads' => $this->upload->data());
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/hinhanh/' . $upload_data['uploads']['file_name'];
                    $this->load->library('image_lib',$config);
                    $data = array(
                        'id_duong' => $id_duong,
                        'tenduong' => $this->input->post('tenduong'),
                        'kieuduong' => $this->input->post('kieuduong'),
                        'color' => $this->input->post('color'),
                        'geojson' => $this->input->post('geojson'),
                        'hinhanh' => $upload_data['uploads']['file_name'],


                    );
                    $this->model_duong->edit($data);
                    $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                    redirect('duong');
                }
                $data = array (
                    'id_duong' => $id_duong,
                    'tenduong' => $this->input->post('tenduong'),
                    'kieuduong' => $this->input->post('kieuduong'),
                    'color' => $this->input->post('color'),
                    'geojson' => $this->input->post('geojson'),

                );
                $this->model_duong->edit($data);
                $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                redirect('duong');

            }
            $data = array(
                'dữ liệu' => 'edit data',
                'duong' => $this->model_duong->detail($id_duong),
                'content' => 'duong/edit'
            );
            
            $this->load->view('layout/viewunion', $data, false);
        }

        // delete
        public function delete($id_duong){
            $data = array('id_duong' => $id_duong);
            $this->model_duong->delete($data);
            $this->session->set_flashdata("Xóa","Xóa thành công rực rỡ");
            redirect('duong');
        }
    }
?>