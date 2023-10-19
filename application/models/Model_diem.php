<?php 
  defined('BASEPATH') OR exit ('No direct script access allowed');

  class Model_diem extends CI_Model{
    public function display_data() {
        $this->db->select('*');
        $this->db->from('tbl_diem');
        $this->db->order_by('id_diem','desc');
        return $this->db->get()->result(); 

    }

    public function add($data){
        $this->db->insert('tbl_diem',$data);
    }

    public function detail($id_diem){
      $this->db->select('*');
      $this->db->from('tbl_diem');
      $this->db->where('id_diem',$id_diem);
      return $this->db->get()->row(); 
    }

    public function edit($data) {
      $this->db->where('id_diem', $data['id_diem']);
      $this->db->update('tbl_diem', $data);
  }

    public function delete($data){
      $this->db->where('id_diem', $data['id_diem']);
      $this->db->delete('tbl_diem', $data);
    }
  
  }
?>