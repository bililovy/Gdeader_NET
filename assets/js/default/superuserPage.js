var count = 1;

// Global variable
var globalCountry;

$(document).ready(function(){
	
	initPage();
	
	$("#count").val(count);
	
	// 暂停1秒 动态加载值
	setTimeout(1000);
	
	bootValidateJsonp(pageValidateOneConfig.forms);
	
	bootValidateJsonp(pageValidateConfig.forms);
	
	$("[data-toggle='tooltip']").tooltip(); 
	
	$(".q1").hover(function(){
	    $(".qa-box1").toggle();
	});
	/**  
	$(".q2").hover(function(){
		$(".qa-box2").toggle();
	});*/	 
});


function initPage(){	
	initReviewerProfile1();
	
	initReviewChannel('reviewChannel1');
	
	//initReviewInterest();
	
	initReviewerProfile2();
	
	initCountry();
	
	addReviewChannel();
	
	$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
	
	$("#refreshImage").click(function() {
		$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
		return false;
	});
	
	$('.superuser-register-form').hide();
	
	$('#back-btn').click(function() {
		$('.base-register-form').show();
		$('.superuser-register-form').hide();
		$('#superUserLi').removeClass("active");
		$('#accountEmail').focus();
	});
	
	$("#stateNameDiv").hide();
		
}

function initReviewerProfile1(){
	$.ajax({
		url:ctxPath+"/cs/sys/reviewer/profile1/list", 
		type:"POST",			
		success:function(result){	 
			var rpList = [];
			var data = $.parseJSON(result); 
			if(data){
				for(var i = 0; i < data.length; i++){
					var c = data[i];
					rpList.push('<option value="' + c.parameterValue + '">' + c.parameterName + '</option>');
				}
				$('#reviewerProfile1').empty();
				$('#reviewerProfile1').append(rpList.join(''));
			}																
		}
	});		
}

function initReviewerProfile2(){
	$.ajax({
		url:ctxPath+"/cs/sys/reviewer/profile2/list", 
		type:"POST",			
		success:function(result){	 
			var rpList = [];
			var data = $.parseJSON(result); 
			if(data){
				for(var i = 0; i < data.length; i++){
					var c = data[i];
					rpList.push('<option value="' + c.parameterValue + '">' + c.parameterName + '</option>');
				}
				$('#reviewerProfile2').empty();
				$('#reviewerProfile2').append(rpList.join(''));
			}																
		}
	});		
}

function initReviewChannel(tagId){
	$.ajax({
		url:ctxPath+"/cs/sys/reviewer/channel/list", 
		type:"POST",			
		success:function(result){	 
			var rcList = [];
			var data = $.parseJSON(result); 
			if(data){
				for(var i = 0; i < data.length; i++){
					var c = data[i];
					//rcList.push('<input type="checkbox" name="reviewChannel[]" value="' + c.parameterValue + '"/>' + c.parameterName + '<input type="text" id="reviewChannel' + c.parameterValue + '" name="reviewChannel' + c.parameterValue + '" class="form-control">');
					rcList.push('<option value="' + c.parameterValue + '">' + c.parameterName + '</option>');
				}
				$('#' + tagId).empty();
				$('#' + tagId).append(rcList.join(''));
			}																
		}
	});		
}

function initReviewInterest(){
	$.ajax({
		url:ctxPath+"/cs/sys/reviewer/interest/list", 
		type:"POST",			
		success:function(result){	 
			var riList = [];
			var data = $.parseJSON(result); 
			if(data){
				for(var i = 0; i < data.length; i++){
					var c = data[i];
					riList.push('<label class="checkbox-inline"><input type="checkbox" name="reviewInterest[]" value="' + c.parameterValue + '"/>' + c.parameterName + '</label>');
				}
				$('#interestAppend').empty();
				$('#interestAppend').append(riList.join(''));
			}																
		}
	});		
}

function initCountry(){
	$.ajax({
		url:ctxPath+"/cs/sys/country/list", 
		type:"POST",			
		success:function(result){	 
			var countryList = [];
			var stList = [];
			var data = $.parseJSON(result); 
			globalCountry = data;
			if(data){
				for(var i = 0; i < data.length; i++){
					var c = data[i];
					var select = '';
					if(1 == c.countryId){
						select = 'selected="selected"';
					}
					countryList.push('<option value="' + c.countryId + '" ' + select +'>' + c.countryName + '</option>');
					
					if(1 == c.countryId){
						if(c.stateList){
							for(var j = 0; j < c.stateList.length; j++){
								var st = c.stateList[j];
								select = '';
								if(1 == st.stateId){
									select = 'selected="selected"';
								}
								stList.push('<option value="' + st.stateId + '" ' + select +'>' + st.stateName + '</option>');
							}
						}
					}
				}
				$('#countryId').empty();
				$('#countryId').append(countryList.join(''));
				
				$('#stateId').empty();
				$('#stateId').append(stList.join(''));
			}																
		}
	});		
}


var pageValidateOne = {
		fields:{
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
			}
		}
	};

var pageValidateOneConfig = {
		forms:[{
			id:'registerForm',
			submit:true,
			url: ucUrl + '/noaccount/superuser/register/one',
			validate:pageValidateOne,
			callbackFn:"superuserRegisterOneCallback",
			confirmFn:function(rtmsg){
				
			}
		}]
	};

