<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <title><?php if(!empty($pageinfo["pagetitle"])): echo ($pageinfo["pagetitle"]); ?>-<?php endif; echo ($webname); ?> </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
<!-- 启用 WebApp 全屏模式 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <!-- 隐藏状态栏/设置状态栏颜色 -->
    <meta name="apple-mobile-web-app-title" content="<?php echo ($pageinfo["pagetitle"]); ?>">
    <!-- 添加到主屏后的标题 -->
    <meta content="telephone=no" name="format-detection" />
    <!-- 忽略数字自动识别为电话号码 -->
    <meta content="email=no" name="format-detection" />
    <!-- 忽略识别邮箱 -->
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <!-- 转码申明：用百度打开网页可能会对其进行转码，如下meta避免转码 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!-- 下面是 禁止浏览器从本地计算机的缓存中访问页面内容：这样设定，访问者将无法脱机浏览。 -->
    <!-- <meta http-equiv="Pragma" content="no-cache"> -->
    <!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
    <meta name="HandheldFriendly" content="true">
    <!-- 微软的老式浏览器 -->
    <meta name="MobileOptimized" content="320">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <!-- UC强制全屏 -->
    <meta name="full-screen" content="yes">
    <!-- QQ强制全屏 -->
    <meta name="x5-fullscreen" content="true">
    <!-- UC应用模式 -->
    <meta name="browsermode" content="application">
    <!-- QQ应用模式 -->
    <meta name="x5-page-mode" content="app">
    <!-- windows phone 点击无高光 -->
    <meta name="msapplication-tap-highlight" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="msapplication-TileColor" content="#000"/>
    <!-- Windows 8 磁贴颜色 -->
    <meta name="msapplication-TileImage" content="icon.png"/>
    <!-- Windows 8 磁贴图标 -->
    <meta name="keywords" content="<?php if(empty($pageinfo["keywords"])): echo ($keywords); else: echo ($pageinfo["keywords"]); endif; ?>" />
    <meta name="description" content="<?php if(empty($pageinfo["description"])): echo ($description); else: echo ($pageinfo["description"]); endif; ?>" />
    <meta name="language" content="zh-CN" />
    <meta name="author" content="<?php if(empty($pageinfo["author"])): echo ($webname); else: echo ($pageinfo["author"]); endif; ?>" />
    <link href="/urpower.ico" type="image/x-icon" rel="icon"/>
    <link href="/urpower.ico" type="image/x-icon" rel="Shortcut Icon"/>
    <link href="/urpower.ico" type="image/x-icon" rel="Bookmark"/>

    <!-- 公共才css js 部分 -->
    <link rel="stylesheet" type="text/css" href="/assets/css/default/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/default/font-icons.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/default/styles.css" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/assets/js/default/html5shiv.js"></script>
    <script type="text/javascript" src="/assets/js/default/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/assets/js/default/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/default/function.js"></script>
    <script type="text/javascript" src="/assets/plugins//layer/layer.js"></script>

    <script type="text/javascript">
        var ctxPath =location.hostname;
        function addFavorite(obj)
            {
                var add_fav_uri = "<?php echo U('Goods/ajaxCart', '', '');?>";
                var $fav_num = obj.find('span.fav-num');
                var $now = parseInt($fav_num.text()) != null ? parseInt($fav_num.text()) : 0;
                var reg =/\d+/g;
                var $gid = (obj.attr('id')).match(reg);
                if ($gid  > 0){
                   var $status = addCart($gid[0], add_fav_uri);
                    if (typeof $status == 'object'){
                        switch ($status.status){
                            case 1:
                                var $data = $status.data;
                                var $fav_count = $status.count;
                                $fav_num.text($now+1);
                                break;
                            default :
                                var $data = $status.data;
                        }
                        layer.tips($data, obj , {
                            tips: [1, '#E56C00'],
                            time: 3000
                        });
                        if ($status.status ==3) {
                            setTimeout(function (){
                                window.location.href=$status.url;
                            },3000)
                        }
                    }
                }else{
                    layer.tips('Operation failed, Please try again ！。', obj , {
                        tips: [1, '#E56C00'],
                        time: 3000
                    });
                }
            }
    </script>
    <meta name="uyan_auth" content="0db1ec8032" />
