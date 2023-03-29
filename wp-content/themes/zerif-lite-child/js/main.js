jQuery( document ).ready(function($) {
    // update Contact Us button
    const contactUsTopBtn = $('#menu-menu-1').children().last().children().first();
    if(contactUsTopBtn) {
        contactUsTopBtn.attr("href", "javascript:void(0);");
        contactUsTopBtn.click((e)=> {
            $('html, body').animate({
                scrollTop: $("#contact").offset().top
            }, 2000);
        })
    }

    const lastMenuLi = $('#menu-menu-1').children().last();
    if(lastMenuLi){
        lastMenuLi.css({'border-top':'none'});
    }

    $('.section-header h2').css({'color':'#020202 !important'})
    $('.section-header .section-legend').css({'color':'#020202 !important'})

    const baseurl = window.location.origin + '/wp-content/uploads';    

    // services section 
    const services = $('#services');
    if(services){
        var img1   = baseurl + "/2020/01/software_healthcare-solutions.jpg";
        var img2   = baseurl + "/2020/01/business_solutions_facebook.jpg";

        let service1 = '<div class="col-md-3 col-md-offset-1" style="background-image: url(' + img1+ '); height: 300px; background-repeat:no-repeat;">1</div>';
        let service2 = '<div class="col-md-3 col-md-offset-1" style="background-image: url(' + img1+ '); height: 300px; background-repeat:no-repeat;">2</div>';
        let service3 = '<div class="col-md-3 col-md-offset-1" style="background-image: url(' + img1+ '); height: 300px; background-repeat:no-repeat;">3</div>';

        let service4 = '<div class="col-md-3 col-md-offset-1" style="background-image: url(' + img2+ '); height: 300px; background-repeat:no-repeat;">4</div>';
        let service5 = '<div class="col-md-3 col-md-offset-1" style="background-image: url(' + img2+ '); height: 300px; background-repeat:no-repeat;">5</div>';
        let service6 = '<div class="col-md-3 col-md-offset-1" style="background-image: url(' + img2+ '); height: 300px; background-repeat:no-repeat;">6</div>';

        let servicesCnt = `<div class="row">${service1}${service2}${service3}</div>`;
        servicesCnt += `<div class="row">${service4}${service5}${service6}</div>`;

        services.html(servicesCnt);
        services.css({'margin-top':'25px'})
    }

    const focus = $('#focus')
    if(focus){
        focus.css({'padding-top':'40px', 'background':'rgb(244, 244, 244)'})
    }

    const aboutus = $('#aboutus')
    if(aboutus){
        aboutus.css({'padding-top':'40px', 'background':'#FFFFFF'})
    }    

    $('.entry-title').hide();
    var contactUs = '<div id="mncontactfrm-header"><h3 class="sec-title" style="margin-left: auto;width: 300px;margin-right: auto;">HOW CAN WE HELP YOU?</h3>';
    contactUs += '<div class="sec-info" style="font-size: 16px; line-height: 1.42857143;width: 80%; margin-left: auto; margin-right: auto; margin-bottom: 15px;">From mobile app development to digital strategy, we do it all.</div></div>';
    var style = {'width':'50%', 'margin-left':'auto', 'margin-right':'auto'};
    $('#mncontactfrm').before(contactUs)
    $('#mncontactfrm-header').css({'width':'50%', 'margin-left':'auto', 'margin-right':'auto', 'font-weight':'400', 'font-size':'23px', 'letter-spacing':'3px;'});
    $('#mncontactfrm').css(style); 

    // header
    $('#menu-menu-1').children().last().children().first().css({'background-color':'#4C508C','padding':'0px 9px', 'color':'white', 'border-radius': '8px', 'font-family': 'Arial, Helvetica, sans-serif'});

    var max = 10;
    var min = 1;
    var value1 = Math.floor(Math.random() * (max - min + 1)) + min;
    var value2 = Math.floor(Math.random() * (max - min + 1)) + min;

    // home -> contact-us section
    var contactUsEl = '<div class="mn_contact_form container" id="mn-stryle4"><div id="mncontactfrm-header" style="width: 50%; margin-left: auto; margin-right: auto; font-weight: 400; font-size: 23px; margin-top: -30px; color: #ffffff;"><h3 class="sec-title" style="margin-left: auto;width: 300px;margin-right: auto;">HOW CAN WE HELP YOU?</h3><div class="sec-info" style="font-size: 16px; line-height: 1.42857143;width: 80%; margin-left: auto; margin-right: auto; margin-bottom: 15px;">From mobile app development to digital strategy, we do it all.</div></div>';
    contactUsEl += '<form name="mncontactfrm" id="mncontactfrm-home" action="/wp-content/plugins/mn-contact-form/ajaxreq/ajax_requests.php" method="post" style="width: 50%; margin-left: auto; margin-right: auto;">';
    contactUsEl += '<div class="form-group"><div class="mn-control-label"><label for="user_name1">Name</label></div><div class="mn-control-input">';
	contactUsEl += '<input type="text" class="form-control" style="text-indent:20px" name="user_name" id="user_name1" value=""></div>';
	contactUsEl += '</div><div class="mn-control-group"><div class="mn-control-label"><label for="user_email2">Email</label></div>';
	contactUsEl += '<div class="form-group"><input class="form-control" type="text" name="user_email" style="text-indent:20px" id="user_email2" value=""></div>';
	contactUsEl += '</div><div class="mn-control-group"><div class="mn-control-label"><label for="user_subject6">Subject</label></div>';
	contactUsEl += '<div class="form-group"><input class="form-control" type="text" name="user_subject" id="user_subject6" style="text-indent:20px" value=""></div>';
	contactUsEl += '</div><div class="mn-control-group"><div class="mn-control-label"><label for="user_message7">Message</label></div>';
	contactUsEl += '<div class="form-group"><textarea rows="10" name="user_message" id="user_message7"></textarea></div>';
	contactUsEl += '</div><p><label for="answer" style="color: #ffffff;margin-right:10px;">Write Your Answer: </label>';
	contactUsEl += '<span id="mn_a" style="color: #ffffff;font-style:italic">' + value1 + ' + </span><span id="mn_b" style="color: #ffffff;font-style:italic">' + value2 + ' = </span><input type="text" name="mn_answer" id="mn_answer" value="" maxlength="4" style="border-radius: 3px; width:60px; margin:0 5px;" required="required"><small style="color: #ffffff;"></small>';
	contactUsEl += '</p><p id="mn_contact_sending_status" style="display:none;"></p><p>';
	contactUsEl += '<input type="hidden" name="mn_save_data" id="" value="0"><div class="mn-control-group"><input class="form-control" type="submit" name="mn_contact_submit" id="mn_contact_submit" value="Submit Request" style="padding-top: 8px; background-color:#0CABE5; width:100%; font-weight: bold;"></div>';
	contactUsEl += '</p><div style="color: #ffffff" id="email-msg"></div></form></div>';
	
	var contactUsElShort = '<div class="mn_contact_form container" id="mn-stryle4"><div id="mncontactfrm-header" style="width: 50%; margin-left: auto; margin-right: auto; font-weight: 400; font-size: 23px; margin-top: -30px; color: #ffffff;"><h3 class="sec-title" style="margin-left: auto;width: 300px;margin-right: auto;">HOW CAN WE HELP YOU?</h3><div class="sec-info" style="font-size: 16px; line-height: 1.42857143;width: 80%; margin-left: auto; margin-right: auto; margin-bottom: 15px;">From mobile app development to digital strategy, we do it all.</div><div id="newFormPosition"></div></div>';
	
    //$('.contact-us').find('.container').append( contactUsElShort );
    $('.contact-us').find('.container').append( contactUsEl );
    $('.contact-us').css({'padding-top':'50px'})

    //$('.contact-us').find('.container').find('.mn_contact_form').after( '<h3>Test</h3>' );
    $("#mn_sidebar").appendTo("#newFormPosition");
    $('#mn_contact_sidebar').css({'width':'100%'});
    $('.widget-title').css({'display':'none'});
    $('#mncontactfrm_sidebar').css({'font-size':'16px'});

    $('#mncontactfrm-home').submit(function( event ) {
        var hasFormErrors = $('#user_name1').val().length == 0 || $('#user_email2').val().length == 0 
							|| $('#user_message7').val().length == 0 || $('#user_subject6').val().length == 0;

	    if(hasFormErrors) {
		    $('#email-msg').html('<span style="font-size:18px;">Please fill in form correctly.</span>');
            event.preventDefault();
			return;
	    }

	    if($('#mn_answer').val() != (value1 + value2)) {
		    $('#email-msg').html('<span style="font-size:18px;">Please write the correct math answer.</span>');
            event.preventDefault();
			return;
	    }

	    //var url = '<?php echo admin_url('admin-ajax.php'); ?>';
	    //var url = window.location.origin + '/wp-admin/admin-ajax.php';
	    var data = { 'action':'get_data', 
                     'user_name': $('#user_name1').val(), 
                     'user_email': $('#user_email2').val(), 
                     'user_message':$('#user_message7').val(), 
                     'user_subject': $('#user_subject6').val(), 
                     'mn_answer': 9, 
                     'mn_save_data': 0, 
                     'admin_email':'info@nextpathtechnology.com', 
                     'mn_captcha':1, 
                     'email_key': email_key,
                     'mn_confirmation_mail':1};

  		$.post(ajaxUrl, data , function(result) {
		   if( JSON.parse(result).status === 'success' ) {
			$('#send_email').val('');
			$('#user_name1').val('');
			$('#user_email2').val('');
			$('#user_message7').val('');
			$('#user_subject6').val('');
			$('#mn_answer').val('');
			$('#email-msg').html('<span style="font-size:18px;">Thank you for your request. We will reply shortly.</span>');
		   } else {
			$('#email-msg').html('<span style="font-size:18px;">There was an error while sending your request.</span>');
		   }
           $('#email-msg').delay(5000).fadeOut('slow');
		});

  		event.preventDefault();
	});

    $('.footer-widget-wrap').hide();

    // Footer
    var updateFooter = function() { 
        var el1 = '<div class="col-md-3 company-details"><h4 style="color:#ffffff">SERVICES</h4><hr style="width:80%"><ul style="line-height:1.8; list-style: none;padding-left: 30px !important;;margin: 0;"><li style="display:-webkit-box"><a href="services/software-consulting/">Business Intelligence</a></li><li style="display:-webkit-box"><a href="/services/application_development/">Data Analytic Solutions</a></li><li style="display:-webkit-box"><a href="/services/mobile-development/">Application/Mobile Solutions</a></li><li style="display:-webkit-box"><a href="/services/e-commerce-development/">E-Commerce Solutions</a></li><li style="display:-webkit-box"><a href="/digital-marketing/">Digital Marketing Solutions</a></li><li style="display:-webkit-box"><a href="/cloud">Cloud Solutions</a></li></ul></div>';
        
        var baseurl  = "<?php echo wp_upload_dir()['baseurl'] ?>";
        var linkedIn = baseurl + "/2019/01/linkedin.png";
        var facebook = baseurl + "/2020/01/business_solutions_facebook.jpg";
        let facebookCmp = `<div style="display:inline-block"><a target="_blank" href="https://www.facebook.com/nextpathtechnology"><img border="0" alt="Next Path Technology Facebook" src="${facebook}" width="40" height="40"></a></div>`;

        var el2 = '<div class="col-md-3 company-details"><h4 style="color:#ffffff">CONTACT US</h4><hr style="width:80%"><div class="icon-top green-text"><img src="http://nextpathtechnology.com/wp-content/themes/zerif-lite/images/envelope4-green.png" alt=""></div><div style="line-height:1.8">Got any questions?</div><a href="mailto:info@nextpathtechnology.com?Subject=ProjectQuote">info@nextpathtechnology.com</a><div style="color: white;font-weight: bold;margin-top: 20px">We Are In Social Network:</div><div style="display:inline-block"><a target="_blank" href="https://www.linkedin.com/company/next-path-technology"><img border="0" alt="Next Path Technology LinkedIn" src="' + linkedIn + '" width="50" height="50"></a></div>'+ facebookCmp + '</div>';

        var el3 = '<div class="col-md-3 company-details"><h4 style="color:#ffffff">INDUSTRIES</h4><hr style="width:80%"><ul style="line-height:1.8;list-style: none;padding-left: 30px !important;;margin: 0;color:#d4cdcd"><li style="display:-webkit-box"><a href="/industries/banking-finance/">Banking&Finance</a></li><li style="display:-webkit-box"><a href="/education/">Education</a></li><li style="display:-webkit-box"><a href="/industries/healthcare/">Healthcare</a></li><li style="display:-webkit-box"><a href="/industries/insurance/">Insurance</a></li><li style="display:-webkit-box"><a href="/industries/manufacturing/">Manufacturing</a></li><li style="display:-webkit-box"><a href="/industries/media-and-entertainment/">Media And Entertainment</a></li></ul></div>';

        var el4 = '<div class="col-md-3 company-details"><h4 style="color:#ffffff">ABOUT US</h4><hr style="width:80%"><div style="line-height:1.8;color: #d4cdcd">You can trust your business<br/>To our experts.<br/><h4>NextPath Technology Inc.</h4></div></div>';

        var footerEl = $('#footer').find('.container');   
        footerEl.html( el1 + el2 + el3 + el4 );
        };

    setTimeout(updateFooter, 1500);

    // hide button on main screen
    //$('.header-content-wrap').find('.container').find('.buttons').children().first().attr('style','display:none !important');
    
    // header adjustments
    const headerContentWrap = $('.header-content-wrap');
    if(headerContentWrap) {
        headerContentWrap.css({'min-height':'600px'});
        //headerContentWrap.attr("id", "slideshow");

        headerContentWrap.find('.container').first().attr('style','position: absolute; width: 100%');
        headerContentWrap.find('.container').first().wrap('<div id="slideshow" style="height: 240px"></div>');

        const slideshow = headerContentWrap.find('#slideshow');

        // add slider 1
        /* 
        headerContentWrap
            .find('.container')
            .first().addClass( "slideshow" ); */

        if(slideshow) {
            let slider = '<div class="container" style="display:none; position: absolute; width: 100%"><h1 class="intro-text">REMODEL YOUR ORGANIZATION TO ACHIEVE YOUR BUSINESS DIGITAL TRANSFORMATION</h1></div>';
            // slider 2
            slideshow.append(slider);            

            slider = '<div class="container" style="display:none; position: absolute; width: 100%"><h1 class="intro-text">TRANSFORM YOUR BUSINESS TO MODERN CLOUD DATA PLATFORM SERVICES</h1></div>';
            // slider 3
            slideshow.append(slider);            

            slider = '<div class="container" style="display:none; position: absolute; width: 100%"><h1 class="intro-text">ANALYZE YOUR BUSINESS DATA BY BRINGING SECURED DATA ALALYTICAL BUSINESS SOLUTIONS</h1></div>';
            // slider 4
            slideshow.append(slider);      
            
            setInterval(function() {
                //$('#slideshow > div:first')
                $('#slideshow > .container:first')
                .fadeOut(1000)
                .next()
                .fadeIn(1000)
                .end()
                .appendTo('#slideshow');
            }, 6000);
        }

        // add button
        const button = '<div class="container" style="margin-top: 50px"><button id="askQuestion" type="button" class="btn btn-success" style="font-size: 16px;">Ask Question</button></div>';
        headerContentWrap.css({'padding':'200px 0 0', 'min-height':'600px'});
        headerContentWrap.append(button);

        const contactUsTitleBtn = $('#askQuestion');
        contactUsTitleBtn.click((e)=> {
            $('html, body').animate({
                scrollTop: $("#contact").offset().top
            }, 2000);
        })        
    }
	//slider

    // home image   
    $('.intro-text').after('<h4 style="color:#FFF;width: 50%; margin-left: auto; margin-right: auto;">We digitiazlize your business and leverage latest cloud technologies, make your business secured and scalable.</h4>');
    $('.about-us').css({'background':'#e2e2e2'});
    $('h2.white-text').css({'color':'#504d4d'});
    $('.white-text.section-legend').css({'color':'#504d4d'});
    
    // About-Us section - convert into Project List    
    $('.about-us').find('.container').find('.row').hide();

    //var baseurl = "<?php echo wp_upload_dir()['baseurl'] ?>";
    //const baseurl = window.location.origin + '/wp-content/uploads';
    var link1   = baseurl + "/2020/01/software_healthcare-solutions.jpg";
    var link2   = baseurl + "/2020/01/software_development_transportation-automotive.jpg";
    var link3   = baseurl + "/2017/07/finance-banking-home.jpg";
    var link4   = baseurl + "/2017/07/ecommerce-retail-home.jpg";
    var link5   = baseurl + "/2017/07/education-human-resources-home.jpg";
    var link6   = baseurl + "/2017/07/travel-hospitality-home.jpg";

    var row0 = '<div class="solutions"><a href="/industries" style="color:#2a2a3c">All Solutions ></a></div>'; 
    var row1 = '<div class="row"><div class="col-lg-4 col-sm-4"><div class="card" style="background-image: url(' + link1 + ')"><div class="card_hover"><h3 class="card__title">Healthcare<br>Software that Empowers Patients and Employees</h3><p class="card__lead" style="margin-bottom: 0px !important;">Aiding healthcare with software</p><span class="button card__button">Read more ><i class="icon-arrow icon-arrow-white"></i></span></div></div></div><div class="col-lg-4 col-sm-4"><div class="card" style="background-image: url(' + link2 + ')"><div class="card_hover"><h3 class="card__title">Transport<br>Automotive</h3><p class="card__lead" style="margin-bottom: 0px !important; width: 190px;">Moving software solutions</p><span class="button card__button">Read more ><i class="icon-arrow icon-arrow-white"></i></span></div></div></div><div class="col-lg-4 col-sm-4"><div class="card" style="background-image: url(' + link3 + ')"><div class="card_hover"><h3 class="card__title">Financial<br>Software Development</h3><p class="card__lead" style="margin-bottom: 0px !important;">Accountable enterprise software</p><span class="button card__button">Read more ><i class="icon-arrow icon-arrow-white"></i></span></div></div></div></div>';
    var row2 = '<div class="row" style="margin-bottom: 80px; margin-top: 25px;"><div class="col-lg-4 col-sm-4"><div class="card" style="background-image: url(' + link4 + ')"><div class="card_hover"><h3 class="card__title">Disrupting<br>Retail Applications</h3><p class="card__lead" style="margin-bottom: 0px !important;">Trend-setting software solutions</p><span class="button card__button">Read more ><i class="icon-arrow icon-arrow-white"></i></span></div></div></div><div class="col-lg-4 col-sm-4"><div class="card" style="background-image: url(' + link5 + ')"><div class="card_hover"><h3 class="card__title">Education<br>Human Resources</h3><p class="card__lead" style="margin-bottom: 0px !important;">Overachieving mobile solutions</p><span class="button card__button">Read more ><i class="icon-arrow icon-arrow-white"></i></span></div></div></div><div class="col-lg-4 col-sm-4"><div class="card" style="background-image: url(' + link6 + ')"><div class="card_hover"><h3 class="card__title">Travel<br>Hotel Reservation Software</h3><p class="card__lead" style="margin-bottom: 0px !important;">Extending comfort with software</p><span class="button card__button">Read more ><i class="icon-arrow icon-arrow-white"></i></span></div></div></div></div>';
    $('.about-us').find('.container').find('.section-header').after( row0 + row1 + row2 );
    $('.section-header').css({'padding-bottom':'0px'});

    // Team section
    $('#team').hide();
    $('.client').hide();

	// Our clinets
    var sample1  = baseurl + "/2020/01/mobile_app_development_sesame_key_study.jpg";
    var sample2  = baseurl + "/2020/01/web_mobile_app_development_billybishop_key_study.jpg";
    var sample3  = baseurl + "/2020/01/web_application_yuidio_key_study.jpg";
	var sample4  = baseurl + "/2020/01/web_mobile_application_reserveamerica_key_study.jpg";
	var sample5  = baseurl + "/2020/01/web_mobile_active_network_key_study.jpg";
	var sample6  = baseurl + "/2020/01/web_mobile_application_reserve_america_key_study.jpg";

	$('#zerif_testim-widget-1').html('<div class="card card-1" style="background-image: url(' + sample1 + '); height: 650px;"></div>');
	$('#zerif_testim-widget-2').html('<div class="card card-2" style="background-image: url(' + sample2 + '); height: 650px;"></div>');
	$('#zerif_testim-widget-3').html('<div class="card card-3" style="background-image: url(' + sample3 + '); height: 650px;"></div>');
	$('#zerif_testim-widget-5').html('<div class="card card-4" style="background-image: url(' + sample4 + '); height: 650px;"></div>');
	$('#zerif_testim-widget-6').html('<div class="card card-5" style="background-image: url(' + sample5 + '); height: 650px;"></div>');
	$('#zerif_testim-widget-7').html('<div class="card card-6" style="background-image: url(' + sample6 + '); height: 650px;"></div>');

	// testimonials
	$('.testimonial').find('.container').css({'margin-top':'-70px'});

    /********************************* Testimonials ********************************************************/
    var img1  = baseurl + "/2017/07/facebook.png";
    var img2  = baseurl + "/2017/07/symantec.png";
    var img3  = baseurl + "/2017/07/ebay.png";
    var img4  = baseurl + "/2017/07/staples.png";
    var img5  = baseurl + "/2017/07/paypal.png";
    var img6  = baseurl + "/2017/07/sesame-street.png";
    var img7  = baseurl + "/2017/07/apple.png";
    var img8  = baseurl + "/2017/07/keybank.png";

    var testimonialsElem1 = '<div class="row" style="margin: 80px 0 70px;"><h1 class="white-text" style="color:rgb(80, 77, 77)">THE BEST BRANDS TRUST US</h1></div>';
    var testimonialsElem2 = '<div class="row"><div class="col-md-3"><div style="background-image: url(' + img1+ '); height: 90px;margin-top:-10px;background-repeat:no-repeat;"></div></div><div class="col-md-3"><div style="background-image: url(' + img2 + '); height: 100px;background-repeat:no-repeat;margin-top:-15px;"></div></div><div class="col-md-3"><div style="background-image: url(' + img3 + '); height: 100px;background-repeat:no-repeat;margin-top:-15px;"></div></div><div class="col-md-3"><div style="background-image: url(' + img4 + '); height: 100px;background-repeat:no-repeat;margin-top:-15px;"></div></div></div>';
    var testimonialsElem3 = '<div class="row" style="margin-bottom: 40px;"><div class="col-md-3"><div style="background-image: url(' + img5 + '); height: 100px;background-repeat:no-repeat;margin-top:-15px;"></div></div><div class="col-md-3"><div style="background-image: url(' + img6 + '); height: 100px;background-repeat:no-repeat;margin-top:-15px;"></div></div><div class="col-md-3"><div style="background-image: url(' + img7 + '); height: 110px;background-repeat:no-repeat;margin-top:-15px;"></div></div><div class="col-md-3"><div style="background-image: url(' + img8 + '); height: 100px;background-repeat:no-repeat;margin-top:-15px;"></div></div></div>';

    $('section[id="testimonials"]').before('<section id="cust-testimonials" style="background: #FFFFFF;"><div class="container">' + testimonialsElem1 + testimonialsElem2 + testimonialsElem3 + '</div></div>');
    /********************************* SESAME APP ********************************************************/
    var headerSesameEl = '<h3 style="color:#030548;padding-left:10px; background-color: #e2e2e2;font-size: 22px;font-weight: bold; font-family: &quot;Trebuchet MS&quot;, Helvetica, sans-serif;">Category: Education</h3>';
    var sesameReadMoreEl = '<div class="readMoreEl-1" style="display: none; float:left; none;position: relative;top: 150px;color: #626263;font-weight: bold;font-size: 22px"><h2 style="text-align:center; color:#63a71d; font-weight:100;">Sesame Street Application</h2><div style="text-align:center;margin-bottom:20px;text-decoration: underline;">Web/Mobile Development</div><div style="font-size: 16px; width: 100%;"><ul><li>Reduce stress and symptoms of attention deficit disorders;</li><li>Boost immunity, energy levels and creativity;</li><li>Increase curiosity and problem-solving ability;</li></ul></div><button style="font-weight: bold;float:right; color:#030548" type="button" class="btn btn-info">READ MORE ></button></div>';

    $('#zerif_testim-widget-1').prepend( headerSesameEl + sesameReadMoreEl);

	$('#zerif_testim-widget-1').click(function(e){
		window.location.href = "http://nextpathtechnology.com/sesame-app";
		e.preventDefault();
	});

	$('#zerif_testim-widget-1').hover(function(e){	   
		$('.card-1').animate({"opacity": 0, "background-color":"#00b4e6"}, 500);
	    $('.readMoreEl-1').show();
    }, function(e){
		$('.card-1').animate({"opacity": 1}, 500);
	    $('.readMoreEl-1').hide();
    });
    /***************************************** billy ************************************************************/
    var headerBillyEl = '<h3 style="color:#030548;padding-left:10px; background-color: #e2e2e2;font-size: 22px;font-weight: bold; font-family: &quot;Trebuchet MS&quot; Helvetica, sans-serif;">Category: Travel</h3>';

    var billyReadMoreEl = '<div class="readMoreEl-2" style="display: none; float:left; none; position: relative;top: 150px;color: #626263;font-weight: bold;font-size: 22px"><h2 style="text-align:center;color:#63a71d; font-weight:100;">Flight Status, Weather & Travel</h2><div style="margin-bottom:20px; margin-left:40px; text-decoration: underline;">Web/Mobile Development</div><div style="font-size: 16px; width: 100%;"><ul><li>Instant access to Shuttle Tracker schedule;</li><li>Your Flight Status of Departure/Arrivals;</li><li>Receive any Travel alerts/updates;</li></ul></div><button style="font-weight: bold;float:right; color:#030548" type="button" class="btn btn-info">READ MORE ></button></div>';

	$('#zerif_testim-widget-2').prepend(headerBillyEl + billyReadMoreEl);
	
    $('#zerif_testim-widget-2').click(function(e){
		window.location.href = "http://nextpathtechnology.com/billy-app";
		e.preventDefault();
	});

	$('#zerif_testim-widget-2').hover(function(e){	   
		$('.card-2').animate({"opacity": 0, "background-color":"#00b4e6"}, 500);
		$('.readMoreEl-2').show();
    }, function(e){
		$('.card-2').animate({"opacity": 1}, 500);
	    $('.readMoreEl-2').hide();
    });
    /***************************************** yidio ************************************************************/
    var headerYidioEl = '<h3 style="color:#030548;padding-left:10px; background-color: #e2e2e2;font-size: 22px;font-weight: bold; font-family: &quot;Trebuchet MS&quot;, Helvetica, sans-serif;">Category: Internet Video</h3>';

    var yidioReadMoreEl = '<div class="readMoreEl-3" style="display:none; float:left; position: relative;color: #626263;font-weight: bold;font-size: 22px"><div style="width:100%"><h3 style="text-align:center; color:#63a71d; font-weight:100;font-weight:500;">Universal Search & Discovery For Any TV</h3></div><h3 style="text-align:center;color:#63a71d; font-weight:100;font-weight:500;">Show Or Movie!</h3><div style="margin-bottom:20px; width:270px; margin-left:auto; margin-right:auto; text-decoration: underline;">Web/Mobile Development</div><div style="font-size: 16px; width: 100%;"><ul style=""><li>Yidio is an online video application that allows you to easily search & discover over 1 million TV Shows and Movies;</li><li>Premium free and paid content services like Netflix, Hulu & Amazon all in one place;</li><li>Angel investors include Alan Warms, CEO of Appolicious, VP/GM of Yahoo, CEO/Co-Founder of Buzz Tracker, Jim Collis and Bill Luby of Seaport Capital, Lon Chow of Apex Venture Partners and Jamie Crouthamel CEO/Founder Performics;</li></ul></div><div style="width:100%"><button style="float:right;color:#030548; font-weight: bold" type="button" class="btn btn-info">READ MORE ></button></div></div>';

	$('#zerif_testim-widget-3').prepend(headerYidioEl + yidioReadMoreEl);

	$('#zerif_testim-widget-3').click(function(e){
		window.location.href = "http://nextpathtechnology.com/yidio-app";
		e.preventDefault();
	});

	$('#zerif_testim-widget-3').hover(function(e){	   
		$('.card-3').animate({"opacity": 0, "background-color":"#00b4e6"}, 500);
		$('.readMoreEl-3').show();
    }, function(e){
		$('.card-3').animate({"opacity": 1}, 500);
		$('.readMoreEl-3').hide();
    });

    /***************************************** reserveamerica ************************************************************/
    var headerReserveamericaEl = '<h3 style="color:#030548;padding-left:10px; background-color: #e2e2e2;font-size:20px;font-weight: bold; font-family: &quot;Trebuchet MS&quot;, Helvetica, sans-serif; height:35px;">Category: Online Reservation</h3>';

  var ulElRA = '<div style="font-size: 16px; width: 90%;"><ul><li>#1 Campground Management Software;</li><li>Proven and Reliable Software. Through our many years in the campground management and reservation industry, we have worked with a wide variety of clients to provide both campground visitors and your staff with an uninterrupted, clean experience;</li><li>Increased Reservations and Visibility. Get your campground listed on ReserveAmerica.com, the leading online camping reservations site. It eliminates the need to pay for or consume your own time with online marketing; we take care of that for you, and at no additional cost.</li></ul></div>'; 

    var reserveamericaReadMoreEl = '<div class="readMoreEl-4" style="display:none; float:left; position: relative;top: 5px;color: #626263;font-weight: bold;font-size: 22px"><h2 style="text-align:center;color:#63a71d; font-weight:500">Find Available Campsites !</h2><div style="margin-bottom:20px; width:270px; margin-left:auto; margin-right:auto; text-decoration: underline;">Web/Mobile Development</div>' + ulElRA + '<button style="margin-top:-10px;float:right;color:#030548;font-weight: bold" type="button" class="btn btn-info">READ MORE ></button></div>';

	$('#zerif_testim-widget-5').prepend(headerReserveamericaEl + reserveamericaReadMoreEl);

	$('#zerif_testim-widget-5').click(function(e){
		window.location.href = "http://nextpathtechnology.com/reserveamerica-app";
		e.preventDefault();
	});

	$('#zerif_testim-widget-5').hover(function(e){	   
		$('.card-4').animate({"opacity": 0, "background-color":"#00b4e6"}, 500);
		$('.readMoreEl-4').show();
    }, function(e){
		$('.card-4').animate({"opacity": 1}, 500);
		$('.readMoreEl-4').hide();
    });
    /***************************************** active5 *********************************************************/
    var headerActiveEl = '<h3 style="color:#030548;padding-left:10px; background-color: #e2e2e2;font-size:22px;font-weight: bold; font-family: &quot;Trebuchet MS&quot;, Helvetica, sans-serif;">Category: Sport/Fitness</h3>';

var title2Active5El = '<div style="margin-bottom:20px; width:270px; margin-left:auto; margin-right:auto; text-decoration: underline;">Web/Mobile Development</div>';

  var ulElActive = '<div style="font-size: 16px; width: 90%;"><ul><li>The Technology That Powers Activities And Fuels Growth Through Data & Insights</li><li>Personal Trainers. Custom Motivational Tips</li><li>Save and Retrieve Data. Share with buddies</li></ul></div>'; 

    var active5kReadMoreEl = '<div class="readMoreEl-5" style="display:none; left:10px; float:left; position: relative;top: 150px;color: #626263;font-weight: bold;font-size: 22px"><h2 style="text-align:center;color:#63a71d; font-weight:500">Couch to 5K® - Running App and Training Coach</h2>' + title2Active5El + ulElActive + '<div style="width:100%;"><div style="width:150px;margin-left: auto; margin-right: auto;"><button style="color:#030548;font-weight: bold" type="button" class="btn btn-info">READ MORE ></button></div></div></div>';

	$('#zerif_testim-widget-6').prepend(headerActiveEl + active5kReadMoreEl);

	$('#zerif_testim-widget-6').click(function(e){
		window.location.href = "http://nextpathtechnology.com/active5k-app";
		e.preventDefault();
	});

	$('#zerif_testim-widget-6').hover(function(e){	   
		$('.card-5').animate({"opacity": 0, "background-color":"#00b4e6"}, 500);
		$('.readMoreEl-5').show();
    }, function(e){
		$('.card-5').animate({"opacity": 1}, 500);
		$('.readMoreEl-5').hide();
    });
    /***************************************** hunt-fish ************************************************************/
    var headerHuntFishEl = '<h3 style="color:#030548;padding-left:10px; background-color: #e2e2e2;font-size: 22px;font-weight: bold; font-family: &quot;Trebuchet MS&quot;, Helvetica, sans-serif;">Category: Business/Licensing</h3>';

var title2HuntFishEl = '<div style="margin-bottom:20px; width:270px; margin-left:auto; margin-right:auto; text-decoration: underline;">Web/Mobile Development</div>';

  var ulElHuntFish = '<div style="font-size: 16px; width: 90%;"><ul><li>Purchase, download & store hunting and fishing licenses right from your mobile device.</li><li>Purchase Licenses</li><li>Keep Track of Your Adventures</li></ul></div>'; 

    var huntFishReadMoreEl = '<div class="readMoreEl-6" style="display:none; left:5px; float:left; position: relative;top: 150px;color: #626263;font-weight: bold;font-size: 22px"><h3 style="text-align:center;color:#63a71d; font-weight:500">HUNTING & FISHING Application</h3>' + title2HuntFishEl + ulElHuntFish + '<div style="width:100%;"><div style="width:150px;margin-left: auto; margin-right: auto;"><button style=";color:#030548;font-weight: bold" type="button" class="btn btn-info">READ MORE ></button></div></div></div>';

	$('#zerif_testim-widget-7').prepend(headerHuntFishEl + huntFishReadMoreEl);

	$('#zerif_testim-widget-7').click(function(e){
		window.location.href = "http://nextpathtechnology.com/hunt-fish-app";
		e.preventDefault();
	});

	$('#zerif_testim-widget-7').hover(function(e){	   
		$('.card-6').animate({"opacity": 0, "background-color":"#00b4e6"}, 500);
		$('.readMoreEl-6').show();
    }, function(e){
		$('.card-6').animate({"opacity": 1}, 500);
		$('.readMoreEl-6').hide();
    });

    // header changes
    var headerEl = '<div style="margin-top: 20px;color: #57576b;text-decoration: underline;"><h2 id="logo-text" style="clear: none;">NEXT PATH TECHNOLOGY</h2></div>';
    $('.navbar-brand').after(headerEl);
    $('.navbar-header').css({'width':'40%'});
    
    setTimeout(function(){
		$("div[data-sr-init='true']").last().removeAttr("style");
    }, 1500); 
    
    $('#logo-text').click(function(){
        window.location.href = "http://nextpathtechnology.com";
		e.preventDefault();
    });    
});