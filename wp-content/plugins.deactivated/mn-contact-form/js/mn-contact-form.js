jQuery(document).ready(function(){
    jQuery("#mncontactfrm").submit(function(e){
         e.preventDefault();
          jQuery("#mn_contact_submit").val('Processing...').attr('disabled', 'disabled');
		  jQuery.post(
		  		mn_ajax.ajaxurl,
				jQuery(this).serialize()+'&admin_email='+mn_ajax['admin_email']+'&mn_captcha='+mn_ajax['mn_captcha']+'&mn_confirmation_mail='+mn_ajax['mn_confirmation_mail']+'&mn_conf_mail_sub='+mn_ajax['mn_conf_mail_sub']+'&mn_conf_mail_msg='+mn_ajax['mn_conf_mail_msg']+'&blog_name='+mn_ajax['blog_name'],
				function(data){
					if(data.error == 1){
						add_class = 'mn_contact_fail';
						remove_class = 'mn_contact_success';
					}
					else{
						add_class = 'mn_contact_success';
                        remove_class = 'mn_contact_fail';
						jQuery( "#mnreset" ).trigger( "click" );
					}
					
					jQuery("#mn_contact_sending_status").show();
					jQuery("#mn_contact_sending_status").removeClass(remove_class).addClass(add_class).empty().html(data.msg);
					jQuery("#mn_a").empty().html(data.mn_a);
					jQuery("#mn_b").empty().html(data.mn_b);
					jQuery('#mn_contact_submit').val('Send').removeAttr('disabled');
				},"json"
          );
     });
	 jQuery("#mncontactfrm_sidebar").submit(function(e){
         e.preventDefault();
          jQuery('#mns_contact_submit').val('Processing...').attr('disabled', 'disabled');
          
		  jQuery.post(
		  		mn_ajax.ajaxurl1,
				jQuery(this).serialize()+'&admin_email='+mn_ajax['admin_email']+'&mn_captcha='+mn_ajax['mn_captcha']+'&mn_confirmation_mail='+mn_ajax['mn_confirmation_mail']+'&mn_conf_mail_sub='+mn_ajax['mn_conf_mail_sub']+'&mn_conf_mail_msg='+mn_ajax['mn_conf_mail_msg']+'&blog_name='+mn_ajax['blog_name'],
				function(data){
					if(data.error == 1){
						add_class = 'mn_contact_fail';
						remove_class = 'mn_contact_success';
					}
					else{
						add_class = 'mn_contact_success';
                        remove_class = 'mn_contact_fail';
						jQuery( "#mnsreset" ).trigger( "click" );
					}
					
					jQuery("#mns_contact_sending_status").show();
					jQuery("#mns_contact_sending_status").removeClass(remove_class).addClass(add_class).empty().html(data.msg);
					jQuery("#mns_a").empty().html(data.mn_a);
					jQuery("#mns_b").empty().html(data.mn_b);
				},"json"
          );
		  jQuery('#mns_contact_submit').val('Send').removeAttr('disabled');
     });
});