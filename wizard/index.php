<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Georg Ringer <g.ringer@cyberhouse.at>
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


    // DEFAULT initialization of a module [BEGIN]
$BACK_PATH = '../../../../typo3/';
define('TYPO3_MOD_PATH', '../typo3conf/ext/chgallery/wizard/');


// by RICC
if (!ereg('typo3conf', $_SERVER['PHP_SELF'])) {
  $BACK_PATH = '../../../';
  define('TYPO3_MOD_PATH', 'ext/chgallery/wizard/');
} else {
  $BACK_PATH = '../../../../typo3/';
  define('TYPO3_MOD_PATH', '../typo3conf/ext/chgallery/wizard/');
}
// end by RICC

$MCONF['name']='xMOD_tx_chgallery_wizard';
$MCONF['script']='index.php';

require_once ($BACK_PATH.'init.php');
require_once(t3lib_extMgm::extPath('chgallery').'lib/class.tx_chgallery_utility.php');
$LANG->includeLLFile('EXT:chgallery/wizard/locallang.xml');

    // ....(But no access check here...)
    // DEFAULT initialization of a module [END]



/**
 * chgallery module tx_chgallery_image_aassawiz0
 *
 * @author    Georg Ringer <g.ringer@cyberhouse.at>
 * @package    TYPO3
 * @subpackage    tx_chgallery
 */

class tx_chgallery_wizard extends t3lib_SCbase {

    /**
     * Main function of the wizard: Displays all images of a dir
     *
     * @return  string the wizards content
     */
    function moduleContent()    {
      global $LANG;
			$vars = t3lib_div::_GET('P');
			
			// error checks
			$error = array();
			// check if CE has been saved once!
			if (intval($vars['uid'])==0) {
				$error[] = $LANG->getLL('error-neversavesd');
			} else {
					// get the single record
				$where = 'uid='.intval($vars['uid']).' AND deleted=0';
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tt_content', $where);
				$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				
				// get a lanuage prefix for the description
				$this->languagePrefix = ($row['sys_language_uid']>0) ? '-'.$row['sys_language_uid'] : '';
				
					// read the flexform settings and transform it to array
				$flexformArray = t3lib_div::xml2array($row['pi_flexform']);
				$flexformArray = $flexformArray['data']['sDEF']['lDEF'];

					// get all the infos we need
				$path 						= $this->checkPath(trim($flexformArray['path']['vDEF']));
				$pagebrowser 			= $flexformArray['pagebrowser']['vDEF'];
				$show				 			= $flexformArray['show']['vDEF'];
			}
			
			if ($path=='') {
				$error[] = $LANG->getLL('error-path');
			} 
			
			// any error occured?
			if (count($error)>0) {
				foreach ($error as $single) {
    			$errors.= '<li>'.$single.'</li>';
    		}
				$content.= '<h2>'.$LANG->getLL('error-header').'</h2>
										<div style="padding:10px;margin:10px;border:1px solid darkorange;font-style:bold;">
											<ul>'.$errors.'</ul>
										</div>	
										<a href="javascript:close();">'.$LANG->getLL('close').'</a>
				'; 
			} else {				
	      
				// get all the images from the directory
				$fileTypes = 'jpg,gif,png';
								
#				$imageList = t3lib_div::getFilesInDir(PATH_site.$path, $fileTypes,1,1);
				$imageList = t3lib_div::getAllFilesAndFoldersInPath (array(), PATH_site.$path, $fileTypes, 0, 1);

				// correct sorting
				array_multisort($imageList, SORT_ASC);

				$content.= '<h2>'.sprintf($LANG->getLL('images'), count($imageList), $path).'</h2>'.$LANG->getLL('description');				
	      /*
	       * save
	       */	       
				$this->save($imageList);
				
				// create the textarea & preview for every image
				$i=0;		
				$directoryList = array();	
				foreach ($imageList as $key=>$singleImage) {
					$thumb = $this->getThumbNail($singleImage, 100);
					if ($show=='LIST') {
						$fileName = str_replace(PATH_site, '', $singleImage);
						$directory = dirname(str_replace($path, '', $fileName));
					} else {
						$fileName =  basename($singleImage);
						$directory = $path;
					} 
					$desc = $this->getSingleDescription($singleImage);
					if ($directory!='.') {
						$directoryList[$directory] .= '<tr class="'.($i++ % 2==0 ? 'bgColor3' : 'bgColor4').'">
													<td align="center">'.$thumb.'</td>
													<td>#'.$i.': <strong>'.$fileName.'</strong><br /><br />
															<textarea style="width:330px;" rows="2"  name="dir['.$key.']">'.$desc.'</textarea></td>
												</tr>';
						
							// display a cutting line to show where a new page would begin
						if ($pagebrowser>0 && $i%$pagebrowser==0) {
						$directoryList[$directory].= '<tr>
													<td colspan="2" align="center"><strong>- - - - - - - - - - - - &#9985; - - - - - - - - - - - - - - - - - - - &#9985; - - - - - - - - - - - -</strong></td>
												</tr>';
						}
					}
	
				}
				
				// ouput every directory including a header to toggle all images of the directory
				$i=0;
				$hide = ($show=='LIST') ? 'none' : 'block';				
				foreach ($directoryList as $key=>$value) {
					$content.= '<div onclick="toggle(\'item'.$i.'\')" style="font:weight:bold;cursor:pointer;background:#ccc;border:1px solid #333;margin-top:10px;padding:2px 5px;">
												<span style="margin:0 10px 0 5px;font-weight:bold;" id="icon'.$i.'">+</span>'.$key.'
											</div>
											<div id="item'.$i.'" style="border:1px solid #ccc;padding:0px;margin:5px;display:'.$hide.';">
											<table cellpadding="1" cellspacing="1" class="bgColor4" width="100%" id="el">
											'.$value.'
											</table></div>';	
											$i++;	
				}				

				// wrap the form around				
				list($rUri) = explode('#',t3lib_div::getIndpEnv('REQUEST_URI'));				
					// save the image titles, popup will be closes after submit
				$content = '
					<form action="" action="'.htmlspecialchars($rUri).'" method="post" name="editform">
						'.$content.'
						<div id="send" style="margin:5px 10px;">
							<input type="submit" value="'.$LANG->getLL('save2').'" />
							<br /><br /><a href="javascript:close();" >'.$LANG->getLL('close').'</a>
						</div>
					</form>
				';
			}

			// return everything
			$this->content.=$this->doc->section('',$content,0,1);
    }

