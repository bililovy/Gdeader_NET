/**
 * Created by Bililovy on 2016/10/27.
 */
function addCart($gid, $url){
    if ($gid){
        var $result  ;
        $.ajax({
            type: 'post',
            dataType:'json',
            url : $url,
            data: {gid:$gid},
            async:false,//这里选择异步为false，那么这个程序执行到这里的时候会暂停，等待
                        //数据加载完成后才继续执行
            success : function(back){
                $result = back;
            }
        });
        return $result;
    }else{
        return -1;
    }
}
function loadCartList(){
    $.post(ajaxGetCartList, '',function (back){
        $('#cart_item_list').height('auto').html(back.data);
    },'json')
}