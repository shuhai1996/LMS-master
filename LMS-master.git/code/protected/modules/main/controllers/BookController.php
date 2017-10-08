<?php

class BookController extends BackController
{
    public $layout = '/layouts/metronic';

    // const ACCOUNT_PATTERN = '/^[A-Za-z\x{4e00}-\x{9fa5}][A-Za-z0-9\x{4e00}-\x{9fa5}_-]{3,20}$/u';
    //const ACCOUNT_PATTERN = '/^[A-Za-z\x{4e00-\x{9fa5}}][A-Za-z0-9\x{4e00-\x{9fa5}_-}{2-20}]$/u';

    // static $msgArray = array(0=>'成功',
    //     -1=>'参数错误',
    //     -2=>'操作失败',
    //     -3=>'账号不符合规则',
    //     -4=>'密码错误',
    //     -5=>'邮箱不能为空',
    //     -6=>'用户已存在',
    //     -7=>'验证码错误',
    // );


    public function actionIndex()
    {
        //$this->layout = "";
        //$this->render("/layouts/metronic");
        $this->redirect('/main/book/list');
    }
    
     public function actionList()
    {

        $this->render('list');
    }
    public function actionListajax()
    {
        //var_dump("??");die();
        //echo "<pre>";var_dump($_REQUEST);exit;
        $pageStart = isset($_REQUEST["iDisplayStart"]) ? intval($_REQUEST["iDisplayStart"]) : 0;
        $pageLen = isset($_REQUEST["iDisplayLength"]) ? intval($_REQUEST["iDisplayLength"]) : 10;
        $orderCol = isset($_REQUEST["iSortCol_0"]) ? intval($_REQUEST["iSortCol_0"]) : 0;
        $orderDir = isset($_REQUEST["sSortDir_0"])&&in_array($_REQUEST["sSortDir_0"], array("asc","desc")) ? $_REQUEST["sSortDir_0"] : "asc";
        $searchContent = isset($_REQUEST["sSearch"]) ? $_REQUEST["sSearch"] : "";

        // column name
        $colNames = Book::model()->attributeNames();
        $totalNum = Book::model()->count();
        $numAfterFilter = Book::model()->count();

        $criteria=new CDbCriteria;
        $criteria->select = '*';  // 只选择 'title' 列
        if(!empty($searchContent)) {
            // $criteria->condition = "uname like '%{$searchContent}%' or email like '%{$searchContent}%'";
        }
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $bookInfos = Book::model()->findAll($criteria);
       // var_dump($bookInfos);die();

        $entitys = array();
        foreach ($bookInfos as $v) {
            $t = Book::model()->find("bid={$v['bid']}");
            $data = array(
                0=>$v['bookcode'],
                1=>$v['bookname'],
                2=>$v['author'],
                3=>$t['typeid'],
                4=>$t['from'],
                5=>$t['location'],
                6=>'<a class="btn btn-sm red" href="/main/book/edit?id='.$v["bid"].'"><i class="fa fa-edit"></i></a> '.
                '<a class="delete btn btn-sm red" data-id="'.$v["bid"].'"><i class="fa fa-times"></i></a>',
            );
            $entitys[] = $data;
        }

        $retData = array(
            "sEcho" => intval($_REQUEST['sEcho']),
            "iTotalRecords" => $totalNum,
            "iTotalDisplayRecords" => $numAfterFilter,
            "aaData" => $entitys,
        );
        echo json_encode($retData);

    }

  

   public function actionEdit()
    {
        //echo "<pre>";var_dump($_REQUEST);exit;
        //var_dump($_REQUEST);exit;
        $book = new Book;
        $bookInfo = array();
        //$bookInfo=$book->find();
        $booktype = new BookType;
        $typeinfos = $booktype->findAll(array('select'=>'id,name'));
        $label = '';
        foreach($_REQUEST as $k=>$v) {
            $_REQUEST[$k] = trim($v);
        }
        foreach ($typeinfos as $type){
            $types[] = $type;
        }
        //var_dump($_REQUEST);exit;
        if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
            // 修改
            $bookInfo = $book->getBookType('bid=:bid',array(':bid'=>$_REQUEST['id']));
            $bookInfo = $bookInfo[0];
            //var_dump($_REQUEST);exit;
            if(isset($_REQUEST['modify'])) {
                $book->updateByPk($_REQUEST['id'],array(
                    'bookcode'=>$_REQUEST['bookcode'],
                    'bookname'=>$_REQUEST['bookname'],
                    'typeid'=>$_REQUEST['typeid'],
                    'author'=>$_REQUEST['author'],
                    'from'=>$_REQUEST['from'],
                    'price'=>$_REQUEST['price'],
                    'page'=>$_REQUEST['page'],
                    'location'=>$_REQUEST['location'],
                    'stroge'=>$_REQUEST['stroge'],
                    'in_time'=>$_REQUEST['in_time']
                ));
                //var_dump($bookInfo);exit;
                $this->redirect('/main/book/list');
            }
        }elseif(!empty($_REQUEST['bookcode'])) {
            // 新增
            $bookInfo = $book->getBookType('bookcode=:bookcode',array(':bookcode'=>$_REQUEST['bookcode']));
            if(!empty($bookInfo)) {
                
                $this->render('edit',array('types'=>$types,'entity'=>$bookInfo,'label'=>'has_book'));
                exit;
            }
            if(isset($_REQUEST['modify'])) {
                $book->bookcode= $_REQUEST['bookcode'];
                $book->bookname = $_REQUEST['bookname'];
                $book->typeid = $_REQUEST['typeid'];
                $book->author = $_REQUEST['author'];
                $book->from = $_REQUEST['from'];
                $book->price = $_REQUEST['price'];
                $book->page = $_REQUEST['page'];
                $book->location = $_REQUEST['location'];
                $book->in_time = $_REQUEST['in_time'];
                $book->stroge = $_REQUEST['stroge'];
                $book->save();
                //var_dump($book);exit;
                $this->redirect('/main/book/list');
                
            }
        }        
        $this->render('edit',array('types'=>$types,'entity'=>$bookInfo,'label'=>$label));
    }
   

     public function actionDel()
        {
            $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
            if($id!='') {
                $ret = Book::model()->deleteByPk($id);
                //RoleAction::model()->deleteAll('bid=:bid',array(':bid'=>$id));
                //var_dump($ret);
            } else {
                echo "fail";
            }
        }

//     public function validateAccount($account)
//     {
//         //echo "11111";exit;
//         //echo $account;
//         //$result = preg_match(self::ACCOUNT_PATTERN, $account, $match);
//         //var_dump(self::ACCOUNT_PATTERN, $account,$result,$match);exit;
//         if (preg_match(self::ACCOUNT_PATTERN, $account, $match))
//         {
//             //echo "fuck,world";exit;
//             return true;
//         }
//         else
//         {
//             //echo "hello,world";exit;
//             return false;
//         }
//     }
//     public function jsonResult($retCode = 0, $info = array())
//     {
//         $result = array('retCode' => $retCode,
//             'msg' => self::$msgArray[$retCode],
//             'info' => $info);

//         echo json_encode($result);
//         exit;
//     }
 }
