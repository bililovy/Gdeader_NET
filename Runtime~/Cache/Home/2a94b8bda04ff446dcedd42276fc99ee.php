<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html lang="en"><head>	<title><?php if(!empty($pageinfo["pagetitle"])): echo ($pageinfo["pagetitle"]); ?>-<?php endif; echo ($webname); ?></title>	<meta http-equiv="content-type" content="text/html;charset=utf-8" />	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>	<meta name="apple-mobile-web-app-capable" content="yes" /> <!-- 启用 WebApp 全屏模式 -->	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /><!-- 隐藏状态栏/设置状态栏颜色 -->	<meta name="apple-mobile-web-app-title" content="标题"><!-- 添加到主屏后的标题 -->	<meta content="telephone=no" name="format-detection" /> <!-- 忽略数字自动识别为电话号码 -->	<meta content="email=no" name="format-detection" /><!-- 忽略识别邮箱 -->	<meta name="renderer" content="webkit|ie-comp|ie-stand">	<!-- 转码申明：用百度打开网页可能会对其进行转码，如下meta避免转码 -->	<meta http-equiv="Cache-Control" content="no-siteapp" />	<!-- 下面是 禁止浏览器从本地计算机的缓存中访问页面内容：这样设定，访问者将无法脱机浏览。 -->	<!-- <meta http-equiv="Pragma" content="no-cache"> -->	<!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->	<meta name="HandheldFriendly" content="true">	<!-- 微软的老式浏览器 -->	<meta name="MobileOptimized" content="320">	<!-- uc强制竖屏 -->	<meta name="screen-orientation" content="portrait">	<!-- QQ强制竖屏 -->	<meta name="x5-orientation" content="portrait">	<!-- UC强制全屏 -->	<meta name="full-screen" content="yes">	<!-- QQ强制全屏 -->	<meta name="x5-fullscreen" content="true">	<!-- UC应用模式 -->	<meta name="browsermode" content="application">	<!-- QQ应用模式 -->	<meta name="x5-page-mode" content="app">	<!-- windows phone 点击无高光 -->	<meta name="msapplication-tap-highlight" content="no">		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />	<meta name="msapplication-TileColor" content="#000"/> <!-- Windows 8 磁贴颜色 -->	<meta name="msapplication-TileImage" content="icon.png"/> <!-- Windows 8 磁贴图标 -->		<meta name="keywords" content="<?php if(empty($pageinfo["keywords"])): echo ($keywords); else: echo ($pageinfo["keywords"]); endif; ?>" />	<meta name="description" content="<?php if(empty($pageinfo["description"])): echo ($description); else: echo ($pageinfo["description"]); endif; ?>" />	<meta name="language" content="zh-CN" />	<meta name="author" content="<?php if(empty($pageinfo["author"])): echo ($webname); else: echo ($pageinfo["author"]); endif; ?>" />	<link rel="shortcut icon" href="/urpower.ico" type="image/x-icon" /><!-- 公共才css js 部分 --><link rel="stylesheet" type="text/css" href="/assets/common/css/init.css" /><link rel="stylesheet" type="text/css" href="/assets/common/css/font-icons.css" /><link rel="stylesheet" type="text/css" href="/assets/common/tools/msgbox/css/msgbox.css" /><script type="text/javascript" src="/assets/common/js/jquery.min.js"></script><script type="text/javascript" src="/assets/common/js/jquery.easing.min.js"></script><script type="text/javascript" src="/assets/common/js/tools/function.js"></script><script type="text/javascript" src="/assets/common/js/tools/jquery.multi.slider.min.js"></script><script type="text/javascript" src="/assets/common/tools/msgbox/js/msgbox.js"></script>
<script type="text/javascript">
var ajaxCartUrl="<?php echo U('Goods/ajaxCart','','');?>";
var ajaxGetCartList="<?php echo U('Goods/ajaxGetCartList','','');?>";
$(function (){
$('a.add_wish').click(function (){
	var $gid=parseInt($(this).parent().attr('id'));
		addCart($(this),$gid);	
})
loadCartList();
var $searchbtn=$('.searchbox button.submit_btn');
$searchbtn.click(function (){
	var sq=$(this).siblings('input[name="sq"]');
	var sqv=sq.val();
	if (sqv.replace(/[ ]/g, '') !='' && sqv !=sq.attr('placeholder')){
		$searchUrl=$searchUrl.replace('-kw-', sqv);
		window.location.href=$searchUrl;
	}else{
		ZENG.msgbox.show('What to Search?', 1, 3000);
	}
});
})
var $searchUrl="<?php echo U('Search/sq', array('q'=>'-kw-'));?>";
</script>

