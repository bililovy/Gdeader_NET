/**
 * @name 用来设置表单的默认值,默认值设置在placeholder属性中
 * @param items
 * @returns {Boolean}
 */	
function inputDefaultSet(items){
			items= (null==items || '' == items) ? false : items;
			if(! items) return false;
			if(items instanceof Array){
				var len=items.length;
				for(var i=0; i<len; i++){
					var $this=items[i];
					if(0 < $this.length){
						inputDefaultSet($this);
					}
				}
			}else if(items instanceof Object){
				if(items.attr('placeholder')){
					items.val(items.attr('placeholder'));					
				}
				addMouseEvent(items);
			}else{
				return false;
			}
		}

function addMouseEvent(object){
	object.bind({
		'focus':function (){
			if(object.attr('placeholder')==object.val()){
				object.addClass('active');
				object.val('');
			}
		},
		'blur': function (){
			if(trim(object.val())==''){
				object.removeClass('active');
				object.val(object.attr('placeholder'));
			}
		}
	})
}

function trim(value){
	return value.replace(/[ ]/g,'');
}
function addCart($o,$gid){	
	$o.find('#TempTip').remove();		
	if ($gid  && $o){
		$.post(ajaxCartUrl,{gid:$gid,},function (back){
			var $redirect;
			if (back.status==1){	
				var $html='<div id="TempTip" style="position: absolute; left: 0; top: -'+($o.height()+10)+'px; padding: 2%; background-color: #1FC1D1;width: 96%;color: #FFF;font-size: 14px;">'+back.data+'</div>';
				$('.cartbox .item_info b#itemCount').text(back.count);
				loadCartList();
				var dur=1000;
			}else if (back.status==2){
				var $html='<div id="TempTip" style="position: absolute; left: 0; top: -'+($o.height()+10)+'px; padding: 2%; background-color: #FFAF21;width: 96%;color: #FFF;font-size: 14px;">'+back.data+'</div>';
				var dur=1500;
			}else if (back.status==3){
				var $html='<div id="TempTip" style="position: absolute; left: 0; top: -'+($o.height()+10)+'px; padding: 2%; background-color: #FFAF21;width: 96%;color: #FFF;font-size: 14px;">'+back.data+'</div>';
				var dur=2000;	
				$redirect=back.url;
			}else{
				var $html='<div id="TempTip" style="position: absolute; left: 0; top: -'+($o.height()+10)+'px; padding: 2%; background-color: #E54B1A;width: 96%;color: #FFF;font-size: 14px;">'+back.data+'</div>';
				var dur=1500;				
			}
			$o.append($html);
			setTimeout(function (){
				$o.find('#TempTip').fadeOut(200, function (){
					$(this).remove();
					if($redirect){
						window.location.href=$redirect;
					}
				})		
			},dur);
		},'json')
	}
}
function loadCartList(){
		$.post(ajaxGetCartList, '',function (back){
			$('#cart_item_list').height('auto').html(back.data);
		},'json')
}