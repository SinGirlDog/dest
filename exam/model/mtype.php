<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 分类(普通)
 *
 * @version        $Id: mtype.php 2018/11/05  Sun $
 */
 
class mtype extends Model
{   
    /**
     * 发表文章时的栏目信息
     *
     * @param     string    $wheresql
     * @return    array
     */
    function get_examtype($wheresql = "")
    {
        $query = "SELECT id, name, reid FROM `#@__examtype` $wheresql ORDER BY id DESC";
        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        $examtypes = array();
        while($examtype = $this->dsql->GetArray())
        {
            $examtypes[] = $examtype;        
        }
        return $examtypes;
    }
    
   /**
     * 更新一个栏目的统计信息
     *
     * @param     int    $tid
     * @return    int
     */
    function update_examtype($tid = "")
    {
        if($tid)
        {
            $query = "UPDATE `#@__examtype` SET asknum=asknum+1 WHERE id='$tid'";
            $this->dsql->ExecuteNoneQuery($query);
            return TRUE;
        }else{
            return FALSE;   
        }

    }
     
    /**
     * 更新分类排序
     * @return    string
     */
    function update($disorders = array())
    {
        if(is_array($disorders))
        {
            foreach($disorders as $key => $disorder)
        	{
        		$query = "UPDATE `#@__examtype` SET disorder='$disorder' WHERE id='$key'";
        		$this->dsql->ExecuteNoneQuery($query); 
        	}
        	return TRUE;
        }else{
            return FALSE;  
        }
    }
    
    /**
     * 获取所有栏目
     * @return    string
     */
    function get_alltype()
    {
        $query = "SELECT * FROM `#@__examtype` ORDER BY id ASC";
        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        $tids = $tid2s = $examtypes = array();
        while($examtype = $this->dsql->GetArray())
        {
        	if($examtype['reid'] == 0)
        	{
        		$tids[] = $examtype;
        	}else{
        		$tid2s[] = $examtype;
        	}
        
        }
        foreach($tids as $tid)
        {
        	$examtypes[] = $tid;
        	foreach($tid2s as $key => $tid2)
        	{
        		if($tid2['reid'] == $tid['id'])
        		{
        			$examtypes[] = $tid2;
        			unset($tid2s[$key]);
        		}
        	}
        }
        return $examtypes;
    }
    
    /**
     * 增加和编辑时的所有栏目获取
     * @param    int $type 1：编辑,2：增加
     * @param    int $id
     * @param    int $reid
     * @return    string
     */
    function get_optiontype($type = 1,$id = "",$reid = "")
    {
        $sectorscache = '<option value="0">无(作为一级分类)</option>';
        if($type == 2) $wheresql = "WHERE reid=0";
        else $wheresql = "WHERE reid=0 and id<>'$id'";
        $query = "SELECT * FROM `#@__examtype` {$wheresql} ORDER BY id ASC";
		$this->dsql->SetQuery($query);
		$this->dsql->Execute();
		while($topsector = $this->dsql->GetArray())
		{
			$check = '';
			if($reid != 0 && $topsector['id'] == $reid) $check = 'selected';
			$sectorscache .= '<option value="'.$topsector['id'].'" '. $check.'>'.$topsector['name'].'</option>';
		}
        return $sectorscache;
    }
    
    /**
     * 获取一个栏目
     * @param    int $id
     * @return    string
     */
    function get_onetype($id = "")
    {
        $rs = $this->dsql->GetOne("SELECT * FROM `#@__examtype` WHERE id='{$id}'");
        return $rs;
    }
    
    /**
     * 保存一个编辑之后栏目
     * @param     array  $data
     * @return    string
     */
    function save_edit($data = array())
    {
        $query = "UPDATE `#@__examtype` SET name='{$data['name']}', reid='{$data['reid']}', onlynum='{$data['onlynum']}', onlyfenshu='{$data['onlyfenshu']}', morenum='{$data['morenum']}', morefenshu='{$data['morefenshu']}'
                WHERE id='{$data['id']}' ";
		if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
        else return FALSE;  
    }
    
   /**
     * 删除一个栏目
     * @param     array  $id
     * @return    string
     */
    function del_type($id = "")
    {
        if($id){
            $query = "DELETE FROM `#@__examtype` WHERE id='$id' OR reid='$id' "; 
            if($this->dsql->ExecuteNoneQuery($query))
            {
                $query = "SELECT id FROM `#@__exam` WHERE tid='$id' OR tid2='$id'";
                $this->dsql->SetQuery($query);
                $this->dsql->Execute();
                $askids = array();
                while($arr = $this->dsql->GetArray())
                {
                    $askids[] = $arr['id'];
                }
                foreach ($askids as $askid) {
                    $query = "DELETE FROM `#@__examcomment` WHERE askid='$id' ";
                    $this->dsql->ExecuteNoneQuery($query);
                }
                $query2 = "DELETE FROM `#@__examanswer` WHERE tid='$id' OR tid2='$id' "; 
                $query3 = "DELETE FROM `#@__examanswer` WHERE tid='$id' OR tid2='$id' "; 
                $this->dsql->ExecuteNoneQuery($query2);
                $this->dsql->ExecuteNoneQuery($query3);
                return TRUE;   
            }else{
                return FALSE;
            } 
        }else{
           return FALSE;
        } 
    }
    
    /**
     * 保存一个新增的栏目
     * @param     array  $data
     * @return    string
     */
    function save_add($data = array())
    {
        if(is_array($data))
        {
            $query = "INSERT INTO `#@__examtype`(name, reid,onlynum,onlyfenshu,morenum,morefenshu) VALUES('{$data['name']}','{$data['reid']}','{$data['onlynum']}','{$data['onlyfenshu']}','{$data['morenum']}','{$data['morefenshu']}');";
    		if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
            else return FALSE; 
        }else{
            return FALSE;
        } 
    }
    
    
}