<!-- 公共才css js 部分 --></head>
<body>
<link rel="stylesheet" type="text/css" href="/assets/css/default/index/index.css" />
<script type="text/javascript" src="/assets/common/js/tools/jquery.imgzoom.js"></script>
<div class="bodyContainer">
<!-- 鍏叡閮ㄥ垎 -->
<!-- header 顶部功能菜单 -->
	<div class="head_top">
		<div class="head_top_container">
			<div class="con_left">
				<div class="icon fa fa-volume-up"></div>
				<!-- <div class="main">
				this is a title for your webiste,welcome to our web
					<ul class="notice_list">
						<li class="item"><a href="###">1.this is a notice for your web that you published</a></li>
						<li class="item"><a href="###">2.this is a notice for your web that you published</a></li>
						<li class="item"><a href="###">3.this is a notice for your web that you published</a></li>
						<li class="item"><a href="###">4.this is a notice for your web that you published</a></li>
						<li class="item"><a href="###">5.this is a notice for your web that you published</a></li>						
					</ul>
					<div class="btn">
						<a href="javascript:" class="fa fa-sort-up prev" title="prev"></a>
						<a href="javascript:" class="fa fa-sort-down next" title="next"></a>
					</div>
				</div> -->
				<div class="main">Welcom to the site, please enjoy yourself !</div>
			</div>
			<div class="con_right">
				<div class="info">
					<?php if($_SESSION['member'] and $_SESSION['member']['SIGNIN_AUTHKEY']=='ALLOW_IN'): ?><div class="login">
							<p class="logon">Hello,<a href="javascript:;" title="check details"><b class="uname"><?php echo ($_SESSION['member']['username']); ?></b></a>!</p>	
							<a href="<?php echo U('Member/exitSign');?>" title="logout"><i class="fa fa-sign-out"></i>sign out</a>
						</div>
						<?php else: ?>
						<div class="unlog" >sign here !
							<div class="sublist">
								<a href="<?php echo U('Member/login');?>" class="op">sign in</a>
								<a href="<?php echo U('Member/regist');?>" class="op">register</a>
							</div>
					</div><?php endif; ?> 				
				</div>
				<div class="clearfix line_vertical"></div>
				<div class="share">
					<ul class="sharelist">
					<?php if(is_array($socialtools)): foreach($socialtools as $key=>$tool): ?><li><a href="<?php echo ($tool["account"]); ?>" target="_blank" data-accout="<?php echo ($tool["account"]); ?>" title="<?php echo ($tool["toolname"]); ?>"><i class="fa <?php echo ($tool["icon"]); ?>"></i></a></li><?php endforeach; endif; ?>		
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- 顶部js -->
	<script type="text/javascript">
		//未登录时，登陆按钮显示隐藏
		$('.head_top .con_right .unlog').hover(function(){
			$(this).find('div.sublist').stop().slideDown(200);
		}, function (){
			$(this).find('div.sublist').stop().slideUp(200);			
		})
		$(".con_left .main").slide({mainCell:"ul.notice_list",autoPage:true,effect:"topLoop",autoPlay:true,vis:2,prevCell:".prev",nextCell:".next"})
		
		</script>
	<!-- /顶部js -->
	<!--// header 顶部功能菜单 -->
	
	<!--logo 和搜索部分  -->
	<div class="header">
		<div class="header_main">
			<div class="logo fl"><a href="/" title="<?php echo ($webname); ?>" class="logo_link" style="background-image: url(<?php echo ($logo); ?>);">website name</a></div>
			<div class="searchbox fl">
				<input type="text" class="search fl color_89"  value="<?php echo ($searchkey); ?>" placeholder="Please enter your search key" data-post-url="<?php echo U('Search/sq',array('q'=>'-kw-'));?>" name="sq"/>
				<button class="submit fl submit_btn" ><i class="fa fa-search"></i></button>
			</div>
			<div class="cartinfo fr">
		  			<div class="cartbox">
		  				<?php if($member): ?><a href="javascript:" class="cartmain"><i class="fl fa fa-shopping-basket"></i>
		  				<span class="item_info">Wishlist:&nbsp;&nbsp; <b id="itemCount"><?php echo ($member["count"]); ?></b>&nbsp;items</span>
		  				</a>
		  				<?php else: ?>
		  				<span style="color: #1A909D; line-height: 35px;display: block;text-align: center;"><a href="<?php echo U('Member/login');?>" style="font-weight: bold;color: #B4B4B4; line-height: 35px;display: block;text-align: center;">Login to get my wishlist</a></span><?php endif; ?>		  				
		  			</div>
		  			<!-- 购物车列表  列出最新的四件商品 -->
		  			<?php if($member): ?><ul class="item_list" id="cart_item_list"></ul><?php endif; ?>
		  			<!-- // 购物车列表  列出最新的四件商品 -->
			</div>
		</div>		
	</div>	
     <style>
        .fix_nav{
            position: fixed;
            top:0;
            left:0;
            background: #FFF;
            width: 100%;
            z-index: 999;
        }
        .fix_nav .cont{            
            height: 60px;
            width: 1100px;
            margin: 0 auto;
            background: #F00;
            overflow: hidden;
        }
        .fix_nav .m_logo{
            background-repeat: no-repeat;
            background-size:150px 60px;
            width: 150px;
            height: 60px;
            float: left;           
        }
        .fix_nav .m_search{
            float: right;
            margin-right: 15px;
        }
        .fix_nav .m_search .search{
            
        }
    </style>

   <!-- <div class="fix_nav">
       <div class="cont">
        <div class="m_logo" style="background-image:url(<?php echo ($logo); ?>);"></div>
        <div class="m_search">
            <input type="text" class="search fl color_89"  value="<?php echo ($searchkey); ?>" placeholder="Please enter your search key" data-post-url="<?php echo U('Search/sq',array('q'=>'-kw-'));?>" name="sq"/>
				<button class="submit fl submit_btn" ><i class="fa fa-search"></i></button>
        </div>
        </div>
    </div>-->

	<script type="text/javascript">
		if($('.search').val() == $('.search').attr('placeholder') || $('.search').val() ==''){
			inputDefaultSet($('.search'));			
		}
		$('.cartinfo').hover(function (){
			if($(this).find('ul.item_list').find('li.goods').length >0){				
				$(this).find('ul.item_list').stop(true).slideDown({ 
				    duration: 500,  
				    easing: 'easeOutBack',  
				    complete: true 
				});
			}
		},function (){
			$(this).find('ul.item_list').stop(true).slideUp({ 
			    duration: 500,  
			    easing: 'easeInOutBack',  
			    complete: true 
			});			
		})
		
		//搜索按钮
		var $searchbtn=$('button.submit_btn');
		$searchbtn.click(function (){
			var sq=$(this).siblings('input[name="sq"]');
			var sqv=sq.val();
			var $searchUrl= sq.attr('data-post-url');
			if (sqv.replace(/[ ]/g, '') !='' && sqv.replace(/[ ]/g, '') !=sq.attr('placeholder').replace(/[ ]/g, '')){
				$searchUrl=$searchUrl.replace('-kw-', sq);
				window.location.href=$searchUrl;
			}else{
				ZENG.msgbox.show('What to Search?', 1, 3000);
			}
		});
	</script>
	<!--//logo 和搜索部分  -->
	
		<!-- 导航部分 -->
	<div class="navs">
		<div class="navigator">
			<ul class="navlist">
					<li  class="on"><a href="/" title="<?php echo ($webname); ?>">home</a></li>
					<?php if(is_array($navs)): foreach($navs as $key=>$nav): ?><li><a href="<?php echo ((isset($nav["navlink"]) && ($nav["navlink"] !== ""))?($nav["navlink"]):'javascript:;'); ?>" title="<?php echo ($nav["navname"]); ?>" <?php if(($nav["openway"]) == "1"): ?>target="_blank"<?php endif; ?>><?php echo ($nav["navname"]); ?></a>
						<?php if(!empty($nav['childs'])): ?><ul class="subnav">
							<?php if(is_array($nav["childs"])): foreach($nav["childs"] as $key=>$subnav): ?><li class="item">
								<a href="<?php echo ($subnav["navlink"]); ?>" title="<?php echo ($subnav["navname"]); ?>" <?php if(($subnav["openway"]) == "1"): ?>target="_blank"<?php endif; ?>><?php echo ($subnav["navname"]); ?>
								<?php if(!empty($subnav['childs'])): ?><i class="fa fa-caret-right"></i><?php endif; ?>
								</a>
								<?php if(!empty($subnav['childs'])): ?><ul class="subnav">
								<?php if(is_array($subnav["childs"])): foreach($subnav["childs"] as $key=>$thirdnav): ?><li class="item"><a href="<?php echo ($thirdnav["navlink"]); ?>" title="<?php echo ($thirdnav["navname"]); ?>" <?php if(($thirdnav["openway"]) == "1"): ?>target="_blank"<?php endif; ?>><?php echo ($thirdnav["navname"]); ?></a></li><?php endforeach; endif; ?>
								</ul><?php endif; ?>
							</li><?php endforeach; endif; ?>						
						</ul><?php endif; ?>
					</li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>   
	<!-- 导航js -->
	<script language="javascript">
			$(".navigator .navlist > li > a").wrapInner( '<div class="navbox"><span class="out"></span></div>' );
			$(".navigator .navlist > li > a> .navbox").each(function() {
				$( '<span class="over">' +  $(this).text() + '</span>' ).appendTo( this );
			});
			 $(".navigator .navlist li.on").find('div.navbox').css('margin-top', '-40px');
			 $(".navigator .navlist li").hover(function() {				 
				 if($(this).find('div.navbox').length>0){
						$(this).find('div.navbox').stop().animate({'margin-top':	'-40px'},{ 
						    easing: 'easeOutQuint', 
						    duration: 500, 
						    complete: true
						}); // move down - hide	
				 }	
				 if($(this).children('ul.subnav').length>0){
					 $(this).children('ul.subnav').stop().slideDown(80);
				 }
			}, function() {
				if($(this).find('div.navbox').length>0){
					if($(this).hasClass('on')) return false;
					$(this).find('div.navbox').stop().animate({'margin-top':	'0px'},{ 
					    easing: 'easeOutQuint', 
					    duration: 500, 
					    complete: true 
					}); // move down - hide		
				}
				 if($(this).children('ul.subnav').length>0){
					 $(this).children('ul.subnav').stop().slideUp(80);
				 }
			});
	</script>	
	<!-- //导航js -->
	<!-- //导航部分 -->
