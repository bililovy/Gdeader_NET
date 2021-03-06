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
<link rel="stylesheet" type="text/css" href="/assets/css/default/goods/detail.css" />
<script type="text/javascript" src="/assets/common/js/tools/jquery.imgzoom.js"></script>
<div class="bodyContainer">
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
<div class="breadcrumb_box">	<ol class="breadcrumb">	  <li><a href="/"><i class="fa fa-home"></i>Home</a></li>	  <?php if(is_array($pageinfo["breadcrumb"])): foreach($pageinfo["breadcrumb"] as $link=>$crumb): if(is_numeric($link) or empty($link)): ?><li><?php echo ($crumb); ?></li>	  <?php else: ?>	  <li><a href="<?php echo ($link); ?>"><?php echo ($crumb); ?></a></li><?php endif; endforeach; endif; ?>	</ol></div>
<div class="detail_box">
	<div class="container">
		<div class="showmain">					
				<div class="preview fl">
					<div id="vertical" class="bigImg">
						<img src="" alt="<?php echo ($goods["goodsname"]); ?>" id="midimg" />
						<div style="display:none;" id="winSelector"></div>
					</div>
					<div class="smallImg">
						<div class="scrollbutton smallImgUp disabled"></div>
						<div id="imageMenu">
							<ul>
							<?php if(is_array($goodsalbums)): foreach($goodsalbums as $key=>$album): ?><li <?php if(($key) == "0"): ?>class="active"<?php endif; ?>><img src="<?php echo ($album["imgpath"]); ?>" width="68" alt="<?php echo ($goods["goodsname"]); ?>"/></li><?php endforeach; endif; ?>
							</ul>
						</div>
						<div class="scrollbutton smallImgDown"></div>
					</div>
					<div id="bigView" style="display:none;">
						<img width="800" height="850" alt="" src="" />
					</div>
				</div>
				<div class="rightinfo fl">
					<div class="operate">
						<i class="fa fa-angle-left"></i>back to : <a href="<?php echo U('Goods/index',array('cid'=>$goods['cateid'],'justfrom'=>'goodsdetail'));?>" class="back"><?php echo ($goods["catename"]); ?></a>
					</div>
					<h1><?php echo ($goods["goodsname"]); ?></h1>
					<div class="goods">
						<h2>$<?php echo ($goods["price"]); ?></h2>
						<div class="attrs_list">
							<?php if(is_array($goodsattr)): foreach($goodsattr as $key=>$attr): ?><span class="attr"><label><?php echo ($attr["attrname"]); ?>:</label><?php if(!is_array($attr['attrvalue'])): echo ($attr["attrvalue"]); else: if(is_array($attr["attrvalue"])): foreach($attr["attrvalue"] as $key=>$attrval): echo ($attrval); ?>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; endif; ?></span><?php endforeach; endif; ?>								
						</div>
						<div class="desc">
							<span>Product Features</span>
								<?php echo ($goods["description"]); ?>
						</div>
						<div class="op" id="<?php echo ($goods["id"]); ?>">
							<a href="<?php if(empty($goods["goodslink"])): ?>javascript:alert('Can not be bought !');<?php else: echo ($goods["goodslink"]); endif; ?>" class="btn buy"><i class="fa fa-shopping-cart"></i>buy now</a>
							<a href="javascript:;" class="btn wish add_wish"><i class="fa fa-shopping-basket"></i>add to wishlist</a>
						</div>
					</div>
				</div>
				<!-- 右侧近期记录浏览记录 -->
					<div class="history fl">
						<div class="title"><i class="fa fa-clock-o"></i>Popular Goods</div>
						<?php if($popular): ?><a href="javascript:;" class="button prev"><i class="fa fa-angle-up"></i></a>
						<a href="javascript:;" class="button next"><i class="fa fa-angle-down"></i></a>
						<div class="scroll">
							<ul>
								<?php if(is_array($popular)): foreach($popular as $key=>$g): ?><li><a href="<?php echo U('Goods/detail',array('gid'=>$g['id'],'justfrom'=>'goodsdetail'));?>" title="<?php echo ($g["goodsname"]); ?>"><img src="<?php echo ($g["goodsimg"]); ?>" alt="<?php echo ($g["goodsname"]); ?>" /><h2><?php echo (mb_substr($g["goodsname"],0,26)); ?></h2></a></li><?php endforeach; endif; ?>
							</ul>
						</div><?php endif; ?>						
					</div>
				<!--// 右侧近期记录浏览记录 -->
		</div>
		<!-- 宝贝详情 -->
		<div class="contain details">
			<div class="heading">
				<span class="maintext">Product Descriptions</span>
				<span class="subtext"> See More Infomation About the Product</span>
			</div>
			<div class="mainbody">
				<!-- 来自自己编辑 -->
				<?php echo ($goods["goodsdetail"]); ?>
					<!-- 来自自己编辑 -->
			</div>
		</div>
		<!--// 宝贝详情 -->
		
		<!-- 相关宝贝 -->
		<?php if($recommends): ?><div class="contain related">
			<div class="heading">
				<span class="maintext">Related Products</span>
				<span class="subtext"> See Our Most featured Products</span>
			</div>
			<div class="related_pro">
				<ul class="prolist">
				<?php if(is_array($recommends)): foreach($recommends as $key=>$pro): ?><li class="item">
					<div class="imgbox">
						<img src="<?php echo ($pro["goodsimg"]); ?>" alt="<?php echo ($pro["goodsname"]); ?>" />
						<a href="<?php echo U('Goods/detail', array('gid'=>$pro['id'], 'justfrom'=>'productdetail'));?>" title="<?php echo ($pro["goodsname"]); ?>" class="link"><i class="fa fa-search"></i>quick view</a>
					</div>
					<div class="info">
						<h2><a href="<?php echo U('Goods/detail', array('gid'=>$pro['id'], 'justfrom'=>'productdetail'));?>" title="<?php echo ($pro["goodsname"]); ?>"><?php echo (mb_substr($pro["goodsname"],0,55)); ?>..</a></h2>
						<div class="oparea" id="<?php echo ($pro["id"]); ?>">
							<p class="price">$<?php echo ($pro["price"]); ?></p>
							<a href="javascript:;" class="btn add_wish"><i class="fa fa-shopping-basket"></i>add to wishlist</a>
						</div>
					</div>
					</li><?php endforeach; endif; ?>
				</ul>
				<div class="hd">
					<ul>
					</ul>
				</div>
			</div>		
	     
		</div><?php endif; ?>
		<!--// 相关宝贝 -->		
	</div>
