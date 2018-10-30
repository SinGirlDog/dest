<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><div class="header_top">  
    <div class="w960 center">  
     <span id="time" class="time">织梦CMS - 轻松建站从此开始！</span>
     <div class="toplinks"><a href="<?php echo $GLOBALS['cfg_cmsurl']; ?>/plus/heightsearch.php" target="_blank">高级搜索</a>|<a href="<?php echo $GLOBALS['cfg_cmsurl']; ?>/data/sitemap.html" target="_blank">网站地图</a>|<a href="<?php echo $GLOBALS['cfg_cmsurl']; ?>/tags.php">TAG标签</a><a href="<?php echo $GLOBALS['cfg_dataurl']; ?>/rssmap.html" class="rss">RSS订阅</a><span>[<a href=""onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo $GLOBALS['cfg_basehost']; ?>');">设为首页</a>] [<a href="javascript:window.external.AddFavorite('<?php echo $GLOBALS['cfg_basehost']; ?>','<?php echo $GLOBALS['cfg_webname']; ?>')">加入收藏</a>]</span></div>
    </div> 
</div>
<div class="header">
	<div class="top w960 center">
      <div class="title">
        <h1><a href="<?php echo $GLOBALS['cfg_basehost']; ?>"><img src="<?php echo $GLOBALS['cfg_templets_skin']; ?>/images/logo.gif" height="54" width="216" alt="<?php echo $GLOBALS['cfg_webname']; ?>"/></a> </h1>
      </div>
      <div class="banner"><?php
$atts = array();
$atts['tagname'] = 'mda';
$atts['name'] = '468x60_SSP';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{

}
}
?></div>
	</div><!-- //top -->
	<!-- //菜单 -->
	<div class="module blue mT10 wrapper w963">
  	<div class="top">
    	<!-- //如果不使用currentstyle，可以在channel标签加入 cacheid='channeltoplist' 属性提升性能 -->
    <div id="navMenu">
    	<ul>
      	<li><a href='<?php echo $GLOBALS['cfg_cmsurl']; ?>/'><span>主页</span></a></li>
      	<?php
$atts = array();
$atts['tagname'] = 'channel';
$atts['type'] = 'top';
$atts['row'] = '10';
$atts['currentstyle'] = '<li class=\'hover\'><a href=\'~typelink~\' ~rel~><span>~typename~</span></a></li>';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{
?>
      	<li><a href='[field:typeurl/]' [field:rel/]><span>[field:typename/]</span></a></li>
      	<?php
}
}
?>
    	</ul>
    </div>	
    <div class="search">
      <form  name="formsearch" action="<?php echo $GLOBALS['cfg_cmsurl']; ?>/plus/search.php">
        <div class="form">
          <h4>搜索</h4>
           <input type="hidden" name="kwtype" value="0" />
           <input name="q" type="text" class="search-keyword" id="search-keyword" value="在这里搜索..." onfocus="if(this.value=='在这里搜索...'){this.value='';}"  onblur="if(this.value==''){this.value='在这里搜索...';}" />
           <select name="searchtype" class="search-option" id="search-option">
               <option value="title" selected='1'>检索标题</option>
               <option value="titlekeyword">智能模糊</option>
           </select>
          <button type="submit" class="search-submit">搜索</button>
        </div>
        </form>
        <div class="tags">
          <h4>热门标签:</h4>
          <ul>
          <?php
$atts = array();
$atts['tagname'] = 'tag';
$atts['row'] = '10';
$atts['getall'] = '1';
$atts['sort'] = 'month';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{
?>
            <li><a href='[field:link/]'>[field:tag /]</a></li>
          <?php
}
}
?>
          </ul>
        </div>
    </div><!-- //search -->
		</div>
	</div>
</div><!-- //header -->
<div class="banner2 w960 center"><?php
$atts = array();
$atts['tagname'] = 'mda';
$atts['name'] = '950x90_SSP';
$blockValue = MakePublicTag($atts,$this->refObj,$fields); 
if(is_array($blockValue) && count($blockValue) > 0){
foreach( $blockValue as $key=>$fields )
{

}
}
?></div>