<!--// 鍏叡閮ㄥ垎 -->
<!-- 鐒︾偣鍥�-->
<!-- focus 鐒︾偣鍥�-->
<div class="slider">
		<div class="bd">
			<ul>
				<?php if(is_array($focuses)): foreach($focuses as $key=>$focus): ?><li><a <?php if(!empty($focus["linkurl"])): ?>target="_blank" href="<?php echo ($focus["linkurl"]); ?>"<?php else: ?>href="javascript:;"<?php endif; ?> title="<?php echo ($focus["title"]); ?>"><img
						src="<?php echo ($focus["cover"]); ?>" alt="<?php echo ($focus["title"]); ?>"/></a></li><?php endforeach; endif; ?>				
			</ul>
		</div>
		<div class="hd">
			<ul></ul>
		</div>
		<div class="pnBtn prev">
			<span class="blackBg"></span> <a class="arrow"
				href="javascript:void(0)"></a>
		</div>
		<div class="pnBtn next">
			<span class="blackBg"></span> <a class="arrow"
				href="javascript:void(0)"></a>
		</div>
	</div>
	<script type="text/javascript">	
			$(".slider .bd li").first().before( jQuery(".slider .bd li").last() );	
			$(".slider").hover(function(){ jQuery(this).find(".arrow").stop(true,true).fadeIn(300) },function(){ jQuery(this).find(".arrow").fadeOut(300) });	
			$(".slider").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"leftLoop", easing:"easeInOutBack", autoPlay:true, vis:3, autoPage:true, trigger:"click"});	
	</script>
	<!--// focus 鐒︾偣鍥�-->
	
