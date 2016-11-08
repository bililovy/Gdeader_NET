KindEditor
    .ready(function (K) {
        var editor = K.create('textarea[name="desc"]', {
            cssPath: cssurl,
            width: "515px",
            height: "200px",
            resizeType: 0,
            skinType: "tinymce",
            items: ["source", "|", "undo", "redo", "|",
                "preview", "cut", "copy",
                "paste", "plainpaste", "wordpaste", "|", "justifyleft",
                "justifycenter", "justifyright", "justifyfull",
                "insertorderedlist", "insertunorderedlist", "indent",
                "outdent", "subscript", "superscript", "clearhtml",
                "quickformat", "selectall", "|", "formatblock",
                "fontname", "fontsize", "|", "forecolor",
                "hilitecolor", "bold", "italic", "underline",
                "strikethrough", "lineheight", "removeformat", "|",
                "table", "hr", "emoticons"]
        });


        $(".checkshow").find("a").click(
            function () {
                $(this).find("i.fa").removeClass("fa-square-o").addClass(
                    "fa-check-square");
                $(this).siblings("a").find("i.fa").removeClass("fa-check-square")
                    .addClass("fa-square-o");
                if ($(this).hasClass("show")) {
                    $isshow = 1;
                } else {
                    if ($(this).hasClass("not_show")) {
                        $isshow = 0;
                    } else {
                        $isshow = 1;
                    }
                }
                $(this).parent().siblings('input[name="isshow"]').val($isshow);
            });
        var title = $('input[name="title"]'), focusname = $('input[name="focusname"]'), linkurl = $('input[name="linkurl"]'), image = $('input[name="image"]'), isshow = $('input[name="isshow"]'), sortorder = $('input[name="sortorder"]'), desc = $('textarea[name="desc"]'), btntext = $('input[name="btntext"]'), showtype = $('select[name="showtype"]');
        isshow.val(1);
        title.blur(function () {
            title_func($(this));
        });
        focusname.blur(function () {
            focusname_func($(this));
        });
        linkurl.blur(function () {
            linkurl_func($(this));
        });
        sortorder.blur(function () {
            int_func($(this), 10);
        });
        $('input[name="submit"]')
            .click(
                function () {
                    var $this = $(this);
                    if ($this.hasClass("submit-disable")) {
                        return false;
                    }
                    setTips($(this), "", true);
                    var bool_title = title_func(title), bool_focusname = focusname_func(focusname), bool_linkurl = linkurl_func(linkurl), bool_image = image_func(image);
                    if (isshow.val() > 0) {
                        isshowValue = parseInt(isshow.val());
                    } else {
                        isshowValue = 0;
                    }
                    int_func(sortorder, 10);
                    if (bool_title && bool_focusname && bool_image
                        && bool_linkurl) {
                        var data = {
                            title: title.val(),
                            focusname: focusname.val(),
                            linkurl: linkurl.val(),
                            cover: image.val(),
                            sortorder: parseInt(sortorder.val()),
                            isshow: parseInt(isshow.val()),
                            btntext: btntext.val(),
                            showtype: showtype.val(),
                            desc: desc.val(),
                        };
                        $(this).siblings("i").html(
                            '<span class="doing">正在提交，请稍后……</span>');
                        $(this).removeClass("submitable").addClass(
                            "submit-disable");
                        $
                            .post(
                                postDataUrl,
                                data,
                                function (back) {
                                    if (back.status == 1) {
                                        easyDialog
                                            .open({
                                                container: {
                                                    header: "消息提醒窗口",
                                                    content: "成功增加一个焦点图，你可以：<br />前往查看，或者继续添加焦点图！",
                                                    yesFn: function () {
                                                        window.location.href = window.location.href;
                                                    },
                                                    noFn: function () {
                                                        window.location.href = back.redirecturl;
                                                    }
                                                }
                                            });
                                        $("#easyDialogYesBtn").text(
                                            "继续添加");
                                        $("#easyDialogNoBtn").text(
                                            "查看焦点图列表");
                                    } else {
                                        easyDialog.open({
                                            container: {
                                                content: back.data
                                            },
                                            autoClose: 2000
                                        });
                                    }
                                }, "json");
                    } else {
                        setTips($(this), "表单数据还有错误，请检查！");
                        return false;
                    }
                });
    });
function title_func(o) {
    var val = o.val();
    if (is_empty(val)) {
        setTips(o, "案例名称不能为空！");
        return false;
    } else {
        if (has_length_error(val, 4, 40)) {
            setTips(o, "名称长度为4-40个字符，请检查！");
            return false;
        } else {
            setTips(o, "", true);
            return true;
        }
    }
}
function focusname_func(o) {
    var val = o.val();
    if (is_empty(val)) {
        setTips(o, "焦点图名称不能为空！");
        return false;
    } else {
        if (has_length_error(val, 2, 12)) {
            setTips(o, "名称长度为2-12个字符，请检查！");
            return false;
        } else {
            setTips(o, "", true);
            return true;
        }
    }
}
function linkurl_func(o) {
    var val = o.val();
    if (is_empty(val)) {
        setTips(o, "焦点图链接地址留空，将显示为空链接", true);
        return true;
    } else {
        if (!is_url(val)) {
            setTips(o, "请输入正确的URL地址，必须带“http://或https://”");
            return false;
        }
        if (has_length_error(val, 0, 150)) {
            setTips(o, "链接地址长度最多为150个字符，请检查！");
            return false;
        } else {
            setTips(o, "", true);
            return true;
        }
    }
}
function image_func(o) {
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
function int_func(o, defaultvalue) {
    var val = o.val();
    if (is_empty(val)) {
        o.val(defaultvalue);
        setTips(o, "将使用默认值" + defaultvalue, true);
    } else {
        if (!is_all_numbers(val)) {
            o.val(defaultvalue);
            setTips(o, "请输入正整数");
        } else {
            setTips(o, "", true);
        }
    }
    return true;
}
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
        o.siblings("i").html('<i style="color: #DD2D28;font-size:15px;padding-right: 5px;" class="fa fa-exclamation-circle"></i><span style="color: #D31B26;">' + tips + "</span>");
    }
}
function file_change(e) {
    document.getElementById("coverImg").value = "#当前选择了:" + e;
    $(".select-cover").val("选择焦点图");
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
    $(".select-cover").val("重新选择");
    $(".uploadBtn").addClass("disabled");
    $.ajaxFileUpload({
        url: coverUploadUrl,
        secureuri: false,
        fileElementId: "coverImgFile",
        dataType: "json",
        success: function (data, status) {
            if (data.status == 0) {
                $(".cover i").html(
                    '<span style="color: #CB0303;">' + data.data
                    + "</span>");
                $(".cover i").fadeIn(200, function () {
                    setTimeout(function () {
                        $(".cover i").fadeOut(200, function () {
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
        error: function (data, status, e) {
            showMsg(e, "");
        }
    });
    return false;
}