<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 文件
 *
 * @version        $Id: mtype.php 15:57 2018/11/11 Sun $
 */

class mfile extends Model
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
    if($tid){
        $query = "UPDATE `#@__examtype` SET asknum=asknum+1 WHERE id='$tid'";
        $this->dsql->ExecuteNoneQuery($query);
        return TRUE;
    }
    else{
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
     * 获取所有文件
     * @return    array
     */
    function get_allfile()
    {
        $query = "SELECT * FROM `#@__examfile` WHERE isdelete != '1' ORDER BY addtime DESC";
        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        $allfile = array();
        while($file = $this->dsql->GetArray()){
            $allfile[] = $file;
        }
        return $allfile;
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
        while($topsector = $this->dsql->GetArray()){
            $check = '';
            if($reid != 0 && $topsector['id'] == $reid) $check = 'selected';
            $sectorscache .= '<option value="'.$topsector['id'].'" '. $check.'>'.$topsector['name'].'</option>';
        }
        return $sectorscache;
    }

    /**
     * 获取一个文件信息
     * @param    int $id
     * @return    string
     */
    function get_onefile($id = "")
    {
        $rs = $this->dsql->GetOne("SELECT * FROM `#@__examfile` WHERE id='{$id}'");
        return $rs;
    }
    
    /**
     * 更新《存储》文件的题目ids字符串
     * @param     array  $data
     * @return    bool
     */
    function save_edit($data = array())
    {
        $query = "UPDATE `#@__examfile` SET quest_ids='{$data['quest_ids']}',updatetime='{$data['updatetime']}' WHERE id='{$data['id']}' ";
        if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
        else return FALSE;
    }
    
   /**
     * 删除一个文件记录(伪装删除)
     * @param     array  $id
     * @return    string
     */
   function del_by_id($id = "")
   {
        if($id){
            $query = "UPDATE `#@__examfile` SET isdelete=1 WHERE id='{$id}' "; 
            if($this->dsql->ExecuteNoneQuery($query)) 
                return TRUE;
            else
                return FALSE;
        }
        else{
            return FALSE;
        } 
    }

    /**
     * 保存一个新增的卷宗
     * @param     array  $data
     * @return    string
     */
    function save_add($data = array())
    {
        if(is_array($data))
        {
            $query = "INSERT INTO `#@__examfile`(id,reid,title,url,quest_ids,addtime,isdelete,updatetime) VALUES('','{$data['reid']}','{$data['title']}','{$data['url']}','{$data['quest_ids']}','{$data['addtime']}','{$data['isdelete']}','{$data['updatetime']}');";
            if($this->dsql->ExecuteNoneQuery($query)) return TRUE;
            else return FALSE; 
        }else{
            return FALSE;
        } 
    }
    
    
}