/**
 * 系统公用处理JS
 */
// 获取当前路径
//var ctxPath = "";//window.location.host;//"/" + location.pathname.split("/")[1];
var debug = false;  //打开调试
var rightsConfig = []; //eg: [{menuid:'10010001',rights:15},{menuid:'10010002',rights:15}]

(function($) {
	var _pageConfig = {};
		
	$.brand = {
		debug: function(msg){
        	if(debug) {
        		$("#debug").append(msg);
            	$("#debug").append("<br>");
        	}
    	},
    	actionAdd : function() {
			var _action = 1;
			return _action;
		},
		actionUpdate : function() {
			var _action = 2;
			return _action;
		},
		actionDelete : function() {
			var _action = 4;
			return _action;
		},
    	selectMenu : function(id, index){
    		$('#'+id).accordion('select',index); 
    	},
		getPageSize : function() {
			var _pageSize = 15;
			return _pageSize;
		},
		getPageList : function() {
			var _pageList = [10, 15, 20, 50, 100];
			return _pageList;
		},
		// 获取当前用户的权限配置
		getRightsConfig : function() {
			return $("#functions").val();
		},
		//----------------------------------------
		toJson : function(id) {
			var _obj = $("#" + id);
			return _obj.serializeArray();
		},
		//页面初始化
		pageInit : function(pageConfig){
			_pageConfig = pageConfig;
			if(_pageConfig.toolbar != null) $.brand.toolbarInit(_pageConfig.toolbar);
			if(_pageConfig.forms != null) $.brand.formInit(_pageConfig.forms);
		},
		//filter初始化
		filterInit:function(filter){
			
		},
		//toolbar初始化
		toolbarInit:function(toolbarConfig){
			var _formToolbar = $('#formToolbar');
			_formToolbar.empty();
			var _toolbars = toolbarConfig;
			var $l = _toolbars.length;
			for(var i=0;i<$l;i++){
				$.brand.debug("###: " + _toolbars[i].id);
				//var rights = _toolbars[i].rights;
				var display = _toolbars[i].display;
				var afn = _toolbars[i].handler;
				var aPrefix = '<a href="' + _toolbars[i].href + '"' +
								' id="' + _toolbars[i].id + '"' + 
								' title="' + _toolbars[i].title + '"' + 
								' style="float:left;">';
				var linkTxt = '<span class="toolbar-btn-span-text ' + _toolbars[i].iconCls + '" style="padding-left:20px;">'+ _toolbars[i].text +'</span>';
				var aPostfix = '</a><span class="toolbar-btn-separator"></span>';
				if(display){
					_formToolbar.append(aPrefix + linkTxt + aPostfix);
					if($.isFunction(afn)){
						$('#'+_toolbars[i].id).bind('click',afn);
					}
				}
			}
		},
		//form初始化
		formInit : function(formsConfig, jsonData){
			var _forms = formsConfig;
			if(jsonData){
				for(var i=0;i<_forms.length;i++){
					$.brand.debug("###: " + _forms[i].id);
					$('#' + _forms[i].id).val(jsonData[_forms[i].key]);
				}
			}
		},
		setFormsData : function(formConfig, jsonData){
			var _forms = formConfig;
			if(jsonData){
				for(var i=0;i<_forms.length;i++){
					$.brand.debug("###: " + _forms[i].id);
					for(var j=0; j<_forms[i].fields.length;j++){										
						var _ftype = _forms[i].fields[j].ftype;
						if(_ftype=='radio'){
							var _name = _forms[i].fields[j].id;
							var _value = jsonData[_forms[i].fields[j].key];
							$("input[name='" + _name + "'][value='"+_value+"']").attr("checked",true);
						}else{
							var _fval = jsonData[_forms[i].fields[j].key];
							var _type = $.trim(_forms[i].fields[j].type).toUpperCase();
							switch(_type){
								case 'BOOLEAN':
									_fval = _fval== true?1:0;
									break;
								case 'NUM':
									_fval = _fval==''?0:_fval;
									break;
								case 'STRING':
									break;
								default:
									break;
							}
							$('#' + _forms[i].fields[j].id).val(_fval);	
						}						
					}
				}
			}			
		},
		setFormData : function(formConfig, jsonData){
			var _form = formConfig;
			if(jsonData){
				$.brand.debug("###: " + _form.id);
				for(var j=0; j<_form.fields.length;j++){										
					var _ftype = _form.fields[j].ftype;
					if(_ftype=='radio'){
						var _name = _form.fields[j].id;
						var _value = jsonData[_form.fields[j].key];
						$("input[name='" + _name + "'][value='"+_value+"']").attr("checked",true);
					}else{
						var _fval = jsonData[_forms[i].fields[j].key];
						var _type = $.trim(_forms[i].fields[j].type).toUpperCase();
						switch(_type){
							case 'BOOLEAN':
								_fval = _fval== true?1:0;
								break;
							case 'NUM':
								_fval = _fval==''?0:_fval;
								break;
							case 'STRING':
								break;
							default:
								break;
						}
						$('#' + _form.fields[j].id).val(_fval);	
					}						
				}
			}			
		},
		setTableData : function(id, value){
			$('#' + id).datagrid('loadData', value);
		},
		//查询
		search : function(config) {
			var _defaultConfig = {
				method:'POST',
				url:'',
				pagination:false,
				compositor:'',
				filter:'',
  				successFn: function (){alert('Testing!');}
            };
            config = $.extend(true, {}, _defaultConfig, config);
			var _url = ctxPath + config.url;
			var _compositor = config.compositor;
			var _filters = config.filter;
			var _successFn = config.successFn;
			
			var _submitFilters = [];
			
			if(config.pagination){
				$('input.pagination-num').val('1');
				_compositor = (_compositor==''?'':_compositor + '&');
				_compositor = _compositor  
						   + 'rows=' + $('select.pagination-page-list').val() 
				           + '&page=' + $('input.pagination-num').val() 
				           + '&sort=' + config.sort
				           + '&order=' + config.order;
			}
			if (_compositor && _compositor != "") {
				_url = _url + '?' + _compositor;
			}
			_url = encodeURI(_url);
			_url = encodeURI(_url);
			var isValidNum = true;
			if(!_filters || $.trim(_filters)!=''){;
				$.each(_filters, function(i, n) {
					var _val = $('#' + n.id).val();
					if($.trim(_val)!=''){
						if($.trim(n.type).toUpperCase()=='NUM'){
							if(!new RegExp(regexUtils.num).test(_val)) { 
								isValidNum = false;
								return false;
							}
						}
						var _filterJson = {};
						_filterJson.key = n.key;
						_filterJson.type = n.type;
						_filterJson.oper = n.oper;
						_filterJson.value = $('#' + n.id).val();
						_submitFilters.push(JSON.stringify(_filterJson));
					}
				});
			}
			if(!isValidNum){
				$.widgets.messager.alert(PromptMsg.message,PromptMsg.msgValidNum,'warning');
				return false;
			}
			var _jsonData = "[" + _submitFilters.join(",") + "]";
			$.ajax({
				type : config.method,
				url : _url,
				dataType : "json",
				data : {
					jsonData : _jsonData
				},
				success: function(data){ 
					if($.isFunction(_successFn)){
						_successFn(data);
					}
				},
   				error:function(){ 
					$.widgets.messager.alert(PromptMsg.message,PromptMsg.msgError,'error');
				},
   				beforeSend : function(XMLHttpRequest) {
					$.widgets.loading.init();
				},
				complete : function(XMLHttpRequest, textStatus) {
					$.widgets.loading.destroy();
				}
			});
		},		
		save : function(config) {
			var _defaultConfig = {
				action:'',
				url:'',
				compositor:'',
				jsonData:'',
				confirmFn: function (){alert('Testing!');}
            };
            config = $.extend(true, {}, _defaultConfig, config);
            var _action = config.action;
            var _url = ctxPath + config.url;
            var _compositor = $.trim(config.compositor);
            var _formJson = {};
            var _confirmFn = config.confirmFn;
            var _flag = '';
            if(_action!='') _flag = 'flag=' + _action;
            switch(_action){
				case 1: //ADD
				case 2: //EDIT
					var _forms = config.jsonData;
					for(var i=0; i<_forms.length; i++){
						var _submit = _forms[i].submit!=null?_forms[i].submit:false;
						if(_submit){//表示数据要提交到后台进行处理
							var isValidate = false;
							var _formid = _forms[i].id;
							isValidate = $('#' + _formid).form('validate');
							if(isValidate){
								var _fields = _forms[i].fields;								
								for(var j=0; j<_fields.length;j++){
									var _byname = _fields[j].byname;
									var _ftype = _fields[j].ftype;
									var _fval = $('#' + _fields[j].id).val();
									if(_byname){
										_fval= document.getElementsByName(_fields[j].id)[0].value;
									}
									if(_ftype=='radio'){
										var _rdname = _fields[j].id;
										_fval = $("input[name='" + _rdname + "'][checked]").val(); 
									}
									var _fkey = _fields[j].key;
									var _type = $.trim(_fields[j].type).toUpperCase();
									switch(_type){
										case 'NUM':
											_fval = _fval==''?0:_fval;
											break;
										case 'STRING':
											break;
										default:
											break;
									}
									_formJson[_fkey] = _fval;
								}
							}else{
								return;
							}
						}
					}
					_formJson = $.toJSON(_formJson);
					break;
				case 4: //DELETE
					_formJson = $.toJSON(config.jsonData);
					break;
				default:
					break;
			}
			if(_flag!=''){
				if(_compositor!=''){
					_compositor += '&' + _flag;
				}else{
					_compositor += _flag;
				}
			}
			if (_compositor && _compositor != "") {
				_url = _url + '?' + _compositor;
			}
            $.ajax( {
				type : "POST",
				url : _url,
				dataType : "json",
				data : {
					jsonData : _formJson
				},
				success: function(data){ 
					if($.isFunction(_confirmFn)){
						_confirmFn(data);
					}
				},
   				error:function(){ 
					$.widgets.messager.alert(PromptMsg.error,PromptMsg.msgError,'error');
				},
   				beforeSend : function(XMLHttpRequest) {
					$.widgets.loading.init();
				},
				complete : function(XMLHttpRequest, textStatus) {
					$.widgets.loading.destroy();
				}
			});
		},
		
		//提交数据
		ajaxSubmit : function(method, url, jsonSourceData, compositor, successFn) {
			if(!url || url == "") return;
			url = ctxPath + url;
			if (compositor && compositor != "") {
				url = url + "&" + compositor;
			}
			var jsonData = null;
			if (jsonSourceData != null && jsonSourceData != "" && typeof jsonSourceData == "object") {
				jsonData = JSON.stringify(jsonSourceData);
			}
			$.ajax( {
				type : method,
				url : url,
				dataType : "json",
				data : {
					jsonData : jsonData
				},
				success: function(data){ 
					if (typeof successFn == 'function') {
						successFn(data);
					}
				},
   				error:function(){ 
					$.widgets.messager.alert(PromptMsg.message,PromptMsg.msgError,'error');
				},
   				beforeSend : function(XMLHttpRequest) {
					$.widgets.loading.init();
				},
				complete : function(XMLHttpRequest, textStatus) {
					$.widgets.loading.destroy();
				}
			});
		},
		
		//前台提交数据
		frontAjaxSubmit : function(method, url, formData, compositor, successFn, errorFn) {
			if(!url || url == "") return;
			url = ctxPath + url;
			if (compositor && compositor != "") {
				url = url + "&" + compositor;
			}
			$.ajax( {
				type : method,
				url : url,
				dataType : "json",
				data : formData,
				success: function(data){ 
					if (typeof successFn == 'function') {
						successFn(data);
					}
				},
   				error:function(){ 
   					if (typeof errorFn == 'function') {
   						errorFn(data);
					}
				},
   				beforeSend : function(XMLHttpRequest) {
					$.widgets.loading.init();
				},
				complete : function(XMLHttpRequest, textStatus) {
					$.widgets.loading.destroy();
				}
			});
		}
	};
	
	$.toolbar = {
		getButtonConfig : function(id, pageToolbar){
			var _toolbars = pageToolbar;
			var _buttonConfig = {};
			for(var i=0;i<_toolbars.length;i++){
				if(id == _toolbars[i].id){
					_buttonConfig = _toolbars[i];
					return false;
				}
			}
			return _buttonConfig;
		},
		disabled : function(id){
			var _button = $("#" + id);
			_button.addClass("ui-state-disabled");
            _button.unbind("click");
		},
		enabled : function(id, config){
			var _button = $("#" + id);
			var _buttonConfig = $.toolbar.getButtonConfig(id, config);
			_button.removeClass("ui-state-disabled");
			_button.bind('click',_buttonConfig.handler);
		}		
	};
	
	$.widgets = {
		/**
		 * 	window常用属性
			modal：是否生产模态窗口 true--是 false--否；
			shadow：是否显示窗口阴影 true--是 false--否；
			title：该对话框标题文本 ，默认：New Dialog；
			minimizable:当True时可显示最小化按钮。默认false。
			maximizable:当True时可显示最大化按钮。默认false。
			resizable:当True时能重绘对话框大小。默认false。
			toolbar:该工具栏置于对话框的顶部，每个工具栏包含:text, iconCls, disabled, handler等属性。
			buttons:这个按钮置于对话框的底部，每个按钮包含:text, iconCls, handler等属性。
		 */
		window : function(config){
			var _defaultConfig = {
				id:'popupWin',
            	modal:true,
  				cache:false,
  				shadow:true,
  				iconCls:'',
  				minimizable:false,
  				maximizable:false,
				defaultButton:true,
  				confirmFn: function (){alert('Testing!');}
			};
			config = $.extend(true, {}, _defaultConfig, config);
			var _id = '#' + config.id;
			$("body").prepend("<div id='" + config.id + "'></div>");
			var _buttons = null;
            if (config.defaultButton == true) {
				_buttons = [{
                	text: TitleMsg.confirm,
                	iconCls: 'icon-ok',
                	handler: function(){
                		//调用前端方法一定要形如config.fn(), 如果是config.fn则不会执行
                		var success = config.confirmFn();
                		if(success){
                			$(_id).window('close');
                		}
                	}
	            }, {
                	text: TitleMsg.cancel,
                	iconCls: 'icon-cancel',
                	handler: function () {
                    	$(_id).window('close');
                	}
            	}];
			} else {
				_buttons = config.buttons;
			}
			$(_id).window({
				href : ctxPath + config.url,
				title : config.title,
				iconCls: config.iconCls,
				modal : config.modal,
				shadow: config.shadow,
				width : config.width,
				height: config.height,
				minimizable:config.minimizable,
  				maximizable:config.maximizable,
				buttons: _buttons				
			});
			//$(_id).window('open');
		},
		//----------------------------------------
		//dialog
		dialog : function(config) {
			var defaultConfig = {
				id:'popupDlg',
            	modal:true,
  				cache:false,
  				shadow:true,
  				collapsible:false, //是否显示可折叠按钮
  				minimizable:false, //是否显示最小化按钮
  				maximizable:false, //是否显示最大化按钮
  				resizable:false,   //对话框是否可编辑大小
  				closable: true,   
				closed: true,   //已关闭 
  				iconCls:'',
				defaultButton : true,
  				confirmFn: function (){alert('Testing!');}
            };
            config = $.extend(true, {}, defaultConfig, config); 
            
            var _id = '#' + config.id;
			if(typeof($(_id)[0]) != "undefined"){
				$(_id).remove();
			}
			$("body").prepend("<div id='" + config.id + "'></div>");
            var _buttons = {};
            if (config.defaultButton == true) {
				_buttons = [{
                	text: TitleMsg.confirm,
                	iconCls: 'icon-ok',
                	handler: function(){
                		//调用前端方法一定要形如config.fn(), 如果是config.fn则不会执行
                		var success = config.confirmFn();
                		if(success){
                			$(_id).dialog('close');
                		}
                	}
	            }, {
                	text: TitleMsg.cancel,
                	iconCls: 'icon-cancel',
                	handler: function () {
                    	$(_id).dialog('close');
                	}
            	}];
			} else {
				_buttons = config.buttonConfig;
			}
			$(_id).dialog({
				href : ctxPath + config.url,
				title : config.title,
				iconCls: config.iconCls,
				modal : config.modal,
				width : config.width,
				height: config.height,
				collapsible:config.collapsible, //是否显示可折叠按钮
  				minimizable:config.minimizable, //是否显示最小化按钮
  				maximizable:config.maximizable, //是否显示最大化按钮
  				resizable:config.resizable,     //对话框是否可编辑大小
  				closable:config.closable,   
				closed:config.closed,
				buttons: _buttons
			});
			$(_id).dialog('open');
		},
		
		//jquery ui dialog
		uiDialog : function(config) {
			var defaultConfig = {
				id:'popupUiDlg',
				title:null,
				appendTo:'body',
				autoOpen:false,				
				closeOnEscape:true,
				closeText:'close',
				dialogClass:'',
				draggable:true,
				height:'auto',
				width:300,
				maxHeight:false,
				maxWidth:false,
				minHeight:150,
				minWidth:150,
            	modal:true,
            	position:{ my: 'center', at: 'center', of: window },
            	resizable:false,  
            	defaultButton : true,
  				close: function (event, ui){}
            };
            config = $.extend(true, {}, defaultConfig, config); 
            
            var _id = '#' + config.id;
			if(typeof($(_id)[0]) != "undefined"){
				$(_id).remove();
			}
			$("body").prepend("<div id='" + config.id + "'></div>");
			var _buttons = {};
			if (config.defaultButton == true) {
				_buttons = {
					Ok : function() {
						$(this).dialog("close");
					}
				};
			}else{
				_buttons = config.buttonConfig;
			}
			return	$(_id).dialog({				
						title : config.title,
						appendTo : config.appendTo,
						autoOpen : config.autoOpen,
						buttons : _buttons,
						closeOnEscape : config.closeOnEscape,
						closeText : config.closeText,
						dialogClass : config.dialogClass,
						draggable : config.draggable,
						height : config.height,
						width : config.width,
						maxHeight : config.maxHeight,
						maxWidth : config.maxWidth,
						minHeight : config.minHeight,
						minWidth : config.minWidth,
		            	modal : config.modal,
		            	position : config.position,
		            	resizable : config.resizable,     
		  				close : config.close
					});
		},
		
		loading : {
			init : function(){
				$.blockUI( {
					message : '<br><img src="' + ctxPath + '/admin/style/images/loading.gif" /><br>'+ PromptMsg.loading + '<br><br>'
				});
			},
			destroy : function(){
				$.unblockUI();
			}
		},
		messager : {
			alert : function(title, content, type){
				if($.trim(type)==''){
					$.messager.alert(title,content);
				}else{
					//type is ['error','info','question','warning']
					$.messager.alert(title,content,type);
				}
			},
			confirm : function(title, content, fn){
				$.messager.confirm(title, content, function(r){
					fn(r);
				});
			},
			prompt : function(title, content, fn){
				
			},
			show : function(config){
				var defaultConfig = {
					title:PromptMsg.prompt,
					msg:'Dialog will be closed after 2 seconds.',
					timeout:2000,
					showType:'slide' //show, slide, fade
				};
				config = $.extend(true, {}, defaultConfig, config);
				$.messager.show({
					title:config.title,
					msg:config.msg,
					timeout:config.timeout,
					showType:config.showType
				});
			}
		}
	};

	
	
	
	/**
	 * 弹出窗
	 */
	function popupWin(target, options){
		var opts = $.extend({}, {
			onDblClickRow:function(){
				$(target).popupWin('edit');
			}
		}, options);
		$(target).datagrid(opts);
	}
	
	var methods = {
		add: function(jq){
			return jq.each(function(){
				var opts = $(this).datagrid('options');
				$('#dlg-pop').dialog('open').dialog('refresh', opts.aurl);
			});
		},
		edit: function(jq){
			return jq.each(function(){
				var opts = $(this).datagrid('options');
				var row = $(this).datagrid('getSelected');
				if (row){
					$('#dlg-pop').dialog('open').dialog('refresh', opts.eurl + row);
				} else {
					$.messager.show({
						title:PromptMsg.warning,
						msg:PromptMsg.plsSelect
					});
				}
			});
		},
		del: function(jq){
			return jq.each(function(){
				var dg = $(this);
				var opts = dg.datagrid('options');
				var row = dg.datagrid('getSelected');
				if (row){
					$.messager.confirm('警告','是否真的删除该单据？',function(r){
						if (r){
							$.post(opts.durl, {id:row.id}, function(result){
								if (result.success){
									dg.datagrid('reload');
								} else {
									$.messager.show({
										title:'警告',
										msg:result.msg
									});
								}
							});
						}
					});
				} else {
					$.messager.show({
						title:'警告',
						msg:'请先选择单据后再进行删除。'
					});
				}
			});
		},
		query: function(jq){
			return jq.each(function(){
				var opts = $(this).datagrid('options');
				var dg = $(this);
				showQueryDialog({
					title:opts.query.title,
					width:opts.query.width,
					height:opts.query.height,
					form:opts.query.form,
					callback:function(data){
						dg.datagrid('load', data);
						if (opts.query.callback){
							opts.query.callback();
						}
					}
				});
			});
		}
	};
	
	$.fn.popupWin = function(options, param){
		if (typeof options == 'string'){
			var method = methods[options];
			if (method){
				return method(this, param);
			} else {
				return this.datagrid(options, param);
			}
		}
		
		options = options || {};
		return this.each(function(){
			popupWin(this, options);
		});
	};
	
	//jquery extends
	// the code of this function is from     
	// http://lucassmith.name/pub/typeof.html     
	$.type = function(o){
		var _toS = Object.prototype.toString;
		var _types = {
			'undefined': 'undefined',
			'number': 'number',
			'boolean': 'boolean',
			'string': 'string',
			'[object Function]': 'function',
			'[object RegExp]': 'regexp',
			'[object Array]': 'array',
			'[object Date]': 'date',
			'[object Error]': 'error'
		};
		return _types[typeof o] || _types[_toS.call(o)] || (o ? 'object' : 'null');
	};     
	// the code of these two functions is from mootools     
	// http://mootools.net
	var $specialChars = {
		'\b': '\\b',
		'\t': '\\t',
		'\n': '\\n',
		'\f': '\\f',
		'\r': '\\r',
		'"': '\\"', 
		'\\': '\\\\'
	};
	var $replaceChars = function(chr){
		return $specialChars[chr] || '\\u00' + Math.floor(chr.charCodeAt() / 16).toString(16) + (chr.charCodeAt() % 16).toString(16);
	};
	$.toJSON = function(o){
		var s = [];
		switch ($.type(o)) {
			case 'undefined':
				return 'undefined';
				break;
			case 'null':
				return 'null';
				break;
			case 'number':
			case 'boolean':
			case 'date':
			case 'function':
				return o.toString();
				break;
			case 'string':
				return '"' + o.replace(/[\x00-\x1f\\"]/g, $replaceChars) + '"';
				break;
			case 'array':
				for (var i = 0, l = o.length; i < l; i++) {
					s.push($.toJSON(o[i]));
				}
				return '[' + s.join(',') + ']';
				break;
			case 'error':
			case 'object':
				for (var p in o) {
					s.push('\"' + p + '\"' + ':' + $.toJSON(o[p]));
				}
				return '{' + s.join(',') + '}';
				break;
			default:
				return '';
				break;
		}
	};
	$.evalJSON = function(s){
		if ($.type(s) != 'string' || !s.length)
			return null;
		return eval('(' + s + ')');
	};
})(jQuery);

//表格合并
jQuery.fn.rowspan = function(colIdx) {  
	return this.each(function() {
		var that = null;
		$('tr', this).each(function(row) {
			$('td:eq(' + colIdx + ')', this).filter(':visible').each(function(col) {
				if (that != null && $(this).html() == $(that).html()) {
					rowspan = $(that).attr("rowSpan");
					if (rowspan == undefined) {
						$(that).attr("rowSpan", 1);
						rowspan = $(that).attr("rowSpan");
					}
					rowspan = Number(rowspan) + 1;
					$(that).attr("rowSpan", rowspan);
                    $(this).hide();
                } else {
                    that = this;
                }
            });
        });
    });
};

//
$.fn.numeral = function() {
	$(this).css("ime-mode", "disabled");
	this.bind("keypress", function(e) {
				var code = (e.keyCode ? e.keyCode : e.which); // 兼容火狐 IE
				if (!$.browser.msie && (e.keyCode == 0x8)) // 火狐下 不能使用退格键
				{
					return;
				}
				return code >= 48 && code <= 57;

			});
	this.bind("blur", function() {
				if (this.value.lastIndexOf(".") == (this.value.length - 1)) {
					this.value = this.value.substr(0, this.value.length - 1);
				} else if (isNaN(this.value)) {
					this.value = "";
				}
			});
	this.bind("paste", function() {
				var s = clipboardData.getData('text');
				if (!/\D/.test(s))
					;
				value = s.replace(/^0*/, '');
				return false;
			});
	this.bind("dragenter", function() {
				return false;
			});
	this.bind("keyup", function() {
				if (/(^0+)/.test(this.value)) {
					this.value = this.value.replace(/^0*/, '');
				}
			});
};

//添加选项卡
function AddTab(id, title, url) {
    if ($('#' + id).tabs('exists', title)) {
        $('#' + id).tabs('select', title); //选中并刷新
        var currTab = $('#' + id).tabs('getSelected');
        var url1 = $(currTab.panel('options').content).attr('src');
        if (url1 != undefined && currTab.panel('options').title != '') {
            $('#' + id).tabs('update', {
                tab: currTab,
                options: {
                    content: createFrame(url)
                }
            });
        }
    } else {
        var content = createFrame(url);
        $('#' + id).tabs('add', {
            title: title,
            content: content,
            closable: true,
            selected: true
        });
    }
    tabClose();
}
//嵌入选项卡
function createFrame(url) {
    var s = '<iframe width="100%" height="100%" frameborder="0" scrolling="auto"   src="' + url + '"></iframe>';
    return s;
}
//绑定及关闭选项卡
function tabClose(id) {
    /*双击关闭TAB选项卡*/
    $(".tabs-inner").dblclick(function () {
        var subtitle = $(this).children(".tabs-closable").text();
        $('#' + id).tabs('close', subtitle);
    });
}

//bootstrapValidate
function bootValidate(formConfig){
	var _forms = formConfig;
	for(var i=0;i<_forms.length;i++){
		var _submit = _forms[i].submit!=null?_forms[i].submit:false;
		if(_submit){//表示数据要提交到后台进行处理
			var _formId = _forms[i].id;
			
			var _defaultConfig = {
				live: 'disabled',
				message: 'This value is not valid',
				feedbackIcons: {
		            valid: 'glyphicon glyphicon-ok',
		            invalid: 'glyphicon glyphicon-remove',
		            validating: 'glyphicon glyphicon-refresh'
			    },
			    fields: {}			 
			};
			
			var config = $.extend(true, {}, _defaultConfig, _forms[i].validate);
			var _url = ctxPath + _forms[i].url;
	        var _confirmFn = _forms[i].confirmFn;
			
			$("#" + _formId).bootstrapValidator({			
				live: config.live,
				message:config.message,
				feedbackIcons:config.feedbackIcons,
				fields: config.fields
			}).on('success.form.bv', function(e) {
	            // Prevent form submission
	            e.preventDefault();

	            // Get the form instance
	            var $form = $(e.target);

	            // Get the BootstrapValidator instance
	            var bv = $form.data('bootstrapValidator');

	            // Use Ajax to submit form data
	           /* $.post($form.attr('action'), $form.serialize(), function(result) {
	                console.log(result);
	            }, 'json');*/
	            
	            $.ajax( {
					type : "POST",
					url : _url,
					dataType : "json",
					data : $form.serialize(),
					success: function(data){ 
						console.log(data);
						if($.isFunction(_confirmFn)){
							_confirmFn(data);
						}
					},
	   				beforeSend : function(XMLHttpRequest) {
						$.widgets.loading.init();
					},
					complete : function(XMLHttpRequest, textStatus) {
						$.widgets.loading.destroy();
					}
				});
	        });
		}
	}
}

function bootValidateJsonp(formConfig){
	var _forms = formConfig;
	for(var i=0;i<_forms.length;i++){
		var _submit = _forms[i].submit!=null?_forms[i].submit:false;
		if(_submit){//表示数据要提交到后台进行处理
			var _formId = _forms[i].id;
			
			var _defaultConfig = {
				live: 'disabled',
				message: 'This value is not valid',
				feedbackIcons: {
		            valid: 'glyphicon glyphicon-ok',
		            invalid: 'glyphicon glyphicon-remove',
		            validating: 'glyphicon glyphicon-refresh'
			    },
			    fields: {}			 
			};
			
			var config = $.extend(true, {}, _defaultConfig, _forms[i].validate);
			var _url = _forms[i].url;
			
	        var _confirmFn = _forms[i].confirmFn;
	        
	        var _callbackFn = _forms[i].callbackFn;
	        
	        var _beforeSendFn = _forms[i].beforeSendFn;
			
			$("#" + _formId).bootstrapValidator({			
				live: config.live,
				message:config.message,
				feedbackIcons:config.feedbackIcons,
				fields: config.fields
			}).on('success.form.bv', function(e) {
	            // Prevent form submission
	            e.preventDefault();

	            // Get the form instance
	            var $form = $(e.target);

	            // Get the BootstrapValidator instance
	            var bv = $form.data('bootstrapValidator');

	            // Use Ajax to submit form data
	           /* $.post($form.attr('action'), $form.serialize(), function(result) {
	                console.log(result);
	            }, 'json');*/
	            
	            $.ajax( {
					type : "POST",
					url : _url,
					dataType : "jsonp",
					jsonp:'callback',  
					jsonpCallback:_callbackFn,
					data : $form.serialize(),
					success: function(data){ 
						console.log(data);
						if($.isFunction(_confirmFn)){
							_confirmFn(data);
						}
					},
	   				beforeSend : function(XMLHttpRequest) {
	   					if($.isFunction(_beforeSendFn)){
	   						_beforeSendFn();
						}
						$.widgets.loading.init();
					},
					complete : function(XMLHttpRequest, textStatus) {
						$.widgets.loading.destroy();
					}
				});
	        });
		}
	}
}

function initbootValidate(formConfig){
	var _forms = formConfig;
	for(var i=0;i<_forms.length;i++){
		var _formId = _forms[i].id;
		var _fromObj = $("#" + _formId);
		
		var _defaultConfig = {
		    fields: []			 
		};
		
		var config = $.extend(true, {}, _defaultConfig, _forms[i].fieldName);
		var _fields = config.fields;
		for(var j = 0; j < _fields.length; j++){
			_fromObj.bootstrapValidator('_initField', _fields[j]);
			_fromObj.bootstrapValidator('resetField', _fields[j]);
		}
		
		var formGroup = _fromObj.find('.form-group');
		if(formGroup.hasClass('has-error')){
			formGroup.removeClass('has-error');
		}
		
		if(formGroup.hasClass('has-success')){
			formGroup.removeClass('has-success');
		}
		// 重置表单
		_fromObj[0].reset();
	}
}

