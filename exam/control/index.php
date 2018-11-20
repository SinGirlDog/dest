<?php

class index extends Control {

    var $skey="treeNewBee";

    function index(){
        parent::__construct();
        $this->ac_start();
        $this->mtype = $this->Model("mtype");
        $this->mvisitor = $this->Model("mvisitor");
        $this->mfile = $this->Model("mfile");
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
        $_SESSION[$this->skey] = $data;
        if($res){
            // header("Location:https://baidu.com");
            header("Location:./index.php?c=index&a=show_list");
        }
        else{
            echo "无效信息；请重新填写！";
        }
    }

    public function ac_show_list(){
        // var_dump($_SESSION[$this->skey]);
        $sdata = $_SESSION[$this->skey];
        $GLOBALS[$this->skey] = $sdata;
        $GLOBALS['filelist'] = $this->mfile->get_allfile($sdata['reid']);
        $this->SetTemplate('show_list.htm');
        $this->Display();
    }

    public function ac_open_file(){
        $this->session_my_check();
        $fileid = request('fileid','');
        $file_cont = $this->mfile->get_onefile($fileid);
        var_dump($file_cont);
    }

    protected function session_my_check(){

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