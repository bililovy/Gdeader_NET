$(document).ready(function(){
	// header menu	
	var $menu = $(".dropdown-menu");
	$menu.menuAim({
		activate: activateSubmenu,
		deactivate: deactivateSubmenu
	});
	
	function activateSubmenu(row) {
		var $row = $(row),
			submenuId = $row.data("submenuId"),
			$submenu = $("#" + submenuId),
			height = $menu.outerHeight(),
			width = $menu.outerWidth();  

		$submenu.css({display: "block"});
		$row.find("a").addClass("maintainHover");
	}

	function deactivateSubmenu(row) {
		var $row = $(row),
			submenuId = $row.data("submenuId"),
			$submenu = $("#" + submenuId);

		$submenu.css("display", "none");
		$row.find("a").removeClass("maintainHover");
	}
	
	$(".dropdown-menu li").click(function(e) {
        e.stopPropagation();
    });

	$(document).click(function() {
        $(".popover").css("display", "none");
        $("a.maintainHover").removeClass("maintainHover");
    });	
	
	
	//search
	$(".search-icn a").click(function(){
		$(".search-box").slideToggle("slow");
	});
	  
	$(".search-close").click(function(){
		$(".search-box").slideUp("slow");
	}); 


	//list info
	$(".show").bind("click",function(){
		$("#menu li").removeClass("current");
		$("#menu li").first().addClass("current");
		$(".tab-box div").first().removeClass("hide");
		$("#cm").addClass("hide");
	  });
	  
	$("#menu li").eq(3).click(function(){
		$(".tab-box .box").addClass("hide");
		$(".tab-box div").first().removeClass("hide");
	});

	//customer
	$(".rw").bind("click",function(){
		$("#menu li").removeClass("current");
		$("#menu li").eq(0).addClass("current");
		$(".tab-box .box").addClass("hide");
		$(".tab-box div").first().removeClass("hide");	
	});

	$(".nav-faq").bind("click",function(){
		$("#menu li").removeClass("current");
		$("#menu li").eq(2).addClass("current");
		$(".tab-box .box").addClass("hide");
		$("#faq").removeClass("hide");
	});
		
	$(".dw").bind("click",function(){
		$("#menu li").removeClass("current");
		$("#menu li").eq(1).addClass("current");
		$(".tab-box .box").addClass("hide");
		$("#dw").removeClass("hide");
	});	
	  
	//go to top
	goTop();   
   
	hideHeader();
});

// 本页锚点滚动
$.fn.scroller = function() {
	var speed = 500; // Choose default speed
	$(this).each(function() {
		$(this).bind('click', function() {
			var target = $(this).attr('href'); // Get scroll target
			$("html, body").animate({
				scrollTop: $(target).offset().top + "px"
			}, speed);
			return false;
		});
	});
}

/** Check whether string s is empty. */
function isEmpty(s){
	return ((s == undefined || s == null || s == "") ? true : false);
}

//if ie6
if(window.ActiveXObject) {  
    var ua = navigator.userAgent.toLowerCase();  
    var ie=ua.match(/msie ([\d.]+)/)[1];  
    if(ie==6.0){  
        alert("taotronics website to remind you: Your browser version is too low, our site can not achieve good visual results, we recommend you upgrade to ie8 more!");  
        window.close();  
    }  
}  
/*

function goTop(){
   var _obj = $("#gotop");
  $(window).scroll(function () {
       var a = $(window).scrollTop();  
	         if (a > 0) {  
	             _obj.css("display", "block");  
	            } else {  
	             _obj.css("display", "none");  
	            }  
    });  
   _obj.click(function () { 
        	  $('html,body').animate({ scrollTop: '0px' }, 800); 
        	  return false; 
    });	
}*/

function hideHeader(){
	var header = new Headroom(document.querySelector("#header"), {
        tolerance: 5,
        offset : 205,
        classes: {
          initial: "animated",
          pinned: "slideDown",
          unpinned: "slideUp"
        }
    });
    header.init();
}

function goTop(){
    var obj=document.getElementById("gotop");
	if (null != obj){
		function getScrollTop(){
				return document.documentElement.scrollTop;
			}
		function setScrollTop(value){
				document.documentElement.scrollTop=value;
			}
		window.onscroll=function(){getScrollTop()>0?obj.style.display="":obj.style.display="none";};
		obj.onclick=function(){
	}
        var goTop=setInterval(scrollMove,10);
        function scrollMove(){
                setScrollTop(getScrollTop()/1.1);
                if(getScrollTop()<1)clearInterval(goTop);
            }
    };
}
	