<?php
/**
 * 页面功能简述： 前端产品控制中心
 *
 * 开发负责人：吴思阳    联系邮箱：1985277517@qq.com  联系QQ: 1985277517
 *
 * 合同协议：成都万应网络科技有限公司（http://www.cdwinning.com）是成都高质量的网络应用开发、网站建设、wap/微信开发科技公司，
 *              公司原则是：尽心、尽责、尽全力。为每位客户打造放心的业务合作关系。公司要求所有开发人员按照客户提供的要求给客户开发高质
 *              量、高稳定性、高体验度的程序。万应科技，有求必应！
 *
 * 技术申明：成都万应网络科技有限公司（简称本公司）在程序上部署版权探针程序，程序解释权归本公司所有。
 *         程序使用版权归合同签署者（简称使用人），未经同意，使用人不得将此程序源码转让和出售。
 *         如果发现以上行为，将进行网站下线或程序删除等操作。
 *
 * 更新日期：2015-11-22
 *
 */
namespace Home\Controller;

use Home\Controller\EmptyController;

class GoodsController extends EmptyController
{
    /**
     * 产品列表控制
     */
    public function index()
    {
        $cid = I('cid', 0, 'intval');
        if ($cid > 0) {
            $cateinfo = M('category')->field('catename')->where(array ('id' => $cid))->find();
            $catename = preg_replace("/[^0-9a-zA-Z\-]+/ui", '-',
                trim(strtolower(htmlspecialchars_decode($cateinfo[ 'catename' ]))));
            header('HTTP/1.1 301 Moved Permanently');
            header('location:/cat' . $cid . '-' . $catename . '.' . C('URL_HTML_SUFFIX'));
            exit;
        } else {
            $this->error('Access Denyed By the Server, Missing  Some Parameters!', '', 5);
        }
    }

    public function goodaCate()
    {
        $cid = I('cid', 0, 'intval');
        if ($cid > 0) {
            //获取当前分类的信息 作为 页面信息
            $cateinfo = M('category')
                ->field('id,description,keywords, catename,parentid, cover')
                ->where(array ('id' => $cid, 'isshow' => 1))
                ->find();

            if (count($cateinfo) > 0) {

                $get_cate_ids = $this->getCates($cid);

                $cates = array_merge([$cateinfo], $get_cate_ids);

                $cateids = array_column($cates, 'id', 'catename');

                $field = 'id,goodsname, goodslink,goodsimg,price,click, cateid, sell_price, score, favnum';

                $where = 'cateid IN (' . implode(',', $cateids) . ' )';

                //默认排序
                $order = 'sortorder, click DESC, favnum DESC ';

                $goods = M('goods')->field($field)->where($where)->order($order)->select();

                if ($goods && is_array($goods)) {

                    $goods_info = array ();

                    $cateids = array_flip($cateids);

                    $show_cates = array ();

                    foreach ($goods as $val) {

                        if ($val[ 'cateid' ] == $cid) {

                            $goods_info [ $val[ 'cateid' ] ][ 'main' ] = 1;

                        }

                        $goods_info [ $val[ 'cateid' ] ][ 'catename' ] = $cateids[ $val[ 'cateid' ] ];

                        $goods_info [ $val[ 'cateid' ] ][ 'goods_list' ] [] = $val;

                        $show_cates[ $val[ 'cateid' ] ] = $cateids[ $val[ 'cateid' ] ];

                    }

                }
                //dump($goods_info);die;
                //------页面信息---//
                $pageinfo = array (

                    'pagetitle' => $cateinfo[ 'catename' ],


                    'description' => $cateinfo[ 'description' ],

                    'keywords' => $cateinfo[ 'keywords' ],

                    'breadcrumb' => array ($cateinfo[ 'catename' ]),

                );

                $this->pageinfo = $pageinfo;
                //------页面信息---//

                $this->goods = array_reverse($goods_info);

                $this->categories = array_reverse($show_cates);

                $this->cat_cover = $cateinfo[ 'cover' ];

                $this->catename = $cateinfo[ 'catename' ];

                $this->display('category');

            } else {

                $this->error('Access Denyed By the Server, Missing  Some Parameters!', '', 5);

            }

        } else {

            $this->error('Access Denyed By the Server, Missing  Some Parameters!', '', 5);

        }
    }


