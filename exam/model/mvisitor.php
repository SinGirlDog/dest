<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 访问者
 *
 * @version        $Id: mvisitor.php 13:21 2018/11/20 Sun $
 */

class mvisitor extends Model
{
	function safe_save($data){
		$res = FALSE;
		if($data['mobile']){			
			$query = "SELECT id FROM `#@__examvisitor` WHERE mobile = '{$data['mobile']}' AND name = '{$data['name']}' limit 1 ";
			$visitor = $this->dsql->GetOne($query);

			if($visitor['id']){
				$lasttime = time();
				$upsql = "UPDATE `#@__examvisitor` SET lasttime = '{$lasttime}' ";
				$res = $this->dsql->ExecuteNoneQuery($upsql);
			}
			else{
				$time = time();

				$insql = "INSERT INTO `#@__examvisitor`(name, lastreid,mobile,addtime,lasttime) VALUES('{$data['name']}','{$data['reid']}','{$data['mobile']}','{$time}','{$time}')";
				$res = $this->dsql->ExecuteNoneQuery($insql);
			}
		}

		return $res;
	}

}