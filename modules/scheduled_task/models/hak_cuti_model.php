<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class hak_cuti_model extends CMS_Model{
    public $table_name = 'tbl_jeniscuti';
  

    public function __construct(){
        parent::__construct();    
    }
    

    public function get_hak_cuti($tanggal, $jenis_cuti){        
        $data = array();       
        $SQL = "SELECT HakId,tbl_hakcuti.NIK AS NIK,Periode1,Periode2,PeriodeExt,Qty FROM tbl_hakcuti INNER JOIN tbl_profile ON tbl_hakcuti.NIK=tbl_profile.NIK WHERE bStatus=1 AND JenisHakCuti='".$jenis_cuti."' AND StatusHak = 1 AND PeriodeExt IS NULL AND Periode2 ='".$tanggal."' AND Periode2 >= '2013-11-01' ORDER BY Periode2 ASC";
        $query = $this->db->query($SQL);
        foreach($query->result() as $row){                 
            $data[] = array(
                    "HakId" => $row->HakId,
                    "NIK" => $row->NIK,
                    "Periode1" => $row->Periode1,
                    "Periode2" => $row->Periode2,                    
                    "PeriodeExt" => $row->PeriodeExt,
                    "Qty" => $row->Qty,                   
            );
        }
        return $data;
    }


    public function hitung_sisa_cuti($hak_cuti, $jenis_cuti){

        $SQL   = "SELECT COUNT(FormCutiNIK) AS total_cuti FROM tbl_formcuti INNER JOIN 
                  tbl_formcutidetail ON tbl_formcutidetail.CutiID=tbl_formcuti.CutiId INNER JOIN 
                  tbl_profile ON tbl_profile.NIK=tbl_formcuti.FormCutiNIK 
                  WHERE HakCutiId='".$hak_cuti."' AND JenisCuti='".$jenis_cuti."' AND StatusForm='A'";     

        $query = $this->db->query($SQL);
        if($query->num_rows()>0){
            $row = $query->row();
            $result = array(                    
                    "total" => $row->total_cuti,
                    "status" => 1,                                      
            );        

            return $result;
        }else{
            $result = array(                  
                    "total" => 0,
                    "status" => 0,                                       
            );  
            return $result;
        }
    }


    public function user_profile($hak_cuti){

        $SQL   = "SELECT tbl_profile.NIK AS NIK,Nama,Email,HakId FROM tbl_hakcuti INNER JOIN tbl_profile ON tbl_profile.NIK=tbl_hakcuti.NIK WHERE tbl_hakcuti.HakId='".$hak_cuti."'";     

        $query = $this->db->query($SQL);
        if($query->num_rows()>0){
            $row = $query->row();
            $result = array(                    
                    "NIK" => $row->NIK,
                    "Nama" => $row->Nama,
                    "Email" => $row->Email,                                      
            );        

            return $result;
        }else{
            $result = array(                  
                    "NIK" => '',
                    "Nama" => '',
                    "Email" => '',                                       
            );  
            return $result;
        }
    }


}