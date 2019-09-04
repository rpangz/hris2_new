<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class employee_model extends CMS_Model {

	protected $tbl_hakcuti       = 'tbl_hakcuti';
  protected $tbl_profile       = 'tbl_profile';

	public function __construct(){
		  parent::__construct();
		  //$this->load->database();
	}


	public function sisa_hak_cuti_user($nik_lama, $nik_baru){

		$today = date('Y-m-d');

		    $SQL    = "SELECT * FROM ".$this->tbl_hakcuti." WHERE NIK=".$nik_lama." AND StatusHak=1 AND ((Periode2 >= '".$today."' AND PeriodeExt IS NULL ) || (PeriodeExt IS NOT NULL && PeriodeExt >= '".$today."')) ORDER BY HakId ASC";
      	$query  = $this->db->query($SQL);

      	foreach ($query->result() as $data){
      		$jumlah_cuti = $this->hitung_jumlah_cuti($data->HakId, $nik_lama);
      		$sisa_cuti 	 = $data->Qty - $jumlah_cuti;

      		if($sisa_cuti > 0){
      			$this->cloning_row_database_same_table($this->tbl_hakcuti, $primary_key_field='HakId', $secondary_key_field='NIK', $data->HakId, $nik_baru, $sisa_cuti, $jumlah_cuti);
      		}
      	}

      	return TRUE;
	}


	public function hitung_jumlah_cuti($hak_cuti, $nik_lama){

		  $SQL    = "SELECT COUNT(a.DetailCutiId) AS total FROM tbl_formcutidetail AS a INNER JOIN tbl_formcuti AS b ON a.CutiId=b.CutiId WHERE b.HakCutiId=".$hak_cuti." AND b.FormCutiNIK=".$nik_lama." AND b.StatusForm='A'";
      $query  = $this->db->query($SQL);
      $data   = $query->row(0);

      return $data->total;
	}



	public function cloning_row_database_same_table($table, $primary_key_field, $secondary_key_field, $primary_key_val, $primary_key_new, $sisa_cuti, $jumlah_pakai){
       	/* generate the select query */
       	$this->db->where($primary_key_field, $primary_key_val);
        $query = $this->db->get($table);

        foreach ($query->result() as $row){   
            foreach($row as $key=>$val){        
                if($key != $primary_key_field){                    
                    if($key == $secondary_key_field){
                        $this->db->set($key, $primary_key_new);
                    }
                    elseif($key == 'Qty'){
                        $this->db->set($key, $sisa_cuti);
                    }
                    elseif($key == 'StatusMutasi'){
                        $this->db->set($key, 1);
                    }
                    elseif($key == 'QtyPakai'){
                        $this->db->set($key, $jumlah_pakai);
                    }
                    elseif($key == 'HakRemark'){
                        $this->db->set($key, 'Mutasi dari Hak Cuti ID '.$primary_key_val);
                    }
                    else{
                        $this->db->set($key, $val);
                    }                
                }             
            }
        }
        /* insert the new record into table*/
        $this->db->insert($table);
        return TRUE;
    }

    public function employee_profile($primary_key){

        $SQL    = "SELECT a.NIK,a.Nama,a.Email,a.Photos,a.Telp,b.NamaJabatan,c.cCompanyName,d.cDivName,e.cDeptName 
                   FROM tbl_profile AS a 
                   INNER JOIN tbl_jabatan AS b ON a.JabatanID=b.JabatanId 
                   INNER JOIN tbl_company AS c ON a.CompanyId=c.iCompanyId 
                   INNER JOIN tbl_div AS d ON a.DivisiID=d.iDivId 
                   INNER JOIN tbl_dept AS e ON a.DeptID=e.iDeptID WHERE a.NIK=".$primary_key;

        $query  = $this->db->query($SQL);
        $result = $query->row_array();

        return $result;
    }


    public function education_profile($primary_key){

        $SQL    = "SELECT a.EduStart,a.EduFinish,b.EducationLevelName,a.EduInstitution,a.EduFaculty FROM tbl_profile_education AS a INNER JOIN tbl_edulevel AS b ON a.EduLevelId=b.EducationLevelName WHERE a.EduNIK=".$primary_key." ORDER BY a.EduStart ASC";

        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function project_profile($primary_key){

        $SQL    = "SELECT * FROM tbl_profile_projecthistory WHERE ProjectNIK=".$primary_key." ORDER BY ProjectDate ASC";

        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function working_profile($primary_key){

        $SQL    = "SELECT * FROM tbl_profile_workexperience WHERE WorkExpNIK=".$primary_key." ORDER BY WorkExpNIK ASC";

        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function skill_profile($primary_key){

        $SQL    = "SELECT * FROM tbl_profile_technicalskill WHERE TechnicalSkillNIK=".$primary_key." ORDER BY TechnicalSkillId ASC";

        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function training_profile($primary_key){

        $SQL    = "SELECT * FROM tbl_profile_training WHERE TrainingNIK=".$primary_key." ORDER BY TrainingYear ASC";

        $query  = $this->db->query($SQL);

        return $query->result();
    }


    public function certification_profile($primary_key){

        $SQL    = "SELECT a.CertDate,b.CertItemName,a.CertProduct,a.CertName,a.CertPartnerName,a.CertValidStart,a.CertValidFinish FROM tbl_profile_certification AS a INNER JOIN tbl_certification_item AS b ON a.CertItem=b.CertItemId WHERE a.CertNIK=".$primary_key." ORDER BY a.CertDate ASC";

        $query  = $this->db->query($SQL);

        return $query->result();
    }
    


}