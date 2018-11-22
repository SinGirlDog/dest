<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 考题
 *
 * @version        $Id: mtype.php 15:01 2018/11/12 Sun $
 */

class myexam extends Model
{
	private $Alpha_Arr = array(
		'A','B','C','D','E',
		'F','G','H','I','J',
		'K','L','M','N','O',
		'P','Q','R','S','T',
		'U','V','W','X','Y','Z'
	);

	function get_all_list($wheresql = ''){
		$query = "SELECT * FROM `#@__exam` $wheresql ORDER BY id DESC";
		$this->dsql->SetQuery($query);
		$this->dsql->Execute();
		$exam_list = array();
		while($exam_one = $this->dsql->GetArray())
		{
			$exam_list[] = $exam_one;        
		}
		return $exam_list;
	}

	function save_one_add($data=array()){
		if(is_array($data)){
			$query = "INSERT INTO `#@__exam`(id,reid,title,quest_body,quest_answer,true_answer,quest_analysis,quest_type,addtime,updatetime) VALUES('','{$data['reid']}','{$data['title']}','{$data['quest_body']}','{$data['quest_answer']}','{$data['true_answer']}','{$data['quest_analysis']}','{$data['quest_type']}','{$data['addtime']}','{$data['updatetime']}');";
			$res = $this->dsql->ExecuteNoneQuery($query);
			if($res){
				return mysql_insert_id();
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}

	function del_by_ids($ids){
		if(empty($ids)){
			return FALSE;
		}
		else{
			$sql = "UPDATE `#@__exam` SET isdelete = 1 where id IN (".$ids.")";
			$res = $this->dsql->ExecuteNoneQuery($sql);
			if($res){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}

	function get_one_exam($id){
		if(empty($id)){
			return FALSE;
		}
		else{
			$wheresql = "where id = ".$id;
			$query = "SELECT * FROM `#@__exam` ".$wheresql." ORDER BY id DESC";
			$this->dsql->SetQuery($query);
			$this->dsql->Execute();
			$exam_one = $this->dsql->GetArray();
			return $exam_one;
		}
	}

	function update_one_exam($data,$id){
		if(empty($id)){
			return FALSE;
		}
		else{
			$wheresql = "where id = ".$id;
			$query = "UPDATE `#@__exam` SET title = '$data[title]',quest_body = '$data[quest_body]',quest_answer = '$data[quest_answer]',true_answer = '$data[true_answer]',quest_analysis = '$data[quest_analysis]',updatetime = '$data[updatetime]' ".$wheresql;

			$this->dsql->ExecuteNoneQuery($query);
			return TRUE;
		}
	}

	function get_questions_byids($quest_ids){
		if($quest_ids){
			$wheresql = "WHERE id IN (".$quest_ids.")";
			$questions = $this->get_all_list($wheresql);
			return $questions;
		}
	}

	function parse_choice_more_answer($answer_str){
		if($answer_str){
			$number_arr = json_decode($answer_str);
			$answer_arr = array();
			foreach($number_arr as $key => $val){
				$answer_arr[] = $this->map_number_to_alphabet($val);
			}
			return $answer_arr;
		}
	}

	function parse_choice_only_answer($answer_str){
		if($answer_str){
			$answer_arr = explode(',',$answer_str);
			return $this->map_number_to_alphabet($answer_arr);
		}
	}

	function get_cankao_answer_byids($quest_ids_str){
		$true_answer = array();
		if($quest_ids_str){
			$questions = $this->get_questions_byids($quest_ids_str);
			foreach($questions as $key=>$exam){
				if($exam['quest_type'] == 'choice_only'){
					$true_answer['answer'][] = $exam['true_answer'];
				}
				else if($exam['quest_type'] == 'choice_more'){
					$true_answer['answer'][] = explode('.',$exam['true_answer']);
				}
				$true_answer['id'][] = $exam['id'];
			}
		}
		return $true_answer;
	}

	function get_analysis_byids($quest_ids_str){
		$analysis = array();
		if($quest_ids_str){
			$questions = $this->get_questions_byids($quest_ids_str);
			foreach($questions as $key=>$exam){
				$temp['quest_analysis'] = $exam['quest_analysis'];
				$analysis[] = $temp;
			}
		}
		return $analysis;
	}

	private function map_number_to_alphabet($number_arr){
		$alpha_arr = array();
		foreach($number_arr as $key=>$val){
			$alpha_arr[] = $this->Alpha_Arr[$val-1];
		}
		return $alpha_arr;
	}

	function count_right_or_wrong_times($times_arr){
		if($times_arr){
			foreach($times_arr as $key_id => $filed){
				$data = '`'.$filed.'` = `'.$filed.'` + 1';
				// $where = array('id'=>$key_id);
				$wheresql = "where id = ".$key_id;
				$upquery = "UPDATE `#@__exam` SET ".$data.$wheresql;
				$res = $this->dsql->ExecuteNoneQuery($upquery);
			}
		}
	}
}