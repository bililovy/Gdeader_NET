
//滑上ul li时 出背景色

$('.np-comment-list .np-post').hover(function (){
	
	$(this).css('background-color', '#F7F7F7');
	
	}, 
	function (){
	
	$(this).css('background-color', '#FFF');
	
})

$('.np-post-footer a.reply').click(function (){
	
	var $this=$(this);
	
	if($this.hasClass('disabled')) return false;
	
	var $comid =parseInt($this.siblings('input[name="commentid"]').val());
	
	if ($comid<=0 || isNaN($comid)){
		
		easyDialog.open({
			
			  container : {
				  
			    content : '当前操作缺少必须参数，请刷新后尝试！'
			    	
			  },
			  
			  autoClose : 1800
			  
			});
		
		return false;
		
	}
	
	if ($this.attr('spm-show') ==='false'){

		$('.np-post-footer a.reply').attr('spm-show','false');
		
		$('.np-post-footer a.reply').siblings('div.reply-box').each(function (){
			
			if ($(this).find('.reply-form').length>0){
				
				$(this).html('');
				
				$(this).hide();
				
			}
			
		});
		
		$this.siblings('div.reply-box').html($('div#reply-frame').html());
		
		$this.siblings('div.reply-box').fadeIn(300,function (){
			
			$('.np-post-footer .reply-box').find('.reply-form ul').find('input[name="replycomid"]').val($comid);
			
			$this.attr('spm-show', 'true');
			
		});		
		
	}else{
		
		$this.siblings('div.reply-box').slideUp(300,function (){
			
			$('.np-post-footer .reply-box').find('.reply-form ul').find('input[name="replycomid"]').val(0);
			
			$this.attr('spm-show', 'false');
			
			$(this).html('');
			
		});
		
	}
	
})

$('.np-post-footer .reply-box').delegate('.reply-form ul.reply-ul a.reply-btn', 'click', function (){	
	
	var $this= $(this);
	
	if ($this.hasClass('disabled')){
		
		return false;
		
	}
	
	var $comid=parseInt($(this).parent().siblings('li').find('input[name="replycomid"]').val());
	
	var $commentcontent =$(this).parent().siblings('li').find('textarea[name="reply"]').val();

	$this.siblings('i.form_tips').html($this.siblings('i').attr('placeholder'));
	
		if ($comid<=0 || isNaN($comid)){
			
			easyDialog.open({
				
				  container : {
					  
				    content : '当前操作缺少必须参数，请刷新后尝试！'
				    	
				  },
				  
				  autoClose : 1800
				  
				});
			
			return false;
			
		}
		
		if($commentcontent.replace(/\s/g, '').length<5 || $commentcontent.replace(/\s/g, '')==''){
			
			$this.siblings('i.form_tips').html('<span style="color: #E22C37;font-size: 12px;">请输入5个字以上的回复！</span>');
			
			return false;
			
		}
				
	var $data={faqid: $comid, replycontent: $commentcontent};
		
	$this.siblings('i.form_tips').html('<span style="color: #36830F;font-size: 12px;">正在提交数据……</span>');
	
	$this.addClass('disabled');
	
	$.post(setReplyUrl, $data, function (back){
		
		if (back.status ==1){
			
			window.location.reload();
			
		}else{
			
			easyDialog.open({
				
				  container : {
					  
				    content : back.data
				    	
				  },
				  
				  autoClose : 2200
				  
				});
			
			$this.removeClass('disabled');
			
		}
		
	}, 'json');
	
})

//审核按钮

$('.np-post-footer a.isrelelased').click(function (){
	
	var $this=$(this);
	
	if($this.hasClass('disabled')) return false;
	
	var $comid =parseInt($this.siblings('input[name="commentid"]').val());
	
	if ($comid<=0 || isNaN($comid)){
		
		easyDialog.open({
			
			  container : {
				  
			    content : '当前操作缺少必须参数，请刷新后尝试！'
			    	
			  },
			  
			  autoClose : 1800
			  
			});
		
		return false;
		
	}
	
	$.post(commentReleaseUrl, {commentid : $comid}, function (back){
		
		if (back.status ==1){
			
			$this.addClass('disabled');
			
			$this.find('i.fa').removeClass('fa-times-circle').addClass('fa-check-circle');
			
			$this.find('b').text('已审核');
			
		}else{
			
			easyDialog.open({
				
				  container : {
					  
				    content : back.data
				    	
				  },
				  
				  autoClose : 1800
				  
				});
			
		}
		
	}, 'json');
	
});

