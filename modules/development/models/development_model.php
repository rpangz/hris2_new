<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class development_model extends CI_Model {

	var $table = 'tp_diagram_frame';
	var $column_order = array('COID','EmployeeID','Description',null); //set column field database for datatable orderable
	var $column_search = array('COID','EmployeeID','Description'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('COID' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	


	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
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

	public function get_detail_header($id)
	{
		$this->db->from('tbl_kpi_header_form');
		$this->db->where('KPIID', $id);
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

	public function get_narration_managing_people($id)
	{
		$this->db->select('narration_value');
		$this->db->from('tbl_kpi_managing_people');
		$this->db->where('iManPeople', $id);
		$query = $this->db->get();
		$num_row = $query->num_rows();
		$data = $query->row();

		if($num_row == 0){
			return 0;
		}
		else{

			if(is_null($data->narration_value) && empty($data->narration_value)){
				return 0;
			}
			else{
				return $data->narration_value;
			}			
		}
		
	}

	public function get_narration_core_value($id)
	{
		$this->db->select('narration_value');
		$this->db->from('tbl_kpi_core_values');
		$this->db->where('iCoreValues', $id);
		$query = $this->db->get();
		$num_row = $query->num_rows();
		$data = $query->row();

		if($num_row == 0){
			return 0;
		}
		else{
			if(is_null($data->narration_value) && empty($data->narration_value)){
				return 0;
			}
			else{
				return $data->narration_value;
			}
		}
	}

	public function get_narration_key_performance_indicator($id)
	{
		$this->db->select('description');
		$this->db->from('tbl_kpi_narration_value');
		$this->db->where('status', 1);
		$this->db->where('narration_item', $id);
		$query = $this->db->get();
		$num_row = $query->num_rows();
		$data = $query->row();

		if($num_row == 0){
			return 0;
		}
		else{
			if(is_null($data->description) && empty($data->description)){
				return 0;
			}
			else{
				return $data->description;
			}
		}
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
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=4) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);

      	return $query->result();

	}

	public function detail_tab3($primary_key){

		$SQL    = "SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=5) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);

      	return $query->result();

	}

	public function count_managing_people($primary_key){

		$SQL    = "SELECT count(activity_id) as Total FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=5) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);  
      	$data   = $query->row(0);

      	return $data->Total;
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

    public function total_score($primary_key, $user_id){

    	$SQL    ="SELECT activity_id,tbl_kpi_activity_plan.KPIID AS KPIID,ItemID,Description,UoM,DD,EveryMonth,Bobot_A,Plan_B,SM1,SM2,Nilai_Skala_Karyawan,Nilai_Skala_Atasan, ((SM1+SM2)/Plan_B)*100 AS Achieve,MonRemarks 
                 FROM tbl_kpi_activity_plan INNER JOIN  tbl_kpi_header_form ON tbl_kpi_header_form.KPIID=tbl_kpi_activity_plan.KPIID 
                 WHERE tbl_kpi_activity_plan.KPIID='".$primary_key."' AND (ItemID=1 OR ItemID=2 OR ItemID=3) ORDER BY ItemID ASC";
      	$query  = $this->db->query($SQL);
      	$data   = $query->row(0);

    }

    public function set_nilai_akhir_pa($value=NULL){

    	/*
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
        */

        /* Dirubah atas pemintaan bu Titi tgl 17-Apr-2018 */
        
        if($value >= 4.52){
            return 'BS (BAIK SEKALI)';
        }
        elseif($value >= 4.01 && $value <= 4.51){
            return 'B+ (BAIK PLUS)';
        }
        elseif($value >= 3.70 && $value <= 4.00){
            return 'B (BAIK)';
        }
        elseif($value >= 3.39 && $value <= 3.69){
            return 'B- (BAIK MINUS)';
        }
        elseif($value >= 3.08 && $value <= 3.38){
            return 'C+ (CUKUP PLUS)';
        }
        elseif($value >= 2.77 && $value <= 3.07){
            return 'C (CUKUP)';
        }
        elseif($value >= 2.26 && $value <= 2.76){
            return 'C- (CUKUP MINUS)';
        }
        elseif($value <= 2.25){
            return 'K (KURANG)';
        }        
        else{
            return 'Tidak Terdeteksi';
        }

    }

    public function save_counseling($data)
	{
		$this->db->insert('tbl_kpi_coaching_and_counseling', $data);
		//$this->db->update('tbl_kpi_header_form', array('iCounseling'=> 1), array('KPIID'=> $data->CounselingKPIID));
		
		return $this->db->insert_id();
	}


	public function get_data_global($primary_key, $type){

		if($type == 1){
			$SQL    = "select a.activity_id,a.ItemID,a.Description,a.Nilai_Skala_Atasan,a.MonRemarksAtasan from tbl_kpi_activity_plan AS a where a.KPIID=".$primary_key." and (a.ItemID=1 OR a.ItemID=2 OR a.ItemID=3) order by a.ItemID, a.activity_id asc";
      		$query  = $this->db->query($SQL);
		}
		else{
			$SQL    = "select a.activity_id,a.ItemID,a.Description,a.Nilai_Skala_Atasan,a.MonRemarksAtasan from tbl_kpi_activity_plan AS a where a.KPIID=".$primary_key." and a.ItemID=".$type." order by a.ItemID,a.activity_id asc";
      		$query  = $this->db->query($SQL);
		}		

      	return $query->result();
	}


}
