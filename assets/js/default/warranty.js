var count = 1;

$(document).ready(function(){
	
	initPage();
	
	$("#count").val(count);
	
	$("#now").click(function() {
		$('html,body').animate({ scrollTop: $('#form').offset().top }, 1250); 
	});
});


function initPage(){	
	
	initWarrantyIntro();
	
	initCountry();
	
	bootValidateJsonp(pageValidateConfig.forms);
	
	isRecommended();

	//addSerialNum();
	
	//initCategoryParent('categoryParentid1');	
	
	//getProductModel('model1', $('#categoryParentid1').val());
	
	//getCategoryItem('categoryItemid1', $('#model1').val());
	
	$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
	
	$("#refreshImage").click(function() {
		$("#jcaptchaImage").attr("src", ucUrl+"/jcaptcha?now=" + new Date().getTime());
		return false;
	});
	
	$("#isRecommended").click(function() {
		var checked   = $(this).is(':checked');
		if(checked){
			$('#myModal').modal('show');
		}
	});
	// select language
	$("#langCode").val(langCode);
}

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
					var langId = 1;
					if("en" == langCode){
						langId = 1;
					}else if("de" == langCode){
						langId = 2;
					}else if("fr" == langCode){
						langId = 3;
					}else if("it" == langCode){
						langId = 4;
					}else if("jp" == langCode){
						langId = 7;
					}else if("es" == langCode){
						langId = 9;
					}
					if(langId == c.countryId){
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
                },
               /* identical: {
                    field: 'confirmPwd',
                    message: bootstrapValidatorMsg.passwordIdentical
                },*/
                different: {
                    field: 'email',
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
                    field: 'email',
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
		orderNo: {
			validators:{
				notEmpty:{
					message: bootstrapValidatorMsg.required
				},
                regexp: {
                    regexp: /^(\d{3}-\d{7}-\d{7})+$/,
                    message: bootstrapValidatorMsg.orderNoRegexp
                }/*,
				remote: {
                    type: 'POST',
                    url: ctxPath + '/order/validate',
                    message: 'The order is not available',
                    delay: 1000
                }*/
			}
		},/*
		categoryItemid1: {
			validators:{
				notEmpty:{
					message: bootstrapValidatorMsg.required
				}
			}
		},*/
		captcha:{
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
		id:'warrantyForm',
		submit:true,
		url: ucUrl + '/noaccount/warranty/register',
		validate:pageValidate,
		callbackFn:"warrantyCallback",
		confirmFn:function(rtmsg){
			
		}
	}]
};