		/**
		 * Save the descriptions to the txt file
		 *
		 * @param string	The file
		 * @return string	The image-tag
		 */
		function save($imageList) {
			$saveVars = t3lib_div::_POST('dir');   
      if(count($saveVars)>0) {
				foreach ($imageList as $key=>$value) {
					t3lib_div::writeFile($value.$this->languagePrefix.'.txt',$saveVars[$key]);
				}					
			}					
		}


		/**
		 * Get the description of a file which is saved in a txt file with the same name.
		 *
		 * @param string	$file The file
		 * @return string	The description
		 */
		function getSingleDescription($file) {
			$file = $file.$this->languagePrefix.'.txt';
			if (is_file($file)) {
				$text = file_get_contents($file);
			}		
			return $text;
		}

		/**
		 * Check the path for a secure and valid one
		 *
		 * @param	string		$path: Path which is checked
		 * @return	string	valid path
		 */	
		function checkPath($path) {
			$path = trim($path);

			$path = tx_chgallery_utility::convertFalPath($path);

			if (!t3lib_div::validPathStr($path)) {
				return '';
			}
			
			if (substr($path,-1)!='/') { // check for needed / at the end
	      $path =  $path.'/';
			}
			
			if (substr($path, 0, 1) =='/') { // check for / at the beginning
				$path = substr($path, 1, -1);
			}
	
			return $path;
		}

		/**
		 * Returns a Thumbnail with maximum dimension of 100pixels
		 *
		 * @param string	The file
		 * @return string	The image-tag
		 */
		function getThumbNail($file, $size=100) {
			global $BACK_PATH;
			return t3lib_BEfunc::getThumbNail($BACK_PATH.'thumbs.php', $file, '', $size);
		}
	

    /**
     * Adds items to the ->MOD_MENU array. Used for the function menu selector.
     *
     * @return    [type]        ...
     */
    function menuConfig()    {
        global $LANG;
        $this->MOD_MENU = Array (
            'function' => array (
                '1' => $LANG->getLL('function1'),
            )
        );
        parent::menuConfig();
    }

    /**
     * Main function of the module. Write the content to $this->content
     *
     * @return    [type]        ...
     */
    function main()    {
        global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		  	$P = $var = t3lib_div::_GP('P');
		  
            // Draw the header.
        $this->doc = t3lib_div::makeInstance('mediumDoc');
        $this->doc->backPath = $BACK_PATH;

            // JavaScript
        $this->doc->JScode = '
            <script language="javascript" type="text/javascript">
                script_ended = 0;
                function jumpToUrl(URL)    {
                    document.location = URL;
                }
								function toggle(obj) {
									var el = document.getElementById(obj); 
									if ( el.style.display != "none" ) {
										el.style.display = "none";
									}
									else {
										el.style.display = "";
									}
								}                
            </script>
        ';

        $this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
        $access = is_array($this->pageinfo) ? 1 : 0;
        if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id) || ($BE_USER->user["uid"] && !$this->id))    {
            if ($BE_USER->user['admin'] && !$this->id)    {
                $this->pageinfo = array(
                        'title' => '[root-level]',
                        'uid'   => 0,
                        'pid'   => 0
                );
            }

            $headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'
                    .$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_cs($this->pageinfo['_thePath'], 50);

            $this->content.=$this->doc->startPage($LANG->getLL('title'));

            // Render content:
            $this->moduleContent();

        }
        $this->content.=$this->doc->spacer(10);
    }

    /**
     * [Describe function...]
     *
     * @return    [type]        ...
     */
    function printContent()    {
        $this->content.=$this->doc->endPage();
        echo $this->content;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/chgallery/wizard/index.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/chgallery/wizard/index.php']);
}

// Make instance:
$SOBE = t3lib_div::makeInstance('tx_chgallery_wizard');
$SOBE->init();

$SOBE->main();
$SOBE->printContent();

?>