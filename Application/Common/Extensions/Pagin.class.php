<?php
/**
 * 分页类
 * @author  siyang & 290747680@qq.com
 * @date 2011-08-17
 * 
 * show(2)  1 ... 62 63 64 65 66 67 68 ... 150
 * 分页样式 
 * #page{font:12px/16px arial}
 * #page span{float:left;margin:0px 3px;}
 * #page a{float:left;margin:0 3px;border:1px solid #ddd;padding:3px 7px; text-decoration:none;color:#666}
 * #page a.now_page,#page a:hover{color:#fff;background:#05c}
*/
class Page{
private $myde_count;       //总记录数
public $myde_size;        //每页记录数
private $myde_page;        //当前页
private $myde_page_count; //总页数
private $page_url;         //页面url
private $page_i;           //起始页
private $page_ub;          //结束页
public $page_limit;

function __construct($myde_count=0,$myde_size=1,$myde_page=1,$page_url)//构造函数
{   
   $this->myde_count=$this->numeric($myde_count);
   $this->myde_size=$this->numeric($myde_size);
   $this->myde_page=$this->numeric($myde_page);
    $this->page_url=$page_url; //连接的地址  
   if($this->myde_page<1)$this->myde_page=1; //当前页小于1的时候，，值赋值为1 
   if($this->myde_count<0)$this->myde_page=0;  
   $this->myde_page_count=ceil($this->myde_count/$this->myde_size);//总页数  
   if($this->myde_page_count<1)
    $this->myde_page_count=0;  
   if($this->myde_page>$this->myde_page_count) 
     $this->myde_page=$this->myde_page_count;  
   $this->page_limit=($this->myde_page * $this -> myde_size) - $this -> myde_size; //下一页的开始记录
   if($this->page_limit<0) $this->page_limit=0;
   //$this->page_i=$this->myde_page-2;
   $this->page_i=$this->myde_page-2;  
        $this->page_ub=$this->myde_page+4; 
        //$this->page_ub=$this->myde_page+2;  
        if($this->page_i<1)$this->page_i=1;        
        if($this->page_ub>$this->myde_page_count){$this->page_ub=$this->myde_page_count; }
}
private function numeric($id) //判断是否为数字
    { if (strlen($id)){
       if (!ereg("^[0-9]+$",$id)) $id = 1;
    }else{
    $id = 1;
   }
   return $id;
} 
private function page_replace($page) //地址替换
{return str_replace("{page}", $page, $this -> page_url);} 
private function myde_home() //首页
{ if($this -> myde_page != 1){  
    return "    <li class=\"paginItem\"><a href=\"".$this -> page_replace(1)."\" title=\"first\" class=\"firstpage\"><span>First</span></a></li>\n";   
   }else{  
//     return "    <li class=\"paginItem\"><a href=\"javascript:void(0)\" class=\"firstpage\">first</a></li>\n";   
    return "    <li class=\"paginItem\"><span>First</span></li>\n";   
   }
} 
private function myde_prev($text='&lt;') //上一页
{ if($this -> myde_page != 1){  
    return "    <li class=\"paginItem\"><a href=\"".$this -> page_replace($this->myde_page-1) ."\" title=\"prev\" class=\"prepage\"><span class=\"pagepre arrow_able\">".$text."</span></a></li>\n";
   }else{  
//     return "    <li class=\"paginItem\"><a href=\"javascript:void(0)\" title=\"first page now\" class=\"prepage\"><span class=\"	pagepre arrow_disable\">".$text."</span></a></li>\n";   
    return "    <li class=\"paginItem\"><span>".$text."</span></li>\n";   
   }
} 
private function myde_next($text='&gt;') //下一页
{ if($this -> myde_page != $this -> myde_page_count){  
     return "    <li class=\"paginItem\"><a href=\"".$this -> page_replace($this->myde_page+1) ."\" title=\"next\" class=\"nextpage\" ><span class=\"pagenxt arrow_able\">".$text."</span></a></li>\n";
    
   }else{  
//     return "  <li class=\"paginItem\"><a href=\"javascript:void(0)\" title=\"last page now\" class=\"nextpage\"><span class=\"pagenxt arrow_disable\">".$text."</span></a></li>\n";   
    return "    <li class=\"paginItem\"><span>".$text."</span></a></li>\n";   
   }
} 
private function myde_last() //尾页
{
   if($this -> myde_page != $this -> myde_page_count){  
     return "    <li class=\"paginItem \"><a href=\"".$this -> page_replace($this -> myde_page_count)."\" title=\"last\" class=\"lastpage\"><span>Last</span></a></li>\n";
    
   }else{  
//     return "    <li class=\"paginItem\"><a href=\"javascript:void(0)\" class=\"lastpage\">last</a></li>\n";   
    return "    <li class=\"paginItem\"><span>Last</span></li>\n";   
   }
} 
/**
 * 
 * @param  $showAll 是否显示总页数
 * @param  $showCur 是否显示当前页码
 * @param  $showIpt 是否启用输入框
 * @param  $showFirst 是否显示 首页
 * @param  $showLast 是否显示尾页
 * @param  $showItem 是否列出页码详情
 * @param  $prevBtnText 
 * @param  $nextBtnText
 * @param  $id
 */
function myde_write($showAll=true,$showCur=true,$showIpt=true,$showFirst=true, $showLast=true, $showItem=true,$prevBtnText='&lt;',$nextBtnText='&gt;',$id='pagination') //输出
{
   $str = "<div id=\"".$id."\" class=\"".$id ."\">\n <ul class=\"paginList\">\n ";  
   if($showAll){
   $str .= " <li class='total'>总记录:<span class='total_num'>".$this -> myde_count."条</span></li>\n";  
   }
   if($showCur){
   $str .= "    <li class='num_show'>Results:<span>".$this -> myde_page."</span>/<span>".$this -> myde_page_count."</span></li>\n";  
   }
   if($showFirst)
   $str .= $this -> myde_home();  
   $str .= $this -> myde_prev($prevBtnText);
   if($showItem){
	   for($page_for_i=$this->page_i;$page_for_i <= $this -> page_ub; $page_for_i++){  
	    if($this -> myde_page == $page_for_i){   
	            $str .= "    <li class=\"paginItem current\"><span>".$page_for_i."</span></li>\n";    
	    }   
	    else{   
	     $str .= "    <li class=\"paginItem \"><a href=\"".$this -> page_replace($page_for_i)."\" title=\"page ".$page_for_i."\"><span>";    
	     $str .= $page_for_i . "</span></a></li>\n";    
	    }
	    }
   }
   $str .= $this -> myde_next($nextBtnText);
   if($showLast)  
   $str .= $this -> myde_last();  
   if($showIpt){
   $str .= "    <li class=\"pages_input\"><span class=\"a\">前往</span><input type=\"text\" value=\"".$this -> myde_page."\"";  
   $str .= "onmouseover=\"javascript:this.value='';this.focus();\" onkeydown=\"javascript: if(event.keyCode==13){ location='";  
   $str .= $this -> page_replace("'+this.value+'")."';return false;}\"";  
   $str .= " title=\"输入您想要到达的页码,然后回车！\" /><span class=\"b\">页</span></li>\n";  
   }
   $str .= " </ul></div>";
   return $str;
}
}
