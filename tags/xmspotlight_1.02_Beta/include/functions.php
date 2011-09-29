<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH."/class/xoopsstory.php";
include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
include_once XOOPS_ROOT_PATH.'/modules/news/include/functions.php';

//include_once(XOOPS_ROOT_PATH . '/modules/news/class/class.newsstory.php');
//include_once(XOOPS_ROOT_PATH . '/modules/xmspotlight/class/class.14x.xmspotlight.php');
include_once(XOOPS_ROOT_PATH . '/modules/news/class/class.newstopic.php');

	$module_handler =& xoops_gethandler('module');
  	$news_modinfo =& $module_handler->getByDirname('news');
    $news_modversion = $news_modinfo->getVar( 'version' );
	if (substr($news_modversion,0,2) == 15)
	{
		include_once XOOPS_ROOT_PATH."/modules/xmspotlight/class/class.15x.xmspotlight.php";
	}else{	
		include_once XOOPS_ROOT_PATH."/modules/xmspotlight/class/class.14x.xmspotlight.php";
	}

/**
 * Function used to display an horizontal menu inside the admin panel
 *
 * Enable webmasters to navigate thru the module's features.
 * Each time you select an option in the admin panel of the news module, this option is highlighted in this menu
 *
 * @package News
 * @author - stolen to the Newbb team ;-)
 * @copyright	(c) The Xoops Project - www.xoops.org
*/
function xmspotlight_adminmenu($currentoption = 0, $breadcrumb = '')
{
	/* Nice buttons styles */
	global $xoopsModule, $xoopsConfig;
	
	echo "
    <style type='text/css'>
    #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    #buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    #buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
	#buttonbar li { display:inline; margin:0; padding:0; }
	#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
	#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/".$xoopsModule->getVar('dirname')."/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
	/* Commented Backslash Hack hides rule from IE5-Mac \*/
	#buttonbar a span {float:none;}
	/* End IE5-Mac hack */
	#buttonbar a:hover span { color:#333; }
	#buttonbar #current a { background-position:0 -150px; border-width:0; }
	#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
	#buttonbar a:hover { background-position:0% -150px; }
	#buttonbar a:hover span { background-position:100% -150px; }
	</style>
    ";

	$tblColors = Array_Fill(0,8,'');
	
  if($currentoption>=0) {
		$tblColors[$currentoption] = 'current';
	}

	/*if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH. '/modules/'.$xoopsModule->getVar('dirname').'/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/english/modinfo.php';
	}*/

	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
//	echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."\">" . _AM_XMSPOTLIGHT_GENERALSET . "</a> | <a href=\"index.php?op=about\">" . _AM_XMSPOTLIGHT_HELP . "</a> | <a href=\"../../system/admin.php?fct=modulesadmin&op=update&module=xmspotlight\"> "._AM_XMSPOTLIGHT_ADMENU6."</a></td>";
	echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a href=\"index.php?op=about\">" . _AM_XMSPOTLIGHT_HELP . "</a> | <a href=\"../../system/admin.php?fct=modulesadmin&op=update&module=xmspotlight\"> "._AM_XMSPOTLIGHT_ADMENU6."</a></td>";
  	echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b><a href=\"index.php\">" . $xoopsModule->name() . "  " . _AM_XMSPOTLIGHT_MODULEADMIN . "</a></b> " . $breadcrumb . "</td>";
	echo "</tr></table>";
	echo "</div>";
	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='" . $tblColors[1] . "'><a href=\"index.php?op=news\"\"><span>"._AM_XMSPOTLIGHT_ADMENU2 ."</span></a></li>\n";
//  echo "<li id='" . $tblColors[2] . "'><a href=\"index.php?op=preferences\"\"><span>"._AM_XMSPOTLIGHT_ADMENU3 ."</span></a></li>\n";
	echo "</ul></div>";
	echo "<br /><br /><pre>&nbsp;</pre><pre>&nbsp;</pre>";
}

