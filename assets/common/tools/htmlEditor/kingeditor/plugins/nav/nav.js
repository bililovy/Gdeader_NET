KindEditor.plugin("nav",function(K){var self=this,name="nav",lang=self.lang(name+"."),htmlPath=self.pluginsPath+name+"/html/";function getFilePath(fileName){return htmlPath+fileName+"?ver="+encodeURIComponent(K.DEBUG?K.TIME:K.VERSION);}self.clickToolbar(name,function(){var lang=self.lang(name+"."),arr=['<div style="padding:10px 20px;">','<div class="ke-header">','<div class="ke-left">',lang.selectTemplate+" <select>"];K.each(lang.fileList,function(key,val){arr.push('<option value="'+key+'">'+val+"</option>");});html=[arr.join(""),"</select></div>",'<div class="ke-right">','<input type="checkbox" id="keReplaceFlag" name="replaceFlag" value="1" /> <label for="keReplaceFlag">'+lang.replaceContent+"</label>","</div>",'<div class="ke-clearfix"></div>',"</div>",'<iframe class="ke-textarea" frameborder="0" style="width:458px;height:260px;background-color:#FFF;"></iframe>',"</div>"].join("");var dialog=self.createDialog({name:name,width:500,title:self.lang(name),body:html,yesBtn:{name:self.lang("yes"),click:function(e){var doc=K.iframeDoc(iframe);self[checkbox[0].checked?"html":"insertHtml"](doc.body.innerHTML).hideDialog().focus();}}});var selectBox=K("select",dialog.div),checkbox=K('[name="replaceFlag"]',dialog.div),iframe=K("iframe",dialog.div);checkbox[0].checked=true;iframe.attr("src",getFilePath(selectBox.val()));selectBox.change(function(){iframe.attr("src",getFilePath(this.value));});});});