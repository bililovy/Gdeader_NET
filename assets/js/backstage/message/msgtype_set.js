var ajaxRequest=null;
function addmsgtype() {
	var title = "新增留言类型";
	$(".mask").fadeIn(150,function() {
			$("div#dialogbox").find("p.title").find("span.txt").text(title);
			$("div#dialogbox").find("p.btn").find("a.submit").addClass("add").removeClass("update");
			$("div#dialogbox").center();
			$("div#dialogbox").show();
			$("div#dialogbox").animate({opacity : 1}, 150);
	});
}

jQuery.fn.center = function() {
	this.css("position", "fixed");
	this.css("top", ($(window).height() - this.height()) / 2 + "px");
	this.css("left", ($(window).width() - this.width()) / 2 + "px");
	return this;
};
function closeDialog() {
	$("div#dialogbox").stop().animate({opacity : 0},150,function() {
		$(this).css("display", "none");
		$("div.mask").fadeOut(150);
		$("#dialogbox").find("input#depname").val("");
		$("#dialogbox").find("input#sortorder").val(50);
		$("#dialogbox").find("p.notice").text("");
		$("div#dialogbox").find("p.btn").find('input[name="depID"]').val(0);
		$("div#dialogbox").find("p.btn").find("a.submit").text("提交");
		$("div#dialogbox").find("p.btn").find("a.submit").removeClass("posting");
		if (ajaxRequest != null) {
			ajaxRequest.abort();
		}
	});
}

$("div#dialogbox p.title span.close, div#dialogbox a.cancel ").click(function() {
	closeDialog();
});

//添加数据
$("div#dialogbox p.btn").delegate("a.submit","click",function() {
	var $this = $(this);
	if ($this.hasClass("posting")) {
		return false;
	}
	var name = $("input#depname").val().replace(/\s/g, "");
	var sortorder = parseInt($("input#sortorder").val());
	var bool_name = func_name($("input#depname"), $("p#name_tips"));
	if (bool_name) {
		if ($this.hasClass("add")) {
			if (isNaN(sortorder) || sortorder < 0) {
				sortorder = 10;
			}
			var $data = {
				typename : name,
				sortorder : sortorder,
				handway : "add"
			};
		} else {
			if ($this.hasClass("update")) {
				var depid = parseInt($this.siblings('input[name="depID"]').val());
				var $data = {
					typename : name,
					sortorder : sortorder,
					id : depid,
					handway : "update"
				};
			} else {
				easyDialog.open({
					container : {
						content : "系统未检测到此操作，请刷新重试！"
					},
					autoClose : 2000
				});
				return false;
			}
		}
		$this.addClass("posting").text("正在提交…");
		ajaxRequest = $.post($postUrl, $data, function(back) {
			if (back.status == 1) {
				closeDialog();
				setTimeout(function() {
					window.location.reload();
				}, 1000);
			} else {
				easyDialog.open({
					container : {
						content : back.data
					},
					autoClose : 2500
				});
			}
			$this.removeClass("posting").text("提交");
		}, "json");
	}
});

//更新
$("table.tablelist td").find("a.edit_dep").click(function() {
	
	var id = parseInt($(this).parent().siblings("td.num").find('input[name="msgtypeid"]').val());
	if (id > 0) {
		var dname = $(this).attr("spm-name");
		var title = '编辑【<b style="color: #DC473D;">' + dname+ "</b>】类型信息";
		var sortorder = $(this).parent().siblings("td.dpsort").text();
		$(".mask").fadeIn(150,function() {
					$("div#dialogbox").find("p.title").find("span.txt").html(title);
					$("div#dialogbox").find("p.btn").find("a.submit").addClass("update").removeClass("add");
					$("div#dialogbox").find("p.btn").find('input[name="depID"]').val(id);
					$("input#depname").val(dname);
					$("input#sortorder").val(sortorder);
					$("div#dialogbox").center();
					countWord($('#depname'), 25, $("span#name_word"), $("p#name_tips"),"字数超出限制（最多25个字）");
					$("div#dialogbox").show();
					$("div#dialogbox").animate({opacity : 1}, 150);
					
				});
	} else {
		easyDialog.open({
			container : {
				content : "更新操作缺少必需参数，请刷新页面重新尝试！"
			},
			autoClose : 2000
		});
		return false;
	}
});
//删除回收
$(".tab-btn.recycle").click(function() {
	var $this = $(this);
	var id = parseInt($(this).parent().siblings("td.num").find('input[name="msgtypeid"]').val());
	var dname = $(this).attr("spm-name");
	if (id > 0) {
		var btnFn = function() {
			var $data = {
				id : id,
				handway: 'delete'
			};
			ajaxRequest = $.post($postUrl, $data, function(
					back) {
				if (back.status == 1) {
					easyDialog.close();
					if ($("table.tablelist").find("tr.tbcontent").length <= 0) {
						window.location.href = back.data;
					} else {
						window.location.reload();
					}
				} else {
					easyDialog.open({
						container : {
							header : "消息提示窗口",
							content : back.data
						},
						autoClose : 8000
					});
				}
			}, "json");
			return false;
		};
		easyDialog.open({
					container : {
						header : "消息提醒窗口：",
						content : '你将删除类型：<b style="color: #F00">'+ dname+ "</b>，如果该类型下还有留言，将无法删除，一旦删除成功，此类型将无法再找回。<br />确定删除吗？",
						yesFn : btnFn,
						noFn : true
					},
					follow : $this[0],
					followX : -275,
				followY : 25
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

$("div#dialogbox").delegate("#depname","keyup",function() {
	countWord($(this), 25, $("span#name_word"), $("p#name_tips"),"字数超出限制（最多25个字）");
});

/******************* BEGIN 函数集成 **************/
function func_name(o, tipsObj) {
	var value = trimValue(o.val());
	if (value == "") {
		tipsObj.html('<i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i>请填入类型名称！');
		tipsObj.fadeIn(200);
		return false;
	}
	if (has_length_error(value, 3, 20)) {
		tipsObj.html('<i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i>类型名称为3-20个字符');
		tipsObj.fadeIn(200);
		return false;
	}
	return true;
}
function countWord(o, maxlen, wordCountObj, errTipObj, errTips) {
	var val = o.val();
	wordCountObj.text(val.length);
	if (val.length > maxlen) {
		errTipObj.fadeIn(200, function() {
			$(this).html('<i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i>'+ errTips);
		});
		return false;
	} else {
		errTipObj.fadeOut(100, function() {
			$(this).html("");
		});
		return true;
	}
}
/******************* END 函数集成 **************/