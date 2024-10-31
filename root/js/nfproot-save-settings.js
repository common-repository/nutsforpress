function nfpGetPostedInputs(nfpPostedInputClass) {

//set posted input variable as an array
		var nfpPostedInputs = {};
		
		//get all inputs value and loop into them
		jQuery(nfpPostedInputClass).each(function(index,value) {
			
			//set posted input with index as an array
			nfpPostedInputs[index] = {};
			
			//define expected values
			var nfpInputType, nfpInputName, nfpInputValue;
			
			//get types and names
			nfpInputType = jQuery(this).prop('type');
			nfpInputName = jQuery(this).prop('name');
			nfpInputSave = jQuery(this).data('save');

			//deal with dropdown
			if(jQuery(this).is('select')) {
				
				//get posted value
				nfpInputValue = jQuery(this).find(':selected').val();
				
				//add values to posted inputs array
				nfpPostedInputs[index]['name'] = nfpInputName;			
				nfpPostedInputs[index]['type'] = 'dropdown';
				nfpPostedInputs[index]['value'] = nfpInputValue;
				nfpPostedInputs[index]['save'] = nfpInputSave;
					
			}
			
			//deal with textarea
			else if(jQuery(this).is('textarea')) {
				
				//get posted value
				nfpInputValue = jQuery(this).val();
				nfpInputValue = btoa(nfpInputValue);
				
				//add values to posted inputs array
				nfpPostedInputs[index]['name'] = nfpInputName;			
				nfpPostedInputs[index]['type'] = 'textarea';
				nfpPostedInputs[index]['value'] = nfpInputValue;
				nfpPostedInputs[index]['save'] = nfpInputSave;
					
			}
			
			//deal with radio button
			else if(nfpInputType === 'radio') {

				if(jQuery(this).prop('checked')) {

					//add values to posted inputs array
					nfpPostedInputs[index]['name'] = nfpInputName;			
					nfpPostedInputs[index]['type'] = nfpInputType;
					nfpPostedInputs[index]['value'] = jQuery(this).val();
					nfpPostedInputs[index]['save'] = nfpInputSave;
				
				} 			
					
			}
			
			//deal with checkboxes
			else if(nfpInputType === 'checkbox') {
				
				//add values to posted inputs array
				nfpPostedInputs[index]['name'] = nfpInputName;
				nfpPostedInputs[index]['type'] = nfpInputType;
				
				if(jQuery(this).prop('checked')) {
					
					nfpPostedInputs[index]['value'] = '1';
				
				} else {
				
					nfpPostedInputs[index]['value'] = '0';		
					
				}
				
				nfpPostedInputs[index]['save'] = nfpInputSave;
				
			}
			
			//deal with other inputs
			else if(
			
				nfpInputType === 'text'
				|| nfpInputType === 'email'
				|| nfpInputType === 'password'
				
			) {
				
				//get posted value
				nfpInputValue = jQuery(this).val();
				
				//add values to posted inputs array
				nfpPostedInputs[index]['name'] = nfpInputName;
				nfpPostedInputs[index]['type'] = nfpInputType;
				nfpPostedInputs[index]['value'] = nfpInputValue;
				nfpPostedInputs[index]['save'] = nfpInputSave;
				
			}
						
		})	

		return nfpPostedInputs;
	
}

jQuery(document).ready(function() {
					
	jQuery('.nfproot-input-global, .nfproot-input-local').on('change', function(){
		
		//remove pending messages before printing newer
		if(jQuery('#nfproot_settings_saved').length > 0) {
									
			jQuery('#nfproot_settings_saved').remove();
			
		}

		//locate input changed
		var nfpInputChanged = jQuery(this);
		
		//check if input has a label
		var nfpInputChangedLabel = nfpInputChanged.next('label');
		
		var nfpInputChangedInfo = 
		
				'<div style="display:inline-block; margin:0 10px;" id="nfproot_settings_saved">'+
				'<span style="color:orange;" class="dashicons dashicons-cloud-upload"></span>'+
				'</div>';
				
		//if label exists
		if(nfpInputChangedLabel.length > 0) {
			
			//put message after label
			nfpInputChangedLabel.after(nfpInputChangedInfo);
			
		//if lable doesn't exist
		} else {
			
			//put message after input
			nfpInputChanged.after(nfpInputChangedInfo);
			
		}
		
		var nfpPostedInputsGlobal = nfpGetPostedInputs('.nfproot-input-global');
		var nfpPostedInputsLocal = nfpGetPostedInputs('.nfproot-input-local');	
		
		//console.log("global: "+JSON.stringify(nfpPostedInputsGlobal));
		//console.log("local: "+JSON.stringify(nfpPostedInputsLocal));
				
		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			url: nfproot_save_settings_object.nfproot_save_settings_url,
			data: {
				'action': 'nfproot_save_settings',
				'nfproot_save_settings_nonce': nfproot_save_settings_object.nfproot_save_settings_nonce,
				'nfproot_posted_inputs_global': nfpPostedInputsGlobal,
				'nfproot_posted_inputs_local': nfpPostedInputsLocal,
			},
			
			//deal with success
			success:function(data){			

				//set a variable that refers to updating message printed on change
				var nfpSettingSaved = jQuery('#nfproot_settings_saved');
							
				if(data === true) {
									
					//print success icon instead of the updating one
					nfpSettingSaved.html('<span style="color:green;" class="dashicons dashicons-cloud-saved">');
										
					//hide and remove success icon after a while
					if(nfpSettingSaved.length > 0) {
						
						nfpSettingSaved.delay(1500).fadeTo(100 , 0, function() {
												
							nfpSettingSaved.remove();
							
						});
						
					}
				
				} else {

					//print failure icon instead of the updating one
					nfpSettingSaved.html('<span style="color:red;" class="dashicons dashicons-cloud-upload">');
			
				}
				
										
			},
			
			error: function(errorThrown){
				
				//console.log(errorThrown);
				
				//set a variable that refers to updating message printed on change
				var nfpSettingSaved = jQuery('#nfproot_settings_saved');
				
				//print failure icon instead of the updating one
				nfpSettingSaved.html('<span style="color:red;" class="dashicons dashicons-cloud-upload">');
			
				
			}
			
		});		
		
	})
		
});