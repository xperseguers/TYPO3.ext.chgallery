plugin.tx_chgallery_pi1.gallery.image {

	stdWrap.override.cObject = IMAGE
	stdWrap.override.cObject {
		
		# normal gallery image 
		file = GIFBUILDER 
		file { 
			XY = [10.w],[10.h] 
			10 = IMAGE
			10 { 
				file.import.data = TSFE:lastImageInfo|origFile
				file.maxH = 110
				file.maxW = 139
			}
			20=TEXT 
			20 {
				text.data = date:Y 
				text.noTrimWrap = |(c) | Ringer | 
				align=right 
				offset=0,[10.h]-25
				fontSize=8
				fontColor=#ffffff
				niceText=1 
				fontFile = fileadmin/fonts/Share-TechMono.ttf			
			} 
		} 	
		
		# lightbox
		imageLinkWrap= 1
		imageLinkWrap {	
			enable = 1
			typolink {
				title.field= tx_chgalleryTitle
				
				parameter.override.cObject = IMG_RESOURCE
				parameter.override.cObject {
	
					file = GIFBUILDER 
					file { 
						XY = [10.w],[10.h] 
						10 = IMAGE
						10 { 
	
							file.import.field = tx_chgalleryFile
							file.maxH = 600
							file.maxW = 800
							
						}
						20=TEXT 
						20 {
							#text.data = date:Y 
							text.field = tx_chgalleryTitle
							text.noTrimWrap = |(c) | by Georg Ringer | 
							align=right 
							offset=0,[10.h]-25
							fontSize=16 
							fontColor=#ffffff
							niceText=1 
							fontFile = fileadmin/fonts/Share-TechMono.ttf			
						} 
					} 	
	
			
				}
	
				# used lightbox is pmkslimbox
				ATagParams = rel="lightbox"
				ATagParams.override = rel="lightbox[presentlb{field:uid}]"
				ATagParams.insertData = 1
				
				
			}
		}		
	}


}