</div>	
<script type="text/javascript">
$('#vertical img').attr('src',$('#imageMenu ul li:first-child').find('img').attr('src'));
</script>
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
					<?php if(is_array($goods_cates)): foreach($goods_cates as $key=>$cate): ?><dd><a href="<?php echo U('Goods/index', array('cid'=>$cate['id'],'justfrom'=>'footer'));?>" <?php if(preg_match('/Index/ui','/Home/Goods')): ?>target="_blank"<?php endif; ?>><?php echo ($cate["catename"]); ?></a></dd><?php endforeach; endif; ?>
				</dl>
			</div>
			<div class="content_box">
				<dl class="end">
					<dt>Abouts</dt>					
						<dd><a href="<?php echo U('News/index');?>" <?php if(preg_match('/Index/ui','/Home/Goods')): ?>target="_blank"<?php endif; ?>>News</a></dd>					
						<dd><a href="<?php echo U('Contact/index');?>" <?php if(preg_match('/Index/ui','/Home/Goods')): ?>target="_blank"<?php endif; ?>>Contact</a></dd>
						<?php if(is_array($signalpages)): foreach($signalpages as $key=>$signal): ?><dd>
						<a href="<?php echo U('Signal/page',array('sid'=>$signal['id'], 'signfrom'=>'indexpage'));?>" title="<?php echo ($signal["title"]); ?>" <?php if(preg_match('/Home/u','/Home/Goods')): ?>target="_blank"<?php endif; ?>><?php echo ($signal["title"]); ?></a>
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
<script type="text/javascript" src="/assets/js/default/Goods/detail.js"></script>
</html>