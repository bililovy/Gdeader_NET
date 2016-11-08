var ajaxRequest;

$("a.recycle").click(
		function() {
			var $this = $(this);
			var id = parseInt($(this).siblings("input[name='navid']").val());
			if (id > 0) {
				var btnFn = function() {
					var data = {
						id : id
					};
					ajaxRequest = $.post($deleteUrl, data,
							function(back) {
								if (back.status == 1) {
									easyDialog.close();
									$this.parent().parent().parent().slideUp(200);
								} else {
									easyDialog.open({
										container : {
											header : "系统提醒窗口",
											content : back.data
										},
										autoClose : 3000
									});
								}
							}, "json");
					return false;
				};
				easyDialog.open({
					container : {
						header : "系统提醒窗口",
						content : '您将删除此导航，删除后将无法再找回。<br />确定删除吗？',
						yesFn : btnFn,
						noFn : function() {
							if (ajaxRequest != null) {
								ajaxRequest.abort();
							}
						}
					},
					follow : $this[0],
					followX : -295,
					followY : 35
				});
			} else {
				easyDialog.open({
					container : {
						content : "当前操作缺失参数，请刷新重试！"
					},
					autoClose : 2000
				});
			}
		});

jQuery.fn.center = function() {
	this.css("position", "fixed");
	this.css("top", ($(window).height() - this.height()) / 2 + "px");
	this.css("left", ($(window).width() - this.width()) / 2 + "px");
	return this;
};
var ori_ico='/assets/common/images/icons/colum1nx.gif';
var spread_ico='/assets/common/images/icons/colum1nx2.gif';
$('.formbody .tool a.spread').click(function (){
	if (!$(this).hasClass('sp')){
		$('table.table tr.tr_list').each(function (){		
			$(this).removeClass('none');
		});
		$('table.table tr').find('img.dragdown').attr('src', spread_ico);
		$(this).addClass('sp').text('隐藏所有下级导航');
	}else{
		$('table.table tr.tr_list').each(function (){		
			$(this).addClass('none');
		});
		$('table.table tr').find('img.dragdown').attr('src', ori_ico);
		$(this).removeClass('sp').text('展开所有下级导航');		
	}
})
$('table.table td img.dragdown').click(function(){
	spreadColumn($(this));
})
function spreadColumn($opObj,flag){
	var reg=/\d+/;
	var $op_index= parseInt($opObj.attr('id').match(reg));
	if($op_index % 1==0){
		var $op=$('table.table tr.tr_list.column_level_'+$op_index);
		if($op.hasClass('none')){
			if (!flag){
				$op.removeClass('none');
				$opObj.attr('src','/assets/common/images/icons/colum1nx2.gif');
			}
		}else{
			$op.addClass('none');
			$opObj.attr('src','/assets/common/images/icons/colum1nx.gif');
			$op.each(function (){
				var $img=$(this).find('img.dragdown');
				if ($img.length>0){
					spreadColumn($img,1);
				}
			})				
		}		
	}	
}

$('.formbody table.table td a.op_show').click(function(){
	if ($(this).hasClass('enabled')){
		$(this).removeClass('enabled');
		$(this).siblings('span.op_show_text').addClass('warn').removeClass('ok').text('停用');
	}else{
		$(this).addClass('enabled');		
		$(this).siblings('span.op_show_text').addClass('ok').removeClass('warn').text('启用');
	}
})


// 弹窗js

