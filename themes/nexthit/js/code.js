$(document).ready(function(){

	$('.ajaxform').submit(function() { // catch the form's submit event
		var responseatt = $(this).attr('name');
		$('#' + responseatt + 'response').html('Please wait.');
		$('#submit').attr("disabled", true);
	    $.ajax({ // create an AJAX call...
	        data: $(this).serialize(), // get the form data
	        type: $(this).attr('method'), // GET or POST
	        url: $(this).attr('action'), // the file to call
	        success: function(response) { // on success..
	            
	            var result = jQuery.parseJSON(response);
	            
	            if(result.success == 1) {
	            	if(result.nextstep) {
	            		window.location = result.nextstep;
	            	}
	            } else {
	              $('#' + responseatt + 'response').html(result.errorstring); // update the DIV
	              $('#submit').attr("disabled", false);
	            }
	        }
	    });
	    return false; // cancel original event to prevent form submitting
	});
	
	$('input.typeahead').typeahead({
		onSelect: function(item) {
	        console.log(item);
	    },
	    item: '<li id="songResult"><a href="#"></a></li><div style="clear: both;"></div>',
		ajax: {
			url: "/song",
			timeout: 500,
			loadingClass: "loading",
			triggerLength: 3,
			displayField: 'html'
		}
	});
});