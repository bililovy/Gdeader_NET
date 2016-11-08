/**
 * 登陆页面JS
 */
$().ready(function(){
	initPage();
	
	$("#resetPwd").click(function() {
		$("#accountEmail").val("");
		var checked   = $(this).is(':checked');
		if(checked){
			$('#resetPwdModal').modal('show');
		}else{
			$('#resetPwdModal').modal('hide');
		}
	});
});

function initPage(){
	bootValidateJsonp(login.forms);
	bootValidateJsonp(resetPwd.forms);
}

var pageValidate = {
	fields:{			
		email: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                },
				emailAddress: {
                    message: bootstrapValidatorMsg.email
                }
			}
		},
		password: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }
			}
		}
	}
};

var pageValidateResetPwd = {
		fields:{			
			accountEmail: {
				validators:{
					/*notEmpty: {
	                    message: bootstrapValidatorMsg.required
	                },
					emailAddress: {
	                    message: bootstrapValidatorMsg.email
	                }*/
				}
			}
		}
	};


var login = {
	forms:[{
		id:'loginForm',
		submit:true,
		url: ucUrl + '/noaccount/login',
		validate:pageValidate,
		callbackFn:"loginCallback",
		confirmFn:function(rtmsg){
			
		}
	}]
};

var resetPwd = {
	forms:[{
		id:'resetPwdForm',
		submit:true,
		url: ucUrl + '/noaccount/password/reset',
		validate:pageValidateResetPwd,
		callbackFn:"resetPwdCallback",
		confirmFn:function(rtmsg){
			
		},
		beforeSendFn:function(){
			$('#msgTip').text("");
		}
	}]
};


function openResetPwdModal(){
	$('#resetPwdModal').modal('show');
}


function resetPwdCallback(rtmsg){
	var opt;
	if(rtmsg.SUCCESS){
		$('#resetPwdModal').modal('hide');
		
		$('#boxModalTitle').html(PromptMsg.prompt);
		opt = function () {
			
		};
		$('#boxModalBody').html(rtmsg.MESSAGE);
		$('#boxModal').modal('show');
		$('#boxModal').on('hide.bs.modal', opt);
	}else{
		$('#msgTip').text(rtmsg.MESSAGE);
		$('#msgTip').show();
	}  	
}

function loginCallback(rtmsg){
	var opt;
	if(rtmsg.SUCCESS){
		//$('#boxModalTitle').html(PromptMsg.prompt);
		//$('#boxModalBody').html(rtmsg.MESSAGE);
		
		setSession(rtmsg.email, rtmsg.username);
		
	}else{
		$('#boxModalTitle').html(PromptMsg.prompt);
		$('#boxModalBody').html(rtmsg.MESSAGE);
		opt = function () {
			//$("#jcaptchaImage").attr("src", ctxPath+"/front/jcaptcha?now=" + new Date().getTime());
		};
		
		$('#boxModal').modal('show');
		$('#boxModal').on('hide.bs.modal', opt);
	}  		
}

function setSession(email, username) {
	var dateTime = new Date().getTime();
	$.ajax({
		url:ctxPath +  '/customer/login/asyn', 
		data: {
			email: email,
			username: username,
			randDate: dateTime			
		},				
		type: 'POST',			
		dataType: 'JSON',
		success:function(json){	
			window.location.href= ucUrl + '/account/welcome';
		}
	});	
}