<!-- 公共才css js 部分 -->
</head>
<body>
<!-- header -->
<!-- Header -->
<header class="header row header--fixed hide-from-print animated slideDown" id="header">
    <div class="container">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"  data-target="#example-navbar-collapse">
                    <span class="sr-only">Switching navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Logo -->
                <div class="logo"><a href="/" title="<?php echo ($webname); ?>"><img class="img-responsive" src="<?php echo ($logo); ?>" alt="<?php echo ($webname); ?>" title="<?php echo ($webname); ?>" style="height:45px;"></a></div>
                <!-- END Logo -->
            </div>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <div class="nav-triangle-up"></div>
                <ul class="nav navbar-nav">
                    <?php if(is_array($navs)): foreach($navs as $key=>$nav): ?><li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo ((isset($nav["navlink"]) && ($nav["navlink"] !== ""))?($nav["navlink"]):'javascript:;'); ?>"  title="<?php echo ($nav["navname"]); ?>" <?php if(($nav["openway"]) == "1"): ?>target="_blank"<?php endif; ?>>
                            <i class="menu-icn fa fa-eye"></i>
                            <span><?php echo ($nav["navname"]); ?></span>
                        </a>
                        <?php if(!empty($nav['childs'])): ?><ul class="dropdown-menu menu-pr" role="menu">
                            <div class="triangle-up"></div>
                            <?php if(is_array($nav["childs"])): foreach($nav["childs"] as $key=>$subnav): ?><li data-submenu-id="submenu-2">
                                <a href="<?php echo ($subnav["navlink"]); ?>" title="<?php echo ($subnav["navname"]); ?>" <?php if(($subnav["openway"]) == "1"): ?>target="_blank"<?php endif; ?>><div class="left"><?php echo ($subnav["navname"]); ?></div>
                                <?php if(!empty($subnav['childs'])): ?><div class="right">&gt;</div><?php endif; ?>
                                </a>
                                <!--<div id="submenu-2" class="popover" style="background:#fff url(http://www.taotronics.com/images/submenu-bg-office.jpg) left bottom no-repeat;">-->
                                <div id="submenu-2" class="popover">
                                    <?php if(!empty($subnav['childs'])): ?><ul class="list-unstyled submenu-box">
                                        <?php if(is_array($subnav["childs"])): foreach($subnav["childs"] as $key=>$thirdnav): ?><li>
                                            <a href="<?php echo ($thirdnav["navlink"]); ?>" title="<?php echo ($thirdnav["navname"]); ?>" <?php if(($thirdnav["openway"]) == "1"): ?>target="_blank"<?php endif; ?>><?php echo ($thirdnav["navname"]); ?></a>
                                        </li><?php endforeach; endif; ?>
                                    </ul><?php endif; ?>
                                </div>
                            </li><?php endforeach; endif; ?>
                        </ul><?php endif; ?>
                    </li><?php endforeach; endif; ?>
                </ul>
            </div>
            <!-- END Menu -->

            <div class="nav-right-box">
                <!-- search -->
                <div class="search-icn"><a href="javascript:void(0);"><i class="menu-icn menu-icn-search fa fa-search"></i><span>Search</span></a></div>
                <!-- END Search -->

                <!--Login -->
                <?php if($_SESSION['member'] and $_SESSION['member']['SIGNIN_AUTHKEY']=='ALLOW_IN'): ?><div class="top-login logined">
                        <p class="logon"><a href="javascript:;" title="check details"><b class="uname"><?php echo ($_SESSION['member']['username']); ?></b></a></p>
                        <a href="<?php echo U('Member/exitSign');?>" title="logout"><i class="fa fa-sign-out"></i><span id="signout">sign out</span></a>
                    </div>
                    <?php else: ?>
                <div class="top-login">
                    <a href="javascript:void(0);"><i class="menu-icn menu-icn-login fa fa-vcard"></i></a>

                    <span><a href="<?php echo U('Member/login');?>">Sign In</a> / <a href="<?php echo U('Member/regist');?>">Register</a></span>

                </div><?php endif; ?>
                <!--END Login -->
            </div>
        </nav>
    </div>

    <!-- search-box -->
    <div class="search-box-unit" >
        <div class="container">
            <div class="search-box-info">
                <form role="form" id="searchForm" method="post" onsubmit="return productSearch('txtSearchM');">
                    <input type="text" class="form-control" id="txtSearchM" name="txtSearchM" placeholder="Search">
                    <button type="submit" class="btn bg-orange" id="btnSearchM">Search</button>
                    <button type="button" class="search-close">X</button>
                </form>
            </div>
        </div>
    </div>
    <!-- end search-box -->
