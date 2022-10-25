jQuery(document).ready(function(){
	jQuery("input[name$='mn_confirmation_mail']").click(function() {
        var checkedValue = jQuery(this).val();
		if(checkedValue == 1){
			jQuery("#mn_sub_msg").show();
		}
		else{
			jQuery("#mn_sub_msg").hide();
		}
    });
	jQuery(".btndelete_mn_frmdata").click(function() {
		var row_id = jQuery(this).closest("tr").attr("id");
		var result = confirm("Do you want to Delete");
		if (result==true) {
			jQuery.post(
				mn_ajax.admin_ajaxurl,
				'mn_action=delete_frm_data&row_id='+row_id,
				function(data){
					if(data.error == 0){
						jQuery('#'+row_id).remove();
					}
				},"json"
			);
		}
    });
	jQuery(".mn-showhide-btn").click(function() {
		var cur = jQuery(this);
		if(cur.closest('li').find('.mn-showhide-container').is(':hidden')){
			jQuery(".mn-showhide-container").slideUp( "fast", function() {
				jQuery(".mn-showhide-btn").html('<i class="fa fa-plus"></i>');
				
			});
			cur.closest('li').find('.mn-showhide-container').slideDown( "fast", function() {
				cur.closest('li').find(".mn-showhide-btn").html('');
			});
		}
	});
	jQuery(".mn_expand").click(function() {
		var cur = jQuery(this);
		if(cur.closest('tr').find('.mn_form_data_more').is(':hidden')){
			jQuery(".mn_form_data_more").slideUp( "fast", function() {
				jQuery(".mn_expand").html('<i class="fa fa-plus"></i>');
				
			});
			cur.closest('tr').find('.mn_form_data_more').slideDown( "fast", function() {
				cur.closest('tr').find(".mn_expand").html('');
			});
		}
	});
	jQuery("#customcss").submit(function(e){
		e.preventDefault();
		jQuery.post(
			mn_ajax.ajax_url,
			jQuery(this).serialize()+'&action=adding_custom_css',
			function(data){
				if(data.error == 0){
					add_class = 'mn_contact_fail';
					remove_class = 'mn_contact_success';
				}else{
					add_class = 'mn_contact_success';
                    remove_class = 'mn_contact_fail';
				}
				jQuery("#mns_frm_status").show();
				jQuery("#mns_frm_status").removeClass(remove_class).addClass(add_class).empty().html(data.msg);
			},"json"
		);
	});
	jQuery(".savebtn").click(function() {
		var cur = jQuery(this);
		cur.attr('disabled', 'disabled');
		cur.val('Saving');
		var row_id = cur.closest("li").attr("id");
		var str = row_id.split("_");
		var fieldid = str[1];
		var fieldlabel = cur.closest("li").find('.fieldlabel').val();
		var isvisible = cur.closest("li").find('.isvisible').val();
		var ismandatory = cur.closest("li").find('.ismandatory').val();
		var error_message = cur.closest("li").find('.error_message').val();
		var placeholder = cur.closest("li").find('.fieldplaceholder').val();
		jQuery.post(
			mn_ajax.ajax_url,
			'action=saving_field_setting&fieldid='+fieldid+'&fieldlabel='+fieldlabel+'&isvisible='+isvisible+'&ismandatory='+ismandatory+'&error_message='+error_message+'&fieldplaceholder='+placeholder,
			function(data){
				cur.val('Saved');
			},"json"
		);
		cur.removeAttr('disabled');
    });
	jQuery("#mn_form_style").change(function() {
		var val = jQuery(this).val();
		if(val == 'mn-stryle1'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyle1').fadeIn();
		}else if(val == 'mn-stryle2'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyle2').fadeIn();
		}else if(val == 'mn-stryle4'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyle3').fadeIn();
		}else if(val == 'mn-stryle5'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyle4').fadeIn();
		}else if(val == 'mn-stryle6'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyle5').fadeIn();
		}else if(val == 'mn-stryle8'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyle6').fadeIn();
		}else if(val == 'mn-default-style'){
			jQuery('.mnpreview').hide();
			jQuery('#mnfrmstyledef').fadeIn();
		}else{
			jQuery('.mnpreview').hide();
		}
    });
	jQuery("#sortable").sortable({
		update : function () {
		  serial = jQuery('#sortable').sortable('serialize');
		  jQuery.post(
			mn_ajax.admin_ajaxurl,
				serial+'&mn_action=sort_field',
				function(data){
				},"json"
			);
		}
	});
	
});