/** 
 * Gets All Published And The Subs (1x level.)
 * Function Used To Assign Values For Block.
 * 
 * Used In The XM-Spotlight Block 
**/
function xmspotlightnewslister($blockstory,$newsstory,$txt,$thetopic,$dateformat,$start=5, $subs=false, $options = False)
{
  $bx=0;
  $bxstoryarray= XMspotlightStory::getAllPublishedMore($start, 0, 1, $thetopic['xmspotlight_sid'], 0, true, 'published',false, $subs);
	if ($options[4] == true){
      	foreach($bxstoryarray as $article2)
    	{
    		if(!in_array($article2->storyid(),$txt)){
      			$newsstory['newstitle'] = $article2->title();
          		$newsstory['storyid'] = $article2->storyid();
      			$newsstory['posttime'] = "(".formatTimestamp($article2->published(),$dateformat).")";
          		$blockstory[] = $newsstory;
    		}else{
          		$bx++;
        	}
      	}
      
      if ($bx>0){
      	//we run it. get more . starting at the last item
      	$bxstoryarraymore= XMspotlightStory::getAllPublishedMore($bx, $start, 1, $thetopic['xmspotlight_sid'], 0, true, 'published',false, $subs); 	
        foreach($bxstoryarraymore as $article2)	{
    		if(!in_array($article2->storyid(),$txt)){
      			$newsstory['newstitle'] = $article2->title();
          		$newsstory['storyid'] = $article2->storyid();
      			$newsstory['posttime'] = "(".formatTimestamp($article2->published(),$dateformat).")";
      			$blockstory[] = $newsstory;
          	}
        }
      }
  }else{//no story time
        foreach($bxstoryarray as $article2)
    	{
    		if(!in_array($article2->storyid(),$txt)){
      			$newsstory['newstitle'] = $article2->title();
          		$newsstory['storyid'] = $article2->storyid();
      			$newsstory['posttime'] = "&nbsp;";
          		$blockstory[] = $newsstory;
    		}else{
          		$bx++;
        	}
      	}
    
      if ($bx>0){
      	//we run it. get more . starting at the last item
      	$bxstoryarraymore= XMspotlightStory::getAllPublishedMore($bx, $start, 1, $thetopic['xmspotlight_sid'], 0, true, 'published',false, $subs); 	
        	foreach($bxstoryarraymore as $article2)	{
    			if(!in_array($article2->storyid(),$txt)){
      				$newsstory['newstitle'] = $article2->title();
          			$newsstory['storyid'] = $article2->storyid();
      				$newsstory['posttime'] = "&nbsp;";
      				$blockstory[] = $newsstory;
          		}
       	 	}
      }
  //end no story time
  }
} 


