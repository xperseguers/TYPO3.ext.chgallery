<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Georg Ringer <http://www.ringer.it/>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


require_once(t3lib_extMgm::extPath('realurl', 'class.tx_realurl_advanced.php'));

class tx_chgallery_realurl {


	/**
	 * Generates additional RealURL configuration and merges it with provided configuration
	 *
	 * @param	array		$params	Default configuration
	 * @param	tx_realurl_autoconfgen		$pObj	Parent object
	 * @return	array		Updated configuration
	 */
	function addChgalleryConfig($params, &$pObj) {
		return array_merge_recursive($params['config'],
						array(
							'postVarSets' => array(
								'_DEFAULT' => array(
									'galerie' => array(
										array(
											'GETvar' => 'tx_chgallery_pi1[pointer]',
										),
										array(
											'GETvar' => 'tx_chgallery_pi1[dir]',
										),
										array(
											'GETvar' => 'tx_chgallery_pi1[single]',
										),
										array(
											'GETvar' => 'tx_chgallery_pi1[ceid]',
										),
									),
								),
							),
							'fileName' => array (
								'index' => array(
									'chgallery.rss' => array(
										'keyValues' => array (
											'type' => 9713,
										),
									),
								),
							),
						),
					);

	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/chgallery/lib/class.tx_chgallery_realurl.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/chgallery/lib/class.tx_chgallery_realurl.php']);
}

?>
