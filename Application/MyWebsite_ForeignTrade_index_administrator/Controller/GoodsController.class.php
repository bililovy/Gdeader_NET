<?php
/**
 * 页面功能简述： 产品管理控制器
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
 * 更新日期：2015-11-17
 *
 */
namespace MyWebsite_ForeignTrade_index_administrator\Controller;

use MyWebsite_ForeignTrade_index_administrator\Controller\PrivilegeController;

class GoodsController extends PrivilegeController
{
    /**
     * 产品列表
     * (non-PHPdoc)
     * @see MyWebsite_ForeignTrade_index_administrator\Controller.EmptyController::index()
     */
    public function index()
    {
        import('Extensions.Page', COMMON_PATH);
        $where = '';
        $count = M('goods')->count();
        $page = new \Page ($count, 10, $_GET [ 'p' ], '?p={page}');
        $limit = $page->page_limit . "," . $page->myde_size;
        $where = ' a.cateid=b.id';
        $field = 'a.goodsimg, a.goodsname, a.cateid, b.catename, a.addtime,a.isnew,a.isshow, a.isrecommend, a.click, a.sortorder,a.id';
        $order = 'a.sortorder ASC, a.addtime DESC';
        $this->goods = M()
            ->table('__GOODS__ as a, __CATEGORY__ as b')
            ->field($field)
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->select();
        $this->page = $page->myde_write();
        $this->display('goods_list');
    }

    /**
     * 产品添加
     */
    public function add()
    {
        $DB_cat = M('category');
        $DB_attr = M('attribute');
        if ($DB_cat->count() <= 0) {
            $this->isAddUsed = false;
        } else {
            $this->isAddUsed = true;
            $DB = M('goodsalbum');
            $this->goodsalbums = $DB->field('imgrealpath', true)
                ->where(array ('goodsid' => 0))
                ->order('id DESC')
                ->select();
            $cats = $DB_cat->field('id,parentid, catename')->order('sortorder ASC')->select();
            $this->cats = getTreeString($cats);
            $this->attrs = $DB_attr->field('id,attrname')->order('sortorder ASC')->select();
            $this->sessionid = session_id();
        }
        $this->display('goods_add');
    }