$('#dialog_box .dialog_body a.radio').click(function (){
	var $this=$(this), $operation=true;
	$this.find('i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o').parent().siblings('a.radio').find('i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
	if($this.hasClass('link')){
		var $way=0;
		if(! $(this).hasClass('self')){
			$way=1;
		}
		$(this).siblings('input[name="openway"]').val($way);		
	}else if ($this.hasClass('config')){
		if($this.hasClass('diy')){
			$('#dialog_box .dialog_body #navsetContainer #diyset').css('display','block');
			$('#dialog_box .dialog_body #navsetContainer #sysset').css('display','none').html('');
		}else if ($this.hasClass('sys')){
			$('#dialog_box .dialog_body #navsetContainer #sysset').css('display','block');
			$('#dialog_box .dialog_body #navsetContainer #diyset').css('display','none');			
			var $getHtml='<div style="height:35px; width:100%;text-align: center;"><img src="/assets/common/images/icons/loading.gif"  style="width:25px;vertical-align: middle; margin-right:5px; display: inline;"/>正在获取数据，请稍候…</div>'
			$('#dialog_box .dialog_body #navsetContainer #sysset').html($getHtml);
			//ajax获取数据
			$.post($ajaxGetCat,'', function (back){
				if(back.status==1){
					
				}else{
					
				}
			},'json')
		}else{
			$operation=false;
		}
	}else if ($this.hasClass('show')){
		var $on=1;
		if(! $(this).hasClass('enable')){
			$on=0;
		}
		$(this).siblings('input[name="isshow"]').val($on);	
	}else{
		$operation=false;
	}
	if ( ! $operation){
		easyDialog.open({
			  container : {
				header: '系统提示窗',
			    content : '无效操作，请刷新重试！'
			  },
			  autoClose : 2000
			});
	}
})

$('#dialog_box .dialog_item#navsetContainer input#navlink').blur(function (){
	var $value= $(this).val();
	$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val($value);
})
$('#dialog_box .dialog_item#navsetContainer select.goodscate').change(function (){
	var $value= $(this).val();
	$value="{:U('Goods/index', array('cid'=>"+$value+"))}";
	$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val($value);
})
$('#dialog_box .dialog_item#navsetContainer select.goods').change(function (){
	var $value= $(this).val();
	$value="{:U('Goods/detail', array('gid'=>"+$value+"))}";
	$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val($value);
})

$('#dialog_box button.submit').click(function (){
	if (checkNav()){
		var $navname=$('#dialog_box input[name="navname"]'),
		  $openway=$('#dialog_box input[name="openway"]'),
		  $navlink=$('#dialog_box input[name="navlink"]'),
		  $parentid=$('#dialog_box input[name="parentid"]'),
		  $isshow=$('#dialog_box input[name="isshow"]');
	   var data={
			   navname: $navname.val(),
			   openway: $openway.val(),
			   navlink: $navlink.val(),
			   isshow: $isshow.val(),
			   pid : $parentid.val()
	   }
	   ajaxRequest=$.post($postUrl, data, function (back){
		   if (back.status==1){
			   window.location.reload();
		   }else{
			   showMsg(back.data);
		   }
	   },'json');
	}
})

function checkNav(){
	$('#dialog_box #tips').html('');
	var $navname=$('#dialog_box input[name="navname"]'),
		  $openway=$('#dialog_box input[name="openway"]'),
		  $navlink=$('#dialog_box input[name="navlink"]'),
		  $parentid=$('#dialog_box input[name="parentid"]'),
		  $isshow=$('#dialog_box input[name="isshow"]');
	if($navname.val().replace(/[ ]/g,'') !=''){
		if (! isNaN(parseInt($openway.val()))){		
			var strRegex =/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
			if(strRegex.test($navlink.val())){
				if(isNaN(parseInt($isshow.val()))){	
					$isshow.val(1);
				}
				if(!isNaN(parseInt($parentid.val()))){					
					return true;
				}else{
				showMsg('表单内部数据有错误，请刷新重试！');						
				}
			}else{
			showMsg('请配置正确的导航链接');	
			}
		}else{
			showMsg('请选择导航打开方式');			
		}
	}else{
		showMsg('请输入导航名称');
	}
	return false;
}

function showMsg(tips){
	tips= '<span style="color:#FF8331;">'+tips+'</span>'
	$('#dialog_box #tips').html(tips);
}
$('.formbody a.addnav').click(function (){
	$('#dialog_box .dialog_body').find('input[name="parentid"]').val(0);
	openDialog('新增导航');
})
$('#dialog_box .dialog_head a.dialog_close, #dialog_box .dialog_body .dialog_item button.bt_tip_normal').click(function (){
	closeDialog();
})
$('.formbody a.addsub').click(function (){
	var $pid=parseInt($(this).siblings('input[name="navid"]').val());
	if (isNaN($pid)){
		$pid=0;
	}
	$('#dialog_box .dialog_body').find('input[name="parentid"]').val($pid);
		openDialog('添加下级导航');
})

function openDialog(title){
	title = title==null ? '新增导航' : title;
	$('#dialog_box').center();
	$('#dialog_box #dialog_head_text').text(title);
	$('#dialog_mask').show();
	$('#dialog_box').show();	
}
function closeDialog(){
	$('#dialog_box').stop().slideUp(100,function (){
		$('#dialog_mask').hide();
		if(null != ajaxRequest) ajaxRequest.abort();
		dialogInit();
	});	
}
function dialogInit(){
	$('#dialog_box #dialog_head_text').text('-----');
	$('#dialog_box .dialog_body input[name="parentid"]').val('');
	
}
	// end 弹窗js