</header>
<!-- END Header -->

<script type="text/javascript" >
    $('.nav-right-box .search-icn').click(function (){
        if ($('.search-box-unit').attr('slide') == 0 || null == $('.search-box-unit').attr('slide')){
       $('.search-box-unit').slideDown(200).attr('slide', 1);
        }else{
       $('.search-box-unit').slideUp(200).attr('slide', 0);
        }
    })
    $('.search-close').click(function (){
       $('.search-box-unit').slideUp(200).attr('slide', 0);
    })

//    $(document).ready(function(){
//        // 设置header一级菜单可以点击
//        $(document).off('click.bs.dropdown.data-api');
//    });
    //search product
    function productSearch(txtid){
        var _keywords = document.getElementById(txtid).value;
var _search_url ="<?php echo U('Search/sq', '');?>";
        if('' != _keywords.replace(/[ ]/gm,'')){
            _search_url = _search_url+'?q='+ _keywords;
            $('#searchForm').attr("action", _search_url);
            $('#searchForm').submit();
            //window.location.href="http://www.taotronics.com/catalog/product/search/" + _keywords;
        }else{
            layer.tips('Please enter the key words', $('#btnSearchM'));
            return false;
        }
    }

</script>
<!--/ header -->
<!-- focus -->

<script type="text/javascript" src="/assets/js/default/toucher.js"></script>
<!-- banner -->
<div class="row banner">
    <div id="carousel-example-generic" class="carousel slide both carousel-fade" data-ride="carousel">
        <!-- Carousel Pointer -->
        <?php if($focuses): ?><ol class="carousel-indicators">
                <?php if(is_array($focuses)): foreach($focuses as $index=>$focus): ?><li data-target="#carousel-example-generic" data-slide-to="<?php echo ($index); ?>" <?php if(($index) == "0"): ?>class="active"<?php endif; ?>></li><?php endforeach; endif; ?>
            </ol><?php endif; ?>

        <!-- Carousel pic -->
        <div class="carousel-inner" role="listbox">
            <?php if(is_array($focuses)): foreach($focuses as $index=>$focus): ?><!-- Banner -->
                <div class="item <?php if(($index) == "0"): ?>active<?php endif; ?>">
                    <a href="<?php if(empty($focus["linkurl"])): ?>javascript:;<?php else: echo ($focus["linkurl"]); endif; ?>" target="_blank" class="big-bn" style=" background:url(<?php echo ($focus["cover"]); ?>) center center no-repeat;"></a>
                    <a href="<?php if(empty($focus["linkurl"])): ?>javascript:;<?php else: echo ($focus["linkurl"]); endif; ?>" target="_blank" class="ipad-bn" style=" background:url(<?php echo ($focus["cover"]); ?>) center center no-repeat;"></a>
                    <?php if($focus["showtype"] == 3): ?><div class="bn-info float-left text-left">  <!-- 样式支持  bn-reg text-left  /  giveaway-bn text-center  /  bn-info float-left text-left -->
                    <?php elseif($focus["showtype"] == 2): ?>
                        <div class="bn-reg text-left">  <!-- 样式支持  bn-reg text-left  /  giveaway-bn text-center  /  bn-info float-left text-left -->
                    <?php else: ?>
                        <div class="giveaway-bn text-center">  <!-- 样式支持  bn-reg text-left  /  giveaway-bn text-center  /  bn-info float-left text-left --><?php endif; ?>
                    <div class="desc-content">
                        <?php echo (htmlspecialchars_decode($focus["desc"])); ?>
                    </div>
                        <a href="<?php echo ($focus["linkurl"]); ?>" target="_blank" class="btn bg-orange margin-t15"><?php echo ((isset($focus["btntext"]) && ($focus["btntext"] !== ""))?($focus["btntext"]):'See More'); ?></a>
                    </div>
                </div>
                <!--End Banner --><?php endforeach; endif; ?>
        </div>

        <!-- Controls -->
        <a id="carleft" class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a id="carright" class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<!-- end banner -->