function warrantyCallback(rtmsg){
	if(rtmsg.SUCCESS){				
		window.location.href= ctxPath + "/register-confirm.html";				
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


function isRecommended(){
	$("#warrantyForm")
	.on('init.form.bv', function(e, data) {
		 console.log('init element --> ', data.field, data.element, data.options);
    })
	.on('added.field.bv', function(e, data) {
		 console.log('Added element --> ', data.field, data.element, data.options);
     })
    .on('removed.field.bv', function(e, data) {
    	 var $parent = data.element.parents('.form-group'),
         $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]');
    	 $small  = $parent.find('.help-block[data-bv-for="' + data.field + '"]');

    	 // From v0.5.3, you can retrieve the icon element by
    	 //$icon = data.element.data('bv.icon');
	
    	 /*$icon.on('click.clearing', function() {
	          // Check if the field is valid or not via the icon class
	          if ($icon.hasClass('glyphicon-remove')) {
	              // Clear the field
	              data.bv.resetField(data.element);
	          }
	      });*/
    	  
    	 $parent.removeClass('has-error');    	 
    	 $icon.hide();
    	 $small.hide();
	      
     })
	.on("change", 'input[type="checkbox"][name="isRecommended"]', function() {
		 var checked   = $(this).is(':checked');
		 
		 if (checked) {
			  $orderNo = $('#warrantyForm').find('input[name="orderNo"]').eq(0),
              //$serialNum  = $('#warrantyForm').find('input[name="serialNum1"]').eq(0);
			  $categoryItem  = $('#warrantyForm').find('input[name="categoryItemid1"]').eq(0);
			  
			 $('#warrantyForm').bootstrapValidator('removeField', $orderNo);
			 $('#warrantyForm').bootstrapValidator('removeField', $categoryItem);
			
		 }else{
			 $('#warrantyForm').bootstrapValidator('addField', $orderNo,{
	              validators: {
	                  notEmpty: {
	                      message: bootstrapValidatorMsg.required
	                  }
	              }
	          });
			 $('#warrantyForm').bootstrapValidator('addField', $categoryItem,{
	              validators: {
	                  notEmpty: {
	                      message: bootstrapValidatorMsg.required
	                  }
	              }
	          });
		 }
	});
}


function addSerialNum(){
	$('.addButton').on('click', function() {
		  ++count;
		  $("#count").val(count);

        var template     = $(this).attr('data-template'),
            $templateEle = $('#' + template + 'Template'),
            $row         = $templateEle.clone().removeAttr('id').insertBefore($templateEle).removeClass('hide'),
            
            $templateEle2 = $('#' + template + 'Template2'),
            $row2         = $templateEle2.clone().removeAttr('id').insertBefore($templateEle).removeClass('hide'),
            
            $select0     = $row.find('select').eq(0);
            $select0.attr('name', template + "Parentid" + count); 
            $select0.attr('id', template + "Parentid" + count);
            $select0.attr('onchange', "javascript:getProductModel('" + "model" + count + "', this.value);");
            
            $select1     = $row.find('select').eq(1);
            $select1.attr('name', "model" + count); 
            $select1.attr('id', "model" + count);
            $select1.attr('onchange', "javascript:getCategoryItem('" + template + "Itemid" + count + "', this.value);");
            
            $select2     = $row2.find('select').eq(0);            
            $select2.attr('name', template + "Itemid" + count);
            $select2.attr('id', template + "Itemid" + count);
            
            $href     = $row2.find('a').eq(0);            
            $href.attr('id', template + "Href" + count);
            
            if(count > 2){
            	$("#" + template + "Href" + (count - 1)).addClass("hide");
            }
            
            var js = [];
            js.push('<script type="text/javascript">\
    				initCategoryParent("' + template + 'Parentid' + count + '");\
    				getProductModel("' + 'model' + count + '", $("#' + template + 'Parentid' + count + '").val());\
    				getCategoryItem("' + template + 'Itemid' + count + '", $("#' + 'model' + count + '").val());\
    				</script>');
            
            $row.append(js.join(''));		
            
        $('#warrantyForm').bootstrapValidator('addField', $select2,{
	              validators: {
	                  notEmpty: {
	                      message: bootstrapValidatorMsg.required
	                  }
	              }
	          }	  
        );

        
        //$el.attr('placeholder', 'ex:FDSEOFD4');
       

        $row2.on('click', '.removeButton', function(e) {
            $('#warrantyForm').bootstrapValidator('removeField', $select2);
            $row.remove();
            $row2.remove();
            --count;
            $("#count").val(count);
            
            if(count > 1){
            	$("#" + template + "Href" + count).removeClass("hide");
            }
        });
	});
}

function initCategoryParent(tagId){
	var categoryList = [];
	categoryList.push('<option value="0">--Category--</option>');
	if(categoryParents){
		for(var i = 0; i < categoryParents.length; i++){
			var c = categoryParents[i];
			categoryList.push('<option value="' + c.categoryId + '">' + c.categoryName + '</option>');
		}
		$('#' + tagId).empty();
		$('#' + tagId).append(categoryList.join(''));
	}
}

function getProductModel(tagId, categoryId){
	var categoryList = [];
	categoryList.push('<option value="">--Model--</option>');
	if(categoryProducts){
		for(var i = 0; i < categoryProducts.length; i++){
			var c = categoryProducts[i];
			if(c.id == categoryId){
				var childs = c.modelList;
				if(childs){
					for(var j = 0; j < childs.length; j++){
						categoryList.push('<option value="' + childs[j] + '">' + childs[j] + '</option>');
					}
				}
				//break;
			}
		}
		$('#' + tagId).empty();
		$('#' + tagId).append(categoryList.join(''));
	}
}

function getCategoryItem(tagId, model){
	var categoryList = [];
	categoryList.push('<option value="">--select--</option>');
	if(categoryProducts){
		for(var i = 0; i < categoryProducts.length; i++){
			var cat = categoryProducts[i];
			var childs = cat.children;
			if(childs){
				for(var j = 0; j < childs.length; j++){
					if(model == childs[j].model){
						categoryList.push('<option value="' + childs[j].id + '">' + childs[j].text + '</option>');
					}
					
				}
			}
		}
		$('#' + tagId).empty();
		$('#' + tagId).append(categoryList.join(''));
	}
}

function initWarrantyIntro(){
	$.ajax( {
		url : ctxPath + "/template/warranty_intro_" + langCode + ".jsp",
		dataType : 'html',
		success : function(msg) {
			$('#warrantyIntro').children().remove();
			$('#warrantyIntro').append(msg);
		}
	});
}

function changeLanguage(lauguage) {
	$.ajax( {
		url : ctxPath + "/change/language",
		type : "POST",
		dataType : "json",
		data : {
			langCode : lauguage
		},
		success : function(rtmsg) {
			//window.location.reload(true);
			window.location.href = ctxPath + "/product-registration?source=" + rtmsg.MESSAGE;
		},
		cache : false
	});
}