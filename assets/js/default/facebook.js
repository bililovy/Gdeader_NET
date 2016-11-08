// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
		return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1701677533432695";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function() {
	FB.init( {
		appId : '{1701677533432695}',
		cookie : true, // enable cookies to allow the server to access
		// the session
		xfbml : true, // parse social plugins on this page
		version : 'v2.6', // use version 2.2
		oauth : true
	});
};

function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

function fbLogin() {
	FB.login(function(response){
		statusChangeCallback(response);
	},{scope: 'public_profile,email'});
}

function statusChangeCallback(response) {
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		fbLoginSuccess();
	} else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		//document.getElementById('status').innerHTML = 'Please log '	+ 'into this app.';
		console.log('Please log ' + 'into this app.');
		fbLogin();
	} else {
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
		//document.getElementById('status').innerHTML = 'Please log '	+ 'into Facebook.';
		console.log('Please log ' + 'into Facebook.');
		fbLogin();
	}
}

function fbLoginSuccess() {
	FB.api('/me?fields=id,name,email,gender,first_name,last_name', function(response) {
		var jsonData = { "userId": response.id, 
         	      		 "name" : response.name,
         	      		 "email" : response.email,
         	      		 "gender" : response.gender,
         	      		 "firstName" : response.first_name,
         	      		 "lastName" : response.last_name,
         	      		 "originalSource":"facebook"
					};
		var jsonStr = JSON.stringify(jsonData);
		$.ajax({
			type: 'POST',				
			url:ucUrl +  '/noaccount/facebook/login', 
			dataType : "jsonp",
			jsonp:'callback',  
			jsonpCallback:"loginCallback",
			data: {"jsonData":jsonStr, "brandId": brandId, "brand": brand, "langId": langId, "langCode": langCode},				
			success:function(json){	
				
			},
			beforeSend : function(XMLHttpRequest) {				
				$.widgets.loading.init();
			},
			complete : function(XMLHttpRequest, textStatus) {
				$.widgets.loading.destroy();
			}
		});	
	});
}


function twitterLogin() {
	var jsonData = { "brandId": brandId, 
					 "brand": brand, 
					 "langId": langId, 
			         "langCode": langCode
				};
	var jsonStr = JSON.stringify(jsonData);
	$.ajax({
		type: 'POST',				
		url:ucUrl +  '/noaccount/twitter/login', 
		dataType : "jsonp",
		jsonp:'callback',  
		jsonpCallback:"twitterLoginCallback",
		data: jsonData,				
		success:function(json){	
			
		},
		beforeSend : function(XMLHttpRequest) {				
			$.widgets.loading.init();
		},
		complete : function(XMLHttpRequest, textStatus) {
			$.widgets.loading.destroy();
		}
	});	
}

function twitterLoginCallback(rtmsg){
	if(rtmsg.SUCCESS){	
		window.location.href = rtmsg.authenticationURL;		
	}else{
		$('#boxModalTitle').html(PromptMsg.prompt);
		$('#boxModalBody').html(PromptMsg.msgError);
		opt = function () {
			//$("#jcaptchaImage").attr("src", ctxPath+"/front/jcaptcha?now=" + new Date().getTime());
		};
		
		$('#boxModal').modal('show');
		$('#boxModal').on('hide.bs.modal', opt);
	}  	
}