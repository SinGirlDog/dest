<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 考题
 *
 * @version        $Id: mtype.php 15:01 2018/11/12 Sun $
 */

class myexam extends Model
{
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

}