<!-- //鐒︾偣鍥�-->

<!-- 浼樻儬淇冮攢妯″潡 -->
		<div class="promote">
				<!-- Section Start-->
				  <div class="flagintro normal">
				  		<div class="flagpart">
				  			<div class="content">
					  			<div class="fl fa fa-truck"></div>
					  			<div class="r_info fl">
						  			<h2>Free Shipping</h2>
						  			<p class="brief">Free Shipping on order over $49</p>
					  			</div>
				  			</div>
				  		</div>
				  		
				  		<div class="flagpart">
				  			<div class="content">
					  			<div class="fl fa fa-credit-card"></div>
					  			<div class="r_info fl">
					  			<h2>Easy Payment</h2>
					  			<p class="brief">Pay Your Deal At Amazon</p>
					  			</div>
				  			</div>
				  		</div>
				  		
				  		<div class="flagpart">
				  			<div class="content">
					  			<div class="fl fa fa-clock-o"></div>
					  			<div class="r_info fl">
					  			<h2>24hrs Shipping</h2>
					  			<p class="brief">Shipping at Anytime you want</p>
					  			</div>
					  		</div>
				  		</div>
				  		
				  		<div class="flagpart">
				  			<div class="content border_none">
					  			<div class="fl fa fa-check"></div>
					  			<div class="r_info fl">
					  			<h2>Over 500+ Choice</h2>
					  			<p class="brief">300+products to choose</p>
					  			</div>
					  		</div>
				  		</div>
				  </div>		
				  <div style="height: 20px;"></div>
		  <!-- Section End-->				  
		</div>		
	<!-- //浼樻儬淇冮攢妯″潡 -->

