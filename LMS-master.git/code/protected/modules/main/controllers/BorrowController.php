<?php

class BorrowController extends BackController
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
        
        $this->redirect('/main/borrow/list');
    }
    
     public function actionList()
    {

        $this->render('list');
    }
    public function actionListajax()
    {
        //svar_dump("??");die();
        //echo "<pre>";var_dump($_REQUEST);exit;
        $pageStart = isset($_REQUEST["iDisplayStart"]) ? intval($_REQUEST["iDisplayStart"]) : 0;
        $pageLen = isset($_REQUEST["iDisplayLength"]) ? intval($_REQUEST["iDisplayLength"]) : 10;
        $orderCol = isset($_REQUEST["iSortCol_0"]) ? intval($_REQUEST["iSortCol_0"]) : 0;
        $orderDir = isset($_REQUEST["sSortDir_0"])&&in_array($_REQUEST["sSortDir_0"], array("asc","desc")) ? $_REQUEST["sSortDir_0"] : "asc";
        $searchContent = isset($_REQUEST["sSearch"]) ? $_REQUEST["sSearch"] : "";

        // column name
        $colNames = Borrow::model()->attributeNames();
        $totalNum = Borrow::model()->count();
        $numAfterFilter = Book::model()->count();

        $criteria=new CDbCriteria;
        $criteria->select = '*';  // 只选择 'title' 列
        if(!empty($searchContent)) {
            // $criteria->condition = "uname like '%{$searchContent}%' or email like '%{$searchContent}%'";
        }
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $borrowInfos = Borrow::model()->findAll($criteria);
        //var_dump($borrowInfos);die();
        $entitys = array();
        foreach ($borrowInfos as $v) {
            $t = Book::model()->find("bid={$v['bookid']}");
            $r = Reader::model()->find("id={$v['readerid']}");
            $n=User::model()->find("uid={$r['uid']}");
            if($v['is_back'])$is_back="是";else $is_back="否";
            $data = array(
                0=>$t['bookname'],
                1=>$n['nickname'],
                2=>$v['borrow_time'],
                3=>$v['back_time'],
                4=>$is_back,
                5=>'<a class="btn btn-sm red" href="/main/borrow/edit?id='.$v["id"].'"><i class="fa fa-edit"></i></a> '.
                '<a class="delete btn btn-sm red" data-id="'.$v["id"].'"><i class="fa fa-times"></i></a>',
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
        $borrow = new Borrow;
        $borrowInfo = array();
        $readername='';
        $label = '';
        //var_dump($_REQUEST);exit;
        if(isset($_REQUEST['id'])&&$_REQUEST['id']!='') {
            // 修改
            $borrowInfo = $borrow->find("id={$_REQUEST['id']}");
             $reader= Reader::model()->find("id={$borrowInfo['readerid']}");
             $u=User::model()->find("uid={$reader['uid']}");
             $readername=$u['nickname'];
            if(!empty($_REQUEST['modify'])) {
                $borrow->updateBorrow($_REQUEST);
                $this->redirect('/main/borrow/list');
            }
        } elseif(!empty($_REQUEST['bookid'])) {
             //新增
            // var_dump($_REQUEST);exit;
            //$roleInfo = $role->find('rname=:name',array(':name'=>$_REQUEST['name']));
            if(!empty($borrowInfo)) {
                $borrowInfo = $borrowInfo->getAttributes();
                // $borrowInfo['actions'] = RoleAction::model()->findActions($roleInfo['rid']);
                $this->render('edit',array('action_list'=>$retActions,'entity'=>$borrowInfo,'label'=>'has_borrow'));
                exit;
            }
            if(!empty($_REQUEST['modify'])) {
                //$borrow->saveBorrow($_REQUEST);
                $this->redirect('/main/borrow/list');
            }
        }

        // foreach($actionList as $k=>$v) {
            // echo "<pre>";var_dump($k,$v->getAttributes());
        // }exit;
        // 
        //var_dump($borrowInfo);exit;
        //$this->render('edit',array('entity'=>$borrowInfo,'readername'=>$u['nickname'],'label'=>$label));
        $this->render('edit',array('entity'=>$borrowInfo,'readername'=>$readername,'label'=>$label));
    }

    // 借阅操作
    public function actionAdd()
    {
        $reader=Reader::model()->find("uid={$_REQUEST['reader']}");
        $readerid=$reader['id'];
        $flag=true;
        $result = array();
        $olds=Borrow::model()->findAll("readerid={$readerid}");
        foreach ($olds as $v) {
           if($v['bookid']==$_REQUEST['bid'])
            $flag=false;

        }
        if($flag)
          { $borrow=new Borrow;
            $borrow->readerid=$readerid;
            $borrow->bookid=$_REQUEST['bid'];
            $borrow->borrow_time=$_REQUEST['rentdate'];
            $borrow->back_time=$_REQUEST['backdate'];       
        if($borrow->save()>0){
           $result=array('success'=>true);
            echo json_encode($result);
        }else{
            $result=array('success'=>false);
            echo json_encode($result);
        }
        }
      else 
         {
            $result=array('success'=>false);
            echo json_encode($result);
        }
        //var_dump($olds);die();
      

    }


    // 删除借阅信息
    public function actionDel()
    {
         $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
            if($id!='') {
                $ret = Borrow::model()->deleteByPk($id);
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
