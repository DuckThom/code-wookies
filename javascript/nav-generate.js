// Set the jQuery stuff
var $ = jQuery;

// Run on page load
$(document).ready(function() {
	// Check if it's a project page
	if (document.location.href.indexOf('/project/') > -1) {
		// Base code
	    var text =  '<div class="project-category-list"> <ul>';

	    // this will be used for page counting
	    var count = 0;
	    
	    // Get the last segment of the url
	    // ie. /foo/bar returns as bar
	    var page = location.pathname;
	    var segment = page.substr(page.lastIndexOf('/') + 1);

	    // Create the urls and button names
	    var urls = ['/project/it/' + segment, '/project/connect/' + segment, '/project/web/' + segment];
	    var names = ['IT &amp; Automatisering', 'Marganza Connect', 'Web &amp; Design'];

	    // Loop through the urls
	    for (var i = urls.length - 1; i >= 0; i--) {
	    	// This will check if the page exists
	        $.ajax({
	            url: urls[i],
	            async: false, // Wait for the request to complete
	            complete: function(data) {
	            	// If the page doesn't exist
	                if (data.status == 404) {
	                	// Create an empty button
	                    //text += '<li class="views-row">' +
	                    //       '</li>';
	                // If it does exist
	                } else if (data.status == 200) {
	                	// Add 1 to the found pages counter
	                	count++;
	                	// Create a button with the url and name from the arrays
	                    text += '<li class="views-row">' +
	                                '<a href="' + urls[i] + '" style="display: block;"' + (urls[i] === location.pathname ? 'class="active-link"' : '') + '>' + names[i] + '</a>' +
	                            '</li>';
	                }
	           }
	        });
	    };
	    
	    // Close the code
	    text += '</ul></div>';

	    // Place the code before the #wrap div, this is the last div using the full browser width
	    // Only place the nav if there are multiple projects
	    if (count > 1)
	    	$('#wrap').before(text);

	    // Wait 10ms before executing this code
	    setTimeout(function() {
	    	// Calculate the position of the bottom of the header image (top position + height of the image)
	    	if ($('.field-name-field-subtitel-con').length) {
		    	var topOffset = $('.field-name-field-subtitel-con').offset().top + $('.field-name-field-subtitel-con').height() + 80;
		    } else if ($('.field-name-field-subtitle-web').length) {
		    	var topOffset = $('.field-name-field-subtitle-web').offset().top + $('.field-name-field-subtitle-web').height() + 80;
		    } else if ($('.field-name-field-subtitel-it').length) {
		    	var topOffset = $('.field-name-field-subtitel-it').offset().top + $('.field-name-field-subtitel-it').height() + 80;
		    }

		    // Attach the project nav to the top of the body
		    $('.project-category-list').css('top', topOffset + "px");
	    }, 10);
	}
});

// Also move the project nav when the browser is being resized
$(window).resize(function() {
	// Calculate the position of the bottom of the header image (top position + height of the image)
	if ($('.field-name-field-subtitel-con').length) {
    	var topOffset = $('.field-name-field-subtitel-con').offset().top + $('.field-name-field-subtitel-con').height() + 80;
    } else if ($('.field-name-field-subtitle-web').length) {
    	var topOffset = $('.field-name-field-subtitle-web').offset().top + $('.field-name-field-subtitle-web').height() + 80;
    } else if ($('.field-name-field-subtitel-it').length) {
    	var topOffset = $('.field-name-field-subtitel-it').offset().top + $('.field-name-field-subtitel-it').height() + 80;
    }

    // Attach the project nav to the top of the body
	$('.project-category-list').css('top', topOffset + "px");
});
