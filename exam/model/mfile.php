<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 文件
 *
 * @version        $Id: mtype.php 15:57 2018/11/11 Sun $
 */

class mfile extends Model
{  
    /**
     * 获取所有文件
     * @return    array
     */
    function get_allfile($reid='')
    {
        if($reid){
           $wheresql = "reid = '{$reid}' and ";
        }
        else{
            $wheresql = '';
        }
        $query = "SELECT * FROM `#@__examfile` WHERE ".$wheresql." isdelete != '1' ORDER BY addtime DESC";
        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        $allfile = array();
        while($file = $this->dsql->GetArray()){
            $allfile[] = $file;
        }
        return $allfile;
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