$("td.toggle-show").delegate("span","click",function() {
			var $this = $(this);
			var id = parseInt($(this).parent().parent().siblings("td.num").find('input[type="hidden"]').val());
			if (id > 0) {
				if ($(this).attr("data-show") === "true") {
					var $isshow = 1;
				} else {
					var $isshow = 0;
				}
				if($this.hasClass('isshow')){
					var $data = {
							isshow : $isshow,
							cid : id,
							datatype : "isshow"
						};
				}else if($this.hasClass('shownav')){
					var $data = {
							isshow : $isshow,
							cid : id,
							datatype : "showinnav"
						};
				}
				$.post($cateShowUrl, $data, function(back) {
					if (back.status == 1) {
						if ($this.attr("data-show") === "true") {
							$this.attr("data-show", "false");
							$this.css("background-image", "url("
									+ $this.attr("_data-true-icon") + ")");
						} else {
							$this.attr("data-show", "true");
							$this.css("background-image", "url("
									+ $this.attr("_data-false-icon") + ")");
						}
					} else {
						easyDialog.open({
							container : {
								content : back.data
							},
							autoClose : 2000
						});
					}
				}, "json");
			} else {
				easyDialog.open({
					container : {
						content : "当前操作缺失参数，请刷新重试！"
					},
					autoClose : 2000
				});
			}
		});
$(".tab-btn.recycle").click(
		function() {
			var $this = $(this);
			var id = parseInt($this.siblings('input[name="cid"]').val());
			if (id > 0) {
				var btnFn = function() {
					var $data = {
						cid : id
					};
					$.post($cateDeleteUrl, $data,
							function(back) {
								if (back.status == 1) {
									if ($("table.tablelist").find(
											"tr").length <= 0) {
										window.location.href = back.data;
									} else {
										window.location.reload();
									}
								} else {
									easyDialog.open({
										container : {
											header:'消息提醒窗口',
											content : back.data
										},
										autoClose : 5000
									});
								}
							}, "json");
					return false;
				};
				easyDialog.open({
					container : {
						header : "消息提醒窗口",
						content : "您将删除本条新闻，删除后将无法再找回。<br />确定删除吗？",
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