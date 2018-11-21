<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 卷纸
 *
 * @version        $Id: mpaper.php 15:25 2018/11/21 Sun $
 */

class mpaper extends Model
{  
	function add_paper_by_fileid($fileid){
		if($fileid){
			$file_rs = $this->dsql->GetOne("SELECT * FROM `#@__examfile` WHERE id='{$fileid}'");
			$arr_by_type = array();
			if($file_rs['quest_ids']){
				$exam_idarr = explode(',', $file_rs['quest_ids']);
				foreach($exam_idarr as $key=>$exam_id){
					$qtype_arr = $this->dsql->GetOne("SELECT quest_type FROM `#@__exam` WHERE id='{$exam_id}'");
					$arr_by_type[$qtype_arr['quest_type']][] = $exam_id;
				}
			}
			$only_idstr = implode(',',$arr_by_type['choice_only']);
			$more_idstr = implode(',',$arr_by_type['choice_more']);
			$data['fileid'] = $fileid;
			$data['title'] = $file_rs['title']."-".date("YmdHis",time());
			$data['name'] = $_SESSION['treeNewBee']['name'];
			$data['mobile'] = $_SESSION['treeNewBee']['mobile'];
			$data['quest_choice_only'] = $arr_by_type['choice_only'];
			$data['quest_choice_more'] = $arr_by_type['choice_more'];
			$data['addtime'] = time();

			$query = "INSERT INTO `#@__exampaper` (id,fileid,name,mobile,title,quest_choice_only,quest_choice_more,addtime) VALUES ('','{$data['fileid']}','{$data['name']}','{$data['mobile']}','{$data['title']}','{$only_idstr}','{$more_idstr}','{$data['addtime']}')";
			$this->dsql->ExecuteNoneQuery($query);

			return mysql_insert_id();
		}
		else{
			return FALSE;
		}
	}

	function get_onepaper($id = "")
	{
		$rs = $this->dsql->GetOne("SELECT * FROM `#@__exampaper` WHERE id='{$id}'");
		return $rs;
	}

}