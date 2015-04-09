// Set the jQuery stuff
var $ = jQuery;

// Run on page load
$(document).ready(function() {
	// Check if it's a project page
	if (document.location.href.indexOf('/project/') > -1) {
		// Base code
	    var text =  '<div class="project-category-list"> <ul>';
	    
	    // Get the last segment of the url
	    // ie. /foo/bar returns as bar
	    var page = document.location.href;
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
	                	// Create a button with the url and name from the arrays
	                    text += '<li class="views-row">' +
	                                '<a href="' + urls[i] + '" style="display: block;">' + names[i] + '</a>' +
	                            '</li>';
	                }
	           }
	        });
	    };
	    
	    // Close the code
	    text += '</ul></div>';

	    // Place the code before the body text
	    $('.field-name-body').before(text);
	}
});
