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

/** xmspotlight onInstall Function . Used in xoops_version.php at module install time
 *
**/ 
function xoops_module_install_xmspotlight(&$module){	
	global $xoopsDB;

	//add field in stories table for link to img for article or spotlight.
	if (!FieldExists('imgspotlight',$xoopsDB->prefix('stories'))) {
  	$sql = sprintf("ALTER TABLE ".$xoopsDB->prefix('stories'). " ADD imgspotlight varchar(255) NOT NULL default ' ' ");	
    $result =	$xoopsDB->query($sql);
	}
	
	//add field in stories table for text for img credits
	if (!FieldExists('imgauthor',$xoopsDB->prefix('stories'))) {
  	$sql = sprintf("ALTER TABLE ".$xoopsDB->prefix('stories')." ADD imgauthor varchar(255) NOT NULL default ' ' ");
  	$result = $xoopsDB->query($sql);
	}
return true;
}

//on update.. run the onInstall script
function xoops_module_update_xmspotlight(&$module){	
	global $xoopsDB;

	//add field in stories table for link to img for article or spotlight.
	if (!FieldExists('imgspotlight',$xoopsDB->prefix('stories'))) {
  	$sql = sprintf("ALTER TABLE ".$xoopsDB->prefix('stories'). " ADD imgspotlight varchar(255) NOT NULL default ' ' ");	
    $result =	$xoopsDB->query($sql);
	}
	
	//add field in stories table for text for img credits
	if (!FieldExists('imgauthor',$xoopsDB->prefix('stories'))) {
  	$sql = sprintf("ALTER TABLE ".$xoopsDB->prefix('stories')." ADD imgauthor varchar(255) NOT NULL default ' ' ");
  	$result = $xoopsDB->query($sql);
	}
return true;
}

/**
 * Taken from News Module.
 * Description: Checks if field exists in a table 
**/
function FieldExists($fieldname,$table)
{
	global $xoopsDB;
	$result=$xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
	return($xoopsDB->getRowsNum($result) > 0);
}
?>
