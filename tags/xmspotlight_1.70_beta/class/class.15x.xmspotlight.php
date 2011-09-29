<?php
/**
 *  this is for news 1.5x
 * 
**/

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH.'/modules/news/class/class.newsstory.php';

/**
 * Extends NewsStory (a class in the News Module)
 * Returns published stories according to some options
 * 
**/
class XMspotlightStory extends NewsStory
{
  
/**
 * Returns published stories according to some options
 * 
**/
  function getAllPublishedMore($limit=0, $start=0, $checkRight=false, $topic=0, $ihome=0, $asobject=true, $order = 'published', $topic_frontpage=false, $subs = false)
  {
  //global $xoopsDB;
  	$db =& Database::getInstance();
  	$myts =& MyTextSanitizer::getInstance();
  	$ret = array();
  	
  	$critadd ='';
  	//if subs is true
  	if ($subs == True){

			$sqlz = "SELECT topic_id FROM ".$db->prefix('topics')." WHERE (topic_pid=".intval($topic).")";
  		$resultz = $db->query($sqlz);
  		
  		while ( $topicz = $db->fetchArray($resultz) ) {
          $critadd .= " OR topicid=".intval($topicz['topic_id'])." ";
      }        
     //$critadd .= ")";
    }
  		
    $sql = "SELECT s.*, t.* FROM ".$db->prefix("stories")." s, ". $db->prefix("topics")." t WHERE (published > 0 AND published <= ".time().") AND (expired = 0 OR expired > ".time().") AND (s.topicid=t.topic_id) ";
    if ($topic != 0) {
  	    if (!is_array($topic)) {
  	    	if($checkRight) {
        			$topics = news_MygetItemIds('news_view');
  	    		if(!in_array ($topic,$topics)) {
  	    			return null;
  	    		} else {
  	    			$sql .= " AND (topicid=".intval($topic)." ".$critadd.") AND (ihome=1 OR ihome=0)";
  	    		}
  	    	} else {
  	        	$sql .= " AND topicid=".intval($topic)." AND (ihome=1 OR ihome=0)";
  	        }
  	    } else {
  			if($checkRight) {
  				$topics = news_MygetItemIds('news_view');
  	    		$topic = array_intersect($topic,$topics);
  	    	}
  	    	if(count($topic)>0) {
  	        	$sql .= " AND topicid IN (".implode(',', $topic).")";
  	    	} else {
  	    		return null;
  	    	}
  	    }
  	} else {
  	    if($checkRight) {
  	        $topics = news_MygetItemIds('news_view');
  	        if(count($topics)>0) {
  	        	$topics = implode(',', $topics);
  	        	$sql .= " AND topicid IN (".$topics.")";
  	        } else {
  	        	return null;
  	        }
  	    }
  		if (intval($ihome) == 0) {
  			$sql .= " AND ihome=0";
  		}
  	}
  	if($topic_frontpage) {
  		$sql .=" AND t.topic_frontpage=1";
  	}
  	$sql .= " ORDER BY s.$order DESC";
  	$result = $db->query($sql,intval($limit),intval($start));
  
  	while ( $myrow = $db->fetchArray($result) ) {
  		if ($asobject) {
  			$ret[] = new NewsStory($myrow);
  		} else {
  			$ret[$myrow['storyid']] = $myts->htmlSpecialChars($myrow['title']);
  		}
  	}
  
  	return $ret;
	}

}

?>