/**
 * Function Used To Display Last 10 Published News Articles
 * 
 * Used In News Spotlight Admin Section  
*/
function xmspotlight_news()
{
	global $xoopsDB, $xoopsModule,$xoopsModuleConfig;
	
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE  xmspotlight_id = 1";
	$news2spot = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$txt = explode("|",$news2spot['xmspotlight_sid']);
	$storyarray = NewsStory::getAllPublished(10);//Gets Last 10 Published News Articles
	
	echo "<h4>"._AM_XMSPOTLIGHT_TENLAST."</h4>";
	echo "<form method=\"post\" action=\"".xoops_getenv('PHP_SELF')."?op=submit\">";
  	echo "<table class='outer' cellspacing='1' cellpadding = '2' width='100%'>";
	echo "<tr>";
 	echo "<td class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_ID."</b></td>";
  	echo "<td class='bg3' align='left'><b>"._AM_XMSPOTLIGHT_TITLE."</b></td>";
  	echo "<td class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_CAT."Category</b></td>";
  	echo "<td class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_AUTHOR."</b></td>";
  	echo "<td class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_PUBLISHED."</b></td>";
  	echo "<td class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_ACTION."</b></td>";
  	echo "</tr>";
	
	foreach ($storyarray as $story)
    {
		$published = formatTimestamp($story->published());
    	$topic = $story->topic();
    	echo "<tr>";
    	echo "<td class='head' align='center'><b>" . $story->storyid() . "</b></td>";
    	echo "<td class='even' align='left'><a href=" . XOOPS_URL . "/modules/news/article.php?storyid=" . $story->storyid() . ">" . $story->title() . "</a></td>";
    	echo "<td class='odd' align='center'>" . $topic->topic_title() . "</td>";
    	echo "<td class='even' align='center'><a href=" . XOOPS_URL . "/userinfo.php?uid=" . $story->uid() . ">" . $story->uname() . "</a></td>";
    	echo "<td class='odd' align='center'>" . $published . "</td>";
		
		if(in_array($story->storyid(),$txt)){
			echo "<td class='even' align='center'><input type=\"checkbox\" name=\"sid[".$story->storyid()."]\" value=\"".$story->storyid()."\" checked></td>";
		}else{
			echo "<td class='even' align='center'><input type=\"checkbox\" name=\"sid[".$story->storyid()."]\" value=\"".$story->storyid()."\"></td>";
		}
    	
    	echo "</tr>";
    }
	
  	echo "</table><br /><input type=\"submit\" name=\"submit\" value=\"Submit\"></form><br />";
	
	//spotlight image.(5 images). hmm maybe more.
	
	//check the spotlighted items. storyid
	//loops storyids to display the link from the stories table
	
	//pseudo.. for each spotlighted item.. display imgspotlight data. 
	//(() use an array. imgspotlight array. (new array) since save each item to their ## array
	//(() or have them the array with special keys. text number strings. so they wont get mixed up in the save.
	
  	echo "<h4>"._AM_XMSPOTLIGHT_SPOTIMAGES."</h4>";
	echo "<form method=\"post\" action=\"".xoops_getenv('PHP_SELF')."?op=submitspotimage\">";
  	echo "<table class='outer' cellspacing='1' cellpadding = '2' width='75%'>";
  	echo "<tr>";
  	echo "<td class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_NUMBER."</b></td>";
  	echo "<td class='bg3' align='left'><b>"._AM_XMSPOTLIGHT_IMGLINK."</b></td>";
	echo "</tr>";
	
  	$imgspotlight = array();//array for img spotlight array

	for($counterz = 0; $counterz <= (count($txt) - 2); $counterz ++)
	{
	    $sql= "SELECT imgspotlight FROM ".$xoopsDB->prefix('stories')." WHERE storyid = $txt[$counterz]";
	    $img2spot = $xoopsDB->fetchArray($xoopsDB->query($sql));	
	    $imgspotlight[$counterz] =  $img2spot['imgspotlight'];
	  	echo "<tr>";
	  	echo "<td class='odd' align='center'>".$txt[$counterz]."</td>"; //Image Number
	    //image link.
	   	// echo "<td class='even' align='center'><input type='text' id='spotlightimage' name=\"spotid[".$txt[$counterz]."]\" value='".$imgspotlight[$counterz]."' size='50'/>";
	   	// echo "&nbsp;<img align='middle' onmouseover='style.cursor=\"pointer\"' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/xmspotlight/include/imagemanager.php?target=spotlightimage\",\"imgmanager\",400,430);' src='".XOOPS_URL."/images/image.gif' alt='image' title='image' />";
	   	echo "<td class='even' align='left'><input type='text' id='spotlightimage".$txt[$counterz]."' name=\"spotid[".$txt[$counterz]."]\" value='".$imgspotlight[$counterz]."' size='50'/>";
	   	echo "&nbsp;<img onmouseover='style.cursor=\"pointer\"' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/xmspotlight/include/imagemanager.php?target=spotlightimage".$txt[$counterz]."\",\"imgmanager\",400,430);' src='".XOOPS_URL."/images/image.gif' alt='image' title='image' />&nbsp;</td>";
	    echo "</tr>";
  	}
	
	echo "</table><br /><input type=\"submit\" name=\"submit\" value=\"Submit\"></form><br />";
	
	$xt = new NewsTopic();
	echo "<h4>"._AM_XMSPOTLIGHT_CATSETTING."</h4>";
	echo "<form method=\"post\" action=\"".xoops_getenv('PHP_SELF')."?op=submitcat\">";
  	echo "<table class='outer' cellspacing='1' cellpadding = '2' width='38%'>";
  	echo "<tr>";
  	echo "<th class='bg3' align='center'><b>"._AM_XMSPOTLIGHT_NUMBER."</b></th>";
  	echo "<th class='bg3' align='left'><b>"._AM_XMSPOTLIGHT_CATNAME."</b></th>";
  	//--echo "<td class='bg3' align='center'><b>Inc. Sub-Categories?</b></td>"; //B-X
	echo "</tr>";
		
    
  // Gets option2 from database
	$sql = "SELECT * FROM ".$xoopsDB->prefix('newblocks')." WHERE  name = 'XM-Spotlight News Block'";
	$newsamoutD = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$xmsoptions = explode("|",$newsamoutD['options']);
	$XMSNEWSAMOUNT = $xmsoptions[2];
  // End Get

  //temporary location for the subs checklist will be row 14
  	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE  xmspotlight_id = 14";
	$subscat = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$stxt = explode("|",$subscat['xmspotlight_sid']);
  //end
  
  	$bxadd = 1;
  	while ($bxadd <= $XMSNEWSAMOUNT)
  	{
  		echo "<tr>";
	  	echo "<td class='head' align='center'><b>Category {$bxadd}</b></td>";
	  	echo "<td class='even' align='center'>";
	  	$snumber=$bxadd + 1;
	  	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE  xmspotlight_id = $snumber";
	  	$cat = $xoopsDB->fetchArray($xoopsDB->query($sql));
	  	$topic_select = $xt->MakeMyTopicSelBox(0,$cat['xmspotlight_sid'],"cat".$bxadd);
	  	echo $topic_select;
	  	echo "</td>";
	/*    	if(in_array($cat['xmspotlight_sid'],$stxt)){
	  			echo "<td class='odd' align='center'><input type=\"checkbox\" name=\"scat[".$bxadd."]\" value=\"".$cat['xmspotlight_sid']."\" checked></td>";
	  		}else{
	  			echo "<td class='odd' align='center'><input type=\"checkbox\" name=\"scat[".$bxadd."]\" value=\"".$cat['xmspotlight_sid']."\"></td>";
	  		}*/
	  	echo "</tr>";
	  	$bxadd++;
  	}
	echo "</table><input type=\"submit\" name=\"submit\" value=\"Submit\"></form><br />";
	
//SubCategory Check.
	$idlist = $xt->getTopicsList();//get all topic ids..
	echo "<form method=\"post\" action=\"".xoops_getenv('PHP_SELF')."?op=topicsubs\">";
  	echo "<table class='outer' cellspacing='1' cellpadding = '2' width='38%'>";
  	//list the um..loop and list topics and ids.. then loop the checks
  	echo "<tr>"; 
  	echo "<th>ID/<em>Title</em></th><th>Show SubCategory?</th></tr>";
  	$bxadd = 0;
  	foreach($idlist as $topic_id => $value){

  	echo "<tr><td> ".$topic_id." / <em>".$idlist[$topic_id]['title']."</em> </td>";
  	    	if(in_array($topic_id,$stxt)){
	  			echo "<td class='odd' align='center'><input type=\"checkbox\" name=\"topicids[".$bxadd."]\" value=\"".$topic_id."\" checked></td>";
	  		}else{
	  			echo "<td class='odd' align='center'><input type=\"checkbox\" name=\"topicids[".$bxadd."]\" value=\"".$topic_id."\"></td>";
	  		}
	$bxadd += 1;
	echo "</tr>";
  	}//gotta change the post saving of the checkboxes and the drops..
  	
	echo "</table><input type=\"submit\" name=\"submit\" value=\"Submit\"></form><br />";
//=== END

}

?>