    private function getCates($base_id = 0)
    {
        static $cates = array ();

        if ($base_id <= 0) {

            return $base_id;

        }

        $cateinfo = M('category')
            ->field('id,description,keywords, catename,parentid')
            ->where(array ('parentid' => $base_id))
            ->select();

        if (count($cateinfo) > 0) {

            foreach ($cateinfo as $cate) {

                $cates [] = $cate;

                $this->getCates($cate[ 'id' ]);

            }


        }

        return $cates;
    }

    /* 	public function getBreadCrumb($id,$now){
            $bread=array();
            $uplevel=M('category')->field('id,catename,parentid')->where('id=' .$id)->find();
            if ($uplevel['parentid'] !=0)
                $this->getBreadCrumb($uplevel['parentid'],$now);
            if ($uplevel) $bread[]=$uplevel;
            if(empty($bread))
                $bread=$now;
            else
                $bread=array_merge($bread,$now);
            $res=array();
            foreach($bread as $val){
                if(is_array($val)) $res[U('index',array('cid'=>$val['id'],'justfrom'=>'catelist'))]=$val['catename'];
                else $res[]=$val;
            }
            return $res;
        } */
    public function getBreadCrumb($id, $now)
    {
        static $bread = array ();
        $uplevel = M('category')->field('id,catename,parentid')->where('id=' . $id)->find();
        array_unshift($bread, $uplevel);
        if ($uplevel[ 'parentid' ] != 0) {
            $this->getBreadCrumb($uplevel[ 'parentid' ], $now);
        }
        $bread[ 'cu' ] = $now;
        $res = array ();
        foreach ($bread as $val) {
            if (! is_null($val)) {
                if (is_array($val)) {
                    $res[ U('index', array ('cid' => $val[ 'id' ], 'justfrom' => 'catelist')) ] = $val[ 'catename' ];
                } else {
                    $res[] = $val;
                }
            }
        }
        $res = array_unique($res);

        return $res;
    }

    static protected function filter_array_unique($array)//写的比较好
    {
        $out = array ();
        foreach ($array as $key => $value) {
            if (! in_array($value, $out)) {
                $out[ $key ] = $value;
            }
        }
        return $out;
    }

    static protected function arrayChange($a)
    {
        $arr2 = array ();
        foreach ($a as $v) {
            if (is_array($v)) {
                self::arrayChange($v);
            }
            $arr2 = array_merge($arr2, $v);
        }
        return $arr2;
    }

    /**
     * 通过分类id找到下级
     */
    static private function GetSubByCate($cid = 0)
    {
        $cateids = array ();
        $subcate = M('category')->field('id')->where(array ('parentid' => $cid))->select();
        if ($subcate) {
            foreach ($subcate as $sub) {
                $cateids[] = $sub[ 'id' ];
                $cateids = array_merge($cateids, self::GetSubByCate($sub[ 'id' ]));
            }
        }
        return $cateids;
    }

    public function detail()
    {
        $gid = I('gid', 0, 'intval');
        $goodsinfo = M('goods')->field('goodsname')->where(array ('id' => $gid))->find();
        $goodsinfo[ 'goodsname' ] = preg_replace("/[^0-9a-zA-Z\-]+/ui", '-',
            trim(strtolower(htmlspecialchars_decode($goodsinfo[ 'goodsname' ]))));
        header('HTTP/1.1 301 Moved Permanently');
        header('location:/pro' . $gid . '-' . htmlspecialchars_decode($goodsinfo[ 'goodsname' ] . '.' . C('URL_HTML_SUFFIX')));
        exit;
    }

