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
        $this->lurd = new Lurd('#@__examdossier', $this->temp, $this->temp.'/lurd');
        $this->lurd->appName = "相关设置";
        $this->lurd->isDebug = FALSE;  //开启调试模式后每次都会生成模板
        $this->lurd->stringSafe = 2;  //默认1(只限制不安全的HTML[script、frame等]，0--为不限，2--为不支持HTML
        //获取url
        $this->currurl = GetCurUrl();
        //载入模型
        $this->answer = $this->Model('examanswer');
        $this->question = $this->Model('mquestion');
        $this->style = 'admin';
        $this->type = $this->Model('mtype');
    }

    function ac_index(){
        $this->ac_list();

    }
    
    //列出答案
    function ac_list(){
        $examtp = $this->type->get_examtype("where reid = 0");
        $GLOBALS['examtp'] = $examtp;
        // $this->ac_xmluploadtest();
        $ifcheck = request('ifcheck', '2');
        $examid = request('examid', '');
        if($ifcheck == 0){
            $wherequery = "WHERE ifcheck = 0";
            $this->lurd->SetParameter('ifcheck',0);
        }else if($ifcheck == 1){
            $wherequery = "WHERE ifcheck = 1";
            $this->lurd->SetParameter('ifcheck',1);
        }else{
            $wherequery = "";
        }
        if($examid){
            $wherequery .= "WHERE examid =".$examid;
            $this->lurd->SetParameter('examid',$examid);
        }
        $orderquery = "ORDER BY id DESC ";
        // 指定每页显示数
        $this->lurd->pageSize = 20;
        // 指定某字段为强制定义的类型
        $this->lurd->BindType('dateline', 'TIMESTAMP', 'Y-m-d H:i');
        // 获取数据
        $this->lurd->ListData('id,examid,uid,username,dateline,content,ifcheck', $wherequery, $orderquery);
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
        $ids = request('id', '');
        if(!is_array($ids)){
            ShowMsg('未选择要删除的答案!','-1');
            exit();  
        }
        foreach($ids as $id){
            $id = preg_replace("#[^0-9]#","",$id);
            if($id=="") continue;
            $rs = $this->answer->del($id);
            if(!$rs)
            {
                ShowMsg("删失败！",$this->currurl);
                exit(); 
            }
        }
        $this->question->update();
        ShowMsg("删除成功！",$this->currurl);
        exit(); 
    }

    //监听删除修改等操作
    function ac_listenall(){
        global $ac;
        $ac = request('bc', '');
        $this->lurd->ListenAll();
        exit();
    }

    function ac_xmluploadtest(){
        require_once(DEDEEXAM.'/libraries/XML/xml.class.php');

        //testing by TomSun
        echo "hello testor <br/>";
        echo DEDEEXAM,"<br/>";
        $myXml = new xml();
        var_dump($myXml);
    }

    function ac_upload_xml(){
        require(DEDEINC.'/uploadsafe.inc.php');

        $_REQUEST['reid_level_1'] = request('reid_level_1', '');
        $_REQUEST['reid_level_2'] = request('reid_level_2', '');
        $_REQUEST['title'] = request('title', '');
        // $_REQUEST['upfile1'] = request('upfile1', '');
        $_REQUEST['upfile1'] = $upfile1;

        if(isset(${"upfile1"}) || is_uploaded_file(${"upfile1"})){
            echo "hehe";die();
        }

        $upfile = "upfile1";
        $upfile_name = "upfile1_name";
        if(!isset(${$upfile}) || !isset(${$upfile_name}))
        {
            // continue;
        }
        $upfile = ${$upfile};
        $upfile_name = ${$upfile_name};
        if(is_uploaded_file($upfile))
        {
          echo $file;
          echo $file_name;
      }
      echo $file_name;
      var_dump($_REQUEST);
      echo "<br/>hello up_xml world!";
      die();
  }

  function ac_ajax_get_select(){
    $html = "<option>-请-选-择-</option>";
    $reid = request('reid', '');
    $examtp = $this->type->get_examtype("where reid = ".$reid);
    if(is_array($examtp) && !empty($examtp)){
        foreach($examtp as $key => $val){
           $html .= "<option value='".$val['id']."'>".$val['name']."</option>";
       }
   }
   echo $html;
}
}
?>