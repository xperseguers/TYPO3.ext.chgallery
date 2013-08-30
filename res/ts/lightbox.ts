plugin.tx_chgallery_pi1.gallery.image {
	imageLinkWrap  = 1
	imageLinkWrap {	
		enable = 1
		typolink {
			title.field= tx_chgalleryTitle
			
			parameter.override.cObject = IMG_RESOURCE
			parameter.override.cObject {
				file.import.data = TSFE:lastImageInfo|origFile
				file.maxW = 800
				file.maxH = 600
				
				stdWrap.postUserFunc = user_replaceSpaces
			}

			# used lightbox is pmkslimbox
			ATagParams = rel="lightbox"
			ATagParams.override = rel="lightbox[presentlb{field:uid}]"
			ATagParams.insertData = 1
			
			
		}
	}	
}

plugin.tx_chgallery_pi1.single.image < plugin.tx_chgallery_pi1.gallery.image