<script>
    $(document).ready(function(){
        //banner
        $('.carousel').carousel({
            interval: 5000
        });

        // banner
        var myTouch = util.toucher(document.getElementById('carousel-example-generic'));
        myTouch.on('swipeLeft',function(e){
            $('#carright').click();
        }).on('swipeRight',function(e){
            $('#carleft').click();
        });
    });
</script>

<!--/ focus -->

<!-- new arrivals -->
<div class="row rav-pr">
    <div class="container">
        <h2 class="text-left gray">New Arrivals</h2>
        <?php if($hots): ?><ul class="list-unstyled">
                <?php if(is_array($hots)): foreach($hots as $key=>$g): ?><li>
                    <img class="gimg" alt="<?php echo ($g["goodsname"]); ?>" src="<?php echo ($g["goodsimg"]); ?>">
                    <h4><a href="<?php echo U('Goods/detail',array('gid'=>$g['id']));?>" target="_blank" title="<?php echo ($g["goodsname"]); ?>"><?php echo ($g["goodsname"]); ?></a></h4>
                    <div class="price">
                        <div class="price-left">
                            <div class="info">
                                <?php if(!$g["sell_price"] or $g["sell_price"] <= 0): ?><span class="font24 bule-size">$<?php echo ($g["price"]); ?></span>
                                <?php else: ?>
                                    <span class="font24 bule-size"><?php echo ($g["sell_price"]); ?></span>
                                    <span class="text-del">$<?php echo ($g["price"]); ?></span><?php endif; ?>
                            </div>
                        </div>

                        <div class="price-right">
                            <div class="score fl" data-score="<?php echo ($g["score"]); ?>">
                                <img src="/assets/images/default/icons/star-off-big.png" />
                                <img src="/assets/images/default/icons/star-off-big.png" />
                                <img src="/assets/images/default/icons/star-off-big.png" />
                                <img src="/assets/images/default/icons/star-off-big.png" />
                                <img src="/assets/images/default/icons/star-off-big.png" />
                            </div>
                            <div class="fav fr" id="gf_<?php echo ($g["id"]); ?>">❤(<span class="fav-num"><?php if($g["favnum"] > 9999): ?>9999+<?php else: echo ($g["favnum"]); endif; ?></span>)</div>
                            <a id="ga-dailyDeals" class="btn bg-blue clear-b" href="<?php if(empty($g["goodslink"])): echo U('Goods/detail',array('gid'=>$g['id'])); else: echo ($g["goodslink"]); endif; ?>" target="_blank">Buy at Amazon</a>
                        </div>
                    </div>
                </li><?php endforeach; endif; ?>

            </ul><?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    // set the stars number
    $('.rav-pr .container .price-right .score').each (function (){
        var $score= (isNaN(parseFloat($(this).attr('data-score'))) || parseFloat($(this).attr('data-score')) <0) ? 0 : parseFloat($(this).attr('data-score'));
        var star_on="/assets/images/default/icons/star-on-big.png";
        var star_half="/assets/images/default/icons/star-half-big.png";
        var imgs =$(this).find('img').length;
        var reg=/\./g;
        var $int_score=null;
        var $float_score=null;
        if (reg.test($score)){
            var $score=$score.toString().split('.');
            $int_score = $score[0];
            $float_score = $score[1];
        }else{
            $int_score = $score;
        }
        for(var i=0; i< imgs; i++){
            if (i<$int_score){
                $(this).find('img').eq(i).attr('src', star_on);
            }
            if(null != $float_score && $float_score >=3){
                $(this).find('img').eq($int_score).attr('src', star_half);
            }
        }
    })
