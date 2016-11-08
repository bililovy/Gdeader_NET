$(document).ready(function(){
	
	initPage();
	
	bootValidate(subscribeValidateConfig.forms);
	
	var slider = $('.mis-stage').miSlider({
		stageHeight: 380,
		slidesOnStage: false,
		slidePosition: 'center',
		slideStart: 'mid',
		slideScaling: 150,
		offsetV: -5,
		centerV: true,
		navButtonsOpacity: 1
	});
	
	$('#msgTxt').hide();
});


function initPage(){	
	//$("#countryId").val(countryId);
}

function changeCountry(txtid){
	window.location.href= ctxPath + "/promotion?country=" + txtid;
}


function setDealId(id, promotionType){
	$("#dealId").val(id);
	$("#email").val("");
	$("#msgTxt").hide();
	if('giveawayProductDeal' == promotionType){
		$("#subscribeProductTitle").html("please enter your email address to get giveaway link");
	}else{
		$("#subscribeProductTitle").html("please enter your email address to get code");
	}
}

var subscribeValidate = {
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
		}
	}
};

var subscribeValidateConfig = {
	forms:[{
		id:'subscribeForm',
		submit:true,
		url: '/edm/product/request/save',
		validate:subscribeValidate,
		confirmFn:function(rtmsg){
			if(rtmsg.SUCCESS){		
				$('#subscribeProductModel').modal('hide');
				
				$('#boxModalTitle').html(PromptMsg.prompt);
				$('#boxModalBody').html(rtmsg.MESSAGE);
				var opt = function () {
					$('#email').val("");
					window.location.href= ctxPath + "/promotion";
				};
				$('#boxModal').modal('show');
				$('#boxModal').on('hide.bs.modal', opt);
			}else{
				$('#msgTxt').text(rtmsg.MESSAGE);
				$('#msgTxt').show();
			}
		}
	}]
};