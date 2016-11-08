/**
 * 
 */
function getUsage(obj,url,type){
    if (null == type || false ==type || null == obj || false ==obj) return false;
    if ($(obj).hasClass('posting')) return false;    
    var $this=$(obj).siblings('span.data').find('i.process');
    $(obj).text('检测中…').css('background', '#999').addClass('posting');
    switch(type){
        case 'website':
            var $data={'type':'space'};
            var $totalObj=$('#spacetotal');
            break;
        case 'mysql':
            var $data={'type':'sql'};
            var $totalObj=$('#sqltotal');
            break;
        default:
                easyDialog.open({
                    container : {
                      header: '消息提醒：',
                      content : '系统无法检测到您的请求类型，请刷新页面重试！'
                    },
                    autoClose : 8000
                  });   
        return false;
    }
    $.post(url,$data,function (back){
        if(back.status==1){
            var $process=-(300-back.percent*300);
            var percent=parseFloat(back.percent)*100;
            $this.css('background-position',$process+'px 0');
            percent='<b style="color: #'+back.fc+'">'+percent.toFixed(2)+' %</b>';           
            setTimeout(function (){            
                $(obj).text('重新检测').css('background', '#1C2B36').removeClass('posting');
                $totalObj.html(back.total);
                $this.siblings('span.space_used').html(back.used);
                $this.siblings('span.use_percent').html(percent);
            },1500);
        }else{
            easyDialog.open({
                container : {
                  header: '消息提醒：',
                  content : back.message
                },
                autoClose : 8000
              });   
            $(obj).text('重新检测').css('background', '#1C2B36').removeClass('posting');
        }
    },'json');   
}
function removedir(o,posturl){
    if (null== o || null == posturl || false == posturl ||  ''== posturl) return false;
    if($(o).hasClass('posting'))  return false;
    $(o).text('操作中…').addClass('posting');
    $.post(posturl,'', function(back){
        if(back.status==1){
            $(o).parent().slideUp(200, function (){
                $(this).remove();
            })
        }else{
            easyDialog.open({
                container : {
                  header: '消息提醒：',
                  content : back.data
                },
                autoClose : 8000
              });
            $(o).text('点此删除').removeClass('posting');
        }
    },'json');
}
function clearSpaceChache(o,url){
    url = (null==url || false ==url || ''==url) ? false : url;
    if(false == url){
        easyDialog.open({
            container : {
                header: '消息提醒：',
                content : '缓存清理失败，系统无法获取必须信息，请刷新页面重新尝试！'
              },
              drag : false,
              autoClose: 3000
            });
        return false;
    }
    var data={type: 'clearSizeCache'};
    $.post(url, data, function (back){
        if(back.status==1){
            easyDialog.open({
                container : {
                    header: '消息提醒：',
                    content : '缓存清理成功，您可再次点击下方按钮获取最新数据！'
                  }, 
                  drag : false,
                  follow : o,
                  followX : -137,
                  followY : 24,
                  autoClose: 2500
                });
        }else{
            easyDialog.open({
                container : {
                    header: '消息提醒：',
                    content : back.message
                  },
                  drag : false,
                  follow : o,
                  followX : -137,
                  followY : 24,
                  autoClose: 8000
                });
        }
    },'json');  
}
/**
 * 隐藏多余的文字
 * 控制器展开收起
 */

 hiddenText(22)
function hiddenText(charnum){
     charnum= (null==charnum || false ==charnum || '' ==charnum) ? 20 : charnum;
        var o = document.getElementById("serverdata");
            var s = o.innerHTML;
            var p = document.createElement("span");
            var n = document.createElement("i");
            p.innerHTML = s.substring(0,charnum);
            n.innerHTML = s.length > charnum ? "..." : "";
            p.style.display='inline';
            n.style.display='inline';
            n.style.lineHeight='18px';
            n.style.padding='0 5px';
            n.style.marginLeft='5px';
            n.style.cursor='pointer';
            n.style.fontStyle='normal';
            n.style.backgroundColor='#1C2B36';
            n.style.color='#FFF';
            n.href = "javascript:void(0)";
            n.onclick = function(){
              if (n.innerHTML == "..."){
                n.innerHTML = "收起";
                p.innerHTML = s;            
              }else{
                n.innerHTML = "...";
                p.innerHTML = s.substring(0,charnum);
              }
            }
            o.innerHTML = "";
            o.appendChild(p);
            o.appendChild(n);
  }