</script>

<!--/ new arrivals -->

<!-- best sellers -->

<div class="row rav-pr">
    <div class="container">
        <h2 class="text-left gray">Best Sellers</h2>
        <?php if($recommends): ?><ul class="list-unstyled">
                <?php if(is_array($recommends)): foreach($recommends as $key=>$rg): ?><li>
                        <img class="gimg" alt="<?php echo ($rg["goodsname"]); ?>" src="<?php echo ($rg["goodsimg"]); ?>">
                        <h4><a href="<?php echo U('Goods/detail',array('gid'=>$rg['id']));?>" target="_blank" title="<?php echo ($rg["goodsname"]); ?>"><?php echo ($rg["goodsname"]); ?></a></h4>
                        <div class="price">
                            <div class="price-left">
                                <div class="info">
                                    <?php if(!$rg["sell_price"] or $rg["sell_price"] <= 0): ?><span class="font24 bule-size">$<?php echo ($rg["price"]); ?></span>
                                        <?php else: ?>
                                        <span class="font24 bule-size"><?php echo ($rg["sell_price"]); ?></span>
                                        <span class="text-del">$<?php echo ($rg["price"]); ?></span><?php endif; ?>
                                </div>
                            </div>

                            <div class="price-right">
                                <div class="score fl" data-score="<?php echo ($rg["score"]); ?>">
                                    <img src="/assets/images/default/icons/star-off-big.png" />
                                    <img src="/assets/images/default/icons/star-off-big.png" />
                                    <img src="/assets/images/default/icons/star-off-big.png" />
                                    <img src="/assets/images/default/icons/star-off-big.png" />
                                    <img src="/assets/images/default/icons/star-off-big.png" />
                                </div>
                                <div class="fav fr" id="gf_<?php echo ($rg["id"]); ?>">❤(<span class="fav-num"><?php if($rg["favnum"] > 9999): ?>9999+<?php else: echo ($rg["favnum"]); endif; ?></span>)</div>
                                <a id="ga-dailyDeals1" class="btn bg-blue clear-b" href="<?php if(empty($rg["goodslink"])): echo U('Goods/detail',array('gid'=>$rg['id'])); else: echo ($rg["goodslink"]); endif; ?>" target="_blank">Buy at Amazon</a>
                            </div>
                        </div>
                    </li><?php endforeach; endif; ?>

            </ul><?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    $('.fav').click(function (){
        addFavorite($(this));
    })
    // set the stars number
    $('.rav-pr .container .price-right .score').each (function (){
        var $score= (isNaN(parseFloat($(this).attr('data-score'))) || parseFloat($(this).attr('data-score')) <0) ? 0 : parseFloat($(this).attr('data-score'));
        var star_on="/assets/images/default/icons/star-on-big.png";
        var star_half="/assets/images/default/icons/star-half-big.png";
        var imgs =$(this).find('img').length;
        var reg=/\./g;
        var $int_score=null;
        var $float_score=null;
        if (reg.test($score)){
            var $score=$score.toString().split('.');
            $int_score = $score[0];
            $float_score = $score[1];
        }else{
            $int_score = $score;
        }
        for(var i=0; i< imgs; i++){
            if (i<$int_score){
                $(this).find('img').eq(i).attr('src', star_on);
            }
            if(null != $float_score && $float_score >=3){
                $(this).find('img').eq($int_score).attr('src', star_half);
            }
        }
    })
</script>

<!--/ best sellers -->

