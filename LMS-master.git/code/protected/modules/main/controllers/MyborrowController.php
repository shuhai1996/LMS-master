<?php

class MyborrowController extends BackController
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
        
        $this->redirect('/main/myborrow/list');
    }
    
     public function actionList()
    {

        $this->render('list');
    }
    public function actionListajax()
    {
        //svar_dump("??");die();
        //var_dump($_REQUEST);exit;
        $reader = user::findIdByUid($_REQUEST["id"]);
        $pageStart = isset($_REQUEST["iDisplayStart"]) ? intval($_REQUEST["iDisplayStart"]) : 0;
        $pageLen = isset($_REQUEST["iDisplayLength"]) ? intval($_REQUEST["iDisplayLength"]) : 10;
        $orderCol = isset($_REQUEST["iSortCol_0"]) ? intval($_REQUEST["iSortCol_0"]) : 0;
        $orderDir = isset($_REQUEST["sSortDir_0"])&&in_array($_REQUEST["sSortDir_0"], array("asc","desc")) ? $_REQUEST["sSortDir_0"] : "asc";
        $searchContent = isset($_REQUEST["sSearch"]) ? $_REQUEST["sSearch"] : "";

        // column name
        $colNames = Borrow::model()->attributeNames();
        $totalNum = Borrow::model()->count();
        $numAfterFilter = Borrow::model()->count();

        $criteria=new CDbCriteria;
        $criteria->select = '*';  // 只选择 'title' 列
        if(!empty($searchContent)) {
            // $criteria->condition = "uname like '%{$searchContent}%' or email like '%{$searchContent}%'";
        }
        if($reader!="")$criteria->condition="readerid =".+$reader['id'];
        else $criteria->condition="readerid =".+'0';
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $borrowInfos = Borrow::model()->findAll($criteria);
        $entitys = array();
        foreach ($borrowInfos as $v) {
         
            $t = Book::model()->find("bid={$v['bookid']}");
            if($v['is_back'])$is_back="是";else $is_back="否";
            $data = array(
                0=>$t['bookname'],
                1=>$v['borrow_time'],
                2=>$v['back_time'],
                3=>$is_back,
                4=>'<a class="btn btn-sm red" id="btncont" data-id="'.$v["id"].'">续借</a> '
                
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

   

    // 续借操作
    public function actionCont()
    {
        $borrow = new Borrow;
        $id=$_REQUEST['id'];
        $a=Borrow::model()->find("id={$id}");
        $oldtime=$a['back_time'];
        $newtime=date("Y-m-d",strtotime("$oldtime +10 day"));
       // var_dump($newtime);die();
        $array = array('id' =>$id ,'newtime'=>$newtime);
        $borrow->cont($array);
    }


 }
