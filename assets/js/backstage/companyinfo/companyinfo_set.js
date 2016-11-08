var pageID=parseInt($('input[name="pageid"]').val()) ? parseInt($('input[name="pageid"]').val()) : 0 ;
KindEditor
		.ready(function(K) {
			var editor = K.create('textarea[name="content"]', {
				cssPath : cssurl,
				uploadJson : uploadurla,
				allowFileManager : true,
				extraFileUploadParams : {
					PHPSESSID : $sessionid
				},
				width : "100%",
				height : "700px",
				resizeType : 0,
				skinType : "tinymce",
				items : [ "fullscreen", "source", "|", "undo", "redo", "|",
						"preview", "print", "template", "code", "cut", "copy",
						"paste", "plainpaste", "wordpaste", "|", "justifyleft",
						"justifycenter", "justifyright", "justifyfull",
						"insertorderedlist", "insertunorderedlist", "indent",
						"outdent", "subscript", "superscript", "clearhtml",
						"quickformat", "selectall", "|", "formatblock",
						"fontname", "fontsize", "|", "forecolor",
						"hilitecolor", "bold", "italic", "underline",
						"strikethrough", "lineheight", "removeformat", "|",
						"image", "multiimage", "flash", "media", "insertfile",
						"table", "hr", "emoticons", "baidumap", "pagebreak",
						"anchor", "link", "unlink", "|", "about" ]
			});
			var title = $('input[name="title"]'), keywords = $('input[name="keywords"]'), description = $('textarea[name="description"]'), isshow = $('input[name="isshow"]');
			var totalNum = description.siblings("div").find("span").text();
			description.keyup(function() {
				wordCount($(this));
			});
			wordCount(description);
			function wordCount(o) {
				var nowLen = o.val().length;
				var thislen = totalNum - nowLen;
				if (thislen < 0) {
					thislen = " 已超出" + thislen;
				}
				o.siblings("div").find("span").text(thislen);
			}
			$(".checkshow").find("a").click(
					function() {
						$(this).find("i.fa").removeClass("fa-square-o")
								.addClass("fa-check-square");
						$(this).siblings("a").find("i.fa").removeClass(
								"fa-check-square").addClass("fa-square-o");
						if ($(this).hasClass("show")) {
							$isshow = 1;
						} else {
							if ($(this).hasClass("not_show")) {
								$isshow = 0;
							} else {
								$isshow = 1;
							}
						}
						$(this).parent().siblings('input[name="isshow"]').val(
								$isshow);
					});
			title.blur(function() {
				title_func($(this));
			});
			description.blur(function() {
				desc_func($(this));
			});
			
			$('input[name="submit"]')
					.click(function() {
								var $this = $(this);									
									if ($this.hasClass("submit-disable")) return false;
									setTips($(this), "", true);
									var bool_title = title_func(title), 
											bool_content = content_func(editor.html()), 
											bool_desc = desc_func(description);
									if (bool_title && bool_desc && bool_content) {
										var data = {
											title : title.val(),
											keywords : keywords.val(),
											description : description.val(),
											isshow : parseInt(isshow.val()),
											content : editor.html(),
											id: pageID
										};
										$(this).siblings("i").html('<span class="doing">正在提交，请稍后……</span>');
										$(this).removeClass("submitable").addClass("submit-disable");
										$.post(postUrl,data,function(back) {
															if (back.status == 1) {
																easyDialog.open({
																	container : {
																		header : "消息提醒窗口",
																		content : "成功更新此单页面！",
																	},
																	autoClose : 2000,
																	callback:function (){
																		window.location.href=window.location.href;
																	}
																});
															} else {
																easyDialog.open({
																			container : {
																				header : "消息提醒窗口",
																				content : back.data
																			},
																			autoClose : 5000
																		});
															}
															$this.siblings("i").html("");
															$this.removeClass("submit-disable").addClass("submitable");
														}, "json");
									} else {
										setTips($(this), "表单数据还有错误，请检查！");
										return false;
									}			
							});
			

			function title_func(o) {
				var val = o.val();
				if (is_empty(val)) {
					setTips(o, "页面标题为必填项，不能为空！");
					return false;
				} else {
					if (has_length_error(val, 5, 40)) {
						setTips(o, "标题长度5-30个字，请检查！");
						return false;
					} else {
						setTips(o, "", true);
						return true;
					}
				}
			}
			
			function desc_func(o) {
				var val = trimValue(o.val());
				if (!is_empty(val)) {
					if (has_length_error(val, 0, 200)) {
						setTips(o, "字数超限，请删减到200字以内");
						return false;
					} else {
						setTips(o, "", true);
						return true;
					}
				} else {
					return true;
				}
			}
			function content_func(val) {
				if (is_empty(val)) {
					prompTip("请设置内容后再提交！", 2000);
					return false;
				} else {
					if (has_minlength_error(val, 30)) {
						prompTip("内容必须在30个字以上（含图片），请再写点吧！", 2500);
						return false;
					} else {
						return true;
					}
				}
			}
			function prompTip(tips, autoClose) {
				autoClose = autoClose == null ? false : true;
				var html = '<span id="temp-tip" style="padding: 6px 10px;color: #FFF; border-radius: 5px; font-size:13px; background: #3672A6;position: absolute; left: 400px;bottom: 0px;z-index: 2000;">'
						+ tips + "</span>";
				if ($("#temp-tip").length > 0) {
					$("#temp-tip").remove();
				}
				$("li.editor").append(html);
				if (autoClose) {
					setTimeout(function() {
						$("#temp-tip").fadeOut(600, function() {
							$(this).remove();
						});
					}, 2100);
				}
			}
			function setTips(o, tips, isDef) {
				isDef = (isDef == null) ? false : true;
				o.siblings("i").html("");
				if (isDef) {
					var defTips = o.siblings("i").attr("placeholder");
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
		});
