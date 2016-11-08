var webname = $('input[name="webname"]'),logo=$('input[name="logo"]'); keywords = $('input[name="keywords"]'), description = $('textarea[name="description"]'), tels = $('input[name="tels"]'), faxes = $('input[name="faxes"]'), email = $('input[name="email"]'), icp = $('input[name="icp"]'), address = $('input[name="address"]'), copyright = $('input[name="copyright"]');
var totalNum = description.siblings("div").find("span").text();
wordCount(description);
description.keyup(function() {
	wordCount($(this));
});
function wordCount(o) {
	var nowLen = o.val().length;
	var thislen = totalNum - nowLen;
	if (thislen < 0) {
		thislen = " 已超出" + thislen;
	}
	o.siblings("div").find("span").text(thislen);
}

$('input[name="submit"]')
		.click(
				function() {
					var $this = $(this);				
					var $data = {
						webname : webname.val(),
						keywords : keywords.val(),
						description : description.val(),
						tels : tels.val(),
						faxes : faxes.val(),
						email : email.val(),
						icp : icp.val(),
						logo:logo.val(),
						address : address.val(),
						copyright : copyright.val()
					};
					var submit = function() {
						$this.val("正在提交数据…");
						$.post(
										$configSubmitUrl,
										$data,
										function(back) {
											if (back.status == 1) {
												easyDialog
														.open({
															container : {
																header : "消息提醒窗口",
																content : '<div style="text-align: center;">网站配置更新成功！<br />2秒后关闭窗口……</div>'
															},
															autoClose : 2000
														});
											} else {
												easyDialog.open({
													container : {
														header : "消息提醒窗口",
														content : back.data
													},
													drag : false
												});
											}
										}, "json");
						$this.val("确认设置");
						easyDialog.close();
						return false;
					};
					easyDialog.open({
						container : {
							header : "消息提醒窗口",
							content : "确定要更改系统配置吗？",
							yesFn : submit,
							noFn : true
						}
					});
				});

function setTips(o, tips, isDef) {
	isDef = (isDef == null) ? false : true;
	o.siblings("i").html("");
	if (isDef) {
		if ("" !== tips) {
			var defTips = tips;
		} else {
			var defTips = o.siblings("i").attr("placeholder");
		}
		if (typeof defTips == "undefined") {
			defTips = "通过校验";
		}
		o.siblings("i").text(defTips);
	} else {
		o
				.siblings("i")
				.html(
						'<i style="color: #DD2D28;font-size:15px;padding-right: 5px;" class="fa fa-exclamation-circle"></i><span style="color: #D31B26;">'
								+ tips + "</span>");
	}
}
function ajaxFileUpload(o) {
	$.ajaxFileUpload({
		url : $imgUploadUrl,
		secureuri : false,
		fileElementId : "logoFile",
		dataType : "json",
		success : function(data, status) {
			if (data.status == 1) {
				$('.forminfo .showarea').find('img').attr('src', data.data);
				$('.forminfo .showarea').fadeIn(200);
				$('.forminfo .uploadBox').find('input[name="logo"]').val(data.data);
			} else {
				o.parent().siblins('i').html('<span style="color: #DD2D28;">'+data.data+'</span>');	
			}
		},
		error : function(data, status, e) {
			showMsg(e, "");
		}
	});
	return false;
}
