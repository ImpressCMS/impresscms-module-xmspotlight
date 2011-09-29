<?php

//include_once XOOPS_ROOT_PATH."/modules/news/class/class.newsstory.php";

include_once XOOPS_ROOT_PATH.'/modules/news/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/xmspotlight/include/functions.php';

	
function xmspotlight_show_news($options)
{
	global $xoopsDB,$xoopsConfig, $module_handler;
	$XMSCATNUM = $options[2]; //For Number Of Categories To Show
	$XMSNEWSITEMS = $options[3]; //For Number Of Items Per Category To Show

  
  	//gotta do a check for which version of news is running so use right function
  	if (!isset($module_handler)){
  		$module_handler =& xoops_gethandler('module');
  	}
  	
  	$news_modinfo =& $module_handler->getByDirname('news');
    $news_modversion = $news_modinfo->getVar( 'version' );
	
//	if (substr($news_modversion,0,2) == 15)
//	{
	  	$xmspotdateformat = news_getmoduleoption('dateformat'); 
		include_once XOOPS_ROOT_PATH."/modules/xmspotlight/class/class.15x.xmspotlight.php";
//	}else{//Gets The Date Format Used By The News Module 	
//		$xmspotdateformat = getmoduleoption('dateformat'); 
//		include_once XOOPS_ROOT_PATH."/modules/xmspotlight/class/class.14x.xmspotlight.php";
//	}
	//$xmspotdateformat = "M/d/Y"; // check php manual for date format
	
  	//Loads the language file based on what language is selected in xoopsconfig .. might not need.
	/*if (file_exists(XOOPS_ROOT_PATH.'/modules/xmspotlight/language/'.$xoopsConfig['language'].'/main.php')) {
	   include_once XOOPS_ROOT_PATH.'/modules/xmspotlight/language/'.$xoopsConfig['language'].'/main.php';
  	} else {
	   include_once XOOPS_ROOT_PATH.'/modules/xmspotlight/language/english/main.php';
  	}*/

  	$block = array();
	// Ambil settings untuk xmspotlight
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE  xmspotlight_id = 1";
	$news2spot = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$txt = explode("|",$news2spot['xmspotlight_sid']);

	$news = array();
	$storyarray = XMspotlightStory::getAllPublished(); //thats a lot of things
	$news = '';
				foreach($storyarray as $article)
			{
					if(in_array($article->storyid(),$txt)){
					$xt = new NewsTopic($article->topicid());
          //$news['image'] = $xt->topic_imgurl("S");
          //$news['imgpath'] = XOOPS_URL."/modules/news/images/topics/";  	
          
            switch($options[0]) {
            case 0: //"Don't Show Image" => 0
               $news['image']= "";
               break;
            case 1: //"Show Topic Image" => 1
               $spotimage = XOOPS_URL."/modules/news/images/topics/".$xt->topic_imgurl("S");
               $news['image']= '<img src="'.$spotimage.'" align="left" style="margin: 8px;">';
               break;
            case 2: //"Show Spotlight Image" => 2
              $id = (int) $article->storyid();
              $sql= "SELECT imgspotlight FROM ".$xoopsDB->prefix('stories')." WHERE storyid = ".$id;
              $img2spot = $xoopsDB->fetchArray($xoopsDB->query($sql));	
               $spotimage= $img2spot['imgspotlight'];//database url.
               
               $news['image']= '<img src="'.$spotimage.'" align="left" style="margin: 8px;">';
               break;
            default :  //if all else fails
               $news['image']= "";
            }
          
          //use a specified spotlight image or if set to not show then dont show one.
          //image manager and a url field.
				$news['hometext'] = $article->hometext();
				$news['storyid'] = $article->storyid();
			    $news['posttime'] = formatTimestamp($article->published(),$xmspotdateformat);
			    //$news['newstitle'] = "<a href=\"".XOOPS_URL."/modules/news/article.php?storyid=".$article->storyid()."\">".$article->title()."</a>";
			    $news['newstitle']= $article->textlink()."&nbsp;:&nbsp;<a href=\"".XOOPS_URL."/modules/news/article.php?storyid=".$article->storyid()."\">".$article->title()."</a>";
			    $news['print'] = "<a target=\"_blank\" href=\"".XOOPS_URL."/modules/news/print.php?storyid=".$article->storyid()."\"><img src=\"".XOOPS_URL."/modules/xmspotlight/images/print.gif\"></a>";
			    $news['makepdf'] = "<a target=\"_blank\" href=\"".XOOPS_URL."/modules/news/makepdf.php?storyid=".$article->storyid()."\"><img src=\"".XOOPS_URL."/modules/xmspotlight/images/pdf.gif\"></a>";
			    $news['send'] = "<a target=\"_blank\" href=\"#\"><img src=\"".XOOPS_URL."/modules/xmspotlight/images/friend.gif\"></a>";
			    //$news['poster'] = xoops_getLinkedUnameFromId(intval($article->uid()));
          //the poster will show the username or real name depending on the settings in the news module
          //gotta add a new row in the table
          $news['poster'] = $article->uname();
 						if ( $news['poster'] ) {
  					$news['posterid'] = $article->uid();
   					$news['poster'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$news['posterid'].'">'.$news['poster'].'</a>';
						} else {
    				$news['poster'] = '';
    				$news['posterid'] = 0;
      				 if(news_getmoduleoption('displayname')!=3) {
    					 $news['poster'] = $xoopsConfig['anonymous'];
    				   }
						} 
					$news['readmore'] = "<a href=\"".XOOPS_URL."/modules/news/article.php?storyid=".$article->storyid()."\">"._MB_XMSPOTLIGHT_READMORE."</a>";
					$news['write'] = "<a href=\"".XOOPS_URL."/modules/news/comment_new.php?com_itemid=".$article->storyid()."\">"._MB_XMSPOTLIGHT_WRITECOMMENT."</a>";
					$news['comments'] = $article->comments()." "._MB_XMSPOTLIGHT_COMMENTS."";
					$block['stories'][] = $news;
					}
			 }
			 
	//current location for the subs checklist will be row 14 in the table
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE  xmspotlight_id = 14";
	$subscat = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$stxt = explode("|",$subscat['xmspotlight_sid']);
  	//end
	
  	$block['showdate'] = $options[4];//1 yes or  0 no
  
    //the new category 1 start
    $sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 2";
    $topic1 = $xoopsDB->fetchArray($xoopsDB->query($sql));
    $xt = new NewsTopic($topic1['xmspotlight_sid']);
	  
	  //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
     	//$block['image5'] = $xt->topic_imgurl("S");
     	switch ($options[1]){ //1 is yes. 0 is no (show images)
      	case 0:
      	$block['image1'] = '';
      	break;
      	case 1:
      	$block['image1'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
      	break;
	     }
    	$block['category1']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
    	$news2 = array();
    	$news2 = '';
      xmspotlightnewslister($block['stories2'],$news2,$txt,$topic1,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);

    
//category 2 start
	
  $sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 3";
	$topic2 = $xoopsDB->fetchArray($xoopsDB->query($sql));
	
	$xt = new NewsTopic($topic2['xmspotlight_sid']);
	//$block['image2'] = $xt->topic_imgurl("S");
	//$block['imgpath2'] = XOOPS_URL."/modules/news/images/topics/";
	
	//subs check
  if(in_array($xt->topic_id(),$stxt )){
  $subs=true;
  }else{$subs=false;}
  
	switch ($options[1]){ //1 is yes. 0 is no (show images)
	case 0:
	$block['image2'] = '';
	break;
	case 1:
	$block['image2'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
	break;
	}
	
	$block['category2']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
		
  $news3 = array();
  $news3 = '';
  xmspotlightnewslister($block['stories3'],$news3,$txt,$topic2,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);

  //### 3rd-4th category start
	if ($XMSCATNUM >= 4){
	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 4";
	$topic3 = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$xt = new NewsTopic($topic3['xmspotlight_sid']);
	//$block['image3'] = $xt->topic_imgurl("S");
	//$block['imgpath3'] = XOOPS_URL."/modules/news/images/topics/";
	
	//subs check
  in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
  
	switch ($options[1]){ //1 is yes. 0 is no (show images)
	case 0:
	$block['image3'] = '';
	break;
	case 1:
	$block['image3'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
	break;
	}
	$block['category3']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
	$news4 = array();
	$news4 = '';
  xmspotlightnewslister($block['stories4'],$news4,$txt,$topic3,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);


	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 5";
	$topic4 = $xoopsDB->fetchArray($xoopsDB->query($sql));
	$xt = new NewsTopic($topic4['xmspotlight_sid']);
	//$block['image4'] = $xt->topic_imgurl("S");
	//$block['imgpath4'] = XOOPS_URL."/modules/news/images/topics/";
	
	//subs check
  in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
  
	switch ($options[1]){ //1 is yes. 0 is no (show images)
	case 0:
	$block['image4'] = '';
	break;
	case 1:
	$block['image4'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
	break;
	}
	$block['category4']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
  $news5 = array();
  $news5 = '';
  xmspotlightnewslister($block['stories5'],$news5,$txt,$topic4,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
  
      if ($XMSCATNUM >= 6){ 
    	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 6";
    	$topic5 = $xoopsDB->fetchArray($xoopsDB->query($sql));
    	$xt = new NewsTopic($topic5['xmspotlight_sid']);
	    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
     	//$block['image5'] = $xt->topic_imgurl("S");
     	switch ($options[1]){ //1 is yes. 0 is no (show images)
      	case 0:
      	$block['image5'] = '';
      	break;
      	case 1:
      	$block['image5'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
      	break;
	     }
    	//$block['imgpath5'] = XOOPS_URL."/modules/news/images/topics/";
    	$block['category5']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
    	$news6 = array();
    	$news6 = '';
      xmspotlightnewslister($block['stories6'],$news6,$txt,$topic5,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
    
    	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 7";
    	$topic6 = $xoopsDB->fetchArray($xoopsDB->query($sql));
    	$xt = new NewsTopic($topic6['xmspotlight_sid']);
    		    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
    	//$block['image6'] = $xt->topic_imgurl("S");
    	//$block['imgpath6'] = XOOPS_URL."/modules/news/images/topics/";
    	switch ($options[1]){ //1 is yes. 0 is no (show images)
      	case 0:
      	$block['image6'] = '';
      	break;
      	case 1:
      	$block['image6'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
      	break;
    	}
    	$block['category6']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
      $news7 = array();
      $news7 = '';
      xmspotlightnewslister($block['stories7'],$news7,$txt,$topic6,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
    
    	
    	
        	if ($XMSCATNUM >=8){ 
        		$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 8";
        	$topic7 = $xoopsDB->fetchArray($xoopsDB->query($sql));
        	$xt = new NewsTopic($topic7['xmspotlight_sid']);
        		    //subs check
          in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
          switch ($options[1]){ //1 is yes. 0 is no (show images)
          	case 0:
          	$block['image7'] = '';
          	break;
          	case 1:
          	$block['image7'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
          	break;
        	}
        	$block['category7']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
        	$news8 = array();
        	$news8 = '';
          xmspotlightnewslister($block['stories8'],$news8,$txt,$topic7,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
        
        	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 9";
        	$topic8 = $xoopsDB->fetchArray($xoopsDB->query($sql));
        	$xt = new NewsTopic($topic8['xmspotlight_sid']);
        		    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
        	switch ($options[1]){ //1 is yes. 0 is no (show images)
          	case 0:
          	$block['image8'] = '';
          	break;
          	case 1:
          	$block['image8'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
          	break;
        	}
        	$block['category8']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
          $news9 = array();
          $news9 = '';
          xmspotlightnewslister($block['stories9'],$news9,$txt,$topic8,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
        
            	if ($XMSCATNUM >=10){ 
            		$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 10";
            	$topic9 = $xoopsDB->fetchArray($xoopsDB->query($sql));
            	$xt = new NewsTopic($topic9['xmspotlight_sid']);
            		    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
              switch ($options[1]){ //1 is yes. 0 is no (show images)
            	case 0:
              	$block['image9'] = '';
              	break;
              	case 1:
              	$block['image9'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
              	break;
            	}
              $block['category9']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
            	$news10 = array();
            	$news10 = '';
              xmspotlightnewslister($block['stories10'],$news10,$txt,$topic9,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
            
            	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 11";
            	$topic10 = $xoopsDB->fetchArray($xoopsDB->query($sql));
            	$xt = new NewsTopic($topic10['xmspotlight_sid']);
            		    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
              switch ($options[1]){ //1 is yes. 0 is no (show images)
              	case 0:
              	$block['image10'] = '';
              	break;
              	case 1:
              	$block['image10'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
              	break;
            	}
              $block['category10']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
              $news11 = array();
              $news11 = '';
              xmspotlightnewslister($block['stories11'],$news11,$txt,$topic10,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
            
                	if ($XMSCATNUM >=12){ 
                	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 12";
                	$topic11 = $xoopsDB->fetchArray($xoopsDB->query($sql));
                	$xt = new NewsTopic($topic11['xmspotlight_sid']);
                		    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
                  switch ($options[1]){ //1 is yes. 0 is no (show images)
                  	case 0:
                  	$block['image11'] = '';
                  	break;
                  	case 1:
                  	$block['image11'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
                  	break;
                  }
                	$block['category11']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
                	$news12 = array();
                	$news12 = '';
                  xmspotlightnewslister($block['stories12'],$news12,$txt,$topic11,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
                
                	$sql = "SELECT * FROM ".$xoopsDB->prefix('xmspotlight')." WHERE xmspotlight_id = 13";
                	$topic12 = $xoopsDB->fetchArray($xoopsDB->query($sql));
                	$xt = new NewsTopic($topic12['xmspotlight_sid']);
                		    //subs check
      in_array($xt->topic_id(),$stxt ) ? $subs=true : $subs=false;
                	switch ($options[1]){ //1 is yes. 0 is no (show images)
                  	case 0:
                  	$block['image12'] = '';
                  	break;
                  	case 1:
                  	$block['image12'] = '<img src="'.XOOPS_URL.'/modules/news/images/topics/'.$xt->topic_imgurl("S").'"align="left" style="margin: 8px;">';
                  	break;
                	}
                	$block['category12']= "<a href='".XOOPS_URL."/modules/news/index.php?storytopic=".$xt->topic_id()."'>".$xt->topic_title()."</a>";
                  $news13 = array();
                  $news13 = '';
                  xmspotlightnewslister($block['stories13'],$news13,$txt,$topic12,$xmspotdateformat,$XMSNEWSITEMS,$subs,$options);
                
                	}//12
            	}//10
    	   }//8
      }//6
  }//4

	$block['CATNUM']=$XMSCATNUM;//number of categories in the block
	return $block;
}

function xmspotlight_edit_news($options)
{
    global $xoopsDB;
    //$options[0] - Show Spotlight Image/ Topic Image / Or No Image
    //$options[1] - Show Images For Category Items
    //$options[2] - Number Of Categories
    //$options[3] - Amount Of Items Per Category
    //$options[4] - Show/No Show Date In Category
    //$options[5] - Date Format
    //$options[6]
    //$options[7]

    
    //Spotlight Image.
    $form = ""._MB_XMSPOTLIGHT_SPOTIMAGESHOW."&nbsp;<select name='options[0]'>";
    $form .= "<option value='0'";
    if ( $options[0] == "0" ) {
        $form .= " selected='selected'";
    }
    $form .= ">"._MB_XMSPOTLIGHT_NOIMAGE."</option>\n"; //no image

    $form .= "<option value='1'";
    if($options[0] == "1"){
        $form .= " selected='selected'";
    }
    $form .= ">"._MB_XMSPOTLIGHT_TOPICIMAGE."</option>"; //topic image
    
    $form .= "<option value='2'";
    if ( $options[0] == "2" ) {
        $form .= " selected='selected'";
    }
    $form .= ">" ._MB_XMSPOTLIGHT_SPOTIMAGE. "</option>"; //spotlight image
    $form .= "</select>\n";

    //Show Category Images
    $form .= "&nbsp;<br /><br />"._MB_XMSPOTLIGHT_CATEGORYIMAGES." <input type='radio' name='options[1]' value='1'";
    if ($options[1] == 1) {
    $form .= " checked='checked'";
    }
    $form .= " />"._YES;
    $form .= "<input type='radio' name='options[1]' value='0'";
    if ($options[1] == 0) {
    $form .= " checked='checked'";
    }
    $form .= " />"._NO.'<br />';
    
          //Number Of Categories To Show
          $form .= "<br />"._MB_XMSPOTLIGHT_CATEGORYSHOW."&nbsp;<select name='options[2]'>";
          $form .= "<option value='2'";
          if ( $options[2] == "2" ) {
              $form .= " selected='selected'";
          }
          $form .= ">2</option>\n"; 
      
          $form .= "<option value='4'";
          if($options[2] == "4"){
              $form .= " selected='selected'";
          }
          $form .= ">4</option>"; 
          
          $form .= "<option value='6'";
          if ($options[2] == "6" ) {
              $form .= " selected='selected'";
          }
          $form .= ">6</option>"; 
          
           $form .= "<option value='8'";
          if ($options[2] == "8" ) {
              $form .= " selected='selected'";
          }
          $form .= ">8</option>"; 
          
           $form .= "<option value='10'";
          if ($options[2] == "10" ) {
              $form .= " selected='selected'";
          }
          $form .= ">10</option>"; 
              
          $form .= "</select>\n";
    
    //Number Of Items In Each Category
    $form .= "<br /><br />"._MB_XMSPOTLIGHT_CATEGORYITEMS."&nbsp;<input type='text' name='options[3]' value='".$options[3]."'/>&nbsp;<br />";
    
    //- Show/No Show Date In Category
    $form .= "&nbsp;<br /><br />"._MB_XMSPOTLIGHT_DATESHOWYESNO." <input type='radio' name='options[4]' value='1'";
    if ($options[4] == 1) {
    $form .= " checked='checked'";
    }
    $form .= " />"._YES;
    $form .= "<input type='radio' name='options[4]' value='0'";
    if ($options[4] == 0) {
    $form .= " checked='checked'";
    }
    $form .= " />"._NO.'<br />';

    return $form;
    
}

?>
