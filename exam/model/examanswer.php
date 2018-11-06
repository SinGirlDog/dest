<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 普通问题的答复
 *
 * @version        $Id: examanswer.php 2018/11/05  Sun $
 */

class examanswer extends Model
{

    /**
     *  获取问题的答案
     *
     * @param     int    $examaid
     * @return    string
     */
    function get_answers($examaid)
    {
    	if($examaid)
    	{
            $query = "SELECT answer.*,m.scores FROM #@__examanswer answer 
            LEFT JOIN `#@__member` m ON m.mid=answer.uid 
            WHERE examid='{$examaid}' AND ifcheck='1' ORDER BY dateline ASC";
            $this->dsql->SetQuery($query);
            $this->dsql->Execute();
            $rows = array();
            while($row = $this->dsql->GetArray())
            {
            	$rows[] = $row;
            }
            return $rows;
        }else{
        	return FALSE;
        }
    }
    
   /**
     *  获取一个答案的基本信息
     *
     * @param     string    $wheresql
     * @param     string    $field
     * @return    array
     */
   function get_one($wheresql = "",$field = '*')
   {
   	if($field)
   	{
   		$row = $this->dsql->GetOne("SELECT $field FROM `#@__examanswer` WHERE $wheresql");
   		return $row;
   	}else{
   		return FALSE;
   	}
   }

    /**
     *  获取一个答案的具体信息
     *
     * @param     int    $id
     * @return    array
     */
    function get_info($id)
    {
    	if($id)
    	{
    		$row = $this->dsql->GetOne("SELECT a.uid, k.dateline, k.solvetime, k.status, k.expiredtime FROM `#@__examanswer` a
    			LEFT JOIN #@__exam k ON k.id=a.examid WHERE a.id='{$id}'");
    		return $row;
    	}else{
    		return FALSE;
    	}
    }
    
   /**
     *  获取一个答案的具体信息(采纳答案)
     *
     * @param     int    $id
     * @return    array
     */
   function get_info_adopt($id)
   {
   	if($id)
   	{
   		$row = $this->dsql->GetOne("SELECT a.examid,a.uid as answeruid,k.uid,k.reward,k.status,k.expiredtime
   			FROM `#@__examanswer` a LEFT JOIN `#@__exam` k ON k.id=a.examid 
   			WHERE a.id='{$id}'");
   		return $row;
   	}else{
   		return FALSE;
   	}
   }

    /**
     * 检查是否已经存在回复
     *
     * @param     int       $uid 
     * @param     string    $examid
     * @return    string
     */
    function get_answer($uid = "",$examid = "")
    {
    	if($uid && $examid)
    	{
    		$row = $this->dsql->GetOne("SELECT id FROM `#@__examanswer` WHERE uid = '{$uid}' AND examid = '{$examid}'");
    		if(is_array($row)) return TRUE;
    		else return FALSE;
    	}else{
    		return TRUE;
    	}
    }
    
   /**
     *  保存回复
     *
     * @param     array    $ids
     * @return    string
     */
   function save_answer($type = "",$data = array())
   {
   	if(is_array($data))
   	{
   		if($type == 'Y') $status = "0";
   		else $status = "1";
   		$query = "INSERT INTO `#@__examanswer` (examid, tid, tid2, uid, username, anonymous, userip, dateline, content, ifcheck)
   		VALUES ('{$data['examaid']}','{$data['tid']}', '{$data['tid2']}', '{$data['uid']}', '{$data['username']}', '{$data['anonymous']}', '{$data['userip']}', '{$data['timestamp']}', '{$data['content']}', '{$status}')";
   		if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
   		else return FALSE;
   	}else{
   		return FALSE;
   	}
   }

    /**
     *  获取最大的id
     *
     * @param     time    $timestamp
     * @return    string
     */
    function get_maxid($timestamp)
    {
    	if($timestamp)
    	{
    		$row = $this->dsql->GetOne("SELECT max(id) AS id FROM `#@__examanswer` WHERE dateline = '{$timestamp}'");
    		return $row['id'];
    	}else{
    		return FALSE;
    	}
    }
    
   /**
     *  针对所有对#@__examanswer表的update行为
     *
     * @param     string    $set
     * @param     string    $wheresql
     * @return    int
     */
   function update_answer($set = "",$wheresql = "")
   {
   	if($wheresql && $set)
   	{
   		$query = "UPDATE `#@__examanswer` SET $set WHERE $wheresql";
   		if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
   		else return FALSE;
   	}else{
   		return FALSE;
   	}
   }

    /**
     *  审核
     *
     * @param     array    $ids
     * @return    string
     */
    function check($ids = array())
    {
    	if(count($ids) > 0)
    	{
    		foreach($ids as $id)
    		{
    			$id = preg_replace("#[^0-9]#","",$id);
    			if($id=="") continue;
    			$query = "UPDATE `#@__examanswer` SET ifcheck='1' WHERE id='{$id}' AND ifcheck='0'";
    			$this->dsql->ExecuteNoneQuery($query);
    		}
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
    
    /**
     *  删除
     *
     * @param     int    $id
     * @return    string
     */
    function del($id)
    {
    	if($id)
    	{
    		$row = $this->dsql->GetOne("SELECT examid FROM `#@__examanswer` WHERE id='{$id}'");
    		$query = "DELETE FROM #@__examanswer WHERE id='{$id}'";
    		if($this->dsql->ExecuteNoneQuery($query))
    		{
    			$query2 = "UPDATE `#@__exam` SET replies = replies - 1 WHERE id='{$row['examid']}'";
    			$this->dsql->ExecuteNoneQuery($query2);
    			global $cfg_basedir,$cfg_remote_site;
    		    //启用远程站点则创建FTP类
    			if($cfg_remote_site == 'Y')
    			{
    				require_once(DEDEINC.'/ftp.class.php');
    				if(file_exists(DEDEDATA."/cache/inc_remote_config.php"))
    				{
    					require_once DEDEDATA."/cache/inc_remote_config.php";
    				}
    				if(empty($remoteuploads)) $remoteuploads = 0;
    				if(empty($remoteupUrl)) $remoteupUrl = '';
                    //初始化FTP配置
    				$ftpconfig = array(
    					'hostname' => $rmhost, 
    					'port' => $rmport,
    					'username' => $rmname,
    					'password' => $rmpwd

    				);
    				$ftp = new FTP; 
    				$ftp->connect($ftpconfig);
    			}
    			$query = "SELECT url FROM `#@__uploads_exam` WHERE rid ='{$id}' AND type = 0";
    			$this->dsql->SetQuery($query);
    			$this->dsql->Execute();
    			while($row = $this->dsql->GetArray())
    			{
    				if($cfg_remote_site == 'Y' && $remoteuploads == 1)
    				{
    					$ftp->delete_file($row['url']);
    				}else{
    					@unlink($cfg_basedir.$row['url']); 
    				}
    			}
    			$this->dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads_exam` WHERE rid ='{$id}' AND type = 0");
    			return TRUE;
    		}else{
    			return FALSE;  
    		}
    	}else{
    		return FALSE;
    	}
    }
}