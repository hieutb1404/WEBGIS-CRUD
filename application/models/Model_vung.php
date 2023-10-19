<?php 
  defined('BASEPATH') OR exit ('No direct script access allowed');

  class Model_vung extends CI_Model{
    public function display_data() {
        $this->db->select('*');
        $this->db->from('tbl_vung');
        $this->db->order_by('id_vung','desc');
        return $this->db->get()->result(); 

    }

    public function add($data){
        $this->db->insert('tbl_vung',$data);
    }

    public function detail($id_vung){
        $this->db->select('*');
        $this->db->from('tbl_vung');
        $this->db->where('id_vung',$id_vung);
        return $this->db->get()->row(); 
      }
  
      public function edit($data) {
        $this->db->where('id_vung', $data['id_vung']);
        $this->db->update('tbl_vung', $data);
    }
  
      public function delete($data){
        $this->db->where('id_vung', $data['id_vung']);
        $this->db->delete('tbl_vung', $data);
      }
    
}
?>