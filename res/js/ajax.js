window.addEvent('domready', function() {
	var next =$$('#chgallery .next a'); 
	for(var i=0;i<next.length;i++) {
		next[i].addEvent('click', function(e) {
			new Event(e).stop();
			chgallerycounter++;
			getGallery(chgallerycounter);
		});
	}	

	var back =$$('#chgallery  .text a'); 
	for(var i=0;i<back.length;i++) {

		back[i].addEvent('click', function(e) {
			new Event(e).stop();
			chgallerycounter=0;
			getGallery(0);
		});
	}


	var prev =$$('#chgallery .prev a'); 
	for(var i=0;i<prev.length;i++) {
		prev[i].addEvent('click', function(e) {
			new Event(e).stop();
			chgallerycounter--
			getGallery(chgallerycounter);
		});
	}	


});

function getGallery(pb) {
	$('chajax').removeClass('hide');
	
	new Ajax(chgalleryurlUrl, {
		data:'pb='+pb,
		method: 'get',
		update: $('chgalleryimg'),
		onSuccess: function(responseText){
			modPB(pb);
		}
	}).request();
}

function modPB(pb) {
	$('chajax').addClass('hide');
	
	if (typeof Lightbox != "undefined") {window.addEvent('domready', Lightbox.init.bind(Lightbox)) }

	
	// change text
	var current =$$('#chgallery .chgcurrent'); 
	for(var i=0;i<current.length;i++) {
		current[i].setText(pb+1);
	}

	// checks
	var next =$$('#chgallery .next a');	
	var prev =$$('#chgallery .prev a');	
	
	// check next
	if (pb+1>=chgallerymax) {
		for(var i=0;i<next.length;i++) { next[i].addClass('hide'); 		}
	} else {
		for(var i=0;i<next.length;i++) { next[i].removeClass('hide');	}
	}
	
	// check prev
	if (pb==0) {
		for(var i=0;i<prev.length;i++) { prev[i].addClass('hide'); 		}
	} else {
		for(var i=0;i<prev.length;i++) { prev[i].removeClass('hide');	}
	}

	
	
}