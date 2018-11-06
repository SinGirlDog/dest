<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2018/11/05  Sun $
 *
 **/
class examtype extends Control
{
    function examtype()
	{
		parent::__construct();
        //获取url
        $this->currurl = GetCurUrl();
        //获取类别
        require_once DEDEEXAM.'/data/examtype.inc.php';
        $this->examtypes = $examtypes;
        $this->style = 'admin';
        //载入模型
        $this->type = $this->Model('mtype');
	}
    
    function ac_index()
    {
        $examtypes = array_filter($this->examtypes, array(&$this, 'oneeven'));
        $examtype_sons = array_filter($this->examtypes, array(&$this, 'twoeven'));
        foreach ($examtypes as $key => $examtype) {
            $son = "";
            foreach ($examtype_sons as $examtype_son) {
                if($examtype_son['reid'] == $examtypes[$key]['id']){
                    $son .= '<tr>
                    <td align="center">'.$examtype_son['id'].'</td>
                    <td> |--'.$examtype_son['name'].'</td>
                    <td><input type="text" name="disorders['.$examtype_son['id'].']" value="'.$examtype_son['disorder'].'" /></td>
                    <td align="center"><a href="?ct=examtype&ac=edit&amp;id='.$examtype_son['id'].'&height=200&amp;width=450" class=\'thickbox\'>修改</a> 
                    <a href="#" onClick="javascript:del('.$examtype_son['id'].')">删除</a></td>
                    </tr>';
                }      
            } 
            $examtypes[$key]['son'] = $son;
        }
        //设定变量值
        $GLOBALS['examtypes'] = $examtypes;
		//载入模板
		$this->SetTemplate('examtype_list.htm');
        $this->Display();
    }
    
    //过滤数组单元,获取一级分类
    function oneeven($var)
    {
       return($var['reid'] == 0);
    }
    
    //过滤数组单元,获取二级分类
    function twoeven($var)
    {
       return($var['reid'] != 0);
    }
    
    //更新排序
    function ac_update()
    {
        $disorders = request('disorders', '');
    	$rs = $this->type->update($disorders);
    	if($rs)
    	{
    	    $this->updatecache();
    		ShowMsg("更新排序成功!","?ct=examtype");
    		exit();
    	}else{
    		ShowMsg('更新排序失败','-1');
    		exit();
    	}
    }
    
    //编辑
    function ac_edit()
    {
        $id = request('id', '');
    	$examtype = $this->type->get_onetype($id);
    	if(is_array($examtype))
    	{
    	    $sectorscache = $this->type->get_optiontype(1,$id,$examtype['reid']);
    	    //设定变量值
            $GLOBALS['id'] = $id;
            $GLOBALS['examtype'] = $examtype;
            $GLOBALS['sectorscache'] = $sectorscache;
    		//载入模板
    		$this->SetTemplate('examtype_edit.htm');
            $this->Display();
	    }else{
	        ShowMsg('编辑分类不存在','-1');
    		exit();
	    }
    }
    
    //保存编辑
    function ac_edit_save()
    {
        $data['id'] = request('id', '');
        $data['name'] = request('name', '');
        $data['reid'] = request('reid', '');
        $data['disorder'] = request('disorder', '');
        if($data['name'] == "")
        {
            ShowMsg('分类名称不能为空','?ct=examtype');
			exit();
        }
        $rs = $this->type->save_edit($data);
		if($rs)
		{
		    $this->updatecache();
			ShowMsg('编辑分类成功，将返回分类管理页面','?ct=examtype');
			exit();
		}else{
			ShowMsg('编辑分类成功，将返回分类管理页面','?ct=examtype');
			exit();
		}
    }
    
    //删除
    function ac_delete()
    {
        $id = request('id', '');
        $rs = $this->type->del_type($id);
		if($rs)
		{
		    $this->updatecache();
			ShowMsg('删除分类成功，将返回分类管理页面', '?ct=examtype');
			exit();
		}else{
			ShowMsg('删除分类失败，将返回分类管理页面 ','?ct=examtype');
			exit();
		}
    }
    
    //增加分类
    function ac_add()
    {
        $ml = request('ml', '');
        $id = request('id', '');
        $name = request('name', '');
        if($ml != 1) $sectorscache = $this->type->get_optiontype(2);
        //设定变量值
        $GLOBALS['ml'] = $ml;
        $GLOBALS['id'] = $id;
        $GLOBALS['name'] = $name;
        $GLOBALS['sectorscache'] = $sectorscache;
		//载入模板
		$this->SetTemplate('examtype_add.htm');
        $this->Display();
    }
    
    //增加分类
    function ac_add_save()
    {
        $data['name'] = request('name', '');
        $data['reid'] = request('reid', '');
        if(empty($data['name']))
        {
            ShowMsg('分类名称不能为空', '?ct=examtype');
			exit();  
        }
        $rs = $this->type->save_add($data);
        if($rs)
		{
		    $this->updatecache();
			ShowMsg('增加分类成功，将返回分类管理页面','?ct=examtype');
			exit();
		}else{
			ShowMsg('增加分类成功，将返回分类管理页面','?ct=examtype');
			exit();
		}

    }
    
    //更新栏目缓存
    function updatecache()
    {
        $examtypes = $this->type->get_alltype();
        $path = DEDEEXAM."/data/cache/examtype.inc";
        $row = serialize($examtypes);
        $configstr = "<"."?php\r\n\$examtypes = '".$row."';";
        file_put_contents($path, $configstr);	
    }
   
}
?>