<!-- subscribe -->
<div class="subscribe">
    <div class="container">
        <div class="subscribe1">
            <h4>Book Latest News</h4>
            <span style="color:#a5a5a5;">To leave your email, you can recieve our latest news for the first time.</span>
        </div>
        <div class="subscribe2">
            <form action="" method="post">
                <input type="text" class="text" name="email" value="Email" onfocus="if (this.value == 'Email'){this.value=''};"
                       onblur="if (this.value == '') { this.value = 'Email';}">
                <a href="javascript:;" class="submit" onclick="checkEmail(this)">Subscribe</a>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript">
    var bookingUrl = "<?php echo U('News/BookingNews');?>";
    function checkEmail(obj) {
        var $this = $(obj).siblings('input[name="email"]');
        var value = $this.val();
        var myreg = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/ig;

        if (!myreg.test(value)) {

            layer.tips('Please input the correct email !', obj, {
                tips: [1, '#E56C00'],
                time: 3000
            });
            $this.focus();
            return false;
        } else {
            //提交
            var $data = {'email': value}
            $.post(bookingUrl, $data, function (back) {
                if (back.status == 1) {
                    layer.msg(back.data, {
                        time: 0 //不自动关闭
                        , btn: ['I\'ve got it !']
                        , yes: function (index) {
                            layer.close(index);
                        }
                    });
                } else {
                    layer.msg(back.data, {
                        time: 0 //不自动关闭
                        , btn: ['I\'ve got it !']
                        , yes: function (index) {
                            layer.close(index);
                        }
                    })
                }
            }, 'json');
    }
    return false;
    }
</script>
<!--// subscribe -->

