/* app.js */
$(function() {
	$( ".draggable" ).draggable();
	$( ".run" ).droppable({ drop: function( event, ui ) { 
		window.location.href = $( ui.draggable ).find('a').attr('href') ;
	}});
});