    /**
     * 产品详情
     */
    public function gdetail()
    {
        $gid = I('gid', 0, 'intval');
        $where = 'a.id=%d AND a.cateid=b.id';
        if ($goodsExists = M()
            ->table('__GOODS__ as a, __CATEGORY__ as b')
            ->field('a.cateid,a.goodsname, a.goodsimg, a.goodslink, a.commentlink, a.keywords, a.description, a.click, a.price, a.goodsdetail, a.score, a.sell_price, a.favnum, b.catename')
            ->where($where, $gid)
            ->find()
        ) {
            $goodsExists[ 'id' ] = $gid;

            //点击量自增1
            M('goods')->where(array ('id' => $gid))->setInc('click', 1);
            //获取产品相册
            $goodsalbums = M('goodsalbum')->field('imgrealpath', true)->where(array ('goodsid' => $gid))->select();
            $goodsattr = M()
                ->table('__ATTRIBUTE__ as a, __GOODSATTR__ as b')
                ->field('a.attrname,b.attrvalue')
                ->where('a.id=b.attrid AND b.goodsid=' . $gid)
                ->order('a.sortorder')
                ->select();
            $reg = '/(\w+)@([0-9]*(\\.[0-9]{1,2})?)/';
            foreach ($goodsattr as $key => & $val) {
                $attr_info = [];
                if (strpos($val[ 'attrvalue' ], '|') !== false) {
                    $attrvalue = array_empty_filter(explode('|', $val[ 'attrvalue' ]));
                    foreach ($attrvalue as $i => $attrval) {
                        preg_match($reg, $attrval, $match);
                        $attr_info [ $i ] [ 'scale' ] = $match[ 1 ];
                        $attr_info [ $i ] [ 'price' ] = $match[ 2 ];
                    }
                } else {
                    unset($attr_info);
                    $attr_info [] = ['scale' => $val[ 'attrvalue' ], 'price' => ''];
                }
                $val[ 'attrvalue' ] = $attr_info;
            }
            //推荐产品
            $recommends = M('goods')->field('id,goodsname,goodslink, price, goodsimg,description')->where(array (
                'isshow' => 1,
                'isrecommend' => 1,
                'id' => array ('NEQ', $gid)
            ))->order('sortorder')->limit(6)->select();


            $faqs =M('goods_faq_content') ->field('addtime,id,isshow,isreleased', true)->where(array('gid'=>$gid, 'isshow'=>1,'isreleased'=>1))->order('addtime DESC')->select();

            $goodsExists[ 'goodsdetail' ] = htmlspecialchars_decode($goodsExists[ 'goodsdetail' ]);

            //------页面信息---//
            $bread = [];
            $bread [ U('index', array ('cid' => $goodsExists[ 'cateid' ])) ] = $goodsExists[ 'catename' ];
            $bread [] = $goodsExists[ 'goodsname' ];

            $pageinfo = array (
                'pagetitle' => $goodsExists[ 'goodsname' ],
                'keywords' => $goodsExists[ 'keywords' ],
                'description' => $goodsExists[ 'description' ],
                'breadcrumb' => $bread
            );
            $this->pageinfo = $pageinfo;
            //------页面信息---//
            //dump($goodsalbums);die;
            $this->goods = $goodsExists;
            //            dump($goodsExists);die;
            $this->goodsattr = $goodsattr;
            $this->recommends = $recommends;
            $this->goodsalbums = $goodsalbums;
            $this->faqs= $faqs;
            $this->display('goods_detail');
        } else {
            $this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !', '', 5);
        }
    }


    public function faqSet()
    {

        if (IS_POST && IS_AJAX) {

            $data = I('post.');

            if (! empty($data[ 'reviewer' ]) || strlen($data[ 'content' ]) > 10 || $data[ 'gid' ] <= 0) {

                $tmp ['gid'] = $data['gid'];

                if (! $new_id = M('goods_faq')->add($tmp)){
                    $return = array (
                        'status' => 0,
                        'data' => 'The Network is busy now! '
                    );

                    $this->ajaxReturn($return);
                    exit;
                }

                $data[ 'addtime' ] = time();
                $data[ 'isshow' ] = 0;
                $data[ 'isreleased' ] = 0;
                $newid = M('goods_faq_content')->add($data);
                if ($newid) {
                    $return = array (
                        'status' => 1,
                        'data' => 'Your question has been sent, thanks for your question ! '
                    );
                } else {
                    $return = array (
                        'status' => 0,
                        'data' => 'The Network is busy, please try again ! '

                    );

                }

            } else {
                $return = array (
                    'status' => 0,
                    'data' => 'Please complete each item of the form ! '

                );
            }
            $this->ajaxReturn($return);
        } else {

            $this->error('Invalid Access Request. System has denied !', '', 3);
        }

    }