<!-- 鐑攢浜у搧 -->
	<div class="hot_product">
		<div class="hot_container">
			<div class="tag_title">
				<h1><i class="fa fa-fire"></i>HOT NEW</h1>
				<div class="controller">
					<a href="javascript:" title="prev" class="btn prev"><i class="fa fa-caret-left"></i></a>				
					<a href="javascript:" title="next" class="btn next"><i class="fa fa-caret-right"></i></a>
				</div>				
			</div>
			<div class="product_scroller">				
				<?php if($hots): ?><ul class="prolist">
					<?php if(is_array($hots)): foreach($hots as $key=>$hotgoods): ?><li class="item" >
					<a href="<?php echo U('Goods/detail',array('gid'=>$hotgoods['id']));?>" title="<?php echo ($hotgoods["goodsname"]); ?>" target="_blank" class="pro_link">
						<img src="<?php echo ($hotgoods["goodsimg"]); ?>" alt="<?php echo ($hotgoods["goodsname"]); ?>" />
						<p class="gname"><?php echo ($hotgoods["goodsname"]); ?></p>
						<p class="price">$<?php echo ($hotgoods["price"]); ?></p>
					</a>
					<div class="opbtn" id="<?php echo ($hotgoods["id"]); ?>">
						<a href="javascript:;" class="add_wish"><i class="fa fa-shopping-basket"></i>Wishlist</a>
						<a href="<?php if(empty($hotgoods["goodslink"])): echo U('Goods/detail',array('gid'=>$hotgoods['id'])); else: echo ($hotgoods["goodslink"]); endif; ?>" class="buy" target="_blank"><i class="fa fa-shopping-cart"></i>Buy Now</a>
					</div>
					</li><?php endforeach; endif; ?>
					</ul><?php endif; ?>			
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$(".hot_container").slide({ mainCell:"ul.prolist",autoPlay:true,effect:"leftLoop", vis:4, scroll:2, autoPage:true, pnLoop:false });
	$('.product_scroller ul.prolist li').hover(function (){
		$(this).addClass('on');
	},function(){
		$(this).removeClass('on');
	})
	</script>