/**
 *修复系统问题 
 *
 */
 function repairsys(o,dourl,action){
     o= (null==o || false ==o || '' ==o) ? false : o;
     dourl= (null==dourl || false ==dourl || '' ==dourl) ? false : dourl;
     action= (null==action || false ==action || '' ==action) ? false : action;
     if( !o || !dourl || !action){
         easyDialog.open({
             container : {
                 header: '消息提醒：',
                 content : '系统检测参数时出错，请刷新页面再次尝试！',
               },
               drag : false,
               follow : o,
               followX : -137,
               followY : 24,
               autoClose: 5000
             });
         return false;
     }
     $(o).text('修复中…').addClass('posting');
    var submit=function (){
         var sitename=$('input[name="sitename"]')[0];
         var siteauth=$('input[name="siteauth"]')[0];
         if(!checkname(sitename) ||  !checkauth(siteauth))                  
             return false;

         var sitenameval = $(sitename).val();
         var siteauthval = $(siteauth).val();
         var data={action: action, sitename: sitenameval, siteauth: siteauthval};
         $.post(dourl, data, function (back){
             if (back.status==1){
                 if($(o).parent().siblings('li').length<=1){
                     window.location.reload();
                 }else{
                     $(o).parent().slideUp(200,function (){
                         $(this).remove();
                     });
                 }
             }else{
                 easyDialog.open({
                     container : {
                         header: '消息提醒：',
                         content : back.message,
                       },
                       drag : false,
                       autoClose: 5000
                     });
             }
             $(o).text('点此修复').removeClass('posting');
         }, 'json');
         return false;
     }
     var formhtml='<div style="width: 100%;line-height: 30px;"><label>网站名称</label><input type="text" value="" placeholder="请输入网站名称" name="sitename" style="padding: 0 10px; height: 25px;width:200px;margin-left: 10px;" onblur="checkname(this)"/></div>';  
          formhtml+='<div style="width: 100%;line-height: 30px;margin-top: 10px;"><label>授权编码</label><input type="text" name="siteauth"  value="" placeholder="请输入网站授权编码" style="padding: 0 10px; height: 25px;width:200px;margin-left: 10px;" onblur="checkauth(this)"/></div>';
          formhtml+='<div style="width: 100%;line-height: 20px;margin-top: 15px;font-size: 12px; text-align:center; color: #898989;" id="siteconftip" placeholder="提示：若您已在万应科技开通服务，并且以上信息若遗忘或不知，请联系<a href=\'http://www.cduwin.com\' target=\'_blank\'>万应客服</a>">提示：若您已在万应科技开通服务，并且以上信息若遗忘或不知，请联系<a href="http://www.cduwin.com" target="_blank">万应客服</a></div>';
     easyDialog.open({
         container : {
             header: '修复前，请完善下列信息',
             content : formhtml,
             yesFn : submit,
             noFn : function (){
                 $(o).text('点此修复').removeClass('posting');
             }
           },
           drag : false,
         });
     $('#easyDialogYesBtn').text('立即修复').css('background', '#294655');
     
 }
 
 function checkname(o){
     val=$(o).val();
     if(''==val){
         $('#siteconftip').html('<span style="color: #E80808;">请输入万应科技为贵网站分配的网站名称</span>');
         return false;
         
     }else if(has_cn(val)){
         $('#siteconftip').html('<span style="color: #E80808;">网站名称不能有中文</span>');
         return false;
     }else{
         $('#siteconftip').html($('#siteconftip').attr('placeholder'));
         return true;
     }
 }
 
 function checkauth(o){
     val=$(o).val();
     if(''==val){
         $('#siteconftip').html('<span style="color: #E80808;">请输入万应科技为贵网站分配的授权编码</span>');
         return false;         
     }else if(has_cn(val)){
         $('#siteconftip').html('<span style="color: #E80808;">授权编码为一串字母+数字，请准确输入</span>');
         return false;
     }else{
         $('#siteconftip').html($('#siteconftip').attr('placeholder'));
         return true;
     }
 }
 function has_cn(val) {
     if (val != null && val != "") {
         var re1 = new RegExp("[\u4E00-\uFA29]|[\uE7C7-\uE7F3]");
         if (re1.test(val)) {
             return true;
         } else {
             return false;
         }
     } else {
         return false;
     }
 }