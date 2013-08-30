plugin.tx_chgallery_pi1.gallery.renderAllLinks > 
plugin.tx_chgallery_pi1.gallery.renderAllLinks = 1

plugin.tx_chgallery_pi1.gallery.renderAllLinks {
	title.field= tx_chgalleryTitle
	
	parameter.override.cObject = IMG_RESOURCE
	parameter.override.cObject {
 
		file = GIFBUILDER 
		file { 
			XY = [10.w],[10.h] 
			10 = IMAGE
			10 { 
				file.import.field = tx_chgalleryImageLong
				file.maxH = 600
				file.maxW = 800
			}
			20=TEXT 
			20 {
				text.data = date:Y 
				text.noTrimWrap = |(c) | Ringer | 
				align=right 
				offset=0,[10.h]-25
				fontSize=16 
				fontColor=#ffffff
				niceText=1 
				fontFile = fileadmin/fonts/Share-TechMono.ttf			
			} 
		} 


	}

	ATagParams = rel="lightbox"
	ATagParams.override = rel="lightbox[presentlb{field:uid}]"
	ATagParams.insertData = 1
}