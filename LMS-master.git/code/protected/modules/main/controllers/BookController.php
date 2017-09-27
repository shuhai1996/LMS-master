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
        $bookInfos = Book::model()->getAllBook($criteria);
       // var_dump($bookInfos);

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
                6=>'<a class="btn btn-sm red" href="/main/user/edit?id='.$v["bid"].'"><i class="fa fa-edit"></i></a> '.
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

  

    // public function actionEdit()
    // {
    //     //echo "<pre>";var_dump($_REQUEST);exit;
    //     $usr = new User;
    //     $role = new Role;
    //     $usrInfo = array();
    //     $label = '';
    //     foreach($_REQUEST as $k=>$v) {
    //         $_REQUEST[$k] = trim($v);
    //     }

    //     // 获取role列表
    //     $roleInfos = $role->findAll(array('select'=>'rid,rname'));
    //     // 过滤超极管理员
    //     foreach($roleInfos as $role) {
    //         if($role['rname']!='superman') $roles[] = $role;
    //     }
    //     // var_dump($_REQUEST); exit;
    //     // 
    //     if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
    //         // 修改
    //         $usrInfo = $usr->getUserWithRole('uid=:uid',array(':uid'=>$_REQUEST['id']));
    //         $usrInfo = $usrInfo[0];
    //         if(isset($_REQUEST['modify'])) {
    //             $usr->updateByPk($_REQUEST['id'],array(
    //                 'uname'=>$_REQUEST['name'],
    //                 'email'=>$_REQUEST['email'],
    //                 'pwd'=>Login::pwdEncry($_REQUEST['pwd']),
    //                 'rid'=>$_REQUEST['rid'],
    //             ));
    //             $this->redirect('/main/user/list');
    //         }
    //     } elseif(!empty($_REQUEST['name'])) {
    //         // 新增
    //         $usrInfo = $usr->getUserWithRole('uname=:name',array(':name'=>$_REQUEST['name']));
    //         //var_dump($usrInfo);exit;
    //         if(!empty($usrInfo)) {
    //             $this->render('edit',array('roles'=>$roles,'entity'=>$usrInfo[0],'label'=>'has_usr'));
    //             exit;
    //         }
    //         if(isset($_REQUEST['modify'])) {
    //             $usr->uname = $_REQUEST['name'];
    //             $usr->email = $_REQUEST['email'];
    //             $usr->pwd = Login::pwdEncry($_REQUEST['pwd']);
    //             $usr->rid = $_REQUEST['rid'];
    //             $usr->save();
    //             $this->redirect('/main/user/list');
    //         }
    //     }

    //     $this->render('edit',array('entity'=>$usrInfo,'roles'=>$roles,'label'=>$label));
    // }

   

//     // 删除用户
//     public function actionDel()
//     {
//         User::model()->delUser($_REQUEST['id']);
//     }

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