    /**
     * 产品基本信息数据添加
     */
    public function goodsAdd()
    {
        if (IS_POST) {
            $data = I('post.');
            //替换封面图地址
            $coverimg = M('goodsalbum')->field('id, imgpath')->where(array ('id' => $data[ 'goodsimg' ]))->find();
            if ($coverimg) {
                $data[ 'goodsimg' ] = $coverimg[ 'imgpath' ];
            } else {
                $data[ 'goodsimg' ] = '/assets/library/images/goods/defaut.jpg';
            }
            $data[ 'addtime' ] = time();
            if ($newID = M('goods')->add($data)) {
                session('goodsid', $newID);
                //更新相册设置封面
                M('goodsalbum')->where(array ('id' => $coverimg[ 'id' ]))->setField(array ('iscover' => 1));
                M('goodsalbum')->where(array ('goodsid' => 0))->setField('goodsid', $newID);
                $return = array (
                    'data' => '成功添加产品',
                    'redirecturl' => U('index'),
                    'status' => 1
                );
            } else {
                $return = array (
                    'data' => '网络繁忙，产品添加失败，请稍后再试！',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此次操作，请通过合法途径访问此页面', '', 5);;
        }
    }

    /**
     * 编辑产品
     */
    public function edit()
    {
        $gid = I('gid', 0, 'intval');
        if ($gid > 0) {
            $cats = M('category')->order('sortorder ASC')->select();
            $this->cats = getTreeString($cats);
            $this->curcate = $cid;
            $this->goods = M('goods')->where(array ('id' => $gid))->find();
            $this->goodsalbums = M('goodsalbum')->where(array ('goodsid' => $gid))->select();
            $this->sessionid = session_id();
            $this->display('goods_edit');
        } else {
            $this->error('页面参数错误，请返回重新操作！', '', 5);
        }
    }

    /**
     * 产品数据编辑
     */
    public function goodsEdit()
    {
        if (IS_POST) {
            $data = I('post.');
            //如果更改了分类，则清除产品的属性
            $oricate = M('goods')->field('cateid')->where(array ('id' => $data[ 'id' ]))->find();
            if ($oricate[ 'cateid' ] != $data[ 'cateid' ]) {
                //清理掉属性
                M('goodsattr')->where(array ('goodsid' => $data[ 'id' ]))->delete();
            }
            //替换封面图地址
            $coverimg = M('goodsalbum')->field('id, imgpath')->where(array ('id' => $data[ 'goodsimg' ]))->find();
            if ($coverimg) {
                $data[ 'goodsimg' ] = $coverimg[ 'imgpath' ];
            } else {
                $data[ 'goodsimg' ] = '/assets/library/images/goods/defaut.jpg';
            }
            $data[ 'updatetime' ] = time();
            // 			dump($data);die;
            if ($effect = M('goods')->save($data)) {
                //更新相册设置封面
                M('goodsalbum')->where(array ('goodsid' => $data[ 'id' ]))->setField('iscover', 0);
                M('goodsalbum')->where(array ('id' => $coverimg[ 'id' ]))->setField(array ('iscover' => 1));
                M('goodsalbum')->where(array ('goodsid' => 0))->setField('goodsid', $data[ 'id' ]);
                $return = array (
                    'data' => '成功更新产品',
                    'redirecturl' => U('index'),
                    'status' => 1
                );
            } else {
                $return = array (
                    'data' => '网络繁忙，产品信息更新失败，请稍后再试！',
                    'status' => 0
                );
            }

            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此次操作，请通过合法途径访问此页面', '', 5);
        }
    }

    /**
     * 根据分类id获取属性
     */
    public function getAttrlistByCate()
    {
        if (IS_POST) {
            $cid = I('cid', 0, 'intval');
            if ($cid > 0) {
                $attrs = M('attribute')->field('sortorder,cateid', true)->where(array ('cateid' => $cid))->select();
                if ($attrs) {
                    $html = '<form name="goodsattr" class="goodsattr" action="' . U('goodsAttr') . '" method="post" >';
                    $html .= '<p style="margin-bottom: 10px;">请在下面设置此商品的属性</p><input type="hidden" name="cateid" value="' . $cid . '"/><input type="hidden" name="action" value="addAttr"/>';
                    foreach ($attrs as $key => $val) {
                        $attrvalues = explode('|', $val[ 'attrvalues' ]);
                        $html .= '<div class="dataline" style="position:relative;  margin: 5px 0;">';
                        $html .= '<input type="hidden" name="attrid[]" value="' . $val[ 'id' ] . '"/>';
                        $html .= '<span style="line-height: 30px;display: block; text-align: center; width: 100px;float: left;color: #666;font-weight:bold;">' . $val[ 'attrname' ] . '</span>';
                        if ($val[ 'attrinputtype' ] == 1) {
                            //单选
                            $html .= '<select name="attrvalue[]"><option value="">--选择' . $val[ 'attrname' ] . '值--</option>';
                            foreach ($attrvalues as $v) {
                                $html .= '<option value="' . $v . '">' . $v . '</option>';
                            }
                            $html .= '</select>';
                        } else if ($val[ 'attrinputtype' ] == 3) {
                            //多选
                            $html .= '<input class="multivalue" type="hidden" name="attrvalue[]" />';
                            foreach ($attrvalues as $v) {
                                $html .= '<span onclick="setValue(this)"  onmouseover="setAttrPrice(this)" style="display: inline-block;padding: 5px 8px;  margin: 3px 5px;background: none; border: 1px solid #009FB3; color: #666;cursor:pointer;" data-value="' . $v . '" picked="0">' . $v . '</span>';
                            }
                        } else {
                            //手动输入
                            $html .= '<input type="text" name="attrvalue[]" style="height: 30px; border: 1px solid #b7b7b7;padding: 0 5px;" /><i>如果有多个值，请用“|”隔开</i>';
                        }
                        $html .= '</div>';
                    }
                    $html .= '</form>';
                } else {
                    $html .= '<p style="line-height: 35px;color: #666;">此分类下还没有可用属性，请<a href="' . U('attrAdd',
                            array ('cid' => $cid)) . '" style="padding: 5px 8px; color: #FFF; background: #009FB3;margin: 0 5px;">点击这里设置属性</a></p>';
                }
                $return = array (
                    'data' => $html,
                    'status' => 1
                );
            } else {
                $return = array (
                    'data' => '系统未检测到可用参数，属性获取失败!',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此次请求，请通过正确途径访问页面！', '', 5);
        }
    }

    /**
     * 根据产品id获取此产品属性
     */
    public function getAttrlistByGID()
    {
        if (IS_POST) {
            $cid = I('cid', 0, 'intval');
            $gid = I('gid', 0, 'intval');
            if ($gid <= 0 && $cid <= 0) {
                $return = array (
                    'data' => '系统未检测到可用参数，属性获取失败!',
                    'status' => 0
                );
                $this->ajaxReturn($return, 'json');
                exit;
            } else {
                $addnew = false;
                $field = 'a.id,a.attrname,a.cateid,a.attrinputtype, a.attrvalues,b.attrvalue';
                $where = 'a.id=b.attrid AND b.goodsid=' . $gid;
                $attrs = M()->table('__ATTRIBUTE__ as a, __GOODSATTR__ as b')->field($field)->where($where)->select();
                if (! attrs || ($cid > 0 && $attrs[ 0 ][ 'cateid' ] != $cid)) {
                    $attrs = M('attribute')->field('sortorder,cateid', true)->where(array ('cateid' => $cid))->select();
                    $addnew = true;
                }
            }
            if ($attrs) {
                $html = '<form name="goodsattr" class="goodsattr" action="' . U('goodsAttr') . '" method="post" >';
                if ($addnew) {
                    $html .= '<input type="hidden" name="action" value="addAttr"/><input type="hidden" name="gid" value="' . $gid . '"/><input type="hidden" name="cateid" value="' . $cid . '"/>';
                } else {
                    $html .= '<input type="hidden" name="action" value="editAttr"/><input type="hidden" name="gid" value="' . $gid . '"/><input type="hidden" name="cateid" value="' . $attrs[ 0 ][ 'cateid' ] . '"/>';
                }
                $html .= '<p style="margin-bottom: 10px;">请在下面设置此商品的属性</p>';
                foreach ($attrs as $key => $val) {
                    $attrvalues = array_empty_filter(explode('|', $val[ 'attrvalues' ]));
                    $html .= '<div class="dataline" style="position:relative;  margin: 5px 0;">';
                    $html .= '<input type="hidden" name="attrid[]" value="' . $val[ 'id' ] . '"/>';
                    $html .= '<span style="line-height: 30px;display: block; text-align: center; width: 100px;float: left;color: #666;font-weight:bold;">' . $val[ 'attrname' ] . '</span>';
                    if ($val[ 'attrinputtype' ] == 1) {
                        //单选
                        $html .= '<select name="attrvalue[]"><option value="">--选择' . $val[ 'attrname' ] . '值--</option>';
                        foreach ($attrvalues as $v) {
                            if ($v == $val[ 'attrvalue' ]) {
                                $html .= '<option value="' . $v . '" selected="selected" picked="1">' . $v . '</option>';
                            } else {
                                $html .= '<option value="' . $v . '">' . $v . '</option>';
                            }
                        }
                        $html .= '</select>';
                    } else if ($val[ 'attrinputtype' ] == 3) {
                        $attrvalue = array_empty_filter(explode('|',
                            preg_replace('/@([0-9]*(\\.[0-9]{1,2})?)/', '', $val[ 'attrvalue' ])));
                        //多选
                        $html .= '<input class="multivalue" type="hidden" name="attrvalue[]" value="' . $val[ 'attrvalue' ] . '" />';
                        foreach ($attrvalues as $v) {

                            if (in_array($v, $attrvalue)) {
                                $html .= '<span onclick="setValue(this)" onmouseover="setAttrPrice(this)" style="display: inline-block;padding: 5px 8px;  margin: 3px 5px;background: #009FB3; border: 1px solid #009FB3; color: #FFF;cursor:pointer;" data-value="' . $v . '" picked="1">' . $v . '</span>';
                            } else {
                                $html .= '<span onclick="setValue(this)" onmouseover="setAttrPrice(this)" style="display: inline-block;padding: 5px 8px;  margin: 3px 5px;background: none; border: 1px solid #009FB3; color: #666;cursor:pointer;" data-value="' . $v . '" picked="0">' . $v . '</span>';
                            }
                        }
                    } else {
                        //手动输入
                        $html .= '<input type="text" name="attrvalue[]" style="height: 30px; border: 1px solid #b7b7b7;padding: 0 5px;" value="' . $val[ 'attrvalue' ] . '" /><i>如果有多个值，请用“|”隔开</i>';
                    }
                    $html .= '</div>';
                }
                $html .= '</form>';
            } else {
                $html .= '<p style="line-height: 35px;color: #666;">此分类下还没有可用属性，请<a href="' . U('attrAdd',
                        array ('cid' => $cid)) . '" style="padding: 5px 8px; color: #FFF; background: #009FB3;margin: 0 5px;">点击这里设置属性</a></p>';
            }
            $return = array (
                'data' => $html,
                'status' => 1
            );
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此次请求，请通过正确途径访问页面！', '', 5);
        }
    }

    /**
     * 产品属性处理地址
     */
    public function goodsAttr()
    {
        $data = I('post.');
        $goodsid = 0;
        if (session('goodsid')) {
            $goodsid = intval(session('goodsid'));
        } else {
            $goodsid = intval($data[ 'gid' ]);
        }
        if ($goodsid <= 0 || empty($goodsid)) {
            $this->error('数据异常，无法获取产品主键信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！', '', 10);
            exit;
        }
        if ($data[ 'cateid' ] <= 0) {
            $this->error('数据异常，无法获取产品分类信息，此产品属性设置失败，请返回重新尝试编辑此商品属性即可！', '', 10);
            exit;
        }
        $cateid = $data[ 'cateid' ];
        $dataArray = array ();
        foreach ($data[ 'attrid' ] as $key => $attrid) {
            $dataArray[ $key ][ 'attrid' ] = $attrid;
            $dataArray[ $key ][ 'goodsid' ] = $goodsid;
            $dataArray[ $key ][ 'cateid' ] = $cateid;
            $dataArray[ $key ][ 'updatetime' ] = time();
        }
        foreach ($data[ 'attrvalue' ] as $key => $attrval) {
            $dataArray[ $key ][ 'attrvalue' ] = $attrval;
        }
        if ($data[ 'action' ] == 'addAttr') {
            if ($newID = M('goodsattr')->addAll($dataArray)) {
                if (session('goodsid')) {
                    session('goodsid', null);
                    $this->success('成功添加一个产品，正在转回产品列表', U('index'), 4);
                } else {
                    $this->success('成功更新产品信息，正在转回产品列表', U('index'), 4);
                }
                exit;
            } else {
                $this->error('网络繁忙或中断导致此产品属性添加失败，请返回产品列表并重新编辑此商品属性即可！', '', 10);
            }
        } else if ($data[ 'action' ] == 'editAttr') {
            $isAllUpdate = true;
            foreach ($dataArray as $dataRow) {
                if (! M('goodsattr')
                    ->where(array ('goodsid' => $goodsid, 'attrid' => $dataRow[ 'attrid' ]))
                    ->setField($dataRow)
                ) {
                    $isAllUpdate = false;
                }
            }
            if (! $isAllUpdate) {
                $this->error('网络繁忙或中断导致此产品属性更新失败，请返回产品列表并重新编辑此商品属性即可！', '', 10);
            } else {
                $this->success('成功更新产品信息，正在转回产品列表', U('index'), 4);
            }
        }
    }

    /**
     * goodsToggle 切换显示状态
     */
    public function goodsToggle()
    {
        if (IS_POST) {
            $data = I('post.', '');
            if ($data[ 'id' ] > 0) {
                if (M('goods')->save($data)) {
                    $return = array (
                        'data' => '切换成功！',
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '系统繁忙，切换失败！',
                        'status' => 0
                    );
                }
            } else {

                $return = array (
                    'data' => '系统为检测到必需参数，请刷新页面重新尝试！',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此次访问，请通过合法方式访问本页面，正在为您重置到之前页面！', '', 5);
        }
    }

    /**
     * 删除goods
     */
    public function goodsTrash()
    {
        if (IS_POST) {
            $gid = I('gid', 0, 'intval');
            if ($gid > 0) {
                //删除商品本身信息、 相册图片、商品属性
                if (M('goods')->delete($gid)) {
                    $goodsimgs = M('goodsalbum')->field('imgrealpath')->where(array ('goodsid' => $gid))->select();
                    foreach ($goodsimgs as $val) {
                        @unlink($val[ 'imgrealpath' ]);
                    }
                    M('goodsalbum')->where(array ('goodsid' => $gid))->delete();
                    M('goodsattr')->where(array ('goodsid' => $gid))->delete();
                    $return = array (
                        'data' => U('index'),
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '网络繁忙，删除失败！',
                        'status' => 0
                    );
                }
            } else {
                $return = array (
                    'data' => '系统为检测到必需参数，请刷新页面重新尝试！',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此次访问，请通过合法方式访问本页面，正在为您重置到之前页面！', '', 5);
        }
    }

    /**
     * 产品分类
     */
    public function category()
    {
        $DB = M('category');
        $order = 'sortorder ASC';
        $where = '';
        $catelists = $DB->field('description,keywords', true)->where($where)->order($order)->select();
        $catelists = getTreeString($catelists, 0, 0, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        $this->catelists = $catelists;
        $this->display('cate_list');
    }

    /**
     * 产品分类添加
     */
    public function cateAdd()
    {
        $DB = D('category');
        if (IS_POST) {
            $data = I('post.');
            if ($DB->create($data)) {
                //判断该类是否为三级以下 是则不允许添加 只能添加三级
                $pid = $data[ 'parentid' ];
                $parentid = $DB->field('parentid')->where(array ('id' => $pid))->find();
                if ($parentid[ 'parentid' ] > 0) {
                    $topPID = $DB->field('parentid')->where(array ('id' => $parentid[ 'parentid' ]))->find();
                }
                if ($topPID[ 'parentid' ] > 0) {
                    $return = array (
                        'data' => '当前系统限制为最多设置3级分类，因此该分类下无法再增加分类，请添加到其他分类！',
                        'waittime' => 5,
                        'status' => 0
                    );
                    $this->ajaxReturn($return, 'json');
                    exit;
                }
                if (isset($_SESSION[ 'coverrealpath' ]) && ! empty($_SESSION[ 'coverrealpath' ])) {
                    $data[ 'coverrealpath' ] = session('coverrealpath');
                }
                if (empty($data[ 'cover' ]) || ! isset($data[ 'cover' ])) {
                    if (isset($_SESSION[ 'cover' ]) && ! empty($_SESSION[ 'cover' ])) {
                        $data[ 'cover' ] = session('cover');
                    } else {
                        $data[ 'cover' ] = '/assets/common/images/icons/default_cate_img.jpg';
                    }
                }
                if ($newID = $DB->add($data)) {
                    session('cover', null);
                    session('coverrealpath', null);
                    $return = array (
                        'data' => '成功添加一个分类',
                        'redirecturl' => U('category'),
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '系统繁忙，分类添加失败，请稍候再试！',
                        'status' => 0
                    );
                }
            } else {
                $return = array (
                    'data' => $DB->getError(),
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
            exit;
        }
        $cates = $DB->field('id, catename,parentid')->order('sortorder ASC, id DESC')->select();
        $cates = getTreeString($cates, 0, 0, '&nbsp;&nbsp;&nbsp;');
        $this->cates = $cates;
        $this->display('cate_add');
    }

    /**
     * 分类编辑
     */
    public function cateEdit()
    {
        $DB = D('category');
        if (IS_POST) {
            $data = I('post.');
            if ($DB->create($data)) {
                //判断是否为当前分类
                if ($data[ 'parentid' ] == $data[ 'id' ]) {
                    $return = array (
                        'data' => '发生错误操作！该分类无法移动到自身分类下，请重新选择其他分类！',
                        'status' => 0
                    );
                    $this->ajaxReturn($return, 'json');
                    exit;
                }
                //判断该类是否为三级以下 是则不允许添加 只能添加三级
                $pid = $data[ 'parentid' ];
                $parentid = $DB->field('parentid')->where(array ('id' => $pid))->find();
                if ($parentid[ 'parentid' ] > 0) {
                    $topPID = $DB->field('parentid')->where(array ('id' => $parentid[ 'parentid' ]))->find();
                }
                if ($topPID[ 'parentid' ] > 0) {
                    $return = array (
                        'data' => '当前系统限制为最多设置3级分类，因此该分类下无法再增加分类，请重新设置！',
                        'status' => 0
                    );
                    $this->ajaxReturn($return, 'json');
                    exit;
                }
                if (isset($_SESSION[ 'coverrealpath' ]) && ! empty($_SESSION[ 'coverrealpath' ])) {
                    $realpath = M('news')->field('coverrealpath')->where(array ('id' => $data[ 'id' ]))->find();
                    $data[ 'coverrealpath' ] = session('coverrealpath');
                }
                if (empty($data[ 'cover' ]) || ! isset($data[ 'cover' ])) {
                    if (isset($_SESSION[ 'cover' ]) && ! empty($_SESSION[ 'cover' ])) {
                        $data[ 'cover' ] = session('cover');
                    } else {
                        $data[ 'cover' ] = '/assets/common/images/icons/default_cate_img.jpg';
                    }
                }
                if ($newID = $DB->save($data)) {
                    if (! empty($realpath[ 'coverrealpath' ])) {
                        @unlink($realpath[ 'coverrealpath' ]);
                    }
                    session('cover', null);
                    session('coverrealpath', null);
                    $return = array (
                        'data' => '成功更新一个分类',
                        'redirecturl' => U('category'),
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '分类更新失败，请确定是否有数据被更改，并稍候再试！',
                        'status' => 0
                    );
                }
            } else {
                $return = array (
                    'data' => $DB->getError(),
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
            exit;
        }

        $cateid = I('cid', 0, 'intval');
        if ($cateid > 0) {
            $category = $DB->where(array ('id' => $cateid))->find();
            $this->curcateid = $category[ 'parentid' ];
            $cates = $DB->field('id, catename,parentid')->order('sortorder ASC, id DESC')->select();
            $cates = getTreeString($cates, 0, 0, '&nbsp;&nbsp;&nbsp;');
            $this->cates = $cates;
            $this->category = $category;
            $this->display('cate_edit');
        } else {
            $this->error('抱歉，系统无法识别此次操作的参数，访问被拒绝，请返回重新操作！', '', 5);
        }
    }

    /**
     * 分类删除
     */
    public function cateTrash()
    {
        if (IS_POST) {
            $cid = I('cid', 0, 'intval');
            if ($cid > 0) {
                if (M('goods')->where(array ('cateid' => $cid))->count() > 0) {
                    $return = array (
                        'data' => '当前分类下还有商品，要删除此分类，请先移动或删除分类下的商品',
                        'status' => 0
                    );
                } else {
                    if (M('category')->where(array ('parentid' => $cid))->count() > 0) {
                        $return = array (
                            'data' => '当前分类下还有子分类，无法直接删除，要删除，请先删除下面子分类，或者移动子分类到其他分类！',
                            'status' => 0
                        );
                    } else {
                        //执行操作
                        if (M('category')->delete($cid)) {
                            $return = array (
                                'data' => '删除成功',
                                'status' => 1
                            );
                        } else {
                            $return = array (
                                'data' => '系统繁忙，删除失败',
                                'status' => 0
                            );
                        }
                    }
                }
            } else {
                $return = array (
                    'data' => '系统无法识别操作参数，请刷新重试！',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此访问，请通过合法途径访问页面!', '', 3);
        }
    }

    /**
     * 分类显示/不显示切换
     */
    public function cateShowToggle()
    {
        if (IS_POST) {
            $cid = I('cid', 0, 'intval');
            $isshow = I('isshow', 0, 'intval');
            $type = I('datatype', '');
            $DB = M('category');
            switch ($type) {
                case 'showinnav':
                    $data[ 'id' ] = $cid;
                    $data[ 'showinnav' ] = $isshow;
                    if ($DB->save($data)) {
                        $return = array (
                            'data' => '更新成功！',
                            'status' => 1
                        );
                    } else {
                        $return = array (
                            'data' => '系统繁忙，更新失败！',
                            'status' => 0
                        );
                    }
                break;
                case 'isshow':
                    $data[ 'id' ] = $cid;
                    $data[ 'isshow' ] = $isshow;
                    if ($DB->save($data)) {
                        $return = array (
                            'data' => '更新成功！',
                            'status' => 1
                        );
                    } else {
                        $return = array (
                            'data' => '系统繁忙，更新失败！',
                            'status' => 0
                        );
                    }
                break;
                default:
                    $return = array (
                        'data' => '系统无法识别操作参数，请刷新重试！',
                        'status' => 0
                    );
            }
            $this->ajaxReturn($return, 'json');
        } else {
            $this->error('系统拒绝此访问，请通过合法途径访问页面!', '', 3);
        }
    }

    /**
     * 产品属性
     */
    public function attribute()
    {
        import('Extensions.Page', COMMON_PATH);
        $where = ' a.cateid=b.id';
        $count = M('attribute')->count();
        $page = new \Page ($count, 10, $_GET [ 'p' ], '?p={page}');
        $limit = $page->page_limit . "," . $page->myde_size;
        $field = 'a.*, b.catename';
        $this->attrs = M()
            ->table('__ATTRIBUTE__ as a, __CATEGORY__ as b')
            ->field($field)
            ->where($where)
            ->order('a.sortorder ASC')
            ->limit($limit)
            ->select();
        $this->page = $page->myde_write();
        $this->display('attr_list');
    }

    /**
     * 产品属性添加
     */
    public function attrAdd()
    {
        if (IS_POST) {
            $data = I('post.');
            $DB = M('attribute');
            if ($newID = $DB->add($data)) {
                $return = array (
                    'data' => '成功添加一个属性',
                    'redirecturl' => U('attribute'),
                    'status' => 1
                );
            } else {
                $return = array (
                    'data' => '系统繁忙，属性添加失败，请稍后再试！',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
            exit;
        }
        $cid = I('cid', 0, 'intval');
        $DB = M('category');
        if ($cates = $DB->field('id,parentid,catename')->order('sortorder ASC')->select()) {
            $this->isAddUsed = true;
        } else {
            $this->isAddUsed = false;
        }
        $this->cid = $cid;
        $cates = getTreeString($cates);
        $this->cates = $cates;
        $this->display('attr_add');
    }

    /**
     * 属性编辑
     */
    public function attrEdit()
    {
        $aid = I('aid', 0, 'intval');
        if ($aid > 0) {
            if (IS_POST) {
                $data = I('post.');
                unset($data[ 'aid' ]);
                if (M('attribute')->where(array ('id' => $aid))->save($data)) {
                    $return = array (
                        'data' => '更新成功！',
                        'redirecturl' => U('attribute'),
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '更新失败，请确认是否有数据被修改并重新尝试！',
                        'status' => 0
                    );
                }
                $this->ajaxReturn($return, 'json');
                exit;
            }

            $cates = M('category')->order('sortorder ASC ')->select();
            $this->cates = getTreeString($cates);
            $this->attr = M('attribute')->where(array ('id' => $aid))->find();
            $this->display('attr_edit');
        } else {
            $this->error('系统未检测到必需参数，此次操作被拒绝，请返回重新尝试！', '', 5);
        }
    }

    /**
     * 属性克隆
     */
    public function AttrClone()
    {
        $aid = I('aid', 0, 'intval');
        if ($aid > 0) {
            if (IS_POST) {
                $data = I('post.');
                if ($data[ 'origincateid' ] == $data[ 'cateid' ]) {
                    $return = array (
                        'data' => '复制失败，原分类与复制到的分类相同，无法复制！<br />请选择与当前分类不同的分类复制。',
                        'status' => 0,
                        'waittime' => 5
                    );
                } else {
                    if (M('attribute')->add($data)) {
                        $return = array (
                            'data' => '成功复制该属性！',
                            'redirecturl' => U('attribute'),
                            'status' => 1
                        );
                    } else {
                        $return = array (
                            'data' => '复制失败，请确认是否有数据被修改并重新尝试！',
                            'status' => 0
                        );
                    }
                }
                $this->ajaxReturn($return, 'json');
                exit;
            }

            $cates = M('category')->order('sortorder ASC ')->select();
            $this->cates = getTreeString($cates);
            $this->attr = M('attribute')->where(array ('id' => $aid))->find();
            $this->display('attr_clone');
        } else {
            $this->error('系统未检测到必需参数，此次操作被拒绝，请返回重新尝试！', '', 5);
        }
    }

    /**
     * 属性删除
     */
    public function attrDel()
    {
        if (IS_POST) {
            $aid = I('aid', 0, 'intval');
            if ($aid > 0) {
                if (M('attribute')->delete($aid)) {
                    $return = array (
                        'data' => U('attribute'),
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '网络繁忙，删除失败，请稍候重试！',
                        'status' => 0
                    );
                }
            } else {
                $return = array (
                    'data' => '系统未查询到此次操作的必需参数，请刷新重试！',
                    'status' => 0
                );
            }
            $this->ajaxReturn($return, 'json');
            exit;
        } else {
            $this->error('系统拒绝此次访问，请通过正确途径访问！', '', 5);
        }
    }


    /************************** BEGIN 评论模块管理************************/

    /**
     * 新闻评论列表
     *
     * 操作相关的还有 goods_faq表 每天加一条评论 就要判断评论的新闻id是否再此表里，如果没有则添加
     *
     */

    public function faq()
    {

        import('Extensions.Page', COMMON_PATH);
        $where = true;
        $count = M('goods_faq')->where($where)->count();
        $page = new \Page ($count, 10, $_GET [ 'p' ], '?p={page}');
        $limit = $page->page_limit . "," . $page->myde_size;
        $goods_faq = M('goods_faq')->limit($limit)->select();
        $this->page = $page->myde_write();

        ///////////////////////////////////

        $faq_list = array ();

        foreach ($goods_faq as $faq) {

            $faq_list[ $faq[ 'gid' ] ][ 'allcount' ] = M('goods_faq_content')
                ->where(array ('gid' => $faq[ 'gid' ]))
                ->count();

            $faq_list[ $faq[ 'gid' ] ][ 'allunreleased' ] = M('goods_faq_content')->where(array (
                'gid' => $faq[ 'gid' ],
                'isreleased' => 0
            ))->count();

            $where = 'a.gid=b.id AND a.gid=' . $faq[ 'gid' ];

            $fields = 'a.id,a.reviewer, a.addtime, a.content, b.goodsname';

            $commentinfo = M()
                ->table('ft_goods_faq_content as a, ft_goods as b')
                ->field($fields)
                ->where($where)
                ->order('a.addtime DESC')
                ->find();

            $faq_list[ $faq[ 'gid' ] ][ 'goodsname' ] = $commentinfo[ 'goodsname' ];

            $faq_list[ $faq[ 'gid' ] ][ 'faqid' ] = $commentinfo[ 'id' ];

            $faq_list[ $faq[ 'gid' ] ][ 'reviewer' ] = $commentinfo[ 'reviewer' ];

            $faq_list[ $faq[ 'gid' ] ][ 'addtime' ] = date('Y-m-d H:i', $commentinfo[ 'addtime' ]);

            $faq_list[ $faq[ 'gid' ] ][ 'content' ] = $commentinfo[ 'content' ];

        }

        $this->page = $page->myde_write();

        $this->faqs = $faq_list;

        $this->display('goods_FAQ_list');

    }

    /**
     * 评论内容展示
     */

    public function faqDetail()
    {

        $gid = I('gid', 0, 'intval');

        if ($gid <= 0) {

            $this->error('当前操作缺少参数，请返回重新刷新页面尝试！');

            exit;

        }


        import('Extensions.Page', COMMON_PATH);
        $count = M('goods_faq_content')->where(array ('gid' => $gid))->count();
        $page = new \Page ($count, 15, $_GET [ 'p' ], '?p={page}');
        $limit = $page->page_limit . "," . $page->myde_size;

        $comments = M('goods_faq_content')
            ->where(array ('gid' => $gid))
            ->limit($limit)
            ->order('addtime DESC')
            ->select();

        $goods_name = M('goods')->field('goodsname')->where(array ('id' => $gid))->find();

        if ($comments) {

            foreach ($comments as & $comment) {

                $comment[ 'addtime' ] = date('Y-m-d H:i:s', $comment[ 'addtime' ]);

                if ($comment[ 'replytime' ] != 0) {

                    $comment[ 'replytime' ] = date('Y-m-d H:i:s', $comment[ 'replytime' ]);

                }

            }

        } else {

            $comments = false;

        }

        $this->comments = $comments;

        $this->goodsname = $goods_name[ 'goodsname' ];

        $this->page = $page->myde_write();

        $this->gid = $gid;

        $this->faqCount = $count;

        $this->display('goods_FAQ_detail');

    }

    /**
     * 评论回复添加
     */
    public function setFAQReply()
    {

        $comid = I('faqid', 0, 'intval');

        $replycontent = I('replycontent', '');

        if ($comid <= 0) {

            $return = array (
                'data' => '操作缺少必须参数，请刷新页面重试 !',
                'status' => 0
            );
            $this->ajaxReturn($return);
            exit;
        }

        if (empty($replycontent)) {
            $return = array (
                'data' => '请输入5个字以上的回复并再次提交 !',
                'status' => 0
            );

            $this->ajaxReturn($return);
            exit;

        }

        $data[ 'replycontent' ] = $replycontent;

        $data[ 'replyer' ] = session('login_infos.username') ? session('login_infos.username') : 'Administrator';

        $data[ 'id' ] = $comid;

        $data[ 'replytime' ] = time();

        if ($affect = M('goods_faq_content')->save($data)) {

            $return = array (
                'data' => '恭喜，成功回复评论 !',
                'status' => 1
            );
        } else {

            $return = array (
                'data' => '抱歉，评论恢复失败，请稍后再试 !',
                'status' => 0
            );

        }
        $this->ajaxReturn($return);
    }

    /**
     * 审核评论
     */
    public function toReleaseComment()
    {

        $comid = I('commentid', 0, 'intval');

        if ($comid <= 0) {

            $this->ajaxReturn('操作缺少必须参数，请刷新页面重试！', '', 0, 'json');

        }

        $data[ 'isreleased' ] = 1;

        $data[ 'id' ] = $comid;

        if ($affect = M('goods_faq_content')->save($data)) {

            $return = array (
                'data' => '恭喜，审核成功 !',
                'status' => '1'
            );

        } else {

            $return = array (
                'data' => '系统繁忙，审核操作失败，请稍候再次尝试！',
                'status' => 0
            );
        }
        $this->ajaxReturn($return);

    }

    /**
     *  显示切换
     */
    public function commentShowToggle()
    {

        $comid = I('commentid', 0, 'intval');

        $isshow = I('isshow', 0, 'intval');

        if ($comid <= 0) {

            $return = array (
                'data' => '操作缺少必须参数，请刷新页面重试！',
                'status' => 0
            );
            $this->ajaxReturn($return);
            exit;
        }

        //先判断有没有审核 没审核 则该功能不起作用

        if (M('goods_faq_content')->where(array ('isreleased' => 1, 'id' => $comid))->count() <= 0) {

            $return = array (
                'data' => '该评论目前还未通过审核，无法切换显示状态，请先审核评论后再切换显示状态！',
                'status' => 2
            );
            $this->ajaxReturn($return);
            exit;
        }

        $data[ 'isshow' ] = $isshow;

        $data[ 'id' ] = $comid;

        if ($affect = M('goods_faq_content')->save($data)) {
            $return = array (
                'data' => '恭喜，更改成功！',
                'status' => 1
            );
        } else {
            $return = array (
                'data' => '系统繁忙，切换操作失败，请稍候再次尝试！',
                'status' => 0
            );

        }
        $this->ajaxReturn($return);

    }

    /**
     * 删除一条评论
     */
    public function commentDelete()
    {

        $comid = I('commentid', 0, 'intval');

        $gid = I('gid', 0, 'intval');

        if ($comid <= 0 || $gid <= 0) {

            $return = array (
                'data' => '操作缺少必须参数，请刷新页面重试 ！',
                'status' => 0
            );
            $this->ajaxReturn($return);
            exit;
        }

        //删除主评论

        if ($affect = M('goods_faq_content')->delete($comid)) {

            //判断当前新闻下还有多少条评论 如果没有评论了那就把页码表的新闻id删掉

            if (M('goods_faq_content')->where(array ('gid' => $gid))->count() <= 0) {

                M('goods_faq')->where(array ('gid' => $gid))->delete();

            }
            $return = array (
                'data' => '恭喜成功删除一条评论 ！',
                'status' => 1
            );

        } else {
            $return = array (
                'data' => '系统繁忙，评论删除失败，请稍候重试！ ！',
                'status' => 0
            );
        }

        $this->ajaxReturn($return);

    }

    public function replyDelete()
    {

        if (IS_POST && IS_AJAX) {

            $comid = I('commentid', 0, 'intval');

            if ($comid > 0) {

                $data [ 'id' ] = $comid;

                $data[ 'replyer' ] = '';

                $data[ 'replytime' ] = 0;

                $data [ 'replycontent' ] = '';

                if ($affect = M('goods_faq_content')->save($data)) {
                    $return = array (
                        'data' => '回复清理成功 ！',
                        'status' => 1
                    );
                } else {
                    $return = array (
                        'data' => '系统繁忙，评论回复删除失败，请稍候重试！ ！',
                        'status' => 0
                    );
                }
            } else {
                $return = array (
                    'data' => '系统参数错误，请重试！ ！',
                    'status' => 0
                );
            }
        $this->ajaxReturn($return);
        }else{

            $this->error('页面请求被拒绝，请重试！','',3);
        }

    }

    /************************** END 评论模块管理************************/

    /**
     * 产品相册上传
     */
    public function goodsAlbum()
    {
        $count = M('goodsalbum')->where(array ('goodsid' => 0))->count();
        if ($count >= 10) {
            $return = array (
                'data' => '图片数量已经达到最大，若需改动，请先删除部分图片！',
                'status' => 0
            );
            header('Content-Type: text/html;charset=utf-8');
            exit(json_encode($return));
        }
        import("Extensions.UploadFile", COMMON_PATH);
        //导入上传类
        $upload = new \UploadFile();
        //设置上传文件大小
        $upload->maxSize = 4194304; //最大4M
        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $nowdate = date('Ymd', time());
        $upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/goods/' . $nowdate . '/';
        if (! is_dir($upload->savePath)) {
            mk_dir($upload->savePath);
        }
        //设置上传文件规则
        $upload->saveRule = 'uniqid';
        //删除原图
        $upload->thumbRemoveOrigin = true;
        if (! $upload->upload()) {
            //捕获上传异常
            $return = array (
                'data' => $upload->getErrorMsg(),
                'status' => 0
            );
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();

            $realpath = $upload->savePath . $uploadList[ 0 ][ 'savename' ];
            $path = '/assets/library/uploads/image/goods/' . $nowdate . '/' . $uploadList[ 0 ][ 'savename' ];
            $DB = M('goodsalbum');
            $data[ 'goodsid' ] = 0;
            $data[ 'imgpath' ] = $path;
            $data[ 'imgrealpath' ] = $realpath;
            if ($newID = $DB->add($data)) {
                $return = array (
                    'data' => $path,
                    'keyid' => $newID,
                    'status' => 1
                );
            } else {
                $return = array (
                    'data' => '图片上传失败，请重新上传',
                    'status' => 0
                );
            }
        }
        header('Content-Type:text/html;charset=utf-8');
        exit(json_encode($return));
    }

    /**
     * 删除session中的某张图片
     */
    public function albumTrash()
    {
        $index = I('imgid', '0', 'intval');
        if ($index <= 0) {
            $return = array (
                'data' => '系统未检测到删除操作的必需参数，请刷新后重新尝试！',
                'error' => 1
            );
        } else {
            $DB = M('goodsalbum');
            $realpath = $DB->field('imgrealpath')->where(array ('id' => $index))->find();
            if ($DB->delete($index)) {
                @unlink($realpath[ 'imgrealpath' ]);
                $return = array (
                    'data' => '删除成功',
                    'status' => 1
                );
            } else {
                $return = array (
                    'data' => '系统繁忙，删除失败，请重试！',
                    'status' => 0
                );
            }
        }
        $this->ajaxReturn($return, 'json');
    }

    /**
     * 产品详情图片上传控制
     */
    public function GoodsDetailUpload()
    {
        import("Extensions.UploadFile", COMMON_PATH);
        //导入上传类
        $upload = new \UploadFile();
        //设置上传文件大小
        $upload->maxSize = 4194304; //最大4M
        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $nowdate = date('Ymd', time());
        $upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/goods/' . $nowdate . '/d/';
        if (! is_dir($upload->savePath)) {
            mk_dir($upload->savePath);
        }
        //设置上传文件规则
        $upload->saveRule = 'uniqid';
        //删除原图
        $upload->thumbRemoveOrigin = true;
        if (! $upload->upload()) {
            //捕获上传异常
            $return = array (
                'url' => $upload->getErrorMsg(),
                'error' => 1
            );
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $path = '/assets/library/uploads/image/goods/' . $nowdate . '/d/' . $uploadList[ 0 ][ 'savename' ];
            $return = array (
                'url' => $path,
                'error' => 0
            );
        }
        $this->ajaxReturn($return);
    }

    /**
     * 产品分类图片上传控制
     */
    public function GoodsCateUpload()
    {
        if (session('cover') && session('coverrealpath')) {
            unlink(session('coverrealpath'));
            session('cover', null);
            session('coverrealpath', null);
        }
        import("Extensions.UploadFile", COMMON_PATH);
        //导入上传类
        $upload = new \UploadFile();
        //设置上传文件大小
        $upload->maxSize = 4194304; //最大4M
        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $nowdate = date('Ymd', time());
        $upload->savePath = C('SITE_UPLOAD_ROOT_PATH') . '/image/goods_cate/' . $nowdate . '/';
        if (! is_dir($upload->savePath)) {
            mk_dir($upload->savePath);
        }
        //设置上传文件规则
        $upload->saveRule = 'uniqid';
        //删除原图
        $upload->thumbRemoveOrigin = true;
        if (! $upload->upload()) {
            //捕获上传异常
            $return = array (
                'data' => $upload->getErrorMsg(),
                'status' => 0
            );
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $path = '/assets/library/uploads/image/goods_cate/' . $nowdate . '/' . $uploadList[ 0 ][ 'savename' ];
            $realpath = $upload->savePath . $uploadList[ 0 ][ 'savename' ];
            session('cover', $path);
            session('coverrealpath', $realpath);
            $return = array (
                'data' => $path,
                'status' => 1
            );

        }
        header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($return));
    }

}