    public function wishlist()
    {
        if (IS_POST) {
            $gid = I('gid', '', 'intval');
            $uid = session('member.uid') ? session('member.uid')  : 0 ;
            if ($gid > 0 && $uid > 0) {
                if (M('wishlist')->where(array ('uid' => $uid, 'gid' => $gid))->delete()) {
                    //商品表的收藏数减去1
                    M('goods')->where(array ('id' => $gid))->setDec('wishlist', 1);
                    $return = array (
                        'status' => 1,
                        'data' => 'successful ！'
                    );
                } else {
                    $return = array (
                        'status' => 0,
                        'data' => 'System is busy, please try again later ！'
                    );
                }
            } else {
                $return = array (
                    'status' => 0,
                    'data' => 'Something occured, please refresh the page and try again ！'
                );
            }
            $this->ajaxReturn($return, 'json');
            exit;
        }
        if (session('member')) {
            $uid = session('member.uid');
            $field = 'b.id,b.goodsimg,b.goodsname,b.goodslink,b.price,b.favnum,b.score';
            $where = 'a.gid=b.id AND a.uid=' . $uid;
            $order = 'a.addtime DESC';
            $wishlists = M()
                ->table('__WISHLIST__ as a, __GOODS__ as b')
                ->field($field)
                ->where($where)
                ->order($order)
                ->select();
        } else {
            $wishlists = 'unlogin';
        }
        //找出推荐商品
        //获取被推荐的商品
        $recommendGoods = M('goods')
            ->field('id, goodsname,goodslink,goodsimg,click,price,score,favnum')
            ->where(array ('isrecommend' => 1, 'isshow' => 1))
            ->order('click DESC')
            ->limit(15)
            ->select();

        $pageinfo = array (
            'pagetitle' => 'Shopping Cart',
            'breadcrumb' => array ('wishlist')
        );

        $this->wishlists = $wishlists;
        $this->recommends = $recommendGoods;
        $this->pageinfo = $pageinfo;
        $this->display();
    }

    public function ajaxGetCartList()
    {
        if (! IS_POST || ! IS_AJAX) {
            $this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !', '', 5);
            exit;
        }
        $cartlist = null;
        $totalPrice = '0.00';
        $count = 0;
        if (session('member.uid')) {
            $uid = session('member.uid');
            $field = 'b.goodsimg,b.goodsname, b.price,b.id, b.goodslink';
            $where = 'a.gid=b.id AND a.uid=' . $uid;
            $order = 'a.id DESC';
            $limit = 4;
            $cartCount = M('wishlist')->where(array ('uid' => $uid))->count();
            $cartlist = M()
                ->table('__WISHLIST__ as a, __GOODS__ as b')
                ->field($field)
                ->where($where)
                ->order($order)
                ->limit($limit)
                ->select();
        }
        if ($cartlist) {
            foreach ($cartlist as $goods) {
                $totalPrice += $goods[ 'price' ];
            }
            $count = count($cartlist);
            $totalPrice = $totalPrice;
        }
        $this->cartlist = $cartlist;
        $this->totalPrice = $totalPrice;
        $this->count = $count;
        $html = $this->fetch('Public/cartlist');
        $this->ajaxReturn(array ('data' => $html));
    }

    /**
     * ajax加入购物车
     */
    public function ajaxCart()
    {
        if (! IS_POST || ! IS_AJAX) {
            $this->error('Access Denyed By The Server, Because A Problem Has Occured By Your Accessing !', '', 5);
            exit;
        }

        if (session('member')) {
            $data[ 'gid' ] = I('gid', '', 'intval');
            $data[ 'uid' ] = session('member.uid');
            if ($data[ 'gid' ] > 0 && $data[ 'uid' ] > 0) {
                $wishDB = M('wishlist');
                if ($wishDB->where(array ('gid' => $data[ 'gid' ], 'uid' => $data[ 'uid' ]))->count() > 0) {
                    $return = array (
                        'status' => 2,
                        'data' => 'Product existed !'
                    );
                } else {
                    $data[ 'addtime' ] = time();
                    if ($newID = $wishDB->add($data)) {
                        M('goods')->where(array ('id' => $data[ 'gid' ]))->setInc('favnum', 1);
                        $return = array (
                            'status' => 1,
                            'data' => 'Product successfully added  !'
                        );
                    } else {
                        $return = array (
                            'status' => 0,
                            'data' => 'Add Failed, please try again later !'
                        );
                    }
                }
            } else {
                $return = array (
                    'status' => 0,
                    'data' => 'Network busy now !'
                );
            }
        } else {
            $return = array (
                'status' => 3,
                'url' => U('Member/login'),
                'data' => 'Please sigin in firstly !<br /> &gt;&gt;&gt; Redirecting to Login page !'
            );
        }

        $this->ajaxReturn($return, 'json');
    }
}