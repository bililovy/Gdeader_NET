$("table.tablelist a.tab-btn")
		.click(
				function() {
					var $this = $(this);
					var adminid = parseInt($this.siblings(
							'input[name="adminid"]').val());
					var sessionuserid = parseInt($("div.rightinfo").find(
							'input[name="sessionuserid"]').val());
					if (adminid <= 0 || isNaN(adminid) || sessionuserid <= 0
							|| isNaN(sessionuserid)) {
						easyDialog.open({
							container : {
								content : "动作执行参数缺失，请刷新页面重试！"
							},
							autoClose : 2000
						});
						return false;
					}
					if ($(this).hasClass("edit")) {
						$data = {
							adminid : adminid,
							handway : "getinfo"
						};
						doAjax($data);
					} else {
						if ($(this).hasClass("chpwd")) {
							$data = {
								adminid : adminid,
								handway : "getpwd"
							};
							doAjax($data);
						} else {
							if ($(this).hasClass("delete")) {
								var $thisuser = $this.parent().siblings(
										"td.tname").text();
								var btnFn = function() {
									$data = {
										adminid : adminid,
										handway : "delete"
									};
									$
											.post(
													$adminUpdateUrl,
													$data,
													function(back) {
														if (back.status == 1) {
															if (back.islogout == 1) {
																top.location.href = location.href;
																return false;
															}
															window.location
																	.reload();
														} else {
															easyDialog
																	.open({
																		container : {
																			header : "网站系统-提醒窗口",
																			content : back.data
																		},
																		overlay : true
																	});
														}
													}, "json");
									return false;
								};
								if (adminid === sessionuserid) {
									$msg = '你当前使用此管理员账户<b style="color: #F00">'
											+ $thisuser
											+ "</b>登录了系统，如果删除账户，将立即退出此系统，删除后，该账户不可恢复。<br />确定删除吗？";
								} else {
									$msg = '你将要删除此管理员：<b style="color: #F00">'
											+ $thisuser
											+ "</b>，删除后不可恢复！<br />确定彻底删除吗？";
								}
								easyDialog.open({
									container : {
										header : "网站系统-提醒窗口",
										content : $msg,
										yesFn : btnFn,
										noFn : true
									},
									follow : $this[0],
									followX : -267,
									followY : 24
								});
							} else {
								easyDialog.open({
									container : {
										content : "执行动作无效，请刷新本页重新尝试！"
									},
									autoClose : 2000
								});
							}
						}
					}
				});
function openDialog() {
	easyDialog.open({
		container : "dialogbox",
		fixed : true,
		drag : true
	});
}
function doAjax($data) {
	$.post($adminUpdateUrl, $data, function(back) {
		if (back.status == 1) {
			$("#dialogbox").html(back.data);
			openDialog();
		} else {
			easyDialog.open({
				container : {
					header : "网站系统-提醒窗口",
					content : back.data
				},
				overlay : true
			});
		}
	}, "json");
}