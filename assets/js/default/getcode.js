$(document).ready(function(){

    initPage();

    bootValidate(productCodeValidateConfig.forms);

    $('#msgTxt').hide();
    $("#email").val("");
});


function initPage(){

}

function isProductCode(productId) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ctxPath + '/edm/product/code/' + productId,
        data: '',
        success: function(rtmap) {
            if(rtmap.SUCCESS){
                $("#productCodeBtn").show();
                $("#productCodeDetails").show();
                $("#productCodeBtn").html("Clip " + rtmap.codeOff + " Coupon");
                $("#dealId").val(rtmap.dealId);
            }else{
                $("#productCodeBtn").hide();
                $("#productCodeDetails").hide();
            }
        }
    });
}

var productCodeValidate = {
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

var productCodeValidateConfig = {
    forms:[{
        id:'productCodeForm',
        submit:true,
        url: '/edm/product/request/save',
        validate:productCodeValidate,
        confirmFn:function(rtmsg){
            if(rtmsg.SUCCESS){
                $('#getCodeModel').modal('hide');

                $('#boxModalTitle').html(PromptMsg.prompt);
                $('#boxModalBody').html(rtmsg.MESSAGE);
                //$('#msgTxt').text(rtmsg.code);
                //$('#msgTxt').show();
                var opt = function () {
                    $('#email').val("");
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