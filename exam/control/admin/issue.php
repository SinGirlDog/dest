<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2011/11/015 Sun $
 *
 **/

class issue extends Control
{
    var $quest_type = array('choice_only'=>"单项选择",'choice_more'=>"多项选择");
    function issue()
    {
      parent::__construct();
      $this->temp = DEDEAPPTPL.'/admin';
      $this->lurd = new Lurd('#@__exam', $this->temp, $this->temp.'/lurd');
      $this->lurd->appName = "EXAM管理";
        $this->lurd->isDebug = FALSE;  //开启调试模式后每次都会生成模板
        $this->lurd->stringSafe = 2;  //默认1(只限制不安全的HTML[script、frame等]，0--为不限，2--为不支持HTML
        $this->style = 'admin';
        //获取url
        $this->currurl = GetCurUrl();
        //载入模型
        $this->question = $this->Model('mquestion');
        $this->myexam = $this->Model('myexam');
        $this->type = $this->Model('mtype');
    }

    function ac_index()
    {
        //指定某字段为强制定义的类型
        $this->ac_list();
    }
    
    //列出EXAM
    function ac_list()
    {
        // $exam_list = $this->myexam->get_all_list("where 1");
        // $GLOBALS['exam_list'] = $exam_list;
        $wherequery = "where isdelete != 1";
        $orderquery = "ORDER BY id DESC ";
        //指定每页显示数
        $this->lurd->pageSize = 2;
        //获取数据
        $this->lurd->ListData('id,reid,title,quest_body,quest_answer,true_answer,quest_analysis,quest_type,isdelete,right_time,wrong_times,addtime,updatetime', $wherequery, $orderquery);
        exit();
    }
    
    function ac_edit(){
        $id = request('id','');
        $thexam = $this->myexam->get_one_exam($id);
        $GLOBALS['thexam'] = $thexam;
        $this->SetTemplate('exam_edit.htm');
        $this->Display();
    }

    function ac_save_edit(){
        $id = request('id','');
        $data['quest_body'] = request('qbody','');
        $data['title'] = substr($data['quest_body'],0,80);
        $data['quest_answer'] = request('qanswer','');
        $data['true_answer'] = request('tanswer','');
        $data['quest_analysis'] = request('qanalysis','');
        $data['updatetime'] = time();
        $res = $this->myexam->update_one_exam($data,$id);
        if($res){
            ShowMsg('修改成功！','?ct=issue');
        }
        else{
            ShowMsg('本次修改失败了!','-1');
        }
    }

    function ac_add_exam(){
        $examtp = $this->type->get_examtype("where reid = 0");
        $GLOBALS['examtp'] = $examtp;
        $GLOBALS['quest_type'] = $this->quest_type;
        $this->SetTemplate('exam_add.htm');
        $this->Display();
    }

    function ac_save_add(){

        $data['reid'] = request('reid_level_2','');
        $data['quest_body'] = request('qbody','');
        $data['title'] = substr($data['quest_body'],0,80);
        $data['quest_answer'] = request('qanswer','');
        $data['true_answer'] = request('tanswer','');
        $data['quest_analysis'] = request('qanalysis','');
        $data['addtime'] = time();
        $data['updatetime'] = time();
        $res = $this->myexam->save_one_add($data);
        if($res){
            ShowMsg('添加成功！','?ct=issue');
        }
        else{
            ShowMsg('本次添加失败了!','-1');
        }
    }

    //审核
    function ac_check()
    {
        $ids = request('id', '');
        if(!is_array($ids))
        {
            ShowMsg('未选择要审核的EXAM!','-1');
            exit();	 
        }
        foreach($ids as $id)
        {
            if($id == "") continue;
            //审核EXAM
            $this->question->update_exam("status='0'","id='{$id}' AND status=-1");
        }
        ShowMsg("EXAM审核成功！",$this->currurl);
        exit();	 
    }

	//推荐
    function ac_digest(){
        $ids = request('id', '');
        if(!is_array($ids)){
            ShowMsg('未选择要审核的EXAM!','-1');
            exit();	 
        }
        foreach($ids as $id){
            if($id == "") continue;
            $this->question->update_exam("digest='1'","id='{$id}'");
        }
        ShowMsg("成功把所选的EXAM设为推荐！",$this->currurl);
        exit();
    }

	 //删除问答操作
    function ac_delete(){
        $id = request('id', '');
        $id = preg_replace("#[^0-9]#","",$id);
        if($id){
            $this->myexam->del_by_ids($id);
            ShowMsg("成功的删除了所选的EXAM！",'-1');
        }
        else{
            ShowMsg("删除所选EXAM失败！",'-1');
        }
    }

	//监听删除修改等操作
    function ac_listenall(){
        global $ac;
        $ac = request('bc', '');
        $this->lurd->ListenAll();
        exit();
    }
}
?>