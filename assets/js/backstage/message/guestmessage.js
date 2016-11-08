$(function() {
	var $ajaxRequest;
	$("div.tool .selector").find("select").cssSelect();
	$("div.tool .selector").find("select").change(function() {
		var $url = $(this).val();
		var reg = /(Message)?|(guestmsg)?/g;
		if (reg.test($url)) {
			$(this).siblings(".tips").fadeIn(200);
			window.location.href = $url;
		}
	});
	$("div.msg_list dl")
			.find("p.opbtn")
			.find("em")
			.click(
					function() {
						var $this = $(this);
						if ($this.hasClass("doing")) {
							return false;
						}
						var msgid = parseInt($this.parent().parent().siblings(
								"dt").find('input[name="umsgid"]').val());
						if (msgid > 0) {
							if ($this.hasClass("delmsg")) {
								var callback = function() {
									$this.hasClass("doing");
									var data = {
										msgid : msgid,
										handway : "delmsg"
									};
									$ajaxRequest = $
											.post(
													$postUrl,
													data,
													function(back) {
														if (back.status == 1) {
															easyDialog.close();
															$this
																	.parent()
																	.parent()
																	.parent()
																	.slideUp(
																			200,
																			function() {
																				window.location
																						.reload();
																			});
														} else {
															easyDialog
																	.open({
																		container : {
																			header : "消息提醒窗口",
																			content : back.data
																		},
																		autoClose : 5000
																	});
														}
														$this
																.removeClass("doing");
													}, "json");
									return false;
								};
								easyDialog
										.open({
											container : {
												header : "消息提醒窗口",
												content : '你将要删除本条留言，删除后无法再找回<br /><i style="padding-left: 90px;"></i>你确定要删除本条留言吗？',
												yesFn : callback,
												noFn : function() {
													if ($ajaxRequest != null) {
														$ajaxRequest.abort();
													}
												}
											},
											follow : $this[0],
											followX : -227,
											followY : -174
										});
							} else {
								if ($this.hasClass("signdone")) {
									if ($this.hasClass("unable")) {
										return false;
									}
									var data = {
										msgid : msgid,
										handway : "signread"
									};
									$this.addClass("doing");
									$ajaxRequest = $
											.post(
													$postUrl,
													data,
													function(back) {
														if (back.status == 1) {
															$this
																	.removeClass(
																			"able")
																	.addClass(
																			"unable");
															$this.text("本条已阅读");
														} else {
															easyDialog
																	.open({
																		container : {
																			header : "消息提醒窗口",
																			content : back.data
																		},
																		autoClose : 5000
																	});
														}
														$this
																.removeClass("doing");
													}, "json");
								} else {									
										easyDialog
												.open({
													container : {
														header : "消息提醒窗口",
														content : "系统未识别你的此次操作请求，请刷新页面重新点击！"
													},
													autoClose : 3000
												});
								}
							}
						} else {
							easyDialog.open({
								container : {
									header : "消息提醒窗口",
									content : "当前操作缺少必须参数，请刷新页面后重新尝试！"
								},
								autoClose : 3000
							});
						}
					});
});