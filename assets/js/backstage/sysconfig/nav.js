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
	var id=parseInt($(this).siblings('input[name="navid"]').val());
	var $this=$(this);
	if (id>0){
		if ($(this).hasClass('enabled')){
			var $data={id:id,isshow:0}
		}else{
			var $data={id:id,isshow:1}
		}
		$.post($ajaxChangeShow, $data, function (back){
			if (back.status==1){
				if ($this.hasClass('enabled')){
					$this.removeClass('enabled');
					$this.siblings('span.op_show_text').addClass('warn').removeClass('ok').text('停用');
                    $this.siblings('input[name="isshow"]').val(0);
				}else{
					$this.addClass('enabled');
					$this.siblings('span.op_show_text').addClass('ok').removeClass('warn').text('启用');
                     $this.siblings('input[name="isshow"]').val(1);
				}
			}else{
				easyDialog.open({
					container : {
				    header: '系统提示窗',
			       content : back.data
			       },
			  autoClose : 3000
			  });
			}
		},'json')
	}else{
		easyDialog.open({
			  container : {
				header: '系统提示窗',
			    content : '操作参数缺失，请刷新重试！'
			  },
			  autoClose : 2000
			});
	}
})


// 弹窗js

$('#dialog_box .dialog_body a.radio').click(function (){
	var $this=$(this), $operation=true;
	if($this.hasClass('doing')) return false;
	$this.addClass('doing').find('i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o').parent().siblings('a.radio').removeClass('doing').find('i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
	if($this.hasClass('link')){
		var $way=0;
		if(! $(this).hasClass('self')){
			$way=1;
		}
		$(this).siblings('input[name="openway"]').val($way);
	}else if ($this.hasClass('config')){
		if($this.hasClass('diy')){
			$('#dialog_box .dialog_body #navsetContainer #diyset').css('display','block');
			$('#dialog_box .dialog_body #navsetContainer #sysset').css('display','none');
		}else if ($this.hasClass('sys')){
			$('#dialog_box .dialog_body #navsetContainer #sysset').css('display','block');
			$('#dialog_box .dialog_body #navsetContainer #diyset').css('display','none');
			var $getHtml='<div id="tempMask" style="height:35px; width:100%;position: absolute; left: 0; top: 0; background: #FFF; text-align: center;"><img src="/assets/common/images/icons/loading.gif"  style="width:25px;vertical-align: middle; margin-right:5px; display: inline;"/>正在获取数据，请稍候…</div>'
			$('#dialog_box .dialog_body #navsetContainer #sysset').prepend($getHtml);
			//ajax获取数据
			$.post($ajaxGetCat,'', function (back){
				$('#dialog_box #tempMask').remove();
				$('#dialog_box .goodscate').html(back.data);
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
	var $value= parseInt($(this).val());
	if (!isNaN($value)){
		var $link=$cateLink.replace('LINK', $value);
		$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val($link);
		$.post($ajaxGetGoods, {cid: $value},function (back){
			$('#dialog_box .goods').html(back.data);
		},'json')
	}else{
		$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val('');
	}
})
$('#dialog_box .dialog_item#navsetContainer select.goods').change(function (){
	var $value=$(this).val();
	var $typeValue= parseInt($(this).val());
	if (!isNaN($typeValue)){
		var $link=$goodsLink.replace('LINK', $typeValue);
		$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val($link);
	}else{
		$('#dialog_box .dialog_item#navsetContainer input[name="navlink"]').val($value);
	}
})

$('#dialog_box').delegate('button.submit','click',function (){
	if (checkNav()){
		var $navname=$('#dialog_box input[name="navname"]'),
			$sortorder=$('#dialog_box input[name="sortorder"]'),
		  $openway=$('#dialog_box input[name="openway"]'),
		  $navlink=$('#dialog_box input[name="navlink"]'),
		  $parentid=$('#dialog_box input[name="parentid"]'),
		  $isshow=$('#dialog_box input[name="isshow"]'),
		  $navico=$('#dialog_box input[name="navico"]');
	   var data={
			   navname: $navname.val(),
			   sortorder: $sortorder.val(),
			   openway: $openway.val(),
			   navlink: $navlink.val(),
			   isshow: $isshow.val(),
			   navico: $navico.val(),
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

$('#dialog_box').delegate('button.update','click',function (){
	if (checkNav()){
		var $navname=$('#dialog_box input[name="navname"]'),
			$sortorder=$('#dialog_box input[name="sortorder"]'),
		  $openway=$('#dialog_box input[name="openway"]'),
		  $navlink=$('#dialog_box input[name="navlink"]'),
		  $navid=$('#dialog_box input[name="navid"]'),
		  $navico=$('#dialog_box input[name="navico"]'),
		  $isshow=$('#dialog_box input[name="isshow"]');
	   var data={
			   navname: $navname.val(),
			   sortorder: $sortorder.val(),
			   openway: $openway.val(),
			   navlink: $navlink.val(),
			   isshow: $isshow.val(),
		       navico: $navico.val(),
			   id : $navid.val()
	   }
	   ajaxRequest=$.post($postUpdateUrl, data, function (back){
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
		$sortorder=$('#dialog_box input[name="sortorder"]'),
		  $openway=$('#dialog_box input[name="openway"]'),
		  $navlinkinput=$('#dialog_box input#navlink'),
		  $parentid=$('#dialog_box input[name="parentid"]'),
		  $isshow=$('#dialog_box input[name="isshow"]');
	if($navname.val().replace(/[ ]/g,'') !=''){
		if (! isNaN(parseInt($sortorder.val()))){
			if (! isNaN(parseInt($openway.val()))){
				var strRegex =/(http(s)?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
				 if($navlinkinput.val().replace(/[ ]/g,'') !=''){
					 if(! strRegex.test($navlinkinput.val())){
							showMsg('请配置正确的导航链接');
							return false;
						}
				 }
				 if(isNaN(parseInt($isshow.val()))){
						$isshow.val(1);
				 }
				 if(!isNaN(parseInt($parentid.val()))){
						return true;
				 }else{
					showMsg('表单内部数据有错误，请刷新重试！');
				 }
			}else{
				showMsg('请选择导航打开方式');
			}
		}else{
			showMsg('导航排序为整数');
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
$('.formbody table.table .op_box a.addsub').click(function (){
	var $pid=parseInt($(this).siblings('input[name="navid"]').val());
	if (isNaN($pid)){
		$pid=0;
	}
	$('#dialog_box .dialog_body').find('input[name="parentid"]').val($pid);
		openDialog('添加下级导航');
})
//更新
$('.formbody table.table .op_box a.update').click(function (){
	var $this=$(this);
    var navid=parseInt($this.siblings('input[name="navid"]').val())>0 ?parseInt($this.siblings('input[name="navid"]').val()):0;
    var parentid=parseInt($this.siblings('input[name="pid"]').val())>0 ?parseInt($this.siblings('input[name="pid"]').val()):0;
    var navico=$this.siblings('input[name="navico"]').val();
    $('#dialog_box .dialog_body').find('input[name="parentid"]').val(parentid);
    var navname=$this.parent().parent().siblings('td').find('input[name="navname"]').val();
    var sortorder=$this.parent().parent().siblings('td').find('input[name="sortorder"]').val();
    var openway=$this.parent().parent().siblings('td').find('input[name="openway"]').val();
    var isshow=$this.parent().parent().siblings('td').find('input[name="isshow"]').val();
    var navlink=$this.parent().parent().siblings('td').find('input[name="navlink"]').val();
    //alert(navid+' '+sortorder+' '+openway+' '+isshow+' '+ navlink);return;
    $('#dialog_box .dialog_body a.radio.link i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
    $('#dialog_box .dialog_body a.radio.show i.fa').removeClass('fa-dot-circle-o').addClass('fa-circle-o');
    $('#dialog_box .dialog_body input[name="navid"]').val(navid);
    $('#dialog_box .dialog_body input[name="navname"]').val(navname);
	$('#dialog_box .dialog_body input[name="sortorder"]').val(sortorder);
	$('#dialog_box .dialog_body input[name="navico"]').val(navico);

    if(1==openway)
        $('#dialog_box .dialog_body a.radio.link.blank i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
    else
        $('#dialog_box .dialog_body a.radio.link.self i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');

    if(1==isshow)
        $('#dialog_box .dialog_body a.radio.show.enable i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
    else
        $('#dialog_box .dialog_body a.radio.show.unenable i.fa').removeClass('fa-circle-o').addClass('fa-dot-circle-o');
	$('#dialog_box .dialog_body input[name="openway"]').val(openway);
	$('#dialog_box .dialog_body input[name="isshow"]').val(isshow);
	$('#dialog_box .dialog_body input#navlink').val(navlink);
    $('#dialog_box input[name="navlink"]').val(navlink);
    $('#dialog_box button.submit').removeClass('submit').addClass('update');
    openDialog('更新导航');
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
	$('#dialog_box .dialog_body input[name="navname"]').val('');
	$('#dialog_box .dialog_body input[name="sortorder"]').val(10);
	$('#dialog_box .dialog_body input[name="openway"]').val(0);
	$('#dialog_box .dialog_body input[name="isshow"]').val(1);
	$('#dialog_box .dialog_body input[name="navlink"]').val('');
	$('#dialog_box .dialog_body input[name="navico"]').val('');
	$('#dialog_box .dialog_body input#navlink').val('');
    $('#dialog_box button').removeClass('update').addClass('submit');
}
	// end 弹窗js