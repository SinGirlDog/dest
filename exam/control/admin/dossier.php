<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2018/11/05  Sun $
 *
 **/

class dossier extends Control{

    function dossier(){
        parent::__construct();
        $this->temp = DEDEAPPTPL.'/admin';
        $this->lurd = new Lurd('#@__examfile', $this->temp, $this->temp.'/lurd');
        $this->lurd->appName = "JZ管理";
        $this->lurd->isDebug = FALSE;  //开启调试模式后每次都会生成模板
        $this->lurd->stringSafe = 2;  //默认1(只限制不安全的HTML[script、frame等]，0--为不限，2--为不支持HTML
        //获取url
        $this->style = 'admin';
        $this->currurl = GetCurUrl();
        //载入模型
        $this->answer = $this->Model('examanswer');
        $this->question = $this->Model('mquestion');
        $this->type = $this->Model('mtype');
        $this->myfile = $this->Model('mfile');
        $this->myexam = $this->Model('myexam');
    }

    function ac_index(){
        $this->ac_list();
    }
    
    //列出答案
    function ac_list(){
        $examtp = $this->type->get_examtype("where reid = 0");
        $GLOBALS['examtp'] = $examtp;

        $file_list = $this->myfile->get_allfile();
        $GLOBALS['file_list'] = $file_list;
       
        $wherequery = "where isdelete != 1";
        $orderquery = "ORDER BY id DESC ";
        // 指定每页显示数
        // $this->lurd->pageSize = 2;reid,title,quest_ids,addtime,updatetime
        // 获取数据
        $this->lurd->ListData('id,reid,title,quest_ids,addtime,updatetime', $wherequery, $orderquery);
        exit();
    }

    //审核
    function ac_check(){
        $reid = request('id', '');
        if(!is_array($ids)){
            ShowMsg('未选择要审核的答案!','-1');
            exit();  
        }
        $rs = $this->answer->check($ids);
        if($rs){
            ShowMsg("审核成功！",$this->currurl);
            exit(); 
        }else{
            ShowMsg("审核失败！",$this->currurl);
            exit(); 
        } 
    }

    //删除
    function ac_delete()
    {
        $id = request('id', '');
        if(empty($id)){
            ShowMsg('未选择要删除的文件!','-1');
            exit();  
        }
        $file = $this->myfile->get_onefile($id);
        if(!empty($file['quest_ids'])){
            $quest_res = $this->myexam->del_by_ids($file['quest_ids']);
            if(!$quest_res)
            {
                ShowMsg("题目删失败！",'-1');
                exit(); 
            }
        }
        $file_res = $this->myfile->del_by_id($id);
        if($file_res){
            ShowMsg("删除成功！",'-1');
        }
        else{
            ShowMsg("删除失败！",'-1');
        }
        exit(); 
    }

    //监听删除修改等操作
    function ac_listenall(){
        global $ac;
        $ac = request('bc', '');
        $this->lurd->ListenAll();
        exit();
    }

    function ac_upload_xml(){

        $updat['reid_level_1'] = request('reid_level_1', '');
        $updat['reid'] = request('reid_level_2', '');
        $updat['title'] = request('title', '');
        $updat['url'] = request('upfile', '');
        $updat['title'] .= $this->type->get_title_by_reid($updat['reid']);
        $updat['addtime'] = time();
        $this->myfile->save_add($updat);
        
        $this->ac_index();
    }

    function ac_ajax_get_select(){
        $html = "";
        $reid = request('reid', '');
        $html = $this->type->ac_ajax_get_select($reid);
        echo $html;
    }

    function ac_preview(){
        $id = request('id','');
        $thefile = $this->myfile->get_onefile($id);
        $GLOBALS['thefile'] = $thefile;
        $this->SetTemplate('dossier_preview.htm');
        $this->Display();
    }

    function ac_parse_save(){
        $file_id = request('id','');
        $file_data = $this->myfile->get_onefile($file_id);
        
        require_once(DEDEEXAM.'/libraries/XML/xml.class.php');
        $myXml = new xml();
        $myXml->dir = $_SERVER['DOCUMENT_ROOT'].$file_data['url'];
        $reform_data = $myXml->get_reform_data();

        $file_quest_ids = array();
        foreach($reform_data as $key => $reform_one)
        {
            $exam_data = array(
                'reid'=>$file_data['reid'],
                'title'=>substr($reform_one['question_body'],0,80),
                'quest_body'=>$reform_one['question_body'],
                'quest_answer'=>$reform_one['question_answer'],
                'true_answer'=>$reform_one['true_answer'],
                'quest_analysis'=>$reform_one['question_analysis'],
                'quest_type'=>$reform_one['quest_type'],
                'addtime'=>time(),
                'updatetime'=>time(),
            );
            $exam_id = $this->myexam->save_one_add($exam_data);
            $file_quest_ids[] = $exam_id;
        }
        $updata = array();
        $updata['id'] = $file_id;
        $updata['quest_ids'] = implode(',', $file_quest_ids);
        $updata['updatetime'] = time();
        $result = $this->myfile->save_edit($updata);
        
        if($result){
            ShowMsg('入库成功','-1');
        }
        else{
            ShowMsg('入库失败','-1');
        }
    }
}
?>