//显示状态切换按钮

$('.np-post-footer a.isshow').click(function (){
	
	var $this=$(this);
	
	var $comid =parseInt($this.siblings('input[name="commentid"]').val());
	
	if ($comid<=0 || isNaN($comid)){
		
		easyDialog.open({
			
			  container : {
				  
			    content : '当前操作缺少必须参数，请刷新后尝试！'
			    	
			  },
			  
			  autoClose : 1800
			  
			});
		
		return false;
		
	}
	
	if ($this.hasClass('showing')){
		
		var $isshow=0;
		
	}else{
		
		var $isshow=1;
		
	}
	
	$.post(commentShowToggleUrl, {isshow:$isshow ,commentid : $comid}, function (back){
		
		if (back.status ==1){
			
			if ($this.hasClass('showing')){
				
				$this.find('i.fa').removeClass('fa-check-circle').addClass('fa-ban');
				
				$this.removeClass('showing');
				
				$this.find('b').text('前端未显示');
				
			}else{
				
				$this.find('i.fa').removeClass('fa-ban').addClass('fa-check-circle');
				
				$this.addClass('showing');
				
				$this.find('b').text('前端显示中');
				
			}
			
		}else if (back.status ==2){
			
			easyDialog.open({
				
				  container : {
					  
				    header : '系统提醒您：',
				    
				    content : back.data
				    	
				  },
				  
				  overlay : true
				  
				});
			
		}else{
			
			easyDialog.open({
				
				  container : {
					  
				    content : back.data
				    	
				  },
				  
				  autoClose : 1800
				  
				});
			
		}
		
	}, 'json');
	
});

//删除按钮
$('.np-post-footer a.delete').click(function (){
	
	var $this=$(this);
	
	var $comid =parseInt($this.siblings('input[name="commentid"]').val());
	
	var $newsid=parseInt($('.all-comments').find('input[name="commentsnewsid"]').val());
	
	if ($comid<=0 || isNaN($comid) || $newsid<=0 || isNaN($newsid)){
		
		easyDialog.open({
			
			  container : {
				  
			    content : '当前操作缺少必须参数，请刷新后尝试！'
			    	
			  },
			  
			  autoClose : 1800
			  
			});
		
		return false;
		
	}	
	
	var btnFn = function(){
		  
		$.post(commentDeleteUrl, {commentid : $comid, gid: $newsid}, function (back){
			
			if (back.status ==1){
				
				easyDialog.close();
				
				window.location.reload();
				
			}else{
				
				easyDialog.open({
					
					  container : {
						  
					    content : back.data
					    	
					  },
					  
					  autoClose : 1800
					  
					});
				
			}
			
		}, 'json');
		  
		  return false;
		  
		};

		easyDialog.open({
			
		  container : {
			  
		    header : '系统提示：',
		    
		    content : '确定删除这一条评论吗？该操作将永久删除，不可恢复！',
		    
		    yesFn : btnFn,
		    
		    noFn : true
		    
		  },
		  
		  follow : $(this)[0],
		  
		  followX : -137,
		  
		  followY : -170
		  
		});
	
});


// 删除回复
$('.reply-info').delegate('.reply-content b.del', 'click', function (){

	var $this=$(this);

	var $comid=parseInt($('#np-post-footer').find('input[name="commentid"]').val());

	if ($comid<=0 || isNaN($comid)){

		easyDialog.open({

			container : {

				content : '当前操作缺少必须参数，请刷新后尝试！'

			},

			autoClose : 1800

		});

		return false;

	}

	var btnFn = function(){

		$.post(replyDeleteUrl, {commentid : $comid}, function (back){

			if (back.status ==1){

				easyDialog.close();

				window.location.reload();

			}else{

				easyDialog.open({

					container : {

						content : back.data

					},

					autoClose : 1800

				});

			}

		}, 'json');

		return false;

	};

	easyDialog.open({

		container : {

			header : '系统提示：',

			content : '确定删除此评论的回复吗？删除后可再次添加回复！',

			yesFn : btnFn,

			noFn : true

		},

		follow : $(this)[0],

		followX : -137,

		followY : -170

	});

})