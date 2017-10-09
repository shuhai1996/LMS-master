<?php 

class SiteController extends BackController
{
    public $layout = 'application.views.layouts.metronic';
    //"application.modules.main.views.layouts.frame_without_leftnav";
    
    public function actionIndex()
    {
        $this->redirect('/site/search');
    }
    public function actionSearch()
    {
        //echo "ok";exit;
        $this->render('search');
    }
    
    public function actionResult()
    {
        //echo "？？？";exit;
        $this->render('result');
    }
    
    public function actionListajax()
    {
        //var_dump($_REQUEST);exit;
        $pageStart = isset($_REQUEST["iDisplayStart"]) ? intval($_REQUEST["iDisplayStart"]) : 0;
        $pageLen = isset($_REQUEST["iDisplayLength"]) ? intval($_REQUEST["iDisplayLength"]) : 10;
        $orderCol = isset($_REQUEST["iSortCol_0"]) ? intval($_REQUEST["iSortCol_0"]) : 0;
        $orderDir = isset($_REQUEST["sSortDir_0"])&&in_array($_REQUEST["sSortDir_0"], array("asc","desc")) ? $_REQUEST["sSortDir_0"] : "asc";
        //搜索条件
        $searchCode = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
        $searchName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : "";

        $colNames = Book::model()->attributeNames();
        $totalNum = Book::model()->count();
        $numAfterFilter = Book::model()->count();
        $criteria=new CDbCriteria;
        $criteria->select = '*';// 只选择 'title' 列
        $criteria->condition = "bookcode like '%{$searchCode}%' and bookname like '%{$searchName}%'";
        //$criteria->condition = "bookname like '%php%'";
        $criteria->limit = $pageLen;
        $criteria->offset = $pageStart;
        $criteria->order = $colNames[$orderCol]." ".$orderDir;
        $bookInfos = Book::model()->findAll($criteria);
        //var_dump($bookInfos);exit;
        
        $entitys = array();
        foreach ($bookInfos as $v) {
           // $t = BookType::model()->find("id={$v['typeid']}");
            $data = array(
                0=>$v['bid'],
                1=>$v['bookcode'],
                2=>$v['bookname'],
                3=>$v['author'],
                4=>$v['from'],
                5=>$v['typeid'],
                6=>$v['stroge'],
                7=>$v['location'],
            );
            $entitys[] = $data;
        }
      $sEcho=$_REQUEST['aoData']["0"]["value"];
      //var_dump($sEcho);exit;
        $retData = array(
            "sEcho" => intval($sEcho),
            "iTotalRecords" => $totalNum,
            "iTotalDisplayRecords" => $numAfterFilter,
            "aaData" => $entitys,
        );
        echo json_encode($retData);
        
    }
    
}


