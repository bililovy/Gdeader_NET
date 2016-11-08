<?php
/**
 * 页面功能简述： 前端新闻管理控制
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
 * 更新日期：2015-11-23
 *
 */
namespace Home\Controller;

use Home\Controller\EmptyController;

class NewsController extends EmptyController
{
    /**
     * 新闻列表
     */
    public function index()
    {
        $count = M('news')->where(array ('isshow' => 1))->count();
        import('Extensions.Pagin', COMMON_PATH);
        $page = new \Page ($count, 12, $_GET [ 'p' ], '?p={page}');
        $limit = $page->page_limit . "," . $page->myde_size;

        $newslist = M('news')
            ->field('id,cover,title,author,click,keywords,addtime,description')
            ->where(array ('isshow' => 1))
            ->order('sortorder, addtime DESC')
            ->limit($limit)
            ->select();
        $ids = array ();
        foreach ($newslist as &$v) {
            $ids[] = $v[ 'id' ];
            $v[ 'day' ] = date('d', $v[ 'addtime' ]);
            $v[ 'month' ] = self::MonthConvert(date('m', $v[ 'addtime' ]));
        }
        if (! empty($ids)) {
            $this->hot = M('news')
                ->field('id,title')
                ->where(array ('isshow' => 1, 'id' => array ('not in', $ids)))
                ->order('click DESC')
                ->limit(8)
                ->select();
        } else {
            $this->hot = false;
        }
        //----- 页面信息获取---//
        $pageinfo = array (
            'pagetitle' => 'News List',
            'keywords' => $this->_config[ 'webname' ],
            'description' => 'This page gives our viewers some latest news of our company',
            'author' => '',
            'breadcrumb' => array ('blogs')
        );
        $this->newslist = $newslist;
        $this->pageinfo = $pageinfo;
        //----- 页面信息获取---//
        $this->page = $page->myde_write(false, false, false, true, true, true, 'Previous', 'Next');
        $this->display('news_list');
    }

    /**
     * 新闻内容页
     */
    public function detail()
    {
        $nid = I('nid', 0, 'intval');
        if ($news = M('news')
            ->field('coverrealpath,isshow,sortorder', true)
            ->where(array ('isshow' => 1, 'id' => $nid))
            ->find()
        ) {
            M('news')->where(array ('id' => $nid))->setInc('click', 1);
            $news[ 'content' ] = htmlspecialchars_decode($news[ 'content' ]);
            //上一条新闻
            $prevnews = M('news')
                ->field('id,title')
                ->where(array ('isshow' => 1, 'id' => array ('LT', $nid)))
                ->order('id DESC')
                ->find();
            $nextnews = M('news')
                ->field('id,title')
                ->where(array ('isshow' => 1, 'id' => array ('GT', $nid)))
                ->order('id ASC')
                ->find();
            //最新新闻
            $this->newest = M('news')->field('id,title,cover,click,addtime')->where(array (
                'id' => array (
                    'not in',
                    array ($nid)
                ),
                'isshow' => 1
            ))->order('addtime DESC')->limit(4)->select();
            $this->news = $news;
            $this->prev = $prevnews;
            $this->next = $nextnews;
            //----- 页面信息获取---//
            $pageinfo = array (
                'pagetitle' => $news[ 'title' ],
                'keywords' => $news[ 'keywords' ],
                'description' => $news[ 'description' ],
                'author' => $news[ 'author' ],
                'breadcrumb' => array (U('index') => 'Blog list', $news[ 'title' ])
            );
            $this->pageinfo = $pageinfo;
            //----- 页面信息获取---//

            $this->display('news_detail');
        } else {
            $this->error('Access Denied By The Server, Because A Problem Has Occured By Your Accessing !', '', 5);
        }
    }

    public function BookingNews()
    {
        if (IS_POST && IS_AJAX) {
            $data = I('post.', '');
            if (empty($data) || ! count($data)) {
                $return = [
                    'status' => 0,
                    'data' =>'Please input the correct email address !'
                ];
            }else{
                if (M('news_booking')->where(array('email'=>$data['email']))->count()>0){
                    $return = [
                        'status' => 0,
                        'data' =>'You have booked with the email, if you need, please change another email !'
                    ];
                }else{
                    $data['addtime'] =time();
                    $data['uid'] =session('member.uid') ? session('member.uid') : 0;
                   if(M('news_booking')->add($data)){
                       $return = [
                           'status' => 1,
                           'data' =>'Booking successfully ! We\'ll Send the news to your email box for the first time when there\'s the latest news !'
                       ];
                   }else{
                       $return = [
                           'status' => 0,
                           'data' =>'The network is busy, please try again later !'
                       ];
                   }
                }
            }
            $this->ajaxReturn($return);
        } else {
            $this->error('Access Denied By The Server, Because A Problem Has Occured By Your Accessing !', '', 5);
        }
    }

    protected static function MonthConvert($month)
    {
        switch ($month) {
            case '01':
                return 'Jan.';
            break;
            case '02':
                return 'Feb.';
            break;
            case '03':
                return 'Mar.';
            break;
            case '04':
                return 'Apr.';
            break;
            case '05':
                return 'May.';
            break;
            case '06':
                return 'Jun.';
            break;
            case '07':
                return 'Jul.';
            break;
            case '08':
                return 'Aug.';
            break;
            case '09':
                return 'Sept.';
            break;
            case '10':
                return 'Oct.';
            break;
            case '11':
                return 'Nov.';
            break;
            case '12':
                return 'Dec.';
            break;
            default :
                return "Null";
        }
    }
}