<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_diem');
        $this->load->model('model_duong');
        $this->load->model('model_vung');


    }
    


    public function index() {
        $data = array(
            'judul' => 'WebGIS Training',
            'diem' => $this->model_diem->display_data(),
            'duong' => $this->model_duong->display_data(),
            'vung' => $this->model_vung->display_data(),
            'content'=>'peta_leaflet',

        );
        $this->load->view('layout/viewunion', $data,false);
    }
}