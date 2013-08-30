plugin.tx_chgallery_pi1.gallery.image {
	imageLinkWrap  = 1
	imageLinkWrap {	
		enable = 1
		typolink {
			title.field= tx_chgalleryTitle
			
			parameter.override.cObject = IMG_RESOURCE
			parameter.override.cObject {
##################
				file = GIFBUILDER 
				file { 
					XY = [10.w],[10.h] 
					10 = IMAGE
					10 {           
						file.import.data = TSFE:lastImageInfo|origFile
						file.maxH = 600
						file.maxW = 800
					}
					20=TEXT 
					20 {
						text.data = date:Y 
						text.noTrimWrap = |(c) | by Georg Ringer | 
						align=right 
						offset=0,[10.h]-45 
						fontSize=10 
						fontColor=#ffffff
						#niceText=1 
					} 
				} 	
#################
		
			}

			# used lightbox is pmkslimbox
			ATagParams = rel="lightbox"
			ATagParams.override = rel="lightbox[presentlb{field:uid}]"
			ATagParams.insertData = 1
			
			
		}
	}	

}