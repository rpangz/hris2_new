<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_Alert_Model extends CMS_Model{
    public function get_full_name($user_nik){
        $this->db->select('NIK,Nama')
                     ->from('tbl_profile')
                     ->where('NIK', $user_nik);
        $db = $this->db->get();
        $row = $db->row(0);

        return $row->Nama;
    }
}