function superuserRegisterOneCallback(rtmsg){
	if(rtmsg.SUCCESS){	
		$('.base-register-form').hide();		
		$('.superuser-register-form').show();
		$('#superUserLi').addClass("active");
		
		$('#accountTempId').val(rtmsg.accountTempId);
		$('#superuserAccountEmail').val(rtmsg.accountTemp.accountEmail);
		$('#superuserPassword').val(rtmsg.accountTemp.password);
	}else{
		$('#boxModalTitle').html(PromptMsg.prompt);
		$('#boxModalBody').html(rtmsg.MESSAGE);
		var opt = function () {
			
		};
		$('#boxModal').modal('show');
		$('#boxModal').on('hide.bs.modal', opt);				
	} 
}

var pageValidate = {
	fields:{			
		firstName: {
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
		},
		/*phone: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }               
			}
		},*/
		countryId: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }               
			}
		},/*	
		state: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }               
			}
		},	*/
		city: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }               
			}
		},	
		address: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }               
			}
		},	
		zip: {
			validators:{
				notEmpty: {
                    message: bootstrapValidatorMsg.required
                }               
			}
		},	
		amzProfileLink: {
			validators: {
				notEmpty:{
					message: bootstrapValidatorMsg.required
				},
                uri: {
                    message: bootstrapValidatorMsg.url
                },
                regexp: {
                    regexp: /^(.*?)profile(.*?)$/,
                    message: bootstrapValidatorMsg.profileUrl
                }
            }
		},
		'reviewChannelValue1': {
			validators: {
				/*notEmpty:{
					message: bootstrapValidatorMsg.required
				},*/
                uri: {
                    message: bootstrapValidatorMsg.url
                }
            }
		},
		/*'reviewInterest[]': {
			validators: {
				notEmpty:{
					message: bootstrapValidatorMsg.required
				}
            }
		},*/
		captcha:{
			feedbackIcons:'false',
			validators:{
				notEmpty:{
					message: bootstrapValidatorMsg.required
				}
			}
		}
	}
};

var pageValidateConfig = {
	forms:[{
		id:'superuserForm',
		submit:true,
		url: ucUrl + '/noaccount/superuser/register',
		validate:pageValidate,
		callbackFn:"superuserRegisterCallback",
		confirmFn:function(rtmsg){
			
		}
	}]
};

function superuserRegisterCallback(rtmsg){
	if(rtmsg.SUCCESS){	
		window.location.href= ucUrl + "/account/superuser";			
	}else{
		$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
		
		$('#boxModalTitle').html(PromptMsg.prompt);
		$('#boxModalBody').html(rtmsg.MESSAGE);
		var opt = function () {
			$("#captcha").val("");
		};
		$('#boxModal').modal('show');
		$('#boxModal').on('hide.bs.modal', opt);				
	} 
}

function addReviewChannel(){
	$('.addButton').on('click', function() {
		  ++count;
		  $("#count").val(count);

        var template     = $(this).attr('data-template'),
            $templateEle = $('#' + template + 'Template'),
            $row         = $templateEle.clone().removeAttr('id').insertBefore($templateEle).removeClass('hide'),
            
            $select     = $row.find('select').eq(0);
            $select.attr('name', template + count); 
            $select.attr('id', template + count);
            
            $input     = $row.find('input').eq(0);
            $input.attr('name', template + 'Value' + count); 
            $input.attr('id', template + 'Value' + count);   
            
            $href     = $row.find('a').eq(0);            
            $href.attr('id', template + "Href" + count);
            
            if(count > 2){
            	$("#" + template + "Href" + (count - 1)).addClass("hide");
            }   
            
            var js = [];
            js.push('<script type="text/javascript">initReviewChannel("' + template + count + '");</script>');
            
            $row.append(js.join(''));	       
	        
	        $('#superuserForm').bootstrapValidator('addField', $input,{
	              validators: {
	                  notEmpty: {
	                      message: bootstrapValidatorMsg.required
	                  },
	                  uri: {
	                      message: bootstrapValidatorMsg.url
	                  }
	              }
	          }	  
	        );


        $row.on('click', '.removeButton', function(e) {
            $('#superuserForm').bootstrapValidator('removeField', $input);
            $row.remove();
            --count;
            $("#count").val(count);
            
            if(count > 1){
            	$("#" + template + "Href" + count).removeClass("hide");
            }
        });
	});
}

function getStates(countryId){
	var stList = [];
	var flag = true;
	if(globalCountry){
		for(var i = 0; i < globalCountry.length; i++){
			var c = globalCountry[i];
			if(countryId == c.countryId){
				stList = [];
				if(c.stateList && c.stateList.length > 0){					
					for(var j = 0; j < c.stateList.length; j++){
						var st = c.stateList[j];
						select = '';
						if(1 == st.stateId){
							select = 'selected="selected"';
						}
						stList.push('<option value="' + st.stateId + '" ' + select +'>' + st.stateName + '</option>');
					}
					
					$("#state").val("");
					$("#stateNameDiv").hide();	
					
					$('#superuserForm').bootstrapValidator('removeField', $('#state'),{
			              validators: {
			                  notEmpty: {
			                      message: bootstrapValidatorMsg.required
			                  }
			              }
			          }	  
			        );
					
					$("#stateIdDiv").show();				
					
					$('#stateId').empty();
					$('#stateId').append(stList.join(''));
					
					flag = false;
				}
			}
		}		
	}
	
	if(flag){
		$('#stateId').empty();
		$("#stateIdDiv").hide();
		
		$("#stateNameDiv").show();
		
		 $('#superuserForm').bootstrapValidator('addField', $('#state'),{
              validators: {
                  notEmpty: {
                      message: bootstrapValidatorMsg.required
                  }
              }
          }	  
        );
	}
}