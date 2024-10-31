//show settings detail function
function nfpExpandContent() {
	
	//get arrow element
	var nfpExpandContent = jQuery('.nfproot-expanded');
	//remove class tha was set only to pick element out it
	jQuery(nfpExpandContent).removeClass('nfproot-expanded');
	//hide clicked arrow (expand)
	jQuery(nfpExpandContent).css('display','none');
	//show next arrow (shrink)
	jQuery(nfpExpandContent).next().css('display','inline-block');
	//show every next parent element with the involved class 
	jQuery(nfpExpandContent).siblings('.nfproot-hidden-content').show();
	
};

//hide settings detail function
function nfpShrinkContent() {
	
	//get arrow element
	var nfpShrinkContent = jQuery('.nfproot-shrinked');
	//remove class tha was set only to pick element out it
	jQuery(nfpShrinkContent).removeClass('nfproot-shrinked');
	//hide clicked arrow (shrink)
	jQuery(nfpShrinkContent).css('display','none');
	//show previous arrow (expand)
	jQuery(nfpShrinkContent).prev().css('display','inline-block');
	//show every next parent element with the involved class 
	jQuery(nfpShrinkContent).siblings('.nfproot-hidden-content').hide();
	
};


jQuery(document).ready(function() {
					
	//display details on switching on and hide it on switching off
	jQuery('.nfproot-switching-content').click(function() {
		
		if(jQuery(this).prop('checked')) {
			
			jQuery(this).parent().siblings('.nfproot-switching-content-expand').addClass('nfproot-expanded');
			nfpExpandContent();
			
		} else {
			
			jQuery(this).parent().siblings('.nfproot-switching-content-shrink').addClass('nfproot-shrinked');
			nfpShrinkContent();
			
		}
		
	});
	
	//display details on clicking on expand arrow
	jQuery('.nfproot-switching-content-expand').click(function() {

		jQuery(this).addClass('nfproot-expanded');
		nfpExpandContent();
		
	});
	
	//hide details on clicking on shrink arrow
	jQuery('.nfproot-switching-content-shrink').click(function() {
		
		jQuery(this).addClass('nfproot-shrinked');
		nfpShrinkContent();
		
	});
			
});