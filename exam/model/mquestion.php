<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 普通EXAM
 *
 * @version        $Id: mquestion.php 2018/11/05  Sun $
 */
 
class mquestion extends Model
{   
    
    /**
     *  获取一个EXAM的基本信息
     *
     * @param     string    $wheresql
     * @param     string    $field
     * @return    array
     */
    function get_one($wheresql = "",$field = '*')
    {
        if($field)
        {
            $row = $this->dsql->GetOne("SELECT $field FROM `#@__exam` WHERE $wheresql");
    		return $row;
    	}else{
            return FALSE;
    	}
    }
    
    /**
     *  获取相应数量的所有EXAM
     *
     * @param     string    $wheresql
     * @param     string    $field
     * @param     int       $row
     * @return    array
     */
    function get_all($wheresql = "",$orderby = "",$row = '10',$field = 'id, tid, tidname, tid2, tid2name,title,reward,replies')
    {
        if($field)
        {
            $arrays = array();
            $query = "SELECT $field FROM `#@__exam` WHERE $wheresql $orderby limit 0,$row";
            $this->dsql->SetQuery($query);
            $this->dsql->Execute();
    		while($arr = $this->dsql->GetArray())
    		{
    			$arrays[] = $arr; 
    		}
    		return $arrays;
    	}else{
            return FALSE;
    	}
    }
    
    /**
     *  获取相应数量的推荐所有EXAM
     *
     * @param     int       $row
     * @return    array
     */
    function get_digests($row = '10')
    {
        $arrays = array();
        $query = "SELECT a.id, a.title,m.userid FROM `#@__exam` a 
                  LEFT JOIN `#@__member` m ON m.mid=a.uid 
                  WHERE a.digest = 1 ORDER BY dateline DESC LIMIT 0,$row";
        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
		while($arr = $this->dsql->GetArray())
		{
			$arrays[] = $arr; 
		}
		return $arrays;
    }
    
    
   /**
     *  获取一个EXAM的基本信息包括发布者信息
     *
     * @param     int    $examaid
     * @return    string
     */
    function get_info($examaid,$rs = "")
    {
        if($examaid)
        {
            if($rs == 1) $wheresql = "AND exam.status = 0";
            else $wheresql = "";
            $query = "SELECT exam.*, mem.userid as username, mem.scores,mem.mtype,mem.face FROM `#@__exam` exam 
                      LEFT JOIN `#@__member` mem ON mem.mid=exam.uid 
                      WHERE exam.id='{$examaid}' {$wheresql}";
    		$this->dsql->ExecuteNoneQuery($query);
    		return $this->dsql->GetOne($query);
    	}else{
            return FALSE;
    	}
    }
    
   /**
     *  获取EXAM的数量
     *
     * @return    string
     */
    function get_total()
    {
        $data['solving'] = 0; //未解决的EXAM数
		$data['solved'] = 0;  //已解决的EXAM数
		$query = "SELECT status,COUNT(status) AS dd FROM `#@__exam` GROUP BY status ";
		$this->dsql->Execute('me',$query);
		while($tmparr = $this->dsql->GetArray())
		{
			if($tmparr['status']==0)
			{
				$data['solving'] = $tmparr['dd'];
			}else{
				$data['solved'] += $tmparr['dd'];
			}
		}
		return $data;
    }
    
   /**
     *  针对所有对#@__exam表的update行为
     *
     * @param     string    $set
     * @param     string    $wheresql
     * @return    int
     */
    function update_exam($set = "",$wheresql = "")
    {
        if($wheresql && $set)
        {
            $query = "UPDATE #@__exam SET $set WHERE $wheresql";
            if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
            else return FALSE;
    	}else{
            return FALSE;
    	}
    }
   
     
   /**
     * 检查在有效期内是否存在同样的EXAM
     *
     * @param     int       $uid 
     * @param     string    $title
     * @return    string
     */
    function get_title($uid = "",$title = "")
    {
        if($uid && $title)
        {
            $row = $this->dsql->GetOne("SELECT id FROM `#@__exam` WHERE uid = '{$uid}' AND title = '{$title}' AND dateline < expiredtime");
    		if(is_array($row)) return TRUE;
    		else return FALSE;
    	}else{
            return TRUE;
    	}
    }
		
