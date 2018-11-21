<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 答题卡
 *
 * @version        $Id: myanswer.php 17:17 2018/11/21 Sun $
 */

class myanswer extends Model
{  
	function add_answer_by_paperid(){
		$paper_id = request('paper_id','');
		$only = request('only','');
		$more = request('more','');
		$only_str = implode(',', $only);
		$more_str = json_encode($more);
		if($paper_id){
			$paper_rs = $this->dsql->GetOne("SELECT * FROM `#@__exampaper` WHERE id='{$paper_id}'");

			$data['paper_id'] = $paper_id;
			$data['fileid'] = $paper_rs['fileid'];
			$data['title'] = $paper_rs['title'];
			$data['name'] = $paper_rs['name'];
			$data['mobile'] = $paper_rs['mobile'];
			$data['addtime'] = time();

			$query = "INSERT INTO `#@__examanswer` (id,paper_id,fileid,name,mobile,title,answer_choice_only,answer_choice_more,addtime) VALUES ('','{$data['paper_id']}','{$data['fileid']}','{$data['name']}','{$data['mobile']}','{$data['title']}','{$only_str}','{$more_str}','{$data['addtime']}')";
			$this->dsql->ExecuteNoneQuery($query);

			return mysql_insert_id();
		}
		else{
			return FALSE;
		}
	}

}