<?php

require_once(PATH_t3lib.'class.t3lib_basicfilefunc.php');

class tx_chgallery_extraeval {

	function returnFieldJS() {
		return 'if (value.length==0) return value;
						else {
							if (value.charAt(0)=="/") value = value.slice(1,value.length);
				 			if (value.charAt(value.length-1)!="/") value = value + "/";
			 			}
						
						return value;';
	}
	
	function evaluateFieldValue($path, $is_in, &$set) {
		$path = trim($path);
		
		if ($path=='') {
			return $path;
		}

		if (substr($path,-1,1)!='/') { // check for needed / at the end
      $path =  $path.'/';
		}
		
		if (substr($path, 0, 1) =='/') { // check for / at the beginning
			$path = substr($path, 1, strlen($path));
		}
		
		return $path;	
	}

}

?>