<!-- //鐑攢浜у搧 -->

<!-- 鎺ㄨ崘浜у搧 -->	
<div class="rec">
	<div class="tag_title">
				<h1><i class="fa fa-tag"></i>RECOMMENDATIONS</h1>							
	</div>
	<?php if($recommends): ?><ul class="jumei-xp-list">	
		<?php if(is_array($recommends)): foreach($recommends as $idx=>$rgoods): ?><li <?php if((($idx+1)%3)==1): ?>class="noml"<?php elseif((($idx+1)%3)==0): ?>class="nomr"<?php endif; ?>>
					<div class="jumei-img-box" id="<?php echo ($rgoods["id"]); ?>">
							<img class="scrollLoading" data-url="<?php echo ($rgoods["goodsimg"]); ?>" src="<?php echo ($rgoods["goodsimg"]); ?>" alt="<?php echo ($rgoods["goodsname"]); ?>">
							<a href="<?php if(empty($rgoods["goodslink"])): ?>{U('Goods/detail',array('gid'=>$rgoods['id']))}<?php else: echo ($rgoods["goodslink"]); endif; ?>" class="op buy" target="_blank"><i class="fa fa-shopping-cart"></i>buy now</a>
							<a href="javascript:" class="op cart add_wish"><i class="fa fa-shopping-basket"></i>add to cart</a>
					</div>
						<a href="<?php echo U('Goods/detail',array('gid'=>$rgoods['id']));?>" title="<?php echo ($rgoods["goodsname"]); ?>" class="glink" target="_blank" ><?php echo (mb_substr($rgoods["goodsname"],0,40)); ?>..</a>
						<div class="intro_box">
							<div class="xp-price red-color">
								<em>$</em><span><?php echo ($rgoods["price"]); ?></span>
							</div>
							<div class="price_icon_wrap fr">
								<i class="fa fa-eye"></i><?php echo ($rgoods["click"]); ?>
							</div>
						</div>
					</li><?php endforeach; endif; ?>
				</ul>
				<?php else: ?>
				<div class="no_data" style="padding: 25px 0; color: #999; font-size: 1.5em; text-align: center;">No Recommended Products here !</div><?php endif; ?>
	</div>
			<script type="text/javascript">
			$('.jumei-img-box img').zoom_img({width:100,height:106});
			$('.jumei-img-box').hover(function (){
				$(this).find('img').addClass('on');
				$(this).find('a.op.buy').stop().animate({left: 0},{
				    easing: 'easeOutBack',
				    duration: 50,
				    complete: true
				});
				$(this).find('a.op.cart').stop().animate({right: 0},{
				    easing: 'easeOutBack',
				    duration: 50,
				    complete: true
				});
			}, function (){
				$(this).find('img').removeClass('on');					
				$(this).find('a.op.buy').stop().animate({left: '-170px'},{
				    easing: 'easeOutBack',
				    duration: 50,
				    complete: true
				});
				$(this).find('a.op.cart').stop().animate({right: '-170px'},{
				    easing: 'easeOutBack',
				    duration: 50,
				    complete: true
				});					
			})		
			</script>
	<!--// 鎺ㄨ崘浜у搧 -->			


