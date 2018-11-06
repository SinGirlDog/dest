<?php  if(!defined('DEDEINC')) exit("Request Error!");
/**
 * 
 * @version        2011/11/06  Sun $
 *
 **/
 
//EXAM分类
$path = DEDEEXAM."/data/cache/examdossier.inc";
if(file_exists($path)) {
    global $cfg_soft_lang;
    require_once($path);
    $examtypes = unserialize($examdossier);
}else{
    global $dsql;
    $query = "SELECT * FROM `#@__examdossier` ORDER BY id ASC";
    $dsql->Execute('me',$query);
    $tids = $tid2s = $examtypes = array();
    while($examtype = $dsql->getarray())
    {
    	if($examtype['reid'] == 0)
    	{
    		$tids[] = $examtype;
    	}else{
    		$tid2s[] = $examtype;
    	}
    
    }
    foreach($tids as $tid)
    {
    	$examtypes[] = $tid;
    	foreach($tid2s as $key => $tid2)
    	{
    		if($tid2['reid'] == $tid['id'])
    		{
    			$examtypes[] = $tid2;
    			unset($tid2s[$key]);
    		}
    	}
    }
    if(count($examtypes))
    {   
        $row = serialize($examtypes);
        $configstr = "<"."?php\r\n\$examdossiers = '".$row."';";
        file_put_contents($path, $configstr);	
    }
}
?>