    /**
     *  保存新增加的EXAM
     *
     * @param     string      $type
     * @param     array    $data
     * @return    string
     */
    function save_exam($type = "",$data = array())
    {
        if(is_array($data))
        {
            if($type == 'Y') $status = "-1";
            else $status = "0";
		    $query = "INSERT INTO `#@__exam`(tid, tidname, tid2, tid2name, uid, anonymous, status, title, reward, dateline, expiredtime, ip ,content) VALUES ('{$data['tid']}', '{$data['tidname']}', '{$data['tid2']}', '{$data['tid2name']}', '{$data['uid']}', '{$data['anonymous']}', '{$status}', '{$data['title']}', '{$data['reward']}', '{$data['timestamp']}', '{$data['expiredtime']}', '{$data['userip']}', '{$data['content']}')";
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
            $row = $this->dsql->GetOne("SELECT max(id) AS id FROM `#@__exam` WHERE dateline = '{$timestamp}'");
    		return $row['id'];
    	}else{
            return FALSE;
    	}
    }
    
    
   /**
     *  获取我的提问
     *
     * @param     int    $uid
     * @param     int    $start
     * @param     int    $end
     * @return    string
     */
    function get_myexam($uid = "",$start= "",$end = "")
    {
        $query = "SELECT id, tid, tidname, tid2, tid2name, uid, title, digest, reward, dateline, expiredtime, 
	              solvetime, status, replies FROM `#@__exam` WHERE uid='{$uid}'
	              ORDER BY dateline DESC LIMIT {$start},{$end}";
	    $this->dsql->SetQuery($query);
		$this->dsql->Execute();
		$myexams = array();
		while($row = $this->dsql->GetArray())
		{
			$myexams[] = $row;
		}
		return $myexams;
    }
    
    /**
     *  批量删除一个EXAM
     *
     * @param     int    $examaid
     * @return    string
     */
    function del($examaid)
    {
        if($examaid){
            $query = "DELETE FROM `#@__exam` WHERE id='{$examaid}'";
    		if($this->dsql->ExecuteNoneQuery($query))
    		{
    		    $this->dsql->ExecuteNoneQuery("DELETE FROM `#@__examanswer` WHERE examid='{$examaid}'");
    		    $this->dsql->ExecuteNoneQuery("DELETE FROM `#@__examcomment` WHERE examid='{$examaid}'");
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
                $query = "SELECT url FROM `#@__uploads_exam` WHERE arcid='{$examaid}' AND type = 0";
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
                $this->dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads_exam` WHERE arcid ='{$examaid}' AND type = 0");
                return  TRUE;
    		}else{
    		    return  FALSE;
    		}
    	}else{
    	    return  FALSE;
    	}
    }
    
    /**
     * 更新统计信息
     * @return    string
     */
    function update()
    {
        $query = "SELECT id, reid FROM `#@__examtype`";
	    $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        while($row = $this->dsql->GetArray())
        {
            if($row['reid'] == 0)
    		{
    			$this->dsql->SetQuery("SELECT COUNT(*) AS dd FROM `#@__exam` WHERE tid='{$row['id']}' ");
    			$this->dsql->Execute('top');
    			$examnum = $this->dsql->GetArray('top');
    			$this->dsql->ExecuteNoneQuery("UPDATE `#@__examtype` SET examnum='{$examnum['dd']}' WHERE id='{$row['id']}' ");
    		}else{
    			$this->dsql->SetQuery("SELECT COUNT(*) as dd FROM `#@__exam` WHERE tid2='{$row['id']}' ");
    			$this->dsql->Execute('sub');
    			$examnum = $this->dsql->GetArray('sub');
    			$this->dsql->ExecuteNoneQuery("UPDATE `#@__examtype` SET examnum='{$examnum['dd']}' WHERE id='{$row['id']}' ");
    		}
        }
    }
}