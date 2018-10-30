<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 扩展小助手
 *
 * @version        $Id: extend.helper.php 1 13:58 2010年7月5日Z tianya $
 * @package        DedeCMS.Helpers
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

/**
 *  返回指定的字符
 *
 * @param     string  $n  字符ID
 * @return    string
 */
if ( ! function_exists('ParCv'))
{
  function ParCv($n)
  {
    return chr($n);
  }
}


/**
 *  显示一个错误
 *
 * @return    void
 */
if ( ! function_exists('ParamError'))
{
  function ParamError()
  {
    ShowMsg('对不起，你输入的参数有误！','javascript:;');
    exit();
  }
}

/**
 *  默认属性
 *
 * @param     string  $oldvar  旧的值
 * @param     string  $nv      新值
 * @return    string
 */
if ( ! function_exists('AttDef'))
{
  function AttDef($oldvar, $nv)
  {
    return empty($oldvar) ? $nv : $oldvar;
  }
}


/**
 *  返回Ajax头信息
 *
 * @return     void
 */
if ( ! function_exists('AjaxHead'))
{
  function AjaxHead()
  {
    @header("Pragma:no-cache\r\n");
    @header("Cache-Control:no-cache\r\n");
    @header("Expires:0\r\n");
  }
}

/**
 *  去除html和php标记
 *
 * @return     string
 */
if ( ! function_exists('dede_strip_tags'))
{
	function dede_strip_tags($str) { 
   $strs=explode('<',$str); 
   $res=$strs[0]; 
   for($i=1;$i<count($strs);$i++) 
   { 
     if(!strpos($strs[$i],'>')) 
       $res = $res.'&lt;'.$strs[$i]; 
     else 
       $res = $res.'<'.$strs[$i]; 
   } 
   return strip_tags($res);    
 } 
}



/**
 *  字符串替换;Edit by SunLijia;
 *
 * @param     string  $find  搜索关键字
 * @param     string  $replace  替换的内容
 * @param     string  $strorig  被搜索的字符串
 * @return    string
 */
if ( ! function_exists('MyStrReplace'))
{
  function MyStrReplace($find='',$replace='',$strorig='')
  {
    return str_replace ($find, $replace, $strorig);
  }
}


/**
 *  子站position截取;Edit by SunLijia;
 *
 * @param     string  $position  原位置
 * @return    string
 */
if ( ! function_exists('MySecPos'))
{
  function MySecPos($position)
  {
    $new_arr = array();
    $pos_arr = explode(' > ', $position);
    array_shift($pos_arr);//删除第一个栏目
    if(sizeof($pos_arr) > 2){//如果存在三级栏目
      $new_arr[] = array_shift($pos_arr);
      array_shift($pos_arr);//删除MEM子站的二级栏目
      $new_arr[] = array_shift($pos_arr);
    }
    else{
      $new_arr = $pos_arr;
    }
    $new_position = implode(' > ', $new_arr);

    return $new_position;
  }
}


/**
 *  子站文章title关键字替换;Edit by SunLijia;
 *
 * @param     string  $title  原标题
 * @param     string  $replace  替换
 * @return    string
 */
if ( ! function_exists('TitleReplace'))
{
  function TitleReplace($replace,$title)
  {
    $find_emba = 'EMBA';
    $replace_emba = '!@#$';
    $find_mba='MBA';

    $title = str_replace($find_emba,$replace_emba, $title);
    $title = str_replace ($find_mba, $replace, $title);
    $new_title = str_replace ($replace_emba, $find_emba, $title);

    return $new_title;
  }
}

/**
 *  太奇名师-手机站-title截取冒号之后的人名;Edit by SunLijia;
 *
 * @param     string  $title  原标题
 * @return    string
 */
if ( ! function_exists('TeachersName'))
{
  function TeachersName($title)
  {
    $title_arr = explode("：",$title);
    if($title_arr[1]){
      $name = $title_arr[1];
    }
    else{
      $name = $title_arr[0];
    }
    return $name;
  }
}

/**
 *  移动端position截取;Edit by SunLijia;
 *
 * @param     string  $position  原位置
 * @return    string
 */
if ( ! function_exists('MySecPos_mobile'))
{
  function MySecPos_mobile($position)
  {
    $position = MySecPos($position);
    $new_position = MyStrReplace('手机','首页',$position);
    return $new_position;
  }
}

/**
 *  子站position截取&结合目录名称替换;Edit by SunLijia;
 *
 * @param     string  $find_str  搜索关键字(被替换的路径);
 * @param     string  $replace_str  替换的内容(根目录的‘/’);
 * @param     string  $position  被搜索的字符串(position字符串);
 * @return    string
 */
if ( ! function_exists('MySecPosAndStrReplace'))
{
  function MySecPosAndStrReplace($find_str='',$replace_str='',$position='')
  {
    $new_position = MySecPos($position);
    return MyStrReplace ($find_str, $replace_str, $new_position);
  }
}

/**
 *  子站文章-上一篇-下一篇-title关键字替换以及目录的替换;Edit by SunLijia;
 *
 * @param     string  $find_str  搜索关键字(被替换的路径);
 * @param     string  $replace_str  替换的内容(根目录的‘/’);
 * @param     string  $prenext  原标题+链接URL
 * @param     string  $replace  替换
 * @return    string
 */
if ( ! function_exists('MyStrReplaceAndTitleReplace'))
{
  function MyStrReplaceAndTitleReplace($find_str,$replace_str,$replace,$prenext)
  {
    $new_prenext = MyStrReplace ($find_str, $replace_str, $prenext);
    return TitleReplace($replace,$new_prenext);
  }
}