<?php

class index extends Control {

    var $skey="treeNewBee";

    function index(){
        parent::__construct();
        $this->ac_start();
        $this->mtype = $this->Model("mtype");
        $this->mvisitor = $this->Model("mvisitor");
        $this->mfile = $this->Model("mfile");
        $this->myexam = $this->Model("myexam");
        $this->mpaper = $this->Model("mpaper");
        $this->myanswer = $this->Model("myanswer");
    }

    function ac_start(){
        session_start();
    }
    //方法前面需加上ac_
    public function ac_index() {
        // echo '测试',var_dump($_SERVER['REQUEST_URI']),DEDEXAM,DEDEAPPTPL,$this->style;die;
        $examtp = $this->mtype->get_examtype(' where reid = 0');
        $GLOBALS['examtp'] = $examtp;
        $this->SetTemplate('index_exam.htm');
        $this->Display();
    }

    public function ac_ajax_get_select(){
        $html = "<option>url_Error</option>";
        $reid = request('reid','');
        $html = $this->mtype->ac_ajax_get_select($reid);
        echo $html;
    }

    public function ac_welcome(){
        $data['reid'] = request('reid_level_2','');
        $data['name'] = request('name','');
        $data['mobile'] = request('mobile','');
        $res = $this->mvisitor->safe_save($data);
        if($res){
            $this->session_my_register($data);
            header("Location:./index.php?c=index&a=show_list");
        }
        else{
            ShowMsg('无效信息；请重新填写！','-1');
        }
    }

    public function ac_show_list(){
        $sdata = $_SESSION[$this->skey];
        $GLOBALS[$this->skey] = $sdata;
        $GLOBALS['filelist'] = $this->mfile->get_allfile($sdata['reid']);
        $this->SetTemplate('show_list.htm');
        $this->Display();
    }

    public function ac_open_file(){
        $this->session_req_check();
        $fileid = request('fileid','');
        $paperid = $this->mpaper->add_paper_by_fileid($fileid);
        if($answer_id){
            header("Location:./index.php?c=index&a=show_one_paper&paperid=".$paperid);
        }
        else{
            ShowMsg("Sorry 考试卷打开失败了！","-1");
        }
    }

    public function ac_show_one_paper(){
        $this->session_rew_check();
        $paperid = request('paperid','');
        $paper_data = $this->mpaper->get_onepaper($paperid);
        $quest_choice_only = $this->myexam->get_questions_byids($paper_data['quest_choice_only']);
        $quest_choice_more = $this->myexam->get_questions_byids($paper_data['quest_choice_more']);
        $GLOBALS['paper_data'] = $paper_data;
        $GLOBALS['quest_choice_only'] = $quest_choice_only;
        $GLOBALS['quest_choice_more'] = $quest_choice_more;
        $this->SetTemplate('show_one_paper.htm');
        $this->Display();
    }

    public function ac_paper_answered(){
        $answer_id = $this->myanswer->add_answer_by_paperid();
        if($answer_id){
            header("Location:./index.php?c=index&a=show_jiexi&answer_id=".$answer_id);
        }
        else{
            ShowMsg("Sorry 答题卡提交失败了！","-1");
        }
    }

    public function ac_show_jiexi(){
        echo "Hello Tom; This is JIEXI speaking ~~~ ";
    }

    protected function session_my_register($data){
        if(!empty($data)){
            $_SESSION[$this->skey] = $data;
            $_SESSION[$this->skey."_".$data['mobile']] = 1;
        }
        else{
            ShowMsg('无效信息!','./index.php?c=index');
            exit();
        }
    }
    protected function session_req_check(){
        $name = request('name','');
        $mobile = request('mobile','');
        $sdata = $_SESSION[$this->skey];
        if($sdata['name'] == $name && $sdata['mobile'] == $mobile){
            $DoNothing = true;
        }
        else{
            ShowMsg('无效信息!','./index.php?c=index');
            exit();
        }
    }
    protected function session_rew_check(){
        $sdata = $_SESSION[$this->skey];
        if($_SESSION[$this->skey."_".$sdata['mobile']] != 1){
            ShowMsg('无效信息!','./index.php?c=index');
            exit();
        }
    }


    public function ac_getList() {
        //通过request()来获取参数
        $id = request('id');
        //获取模型数据
        $data = $this->Model('elist')->getList();
        //分配数据
        $GLOBALS['data'] = $data;
        //设置模板
        $this->SetTemplate('showlist.htm');
        //显示模板
        $this->Display();
    }
}