<?php

class test extends Control {

    function test(){
        parent::__construct();
        
    }

    //方法前面需加上ac_
    public function ac_test() {
        // echo '测试',var_dump($_SERVER['REQUEST_URI']),DEDEXAM,DEDEAPPTPL,$this->style;
        $data = array(
            'test_one'=>'测试——1',
            'test_two'=>'测试——2',
        );
        $GLOBALS['data'] = $data;
        $this->SetTemplate('index.htm');
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