<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Torben Hansen <derhansen@gmail.com>, Skyfillers GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

class tx_chgallery_utility {

	/**
	 * If the given path is a FAL path and the storage is local, then the basepath is appended to the path
	 * so it can be used with general file functions in this extension.
	 *
	 * @param $path
	 * @return string
	 */
	public static function convertFalPath($path) {
		if (preg_match('/^file:(\d+):(.*)$/', $path, $matches)) {
			/** @var $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
			$storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
			/** @var $storage \TYPO3\CMS\Core\Resource\ResourceStorage */
			$storage = $storageRepository->findByUid(intval($matches[1]));
			$storageRecord = $storage->getStorageRecord();
			$storageConfiguration = $storage->getConfiguration();
			if ($storageRecord['driver'] === 'Local') {
				$basePath = rtrim($storageConfiguration['basePath'], '/') . '/';
				$path = $basePath . substr($matches[2], 1);
			}
		}
		return $path;
	}
}

?>