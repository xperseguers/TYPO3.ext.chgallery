<?php

	/**
	 * user function to replace spaces with rawurlencoded %20
	 * use includeLibs.chgallery = EXT:chgallery/lib/replaceSpaces.php
	 * and call it with stdWrap.postUserFunc = user_trimSpaces	 	 
	 *
	 * @param	string		$file: The file including the path
	 * @param	array		$conf: possible configuration
	 * @return	corrected path+file
	 */
	function user_replaceSpaces($file, $conf) {
		$search = array(' ');
		$replace = array('%20');
		$file = str_replace($search, $replace, $file);
		return $file;
	}

?>