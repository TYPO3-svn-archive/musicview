<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';

t3lib_extMgm::addPlugin(array('LLL:EXT:musicview/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');


#t3lib_extMgm::addStaticFile($_EXTKEY,"pi1/static/","Music Overview from Last.fm");
#t3lib_extMgm::addStaticFile($_EXTKEY,"static/typoscript/","Music Overview from Last.fm");
#t3lib_extMgm::addStaticFile($_EXTKEY,"static/typoscript/", "Music Overview from Last.fm");

t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds_pi1.xml');

if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_musicview_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_musicview_pi1_wizicon.php';




t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key,pages';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi2']='pi_flexform';

t3lib_extMgm::addPlugin(array('LLL:EXT:musicview/locallang_db.xml:tt_content.list_type_pi2', $_EXTKEY.'_pi2'),'list_type');


#t3lib_extMgm::addStaticFile($_EXTKEY,"pi2/static/","Music Overview Search");
#t3lib_extMgm::addStaticFile($_EXTKEY,"static/typoscript/","Music Overview Search");
#t3lib_extMgm::addStaticFile($_EXTKEY,"static/typoscript/", "Music Overview Search");

t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi2', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds_pi2.xml');

if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_musicview_pi2_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi2/class.tx_musicview_pi2_wizicon.php';

#t3lib_extMgm::addStaticFile($_EXTKEY,'static/typoscript/', 'typoscript');
?>
