<?php 
/**
 * 页面功能简述： 分页类
 * 
 * 开发负责人：吴思阳    联系邮箱：1985277517@qq.com  联系QQ: 1985277517  
 * 
 * 合同协议：成都万应网络科技有限公司（http://www.cdwinning.com）是成都高质量的网络应用开发、网站建设、wap/微信开发科技公司，
 * 		      公司原则是：尽心、尽责、尽全力。为每位客户打造放心的业务合作关系。公司要求所有开发人员按照客户提供的要求给客户开发高质
 * 		      量、高稳定性、高体验度的程序。万应科技，有求必应！
 * 
 * 技术申明：成都万应网络科技有限公司（简称本公司）在程序上部署版权探针程序，程序解释权归本公司所有。
 *         程序使用版权归合同签署者（简称使用人），未经同意，使用人不得将此程序源码转让和出售。
 *         如果发现以上行为，将进行网站下线或程序删除等操作。
 *         
 * 更新日期：2015-11-22
 * 
 */

/* * *********************************************
 * @类名:   page
* @参数:   $myde_total - 总记录数
*          $myde_size - 一页显示的记录数
*          $myde_page - 当前页
*          $myde_url - 获取当前的url
* @功能:   分页实现
* @作者:   Bililovy
* 分页样式
* 
*  p{margin:0}
            #page{
                height:40px;
                padding:20px 0px;
            }
            #page a{
                display:block;
                float:left;
                margin-right:10px;
                padding:2px 12px;
                height:24px;
                border:1px #cccccc solid;
                background:#fff;
                text-decoration:none;
                color:#808080;
                font-size:12px;
                line-height:24px;
            }
            #page a:hover{
                color:#077ee3;
                border:1px #077ee3 solid;
            }
            #page a.cur{
                border:none;
                background:#077ee3;
                color:#fff;
            }
            #page p{
                float:left;
                padding:2px 12px;
                font-size:12px;
                height:24px;
                line-height:24px;
                color:#bbb;
                border:1px #ccc solid;
                background:#fcfcfc;
                margin-right:8px;

            }
            #page p.pageRemark{
                border-style:none;
                background:none;
                margin-right:0px;
                padding:4px 0px;
                color:#666;
            }
            #page p.pageRemark b{
                color:red;
            }
            #page p.pageEllipsis{
                border-style:none;
                background:none;
                padding:4px 0px;
                color:#808080;
            }
            .dates li {font-size: 14px;margin:20px 0}
            .dates li span{float:right}
            
*/
class PageStyle2 {
	private $myde_total;          //总记录数
	private $myde_size;           //一页显示的记录数
	private $myde_page;           //当前页
	private $myde_page_count;     //总页数
	private $myde_i;              //起头页数
	private $myde_en;             //结尾页数
	private $myde_url;            //获取当前的url
	/*
	 * $show_pages
	* 页面显示的格式，显示链接的页数为2*$show_pages+1。
	* 如$show_pages=2那么页面上显示就是[首页] [上页] 1 2 3 4 5 [下页] [尾页]
	*/
	private $show_pages;
	public function __construct($myde_total = 1, $myde_size = 1, $myde_page = 1, $myde_url, $show_pages = 2) {
		$this->myde_total = $this->numeric($myde_total);
		$this->myde_size = $this->numeric($myde_size);
		$this->myde_page = $this->numeric($myde_page);
		$this->myde_page_count = ceil($this->myde_total / $this->myde_size);
		$this->myde_url = $myde_url;
		if ($this->myde_total < 0)
			$this->myde_total = 0;
		if ($this->myde_page < 1)
			$this->myde_page = 1;
		if ($this->myde_page_count < 1)
			$this->myde_page_count = 1;
		if ($this->myde_page > $this->myde_page_count)
			$this->myde_page = $this->myde_page_count;
		$this->limit = ($this->myde_page - 1) * $this->myde_size;
		$this->myde_i = $this->myde_page - $show_pages;
		$this->myde_en = $this->myde_page + $show_pages;
		if ($this->myde_i < 1) {
			$this->myde_en = $this->myde_en + (1 - $this->myde_i);
			$this->myde_i = 1;
		}
		if ($this->myde_en > $this->myde_page_count) {
			$this->myde_i = $this->myde_i - ($this->myde_en - $this->myde_page_count);
			$this->myde_en = $this->myde_page_count;
		}
		if ($this->myde_i < 1)
			$this->myde_i = 1;
	}
	//检测是否为数字
	private function numeric($num) {
		if (strlen($num)) {
			if (!preg_match("/^[0-9]+$/", $num)) {
				$num = 1;
			} else {
				$num = substr($num, 0, 11);
			}
		} else {
			$num = 1;
		}
		return $num;
	}
	//地址替换
	private function page_replace($page) {
		return str_replace("{page}", $page, $this->myde_url);
	}
	//首页
	private function myde_home() {
		if ($this->myde_page != 1) {
			return "<a href='" . $this->page_replace(1) . "' title='首页'>首页</a>";
		} else {
			return "<p>首页</p>";
		}
	}
	//上一页
	private function myde_prev() {
		if ($this->myde_page != 1) {
			return "<a href='" . $this->page_replace($this->myde_page - 1) . "' title='上一页'>上一页</a>";
		} else {
			return "<p>上一页</p>";
		}
	}
	//下一页
	private function myde_next() {
		if ($this->myde_page != $this->myde_page_count) {
			return "<a href='" . $this->page_replace($this->myde_page + 1) . "' title='下一页'>下一页</a>";
		} else {
			return"<p>下一页</p>";
		}
	}
	//尾页
	private function myde_last() {
		if ($this->myde_page != $this->myde_page_count) {
			return "<a href='" . $this->page_replace($this->myde_page_count) . "' title='尾页'>尾页</a>";
		} else {
			return "<p>尾页</p>";
		}
	}
	//输出
	public function myde_write($id = 'page') {
		$str = "<div id=" . $id . ">";
		$str.=$this->myde_home();
		$str.=$this->myde_prev();
		if ($this->myde_i > 1) {
			$str.="<p class='pageEllipsis'>...</p>";
		}
		for ($i = $this->myde_i; $i <= $this->myde_en; $i++) {
			if ($i == $this->myde_page) {
				$str.="<a href='" . $this->page_replace($i) . "' title='第" . $i . "页' class='cur'>$i</a>";
			} else {
				$str.="<a href='" . $this->page_replace($i) . "' title='第" . $i . "页'>$i</a>";
			}
		}
		if ($this->myde_en < $this->myde_page_count) {
			$str.="<p class='pageEllipsis'>...</p>";
		}
		$str.=$this->myde_next();
		$str.=$this->myde_last();
		$str.="<p class='pageRemark'>共<b>" . $this->myde_page_count .
		"</b>页<b>" . $this->myde_total . "</b>条数据</p>";
		$str.="</div>";
		return $str;
	}
}
