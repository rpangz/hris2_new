<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class karyawan_model extends CI_Model {

	protected $tbl_profile                  = 'tbl_profile';
    protected $tbl_profile_certification    = 'tbl_profile_certification';
    protected $tbl_profile_projecthistory   = 'tbl_profile_projecthistory';
    protected $tbl_profile_technicalskill   = 'tbl_profile_technicalskill';
    protected $tbl_profile_education        = 'tbl_profile_education';
    protected $tbl_profile_workexperience   = 'tbl_profile_workexperience';
    protected $tbl_profile_training         = 'tbl_profile_training';
    protected $tbl_profile_attachment       = 'tbl_profile_attachment';
    protected $tbl_profile_files            = 'tbl_profile_files';
    protected $tbl_profile_member           = 'tbl_profile_member';
    protected $tbl_profile_pergerakan_mutasi= 'tbl_profile_pergerakan_mutasi';
    protected $tbl_hakcuti                  = 'tbl_hakcuti';


  	public function __construct(){
  		parent::__construct();
  		$this->load->database();
  	}

    public function employee_profile($primary_key){

        $SQL    = "SELECT a.NIK,a.Nama,a.Email,a.Photos,a.Telp,b.NamaJabatan,c.cCompanyName,d.cDivName,e.cDeptName 
                   FROM ".$this->tbl_profile." AS a 
                   LEFT JOIN tbl_jabatan AS b ON a.JabatanID=b.JabatanId 
                   INNER JOIN tbl_company AS c ON a.CompanyId=c.iCompanyId 
                   INNER JOIN tbl_div AS d ON a.DivisiID=d.iDivId 
                   INNER JOIN tbl_dept AS e ON a.DeptID=e.iDeptID WHERE a.NIK=".$primary_key;

        $query  = $this->db->query($SQL);
        $result = $query->row_array();

        return $result;
    }


    public function education_profile($primary_key){

        //$SQL    = "SELECT a.EduStart,a.EduFinish,b.EducationLevelName,a.EduInstitution,a.EduFaculty,a.EduFileUrl FROM ".$this->tbl_profile_education." AS a INNER JOIN tbl_edulevel AS b ON a.EduLevelId=b.EducationLevelName WHERE a.EduNIK=".$primary_key." ORDER BY a.EduStart DESC";

        $SQL    = "SELECT a.*,CASE WHEN (a.checking!=b.checking) OR (b.checking IS NULL) THEN 'TIDAK SAMA' ELSE '' END checking FROM (
                    SELECT *,CAST(CONCAT(EduStart, EduFinish, EduLevelId, EduInstitution, EduCity, EduFaculty, EduMajor, EduGPA) AS CHAR) checking
                    FROM tbl_profile_education a WHERE EduNik = ".$primary_key." ) a
                    LEFT JOIN
                    (SELECT Eduid,CAST(CONCAT(EduStart, EduFinish, EduLevelId, EduInstitution, EduCity, EduFaculty, EduMajor, EduGPA) AS CHAR) checking
                    FROM tbl_profile_education_data_old WHERE EduNik = ".$primary_key.") b
                    ON a.Eduid=b.Eduid";
        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function project_profile($primary_key){

        //$SQL    = "SELECT * FROM ".$this->tbl_profile_projecthistory." WHERE ProjectNIK=".$primary_key." ORDER BY ProjectDate DESC";
        $SQL    = "SELECT a.*,CASE WHEN (a.checking!=b.checking) OR (b.checking IS NULL) THEN 'TIDAK SAMA' ELSE '' END checking FROM (
                    SELECT *,CAST(CONCAT(ProjectDate, ProjectName, ProjectInstitution, ProjectYear, ProjectLength, ProjectTechnicalSpec, ProjectPosition) AS CHAR) checking
                    FROM tbl_profile_projecthistory a WHERE ProjectNik = ".$primary_key." ) a
                    LEFT JOIN
                    (SELECT Projectid,CAST(CONCAT(ProjectDate, ProjectName, ProjectInstitution, ProjectYear, ProjectLength, ProjectTechnicalSpec, ProjectPosition) AS CHAR) checking
                    FROM tbl_profile_projecthistory_data_old WHERE ProjectNik = ".$primary_key.") b
                    ON a.Projectid=b.Projectid";
        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function working_profile($primary_key){

        //$SQL    = "SELECT * FROM ".$this->tbl_profile_workexperience." WHERE WorkExpNIK=".$primary_key." ORDER BY WorkExpNIK ASC";
        $SQL    = "SELECT a.*,CASE WHEN (a.checking!=b.checking) OR (b.checking IS NULL) THEN 'TIDAK SAMA' ELSE '' END checking FROM (
                    SELECT *,CAST(CONCAT(WorkExpStart, WorkExpFinish, WorkExpCompany, WorkExpPosition, WorkExpDesc) AS CHAR) checking
                    FROM tbl_profile_workexperience a WHERE workexpnik = ".$primary_key." ) a
                    LEFT JOIN
                    (SELECT workexpid,CAST(CONCAT(WorkExpStart, WorkExpFinish, WorkExpCompany, WorkExpPosition, WorkExpDesc) AS CHAR) checking
                    FROM tbl_profile_workexperience_data_old WHERE workexpnik = ".$primary_key.") b
                    ON a.workexpid=b.workexpid";
        $query  = $this->db->query($SQL);

        return $query->result();
    }

    public function skill_profile($primary_key){

        //$SQL    = "SELECT * FROM ".$this->tbl_profile_technicalskill." WHERE TechnicalSkillNIK=".$primary_key." ORDER BY TechnicalSkillId ASC";
        $SQL    = "SELECT a.*,CASE WHEN (a.checking!=b.checking) OR (b.checking IS NULL) THEN 'TIDAK SAMA' ELSE '' END checking,b.checking FROM (
                    SELECT *,CAST(CONCAT(TechnicalSkillName, TechnicalSkillExp, TechnicalSkillDesc) AS CHAR) checking
                    FROM tbl_profile_technicalskill a WHERE Technicalskillnik = ".$primary_key." ) a
                    LEFT JOIN
                    (SELECT TechnicalskillID,CAST(CONCAT(TechnicalSkillName, TechnicalSkillExp, TechnicalSkillDesc) AS CHAR) checking
                    FROM tbl_profile_technicalskill_data_old WHERE Technicalskillnik = ".$primary_key.") b
                    ON a.TechnicalskillID=b.TechnicalskillID";
        $query  = $this->db->query($SQL);
        return $query->result();
    }

    public function training_profile($primary_key){

        //$SQL    = "SELECT * FROM ".$this->tbl_profile_training." WHERE TrainingNIK=".$primary_key." ORDER BY TrainingYear DESC";
        $SQL    = "SELECT a.*,CASE WHEN (a.checking!=b.checking) OR (b.checking IS NULL) THEN 'TIDAK SAMA' ELSE '' END checking FROM (
                    SELECT *,CAST(CONCAT(TrainingYear, TrainingInstitution, TrainingCity, TrainingModul, TrainingType) AS CHAR) checking
                    FROM tbl_profile_training a WHERE TrainingNik = ".$primary_key." ) a
                    LEFT JOIN
                    (SELECT TrainingID,CAST(CONCAT(TrainingYear, TrainingInstitution, TrainingCity, TrainingModul, TrainingType) AS CHAR) checking
                    FROM tbl_profile_training_data_old WHERE TrainingNik = ".$primary_key.") b
                    ON a.TrainingID=b.TrainingID";
        
        $query  = $this->db->query($SQL);
        return $query->result();
    }


    public function certification_profile($primary_key){

        //$SQL    = "SELECT a.CertDate,b.CertItemName,a.CertProduct,a.CertName,a.CertPartnerName,a.CertValidStart,a.CertValidFinish,a.CertFileUrl FROM ".$this->tbl_profile_certification." AS a INNER JOIN tbl_certification_item AS b ON a.CertItem=b.CertItemId WHERE a.CertNIK=".$primary_key." ORDER BY a.CertDate DESC";

        $SQL    = "SELECT a.*,CASE WHEN (a.checking!=b.checking) OR (b.checking IS NULL) THEN 'TIDAK SAMA' ELSE '' END checking FROM (
                    SELECT *,CAST(CONCAT(CertDate, CertItem, CertProduct, CertName, CertPartnerName, CertValidStart, CertValidFinish) AS CHAR) checking
                    FROM tbl_profile_certification a WHERE CertNIK = ".$primary_key." ) a
                    LEFT JOIN
                    (SELECT Certid,CAST(CONCAT(CertDate, CertItem, CertProduct, CertName, CertPartnerName, CertValidStart, CertValidFinish) AS CHAR) checking
                    FROM tbl_profile_certification_data_old WHERE CertNIK = ".$primary_key.") b
                    ON a.Certid=b.Certid";
        $query  = $this->db->query($SQL);

        return $query->result();
    }
    


}