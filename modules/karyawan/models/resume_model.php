<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class resume_model extends CI_Model {

	var $table = 'tbl_profile';
	var $column_order = array('NIK','Nama','Email',null); //set column field database for datatable orderable
	var $column_search = array('NIK','Nama','Email'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('NIK' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($user_id, $table)
	{
		
		$this->db->from($table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		
	}

	function get_datatables_1($user_id, $table_name)
	{
		$SQL    = "SELECT * FROM ".$table_name." WHERE NIK='".$user_id."' ORDER BY NIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function get_datatables_2($user_id, $table_name)
	{
		$SQL    = "SELECT *, DATE_FORMAT(WorkExpStart,'%d-%b-%Y') AS Startdate,
				   DATE_FORMAT(WorkExpFinish,'%d-%b-%Y') AS Finishdate 
				   FROM ".$table_name." WHERE WorkExpNIK='".$user_id."' ORDER BY WorkExpNIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function get_datatables_3($user_id, $table_name)
	{
		$SQL    = "SELECT * FROM ".$table_name." WHERE EduNIK='".$user_id."' ORDER BY EduNIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function get_datatables_4($user_id, $table_name)
	{
		$SQL    = "SELECT * FROM ".$table_name." WHERE TrainingNIK='".$user_id."' ORDER BY TrainingNIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function get_datatables_5($user_id, $table_name)
	{
		$SQL    = "SELECT * FROM ".$table_name." WHERE TechnicalSkillNIK='".$user_id."' ORDER BY TechnicalSkillNIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function get_datatables_6($user_id, $table_name)
	{
		$SQL    = "SELECT *, DATE_FORMAT(CertDate,'%d-%b-%Y') AS Tanggal, DATE_FORMAT(CertValidStart,'%d-%b-%Y') AS Startdate,DATE_FORMAT(CertValidFinish,'%d-%b-%Y') AS Finishdate 
		FROM ".$table_name." WHERE CertNIK='".$user_id."' ORDER BY CertNIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function get_datatables_7($user_id, $table_name)
	{
		$SQL    = "SELECT *, DATE_FORMAT(ProjectDate,'%d-%b-%Y') AS Tanggal FROM ".$table_name." WHERE ProjectNIK='".$user_id."' ORDER BY ProjectNIK";
      	$query  = $this->db->query($SQL);
		return $query->result();
	}

	function count_filtered($user_id, $table_name)
	{
		$this->_get_datatables_query($user_id, $table_name);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($user_id, $table_name)
	{
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from('tbl_kpi_activity_plan');
		$this->db->where('activity_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_edit_plan($id)
	{
		$this->db->from('tbl_kpi_activity_plan');
		$this->db->where('activity_id', $id);
		$query = $this->db->get();

		return $query->row();
	}


	public function get_monitoring_plan($id)
	{
		$this->db->from('tbl_kpi_activity_plan');
		$this->db->where('activity_id', $id);
		$query = $this->db->get();
		return $query->row();
	}	

	public function save($data)
	{
		$this->db->insert('tbl_kpi_activity_plan', $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update('tbl_kpi_activity_plan', $data, $where);
		return $this->db->affected_rows();
	}

	public function update_monitoring($where, $data)
	{
		$this->db->update('tbl_kpi_activity_plan', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('activity_id', $id);
		$this->db->delete('tbl_kpi_activity_plan');
	}

	public function deal_by_id($id)
	{
		$this->db->update('tbl_kpi_header_form', array('iAgree'=> 1), array('KPIID'=> $id));

	}

	public function undeal_by_id($id)
	{
		$this->db->update('tbl_kpi_header_form', array('iAgree'=> 0), array('KPIID'=> $id));

	}


	public function get_detail_pa($id)
	{
		$this->db->from('tbl_kpi_header_form');
		$this->db->where('KPIID', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function detail_tab1($primary_key){

		$SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=1 OR ItemID=2 OR ItemID=3) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);

      	return $query->result();

	}

	public function detail_tab2($primary_key){

		$SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=4 OR ItemID=5) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);

      	return $query->result();

	}

	public function count_bobot_user($primary_key, $type, $activity_id){

		if (isset($activity_id)){
			if ($type > 3){
			$this->db->select('sum(Bobot_A) AS total')
                 ->from('tbl_kpi_activity_plan')
                 ->where('KPIID', $primary_key)
                 ->where('ItemID', $type)
                 ->where('activity_id !=', $activity_id);

			}
			else{
				$this->db->select('sum(Bobot_A) AS total')
	                 ->from('tbl_kpi_activity_plan')
	                 ->where('KPIID', $primary_key)
	                 ->where('activity_id !=', $activity_id)
	                 ->where('FIND_IN_SET (ItemID,"1,2,3")');
			}

		}
		else{
			if ($type > 3){
			$this->db->select('sum(Bobot_A) AS total')
                 ->from('tbl_kpi_activity_plan')
                 ->where('KPIID', $primary_key)
                 ->where('ItemID', $type);

			}
			else{
				$this->db->select('sum(Bobot_A) AS total')
	                 ->from('tbl_kpi_activity_plan')
	                 ->where('KPIID', $primary_key)
	                 ->where('FIND_IN_SET (ItemID,"1,2,3")');
			}
		}
		
        
        $db      = $this->db->get();
        $data    = $db->row(0);
        $num_row = $db->num_rows();
        return $data->total;
    }

    public function get_edit_resume_7($primary_key)
	{
		$this->db->from('tbl_profile_projecthistory_testing');
		$this->db->where('ProjectId', $primary_key);
		$query = $this->db->get();
		$data  = $query->row(0);

		return $data;
	}


    public function total_score($primary_key, $user_id){

    	$SQL    ="SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=1 OR ItemID=2 OR ItemID=3) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);
      	$data   = $query->row(0);

    }

    public function set_nilai_akhir_pa($value=NULL){

        if ($value >= 4.50 && $value <= 5.00){
            return 'IST (ISTIMEWA)';
        }
        elseif($value >=3.75 && $value <= 4.49){
            return 'BS (BAIK SEKALI)';
        }
        elseif($value >= 3.25 && $value <= 3.74){
            return 'B+ (BAIK PLUS)';
        }
        elseif($value >= 3.00 && $value <= 3.24){
            return 'B (BAIK)';
        }
        elseif($value >= 2.75 && $value <= 2.99){
            return 'B- (BAIK MINUS)';
        }
        elseif($value >= 2.00 && $value <= 2.74){
            return 'C (CUKUP)';
        }
        elseif($value >= 1.00 && $value <= 1.99){
            return 'K (KURANG)';
        }        
        else{
            return 'Tidak Terdeteksi';
        }

    }


}
