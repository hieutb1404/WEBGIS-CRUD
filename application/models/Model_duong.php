<?php 
  defined('BASEPATH') OR exit ('No direct script access allowed');

  class Model_duong extends CI_Model{
    public function display_data() {
        $this->db->select('*');
        $this->db->from('tbl_duong');
        $this->db->order_by('id_duong','desc');
        return $this->db->get()->result(); 

    }

    public function add($data){
        $this->db->insert('tbl_duong',$data);
    }

    public function detail($id_duong){
        $this->db->select('*');
        $this->db->from('tbl_duong');
        $this->db->where('id_duong',$id_duong);
        return $this->db->get()->row(); 
      }
  
      public function edit($data) {
        $this->db->where('id_duong', $data['id_duong']);
        $this->db->update('tbl_duong', $data);
    }
  
      public function delete($data){
        $this->db->where('id_duong', $data['id_duong']);
        $this->db->delete('tbl_duong', $data);
      }
    
}
?>