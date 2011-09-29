<?php
// $Id: xoops_version.php,v 1.13 2003/04/01 22:51:21 mvandam Exp $
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
// General Info
$modversion['name']         = "XM-Spotlight";
$modversion['dirname']      = "xmspotlight";
$modversion['description']  = "News Spotlight";
$modversion['version']      = "1.70";
$modversion['status_version']	= "Beta3";
$modversion['build']      = "JAN 19,2011";
$modversion['author']       = "SMD";
$modversion['author_realname']  = "Sumardi Shukor(SMD)";
$modversion['author_website_url']  = "http://www.xoopsmalaysia.org";
$modversion['author_website_name']  = "XOOPS Malaysia (XM)";
$modversion['author_email']  = "webmaster@xoopsmalaysia.org";
$modversion['otherauthor']= "Bandit-X";

/*array(
'otherauthor' =>"Bandit-X",
'author_realname'  => "",
'author_website_url'  => "http://www.bandit-x.net",
'author_website_name'  => "Bandit-X.Net // Give Code Life!!",
'author_email'  => "bandit-x@bandit-x.net");*/

$modversion['credits']  = "The thank goes to spotlight module & xoops.org, MyBlocksAdmin By GIJ";
$modversion['license']      = "GNU/GPL";
$modversion['official']     = "No";
$modversion['image']        = "images/logo.gif";
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['onInstall'] = "oninstall.php";
$modversion['onUpdate'] = "oninstall.php";
//==== Main Menu. ====
$modversion['hasMain'] = 0;
// == makes the icon appear in admin ==
$modversion['hasAdmin'] = 1;
// == if button(image) is pushed where the link goes to ==
$modversion['adminindex'] = 'admin/index.php';
// == defines links to the modules admin menu. ==
$modversion['adminmenu'] = 'admin/menu.php';
// == Tables created by sql file (without prefix!) ==
$modversion['tables'][] = "xmspotlight";
// == Templates ==
$modversion['templates'][1]['file'] = 'xmspotlight_imagemanager.html';
$modversion['templates'][1]['description'] = 'Hacked Image Manager Template';
// == Blocks ==
$modversion['blocks'][1]['file'] = 'xmspotlight_block_news.php';
$modversion['blocks'][1]['name'] = 'XM-Spotlight News Block';//Dont Change This Line
$modversion['blocks'][1]['description'] = 'Spotlight - Focus News';
$modversion['blocks'][1]['show_func'] = 'xmspotlight_show_news';
$modversion['blocks'][1]['edit_func'] = 'xmspotlight_edit_news';
$modversion['blocks'][1]['options'] = '0|0|4|5|0';              
    //$options[0] - Show Spotlight Image/ Topic Image / Or No Image
    //$options[1] - Show Images For Category Items
    //$options[2] - Number Of Categories //this was taken out and put in module pref.
    //$options[3] - Amount Of Items Per Category
    //$options[4] - Show/No Show Date In Category    
$modversion['blocks'][1]['template'] = 'news_block_xmspotlight.html';
$modversion['blocks'][1]['can_clone'] = true ;//Clone Block 

//On Update- dont modify settings
//GIJ
if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
include dirname( __FILE__ ) . "/include/onupdate.inc.php" ;
}
?>