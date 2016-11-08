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
			var totalNum = $('textarea[name="description"]').siblings("div")
					.find("span").text();
			wordCount($('textarea[name="description"]'));
			$('textarea[name="description"]').keyup(function() {
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
			var title = $('input[name="title"]'), keywords = $('input[name="keywords"]'),cover = $('input[name="cover"]'), description = $('textarea[name="description"]'), isshow = $('input[name="isshow"]'), sortorder = $('input[name="sortorder"]'), author = $('input[name="author"]'), click = $('input[name="click"]');
			isshow.val(1);
			title.blur(function() {
				title_func($(this));
			});
			description.blur(function() {
				desc_func($(this));
			});
			sortorder.blur(function() {
				var $val = $(this).val();
				if (is_empty($val)) {
					$(this).val(50);
				} else {
					if (!is_all_numbers($val)) {
						$(this).val(50);
					}
				}
			});
			click.blur(function() {
				var $val = $(this).val();
				if (is_empty($val)) {
					$(this).val(0);
				} else {
					if (!is_all_numbers($val)) {
						$(this).val(0);
					}
				}
			});
			author.blur(function() {
				author_func($(this));
			});
			$('input[name="submit"]')
					.click(
							function() {
								var $this = $(this);
								if ($this.hasClass("submit-disable")) {
									return false;
								}
								setTips($(this), "", true);
								var bool_title = title_func(title), bool_content = content_func(editor
										.html()),  bool_cover = cover_func(cover), bool_desc = desc_func(description);
								bool_author = author_func(author);
								if (bool_title && bool_desc && bool_content && bool_cover && bool_author) {
									var data = {
										title : title.val(),
										keywords : keywords.val(),
										cover : cover.val(),
										description : description.val(),
										isshow : parseInt(isshow.val()),
										sortorder : parseInt(sortorder.val()),
										click : parseInt(click.val()),
										author : author.val(),
										content : editor.html()
									};
									$(this)
											.siblings("i")
											.html(
													'<span class="doing">正在提交，请稍后……</span>');
									$(this).removeClass("submitable").addClass(
											"submit-disable");
									$
											.post(
													$newsAddurl,
													data,
													function(back) {
														if (back.status == 1) {
															easyDialog
																	.open({
																		container : {
																			header : "消息提醒窗口",
																			content : "成功增加一条公司新闻，你可以：<br />前往查看，或者继续增加！",
																			yesFn : function() {
																				window.location.href=window.location.href;
																			},
																			noFn : function() {
																				window.location.href = back.redirecturl;
																			}
																		}
																	});
															$("#easyDialogYesBtn").text("继续添加");
															$("#easyDialogNoBtn").text("查看列表");
														} else {
															easyDialog
																	.open({
																		container : {
																			content : back.data
																		},
																		autoClose : 2000,
																		callback : function() {
																			$this
																					.siblings(
																							"i")
																					.html(
																							"");
																			$this
																					.removeClass(
																							"submit-disable")
																					.addClass(
																							"submitable");
																		}
																	});
														}
													}, "json");
								} else {
									setTips($(this), "表单数据还有错误，请检查！");
									return false;
								}
							});
			function title_func(o) {
				var val = o.val();
				if (is_empty(val)) {
					setTips(o, "标题为必填项，不能为空！");
					return false;
				} else {
					if (has_length_error(val, 5, 55)) {
						setTips(o, "标题长度5-55个字符，请检查！");
						return false;
					} else {
						setTips(o, "", true);
						return true;
					}
				}
			}
			function cover_func(o) {
				var val = o.val();
				var reg = /^#.*/;
				if (reg.test(val)) {
					setTips(o, "请上传选中的图片");
					return false;
				} else {
					setTips(o, "", true);
					return true;
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
			function author_func(o) {
				var val = trimValue(o.val());
				if (is_empty(val)) {
					setTips(o, "", true);
					return true;
				} else {
					var num_reg = /\d/g;
					if (has_specialchars(val)) {
						setTips(o, "发布者不能有”*!@#$“等特殊字符");
						return false;
					} else {
						if (has_length_error(val, 0, 12)) {
							setTips(o, "不能超过12个字符");
							return false;
						} else {
							setTips(o, "", true);
							return true;
						}
					}
				}
			}
			
			function content_func(val) {
				if (is_empty(val)) {
					prompTip("请编写新闻内容后再提交！", 2000);
					return false;
				} else {
					if (has_minlength_error(val, 30)) {
						prompTip("新闻内容必须在30个字以上（含图片），请再写点吧！", 2500);
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
function file_change(e) {
	document.getElementById("coverImg").value = "#当前选择了:" + e;
	$(".select-cover").val("选择封面");
	$(".uploadBtn").removeClass("disabled");
}
function ajaxFileUpload() {
	var reg = /^#.*/;
	if ($("#coverImg").val().replace(/\s/g, "").length <= 0
			|| !reg.test($("#coverImg").val().replace(/\s/g, ""))) {
		$(".cover i").html('<span style="color: #CB0303;">您还没选择上传文件</span>');
		return false;
	}
	if ($(".uploadBtn").hasClass("disabled")) {
		return false;
	}
	$(".select-cover").val("重选封面");
	$(".uploadBtn").addClass("disabled");
	$.ajaxFileUpload({
		url : $coverUploadUrl,
		secureuri : false,
		fileElementId : "coverImgFile",
		dataType : "json",
		success : function(data, status) {
			if (data.status == 0) {
				$(".cover i").html(
						'<span style="color: #CB0303;">' + data.data
								+ "</span>");
				$(".cover i").fadeIn(200, function() {
					setTimeout(function() {
						$(".cover i").fadeOut(200, function() {
							$(this).html("");
						});
					}, 2000);
				});
				return false;
			} else {
				if (data.status == 1) {
					$("#coverImg").val(data.data);
					$("#coverImgFile").val("");
					$(".show_cover .img img").attr("src", data.data);
				}
			}
		},
		error : function(data, status, e) {
			showMsg(e, "");
		}
	});
	return false;
}
