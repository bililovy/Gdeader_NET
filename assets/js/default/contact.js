$('select[name="type"]').cssSelect();
$('input[name="submit"]').click(function (){
    var $this=$(this);
    var $selector = $this;
    var name=$('input[name="name"]'),
        email=$('input[name="email"]'),
        subject=$('input[name="subject"]'),
        type=$('select[name="type"]'),
        content=$('textarea[name="content"]');

    if(name.val().replace(/[ ]/g, '').length<3){
        var tips='What\'s your name?';
        name.focus();
        $selector=name;
    }else if(! is_email(email.val())){
        var tips='Please give us an available  EMAIL !';
        email.focus();
        $selector=email;
    }else if (subject.val().replace(/[ ]/g, '').length<10){
        var tips='Please enter a subject for your message at lease 10 words !';
        subject.focus();
        $selector=subject;
    }else if (type.val()==0){
        var tips='Please select a message type item !';
        type.focus();
        $selector=$('#select_ui_name_type');
    }else if (content.val().replace(/[ ]/g, '').length<10){
        var tips='The message content needs to be at lease 10 words !';
        content.focus();
        $selector=content;
    }else{
        var $data={
            uname: name.val(),
            email: email.val(),
            subject: subject.val(),
            message: content.val(),
            msgtype: type.val(),
            from: 'contact'
        };
        $.post($msgUrl, $data,function (back){
            if(back.status==1){
                ZENG.msgbox.show('', 4, 3000);
                layer.tips('Message Sent, We\'ll take a serious look at your message,Think U !', $this, {
                    tips: [1, '#05710A'],
                    time: 3000
                });
                name.val('');
                email.val('');
                subject.val('');
                content.val('');
                type.val(0);
                $('select[name="type"]').cssSelect();
            }else{
                layer.tips('Sending Failed ! Please Try Again Later!', $this);
            }
        }, 'json');
        return false;
    }
    layer.tips(tips, $selector);
});

/**************** BEGIN 函数集成************************/
function formResponse(){
    if($(window).width()<550){
        $('.middle_content').addClass('mini');
    }else{
        $('.middle_content').removeClass('mini');
    }
}
/**************** END 函数集成************************/