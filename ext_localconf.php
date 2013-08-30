<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY,'editorcfg','
	tt_content.CSS_editor.ch.tx_chgallery_pi1 = < plugin.tx_chgallery_pi1.CSS_editor
',43);


t3lib_extMgm::addPItoST43($_EXTKEY,'pi1/class.tx_chgallery_pi1.php','_pi1','list_type',1);

// RealURL autoconfiguration
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['chgallery'] = 'EXT:chgallery/lib/class.tx_chgallery_realurl.php:tx_chgallery_realurl->addChgalleryConfig';

// here we register "tx_exampleextraevaluations_extraeval1"

$TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals']['tx_chgallery_extraeval'] = 'EXT:chgallery/lib/class.tx_chgallery_extraeval.php';
?>
