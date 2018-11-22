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
        $this->session_rew_check();
        $sdata = $_SESSION[$this->skey];
        $GLOBALS[$this->skey] = $sdata;
        if($sdata['reid']){
            $GLOBALS['filelist'] = $this->mfile->get_allfile($sdata['reid']);
        }
        $this->SetTemplate('show_list.htm');
        $this->Display();
    }

    public function ac_open_file(){
        $this->session_req_check();
        $fileid = request('fileid','');
        $paperid = $this->mpaper->add_paper_by_fileid($fileid);
        if($paperid){
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
        $paper_id = request('paper_id','');
        $only = request('only','');
        $more = request('more','');
        $only_str = implode(',', $only);
        $more_str = json_encode($more);

        $paper_data = $this->mpaper->get_onepaper($paper_id);
        $cankao_choice_only = $this->myexam->get_cankao_answer_byids($paper_data['quest_choice_only']);
        $cankao_choice_more = $this->myexam->get_cankao_answer_byids($paper_data['quest_choice_more']);
        $answer_choice_only = $this->myexam->parse_choice_only_answer($only_str);
        $answer_choice_more = $this->myexam->parse_choice_more_answer($more_str);

        $fenshu_only = $this->correct_fenshu_only($answer_choice_only,$cankao_choice_only);
        $fenshu_more = $this->correct_fenshu_more($answer_choice_more,$cankao_choice_more);
        var_dump($fenshu_only);
        var_dump($fenshu_more);
        die();

        $answer_id = $this->myanswer->add_answer_by_paperid();
        if($answer_id){
            header("Location:./index.php?c=index&a=show_jiexi&answer_id=".$answer_id);
        }
        else{
            ShowMsg("Sorry 答题卡提交失败了！","-1");
        }
    }

    public function ac_show_jiexi(){
        $this->session_rew_check();
        $answer_data = $this->myanswer->get_oneanswer();
        $paper_data = $this->mpaper->get_onepaper($answer_data['paper_id']);
        $quest_choice_only = $this->myexam->get_questions_byids($paper_data['quest_choice_only']);
        $quest_choice_more = $this->myexam->get_questions_byids($paper_data['quest_choice_more']);
        $answer_choice_only = $this->myexam->parse_choice_only_answer($answer_data['answer_choice_only']);
        $answer_choice_more = $this->myexam->parse_choice_more_answer($answer_data['answer_choice_more']);
        $cankao_choice_only = $this->myexam->get_cankao_answer_byids($paper_data['quest_choice_only']);
        $cankao_choice_more = $this->myexam->get_cankao_answer_byids($paper_data['quest_choice_more']);
        $analysis_choice_only = $this->myexam->get_analysis_byids($paper_data['quest_choice_only']);
        $analysis_choice_more = $this->myexam->get_analysis_byids($paper_data['quest_choice_more']);

        $GLOBALS['answer_data'] = $answer_data;
        $GLOBALS['quest_choice_only'] = $quest_choice_only;
        $GLOBALS['quest_choice_more'] = $quest_choice_more;
        $GLOBALS['answer_choice_only'] = $answer_choice_only;
        $GLOBALS['answer_choice_more'] = $answer_choice_more;
        $GLOBALS['cankao_choice_only'] = $cankao_choice_only;
        $GLOBALS['answer_choice_more'] = $answer_choice_more;
        $GLOBALS['analysis_choice_only'] = $analysis_choice_only;
        $GLOBALS['analysis_choice_more'] = $analysis_choice_more;
        // var_dump($answer_choice_more);die();
        $this->SetTemplate('show_jiexi_result.htm');
        $this->Display();
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

    protected function correct_fenshu_only($answer_arr,$cankao_arr){
        $fenshu = 0;
        $times_arr = array();
        $cankao_answer_arr = $cankao_arr['answer'];
        $cankao_id_arr = $cankao_arr['id'];
        foreach($answer_arr as $key => $answer){
            if($answer == $cankao_answer_arr[$key]){
                $fenshu++;
                $times_arr[$cankao_id_arr[$key]] = 'right_times';
            }
            else{
                //count err times
                $times_arr[$cankao_id_arr[$key]] = 'wrong_times';
            }
        }
        //cont answer times
        $this->count_right_or_wrong_times($times_arr);
        
        return $fenshu;
    }

    protected function correct_fenshu_more($answer_arr,$cankao_arr){
        $fenshu = 0;
        $times_arr = array();
        $cankao_answer_arr = $cankao_arr['answer'];
        $cankao_id_arr = $cankao_arr['id'];
        if(is_array($answer_arr[0])){
            foreach($answer_arr as $key => $answer){
                $answer_length = sizeof($answer);
                if($answer_length > 4 or $answer_length < 2){
                    //选项太少或者太多直接零分;
                    $times_arr[$cankao_id_arr[$key]] = 'wrong_times';
                    continue;
                    //count err times
                }
                $cankao_length = sizeof($cankao_answer_arr[$key]);
                $intersect_length = sizeof(array_intersect($answer, $cankao_answer_arr[$key]));
                if( ($answer_length == $cankao_length) && ($intersect_length == $cankao_length) ){
                    //选项完全匹配则满分;
                    $fenshu += 2;
                    $times_arr[$cankao_id_arr[$key]] = 'right_times';
                    continue;
                }
                else{
                    //count err times
                    $times_arr[$cankao_id_arr[$key]] = 'wrong_times';
                }
                $temp_fen = 0;
                foreach($answer as $ans){
                    //选对一个半分;选错一个零蛋;
                    if(in_array($ans,$cankao_answer_arr[$key])){
                        $temp_fen += 0.5;
                    }
                    else{
                        $temp_fen = 0;
                        break;
                    }
                }
                $fenshu += $temp_fen;
            }
        }
        $this->count_right_or_wrong_times($times_arr);
        
        return $fenshu;
    }

    protected function count_right_or_wrong_times($times_arr){
        $this->myexam->count_right_or_wrong_times($times_arr);
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