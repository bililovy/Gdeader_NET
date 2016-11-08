var count = 1;

$(document).ready(function(){
	
	initPage();	
	
});


function initPage(){	
	initCountry();
	
	bootValidateJsonp(pageValidateConfig.forms);	
	
	$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
	
	$("#refreshImage").click(function() {
		$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
		return false;
	});
}

var pageValidate = {
	fields:{
		/*firstName: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }
			}
		},
		lastName: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }
			}
		},*/
		accountEmail: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                },
				emailAddress: {
                    message: bootstrapValidatorMsg.email
                }/*,
				remote: {
	                type: 'POST',
	                url: ucUrl + '/noaccount/email/validate',
	                message: 'The order is not available',
	                delay: 1000
            	}*/
			}
		},
		password: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                },
               /* identical: {
                    field: 'confirmPwd',
                    message: bootstrapValidatorMsg.passwordIdentical
                },*/
                different: {
                    field: 'accountEmail',
                    message: bootstrapValidatorMsg.passwordDifferent
                },
                stringLength: {
                    min: 6,
                    max: 15,
                    message: bootstrapValidatorMsg.passwordLength
                },
                regexp: {
                    regexp: /^[a-zA-Z0-9_\.]+$/,
                    message: bootstrapValidatorMsg.passwordRegexp
                }
			}
		},
		confirmPwd: {
			validators: {
                notEmpty: {
                    message: bootstrapValidatorMsg.required
                },
                identical: {
                    field: 'password',
                    message: bootstrapValidatorMsg.confirmPwdIdentical
                },
                different: {
                    field: 'accountEmail',
                    message: bootstrapValidatorMsg.passwordDifferent
                },
                stringLength: {
                    min: 6,
                    max: 15,
                    message: bootstrapValidatorMsg.passwordLength
                },
                regexp: {
                    regexp: /^[a-zA-Z0-9_\.]+$/,
                    message: bootstrapValidatorMsg.passwordRegexp
                }
            }
		},		
		captcha:{
			validators:{
				notEmpty:{
					message: bootstrapValidatorMsg.required
				}
			}
		}
	}
};

function initCountry(){
	$.ajax({
		url:ctxPath+"/cs/sys/country/list", 
		type:"POST",			
		success:function(result){	 
			var countryList = [];
			var data = $.parseJSON(result); 
			if(data){
				for(var i = 0; i < data.length; i++){
					var c = data[i];
					var select = '';
					if(1 == c.countryId){
						select = 'selected="selected"';
					}
					countryList.push('<option value="' + c.countryId + '" ' + select +'>' + c.countryName + '</option>');
				}
				$('#countryId').empty();
				$('#countryId').append(countryList.join(''));
			}																
		}
	});		
}

var pageValidateConfig = {
	forms:[{
		id:'registerForm',
		submit:true,
		url: ucUrl + '/noaccount/register',
		validate:pageValidate,
		callbackFn:"registerCallback",
		confirmFn:function(rtmsg){
			
		}
	}]
};


function registerCallback(rtmsg){
	if(rtmsg.SUCCESS){	
		//window.location.href= ctxPath + "/register-confirm.html";		
		window.location.href= ucUrl + "/account/superuser";			
	}else{
		$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
		
		$('#boxModalTitle').html(PromptMsg.prompt);
		if(rtmsg._alert){
			var $alert = rtmsg._alert;
			if ($alert.exception) {
				$('#boxModalBody').html($alert.exception);
			}
			if ($alert.error) {
				$('#boxModalBody').html($alert.error);
			}
		}else{
			$('#boxModalBody').html(rtmsg.MESSAGE);
		}
		
		var opt = function () {			
			$("#captcha").val("");
		};
		$('#boxModal').modal('show');
		$('#boxModal').on('hide.bs.modal', opt);				
	} 
}