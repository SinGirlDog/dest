<?php

class index extends Control {

    function index(){
        parent::__construct();
    }

    //方法前面需加上ac_
    public function ac_index() {
        // echo '测试',var_dump($_SERVER['REQUEST_URI']),DEDEXAM,DEDEAPPTPL,$this->style;die;
       
        $this->SetTemplate('index_exam.htm');
        $this->Display();
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