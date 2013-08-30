/*
	use: accordion.display(1);
	
*/


var accordion = "";

window.addEvent('domready', function(){
accordion = new Accordion('div.chgallery-title', 'div.chgallery-content', {
	alwaysHide:true,
	opacity: false,
//	display:'',
	onActive: function(toggler, element){
		toggler.addClass('act');
	},
 
	onBackground: function(toggler, element){
		toggler.removeClass('act');		
	}
}, $('chgallery-list'));	

}); 
