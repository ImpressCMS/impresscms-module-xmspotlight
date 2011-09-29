<?php

include("../../../include/cp_header.php");
include("../include/functions.php");
//does saving and displaying admin section.

$op = ''; 

if (isset($_GET))
{
    foreach ($_GET as $k => $v)
    {
        ${$k} = $v;
    } 
}

global $xoopsModuleConfig;//, $xoopsConfig;

switch ($op)
{
    case 'news':
		xoops_cp_header();
		xmspotlight_adminmenu(1);
		
		$sql = "SELECT dirname FROM " . $xoopsDB->prefix("modules") . " WHERE dirname = 'news' AND isactive='1';"; 
	    $result = $xoopsDB->query($sql);
	
	    if (!$row = $xoopsDB->fetchRow($result)){
	        echo _AM_XMSPOTLIGHT_NEWSERROR;
			xoops_cp_footer();
			exit();
	    }else{
	        xmspotlight_news();
	    } 
	    
		xoops_cp_footer();
	break;
	
	case 'submit':
		$sid = isset($_POST['sid']) ? $_POST['sid'] : '';
		$stid = '';
		
		if(!empty($sid)){
			foreach($sid as $story_id)
			{
				$stid .= $story_id."|";
			}
		}
		
		$sql = sprintf("UPDATE " . $xoopsDB->prefix("xmspotlight") . " SET xmspotlight_sid='" . $stid . "' WHERE xmspotlight_id = 1");
	    $result = $xoopsDB->query($sql);
		
		redirect_header("index.php?op=news",3,_AM_XMSPOTLIGHT_NEWSSPOTTED);
	break;
	
	//Saves The Categories
	case 'submitcat':
		// Gets options from database (settings from the blocks)(needing option2)
		$sql = "SELECT * FROM ".$xoopsDB->prefix('newblocks')." WHERE  name = 'XM-Spotlight News Block'";
		$newsamoutD = $xoopsDB->fetchArray($xoopsDB->query($sql));
		$xmsoptions = explode("|",$newsamoutD['options']);
		$XMSNEWSAMOUNT = $xmsoptions[2];
	
		if ($XMSNEWSAMOUNT >0)
		{
	  		$cat = array();
			$bxadd=1;
		    
		    while($bxadd <= $XMSNEWSAMOUNT){
		    	$cat[$bxadd]= isset($_POST['cat'.$bxadd]) ? $_POST['cat'.$bxadd] : '';
		    	$bxaddp =$bxadd + 1;
		    	$sql = sprintf("UPDATE " . $xoopsDB->prefix("xmspotlight") . " SET xmspotlight_sid='" . $cat[$bxadd] . "' WHERE xmspotlight_id = $bxaddp");
		      	$result = $xoopsDB->query($sql);
		    	$bxadd++;
		    }
	    redirect_header("index.php?op=news",3,_AM_XMSPOTLIGHT_DBUPDATED);
	 	}//else.. do nothing..
 	break;
 	
 	case 'topicsubs':
		$topicids = isset($_POST['topicids']) ? $_POST['topicids'] : '';
		$stopicids = '';
		
		if(!empty($topicids)){
			foreach($topicids as $top_id)
			{
				$stopicids .= $top_id."|";
			}
		}
		
		$sql = "UPDATE " . $xoopsDB->prefix("xmspotlight") . " SET xmspotlight_sid='" . $stopicids . "' WHERE xmspotlight_id = 14";
	  	$result = $xoopsDB->query($sql);
	  	
	  	redirect_header("index.php?op=news",3,_AM_XMSPOTLIGHT_DBUPDATED);
	break;
	
	//save the spotlight images urls.
	//this is where the saving to database goes to.. stories. storyid.. and putting value in 
	//image section. value is the url link for the image
  	case 'submitspotimage';	//save the corresponding story id with the stories imgspotlight field
		$spotid = isset($_POST['spotid']) ? $_POST['spotid'] : '';
	 	if(!empty($spotid)){
	   		foreach($spotid as $story_id => $value)
		  		{
		   			$sql = sprintf("UPDATE " . $xoopsDB->prefix("stories") . " SET imgspotlight ='" . $value . "' WHERE storyid ='". $story_id. "'");
		    		$result = $xoopsDB->query($sql);	
		  		}
	 	}
 	
 		redirect_header("index.php?op=news",3,_AM_XMSPOTLIGHT_NEWSSPOTIMG);
	break;
	
	//Does An 'About The Module'
	case 'about':
    	xoops_cp_header();
    	xmspotlight_adminmenu();
	  	$versioninfo =& $module_handler->get($xoopsModule->getVar('mid'));
	  	// Left headings...
    	echo "<img src='" . XOOPS_URL . "/modules/".$xoopsModule->dirname()."/" . $versioninfo->getInfo('image') . "' alt='' hspace='0' vspace='0' align='left' style='margin-right: 10px;' /></a>";
    	echo "<div style='margin-top: 10px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" . $versioninfo->getInfo('name') . " version " . $versioninfo->getInfo('version') . " (" . $versioninfo->getInfo('status_version') . " Build ". $versioninfo->getInfo('build') .")</div>";

		if( $versioninfo->getInfo('author_realname') != '')
		{
	   		$author_name = $versioninfo->getInfo('author') . " (" . $versioninfo->getInfo('author_realname') . ")";
  		}else{
	   		$author_name = $versioninfo->getInfo('author');
  		}

		echo "<div style = 'line-height: 16px; font-weight: bold; display: block;'>" . _AM_XMSPOTLIGHT_BY . " " . $versioninfo->getInfo('otherauthor');
		echo "</div><div>Modified Version Of The Original XM-Spotlight 1.01 Alpha </div><div style = 'line-height: 16px; font-weight: bold; display: block;'>By:".$author_name."</div>";
		echo "<div style = 'line-height: 16px; display: block;'>" . $versioninfo->getInfo('license') . "</div><br /><br /></>\n";

		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr>";
		echo "<td colspan='2' class='bg3' align='left'><strong>" . _AM_XMSPOTLIGHT_AUTHOR_INFO . "</strong></td>";
		echo "</tr>";
		
		if ( $versioninfo->getInfo('author_realname') != '' )
		{
			echo "<tr>";
			echo "<td class='head' width='150px' align='left'>" ._AM_XMSPOTLIGHT_AUTHOR_NAME . "</td>";
			echo "<td class='even' align='left'>" . $author_name . "</td>";
			echo "</tr>";
		}
		if ( $versioninfo->getInfo('author_website_url') != '' )
		{
			echo "<tr>";
			echo "<td class='head' width='150px' align='left'>" . _AM_XMSPOTLIGHT_AUTHOR_WEBSITE . "</td>";
			echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('author_website_url') . "' target='_blank'>" . $versioninfo->getInfo('author_website_name') . "</a></td>";
			echo "</tr>";
		}
		if ( $versioninfo->getInfo('author_email') != '' )
		{
			echo "<tr>";
			echo "<td class='head' width='150px' align='left'>" . _AM_XMSPOTLIGHT_AUTHOR_EMAIL . "</td>";
			echo "<td class='even' align='left'><a href='mailto:" . $versioninfo->getInfo('author_email') . "'>" . $versioninfo->getInfo('author_email') . "</a></td>";
			echo "</tr>";
		}
		if ( $versioninfo->getInfo('credits') != '' )
		{
			echo "<tr>";
			echo "<td class='head' width='150px' align='left'>" . _AM_XMSPOTLIGHT_AUTHOR_CREDITS . "</td>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('credits') . "</td>";
			echo "</tr>";
		}
		
		if ( $versioninfo->getInfo('otherauthor') != '' )
		{
			echo "<tr>";
			echo "<td class='head' width='150px' align='left'>Modified By:</td>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('otherauthor') . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br />\n";
		
		xoops_cp_footer();
	break;
	
	default:
		xoops_cp_header();
		xmspotlight_adminmenu();
		xoops_cp_footer();
	break;
}

?>