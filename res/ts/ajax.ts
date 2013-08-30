#TS code
plugin.tx_chgallery_pi1 {
1	# Load a different template which is needed	
	templateFile = EXT:chgallery/res/ajax.html 
	# Activiate ajax
	ajax = 1 
}

# Essential lines !!!
export_chgallery.10.renderObj  {
      10 < plugin.tx_chgallery_pi1
      10.userFunc = tx_chgallery_pi1->xmlFunc
} 
