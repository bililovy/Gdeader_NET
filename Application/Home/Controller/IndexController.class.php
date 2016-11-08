<?php
namespace Home\Controller;


use Home\Controller\EmptyController;

class IndexController extends EmptyController
{
    public function index()
    {
        //获取焦点图
        unset($where);
        unset($field);
        $field = 'title,cover,linkurl,desc,btntext, showtype';
        $where[ 'isshow' ] = 1;
        $order = 'sortorder ASC, id DESC';
        $limit = 5;
        $focuses = M('focus')->field($field)->where($where)->order($order)->limit($limit)->select();

        //    		$cartCount=M('wishlist')->where(array('uid'=>$_SESSION['member']['uid']))->count();
        //获取促销活动
        unset($field);
        unset($where);
        unset($limit);

        //获取新上架的商品
        $new_goods = M('goods')->field('id, goodsname,goodslink,goodsimg,price, sell_price, favnum, score')->where(array (
            'isshow' => 1,
            'isnew' => 1
        ))->order('click DESC')->limit(4)->select();
        if ($new_goods) {
            $existIDs = [];
            foreach ($new_goods as $goods) {
                $existIDs[] = $goods[ 'id' ];
            }
        }
        //获取热销商品
        $hot_goods = M('goods')
            ->field('id, goodsname,goodslink,goodsimg,click,price, sell_price, favnum, score')
            ->where(array ('id' => array ('not in', $existIDs), 'isshow' => 1, 'isrecommend' => 1))
            ->order('click DESC')
            ->limit(4)
            ->select();
        //------页面信息---//
        $pageinfo = array (
            'pagetitle' => '',
        );
        $this->pageinfo = $pageinfo;
        //------页面信息---//

        //获取提问类型
        $this->focuses = $focuses;
        $this->hots = $new_goods;
        $this->recommends = $hot_goods;
        $this->display('index');
    }

}