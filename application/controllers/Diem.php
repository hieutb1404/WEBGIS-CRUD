<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Diem extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->load->model('model_diem');
        }
        public function index () {
            $data = array(
                'Tieu de' => 'WebGIS Trainning',
                'diem' => $this->model_diem->display_data(),
                'content' => 'diem/data'
            );
            $this->load->view('layout/viewunion', $data, false);
        }

        public function add(){
            $this->form_validation->set_rules('tendiem','tendiem','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('loai','loai','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('vitri','vitri','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('chuluong','chuluong','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('thoigian','thoigian','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            
            $this->form_validation->set_rules('kinhdo','kinhdo','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('vido','vido','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('diem','diem','required',array(
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
                        'content' => 'diem/add'
                    );
                    $this->load->view('layout/viewunion', $data,false);
                } else {
                    $upload_data = array('uploads' => $this->upload->data());
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/hinhanh/' . $upload_data['uploads']['file_name'];
                    $this->load->library('image_lib',$config);
                    $data = array(
                        'tendiem' => $this->input->post('tendiem'),
                        'loai' => $this->input->post('loai'),
                        'vitri' => $this->input->post('vitri'),
                        'chuluong' => $this->input->post('chuluong'),
                        'thoigian' => $this->input->post('thoigian'),
                        'hinhanh' => $upload_data['uploads']['file_name'],
                        'kinhdo' => $this->input->post('kinhdo'),
                        'vido' => $this->input->post('vido'),
                        'diem' => $this->input->post('diem'),

                    );
                    $this->model_diem->add($data);
                    $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                    redirect('diem');
                }

            }
            $data = array (
                'dữ liệu' => 'Add data',
                'content' => 'diem/add'
            );
            $this->load->view('layout/viewunion', $data, false);
        }


        // edit
        public function edit($id_diem=null){
            $this->form_validation->set_rules('tendiem','tendiem','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('loai','loai','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('vitri','vitri','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('chuluong','chuluong','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('thoigian','thoigian','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            
            $this->form_validation->set_rules('kinhdo','kinhdo','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('vido','vido','required',array(
                'required' => '%s yêu cầu nhập đầy đủ !!!'
            ));
            $this->form_validation->set_rules('diem','diem','required',array(
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
                        'diem' => $this->model_diem->detail($id_diem),
                        'content' => 'diem/edit'
                    );
                    $this->load->view('layout/viewunion', $data,false);
                } else {
                    $upload_data = array('uploads' => $this->upload->data());
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/hinhanh/' . $upload_data['uploads']['file_name'];
                    $this->load->library('image_lib',$config);
                    $data = array(
                        'id_diem' => $id_diem,
                        'tendiem' => $this->input->post('tendiem'),
                        'loai' => $this->input->post('loai'),
                        'vitri' => $this->input->post('vitri'),
                        'chuluong' => $this->input->post('chuluong'),
                        'thoigian' => $this->input->post('thoigian'),
                        'hinhanh' => $upload_data['uploads']['file_name'],
                        'kinhdo' => $this->input->post('kinhdo'),
                        'vido' => $this->input->post('vido'),
                        'diem' => $this->input->post('diem'),


                    );
                    $this->model_diem->edit($data);
                    $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                    redirect('diem');
                }
                $data = array (
                            'id_diem' => $id_diem,
                            'tendiem' => $this->input->post('tendiem'),
                            'loai' => $this->input->post('loai'),
                            'vitri' => $this->input->post('vitri'),
                            'chuluong' => $this->input->post('chuluong'),
                            'thoigian' => $this->input->post('thoigian'),
                            'kinhdo' => $this->input->post('kinhdo'),
                            'vido' => $this->input->post('vido'),
                            'diem' => $this->input->post('diem'),

                );
                $this->model_diem->edit($data);
                $this->session->set_flashdata('thành công rực rỡ','Dữ liệu tuyệt vời');
                redirect('diem');

            }
            $data = array(
                'dữ liệu' => 'edit data',
                'diem' => $this->model_diem->detail($id_diem),
                'content' => 'diem/edit'
            );
            
            $this->load->view('layout/viewunion', $data, false);
        }

        // delete
        public function delete($id_diem){
            $data = array('id_diem' => $id_diem);
            $this->model_diem->delete($data);
            $this->session->set_flashdata("Xóa","Xóa thành công rực rỡ");
            redirect('diem');
        }
    }


?>