<!-- footer -->
<div class="footer-section">
    <div class="container">
        <div class="footer-grids">
            <div class="col-md-2 footer-grid">
                <h4>products</h4>
                <ul>
                    <?php if(is_array($goods_cates)): foreach($goods_cates as $key=>$cate): ?><li><a href="<?php echo U('Goods/index', array('cid'=>$cate['id'],'justfrom'=>'footer'));?>" <?php if(preg_match('/Index/ui','/Home/Index')): ?>target="_blank"<?php endif; ?>><?php echo ($cate["catename"]); ?></a></li><?php endforeach; endif; ?>
                </ul>
            </div>
            <div class="col-md-2 footer-grid">
                <h4>company</h4>
                <ul>
                    <li><a href="<?php echo U('Index/about');?>">About Us</a></li>
                    <li><a href="<?php echo U('Index/introduction');?>">Introduction</a></li>
                </ul>
            </div>
            <div class="col-md-2 footer-grid">
                <h4>service</h4>
                <ul>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="<?php echo U('News/index');?>" <?php if(preg_match('/Index/ui','/Home/Index')): ?>target="_blank"<?php endif; ?>>News</a></li>
                </ul>
            </div>
            <div class="col-md-2 footer-grid">
                <h4>guidance</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <?php if(is_array($navs)): foreach($navs as $i=>$nav): ?><li>
                        <a href="<?php echo ($nav["navlink"]); ?>"><?php echo ($nav["navname"]); ?></a>
                        </li><?php endforeach; endif; ?>
                </ul>
            </div>

            <div class="col-md-4 footer-grid1">
                <?php if($socialtools): ?><div class="social-icons">
                        <?php if(is_array($socialtools)): foreach($socialtools as $key=>$social): ?><a href="<?php echo ($social["account"]); ?>" title="<?php echo ($social["toolname"]); ?>" target="_blank"><i class="icon fa <?php echo ($social["icon"]); ?>"></i></a><?php endforeach; endif; ?>
                    </div><?php endif; ?>
                <p><?php echo ($copyright); ?>.<a href="<?php echo ($domain); ?>">--<?php echo ($webname); ?></a></p>
                <p><i class="fa fa-phone" style="margin-right: 5px;"></i>phone:</span><span class="content"><?php if(! is_array($tels)): echo ($tels); else: if(is_array($tels)): foreach($tels as $index=>$tel): if(($index) != "0"): ?>&nbsp;/&nbsp;<?php endif; if(($index) <= "4"): echo ($tel); endif; endforeach; endif; endif; ?></span></p>
                <p><i class="fa fa-envelope-o" style="margin-right: 5px;"></i>Email:</span><span class="content">  <?php echo ($email); ?> </span> </p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<style type="text/css">

    .side_bar_right{position:fixed;width:54px;height:105px;right:40px;bottom:10px;z-index:100;}
    .side_bar_right ul li{width:54px;height:54px;float:left;position:relative;border-bottom:1px solid #444;}
    .side_bar_right ul li .side_bar_rightbox{position:absolute;width:54px;height:54px;top:0;right:0;transition:all 0.3s;background:#E56C00;opacity:0.8;filter:Alpha(opacity=80);color:#fff;font:14px/54px "微软雅黑";overflow:hidden;}
    .side_bar_right ul li .side_bar_righttop{width:54px;height:54px;line-height:54px;display:inline-block;background:#E56C00;opacity:0.8;filter:Alpha(opacity=80);transition:all 0.3s;}
    .side_bar_right ul li .side_bar_righttop:hover{background:#ae1c1c;opacity:1;filter:Alpha(opacity=100);}
    .side_bar_right ul li img{float:left;}
    .side_bar_right .side_bar_rightbox{text-align: center; color:#FFF}
    .side_bar_right .side_bar_rightbox i{color:#FFF;font-size: 1.6em; }
    .side_bar_right .side_bar_rightbox #favorite_count {margin-left: 5px;
        color: #ffffff; display: none}


</style>

<script type="text/javascript">
    $(document).ready(function(){

        $(".side_bar_right ul li").hover(function(){
            $(this).find(".side_bar_rightbox").stop().animate({"width":"124px"},200, function (){
                $('#favorite_count').fadeIn(100);
            }).css({"opacity":"1","filter":"Alpha(opacity=100)","background":"#ae1c1c"})
        },function(){
            $(this).find(".side_bar_rightbox").stop().animate({"width":"54px"},200, function (){
                $('#favorite_count').fadeOut(100);
            }).css({"opacity":"0.8","filter":"Alpha(opacity=80)","background":"#E56C00"})
        });

    })
    //回到顶部
    function gotoTop(){
        $('html,body').animate({'scrollTop':0},600);
    }
</script>
<div class="side_bar_right">
    <ul>
        <?php if($member): ?><li><a href="<?php echo U('Goods/wishlist');?>" title="favorite Cart"><div class="side_bar_rightbox" ><i class="fa fa-heart"></i><span id="favorite_count" >(<?php echo ((isset($member["count"]) && ($member["count"] !== ""))?($member["count"]):0); ?>)</span></a></li>
        <?php else: ?>
        <li><a href="<?php echo U('Member/login');?>" title="Login to see the favorite cart"><div class="side_bar_rightbox" ><i class="fa fa-heart"></i><span id="favorite_count" >(0)</span></a></li><?php endif; ?>
            <li style="border:none;" onclick="gotoTop()"><a href="javascript:;"  class="side_bar_righttop"><img src="/assets/images/default/icons/side_icon05.png"></a></li>
    </ul>
</div>

<script type="text/javascript">
    //image lazy load
//    $("img.lazy").lazyload({
//        effect: "fadeIn",
//        threshold : 200
//    });
</script>
<!--/footer-->

<!-- script -->
<script type="text/javascript" src="/assets/js/default/base_common.js"></script>
<script type="text/javascript" src="/assets/js/default/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/default/bootstrapValidator.js"></script>
<script type="text/javascript" src="/assets/js/default/jquery.lazyload.js"></script>
<script type="text/javascript" src="/assets/js/default/jquery.menu.js"></script>
<script type="text/javascript" src="/assets/js/default/headroom.min.js"></script>
<script type="text/javascript" src="/assets/js/default/brand.js"></script>
<script type="text/javascript" src="/assets/js/default/jquery.blockUI.js"></script>
<script type="text/javascript" src="/assets/js/default/front-base.js"></script>
<script type="text/javascript" src="/assets/js/default/front-lang-en.js"></script>



<!--/script-->
</body>
</html>