<!-- 鍏充簬鎴戜滑 绠�粙 -->
	<div class="introduce">
		<div class="introduce_container">
				<div class="tag_title">
				<h1><i class="fa fa-globe"></i>OUR INTRODUCTION</h1>
			</div>
			<div class="main"><?php echo ($introduction); ?></div>
		</div>
	</div>
<!--// 鍏充簬鎴戜滑 绠�粙 -->

</div>
<div class="footer_zw"></div>
<!-- footer 底部 -->
<div class="foot">
	<div class="container">
		<div class="up_contain">
			<div class="content_box">
				<dl class="com">
					<dt><?php echo ($webname); ?></dt>
					<dd><span class="label"><i class="fa fa-map-marker"></i>address:</span><span class="content"> <?php echo ($address); ?></span></dd>
					<dd><span class="label"><i class="fa fa-phone"></i>phone:</span><span class="content"><?php if(! is_array($tels)): echo ($tels); else: if(is_array($tels)): foreach($tels as $index=>$tel): if(($index) != "0"): ?>&nbsp;/&nbsp;<?php endif; if(($index) <= "4"): echo ($tel); endif; endforeach; endif; endif; ?></span></dd>
					<dd><span class="label"><i class="fa fa-envelope-o"></i>Email:</span><span class="content">  <?php echo ($email); ?> </span> </dd>
				</dl>
			</div>
			<div class="content_box">
				<dl>
					<dt>Products</dt>
					<?php if(is_array($goods_cates)): foreach($goods_cates as $key=>$cate): ?><dd><a href="<?php echo U('Goods/index', array('cid'=>$cate['id'],'justfrom'=>'footer'));?>" <?php if(preg_match('/Index/ui','/Home/Index')): ?>target="_blank"<?php endif; ?>><?php echo ($cate["catename"]); ?></a></dd><?php endforeach; endif; ?>
				</dl>
			</div>
			<div class="content_box">
				<dl class="end">
					<dt>Abouts</dt>					
						<dd><a href="<?php echo U('News/index');?>" <?php if(preg_match('/Index/ui','/Home/Index')): ?>target="_blank"<?php endif; ?>>News</a></dd>					
						<dd><a href="<?php echo U('Contact/index');?>" <?php if(preg_match('/Index/ui','/Home/Index')): ?>target="_blank"<?php endif; ?>>Contact</a></dd>
						<?php if(is_array($signalpages)): foreach($signalpages as $key=>$signal): ?><dd>
						<a href="<?php echo U('Signal/page',array('sid'=>$signal['id'], 'signfrom'=>'indexpage'));?>" title="<?php echo ($signal["title"]); ?>" <?php if(preg_match('/Home/u','/Home/Index')): ?>target="_blank"<?php endif; ?>><?php echo ($signal["title"]); ?></a>
						</dd><?php endforeach; endif; ?>
				</dl>
			</div>
		</div>
		<div class="down_contain">
			<div class="nav">
				<a href="/">Home</a>
				<?php if(is_array($navs)): foreach($navs as $i=>$nav): ?><span style="color: #333; margin: 0 3px;">|</span>
				<a href="<?php echo ($nav["navlink"]); ?>"><?php echo ($nav["navname"]); ?></a><?php endforeach; endif; ?>
			</div>
			<div class="power"><?php echo ($copyright); ?></div>
		</div>
	</div>
</div>
<script type="text/javascript">
var f_height=$(".foot").height();
$(".footer_zw").css("height",f_height+45);

//统计代码
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
</script>
<!--  // footer 底部 -->

</body>
</html>