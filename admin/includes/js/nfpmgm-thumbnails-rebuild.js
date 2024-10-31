jQuery(document).ready(function() {
	
	//bind rebuild thumbnails button
	jQuery('#nfpmgm_rebuild_thumbnails_button').click(function(){
		
		jQuery('.nfpmgm-ending-thumbnails-rebuild').hide();
		jQuery('.nfpmgm-preparing-thumbnails-rebuild').show();
		jQuery('#nfpmgm_rebuild_thumbnails_button').prop('disabled', true);
		
		var nfpmgm_rebuild_all_thumbnails = 0;
		if(jQuery('#nfpmgm_rebuild_all_thumbnails').prop('checked') === true) {
			
			nfpmgm_rebuild_all_thumbnails = 1;
		}
				
		var nfpmgm_rebuild_pdf_thumbnails = 0;
		if(jQuery('#nfpmgm_rebuild_pdf_thumbnails').prop('checked') === true) {
			
			nfpmgm_rebuild_pdf_thumbnails = 1;
			
		}
	
		//get media to work with
		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			url: nfpmgm_thumbnails_rebuild_object.nfpmgm_thumbnails_rebuild_url,
			data: {
				'action': 'nfpmgm_thumbnails_rebuild',
				'nfpmgm_thumbnails_rebuild_nonce': nfpmgm_thumbnails_rebuild_object.nfpmgm_thumbnails_rebuild_nonce,
				'nfpmgm_rebuild_all_thumbnails': nfpmgm_rebuild_all_thumbnails,
				'nfpmgm_rebuild_pdf_thumbnails': nfpmgm_rebuild_pdf_thumbnails
			},
			
			//deal with success
			success:function(data){
				
				//count ids
				var nfpmgmEntriesToWorkWith = data.length;
				
				if(nfpmgmEntriesToWorkWith === 0) {
					
					//no image needs to be treated
					jQuery('.nfpmgm-preparing-thumbnails-rebuild').hide();
					jQuery('.nfpmgm-ending-thumbnails-rebuild').show();
					jQuery('#nfpmgm_rebuild_thumbnails_button').prop('disabled', false);
					//console.log("no image to work with");
					return;
					
				} else {
					
					nfpmgmEntriesToWorkWith = data['id'].length;
					
					jQuery('.nfpmgm-preparing-thumbnails-rebuild').hide();
					jQuery('.nfpmgm-executing-current-thumbnail').text('1');
					jQuery('.nfpmgm-executing-total-thumbnail').text(nfpmgmEntriesToWorkWith);
					jQuery('.nfpmgm-executing-thumbnails-rebuild').show();
					
					//console.log(nfpmgmEntriesToWorkWith+' thumbnail to work with');
					
				}
							
												
				//define a viariable to count loops
				var nfpmgmRebuildReiterances = 0;				
				
				function nfpmgmRebuildThumbnail(nfpmgmEntriesToWorkWith,nfpmgmRebuildReiterances) {

					var nfpmgmImagesIds = data['id'];
					var nfpmgmImagesPaths = data['path'];
					var nfpmgmImagesTargetQualities = data['quality'];
					var nfpmgmImagesTargetSizes = data['size'];
					var nfpmgmImagesTypes = data['type'];

					var nfpmgmInvolvedImageId = nfpmgmImagesIds[nfpmgmRebuildReiterances];
					var nfpmgmInvolvedImagePath = nfpmgmImagesPaths[nfpmgmRebuildReiterances];
					var nfpmgmInvolvedImageTargetQuality = nfpmgmImagesTargetQualities[nfpmgmRebuildReiterances];
					var nfpmgmInvolvedImageTargetSize = nfpmgmImagesTargetSizes[nfpmgmRebuildReiterances];
					var nfpmgmInvolvedImageType = nfpmgmImagesTypes[nfpmgmRebuildReiterances];

					//console.log(nfpmgmRebuildReiterances+": treating "+nfpmgmInvolvedImageId+" with path "+nfpmgmInvolvedImagePath)		
								
					jQuery.ajax({
						type: 'POST',
						dataType: 'json',
						url: nfpmgm_thumbnails_rebuild_object.nfpmgm_thumbnails_rebuild_url,
						data: {
							'action': 'nfpmgm_thumbnails_rebuild',
							'nfpmgm_thumbnails_rebuild_nonce': nfpmgm_thumbnails_rebuild_object.nfpmgm_thumbnails_rebuild_nonce,
							'nfpmgm_current_image_id': nfpmgmInvolvedImageId,
							'nfpmgm_current_image_path': nfpmgmInvolvedImagePath,
							'nfpmgm_image_target_quality': nfpmgmInvolvedImageTargetQuality,
							'nfpmgm_image_target_size': nfpmgmInvolvedImageTargetSize,
							'nfpmgm_current_image_type': nfpmgmInvolvedImageType
						},
						
						//deal with success
						success:function(data) {
							
							nfpmgmRebuildReiterances++;
																
							if(nfpmgmRebuildReiterances < nfpmgmEntriesToWorkWith) {
								
								setTimeout(function() {
								
									jQuery('.nfpmgm-executing-current-thumbnail').text(nfpmgmRebuildReiterances+1);																
									nfpmgmRebuildThumbnail(nfpmgmEntriesToWorkWith,nfpmgmRebuildReiterances);
									
								}, 250);									
							
							}
							
							else if(nfpmgmRebuildReiterances === nfpmgmEntriesToWorkWith) {

								jQuery('#nfpmgm_rebuild_thumbnails_button').prop('disabled', false);
								jQuery('.nfpmgm-executing-thumbnails-rebuild').hide();
								jQuery('.nfpmgm-ending-thumbnails-rebuild').show();
								
								//console.log("job completed")
								return;								
								
							}
							
						},
						
						//deal with errors
						error: function(errorThrown){
							console.log(errorThrown);
						},

					}); 
				
				};
									
				nfpmgmRebuildThumbnail(nfpmgmEntriesToWorkWith,nfpmgmRebuildReiterances);

										
			},
			
			error: function(errorThrown){
				console.log(errorThrown);
			}
			
		});		
		
		
	})
              
});