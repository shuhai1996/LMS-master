<?php

class Borrow extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lms_borrow';
    }

   
    public function getAllBorrow()
    {
        $sql = "select * from `lms_borrow`  order by update_time desc";
        $conn = Yii::app()->db_frame;
        $command = $conn->createCommand($sql);
        $rows = $command->queryAll();
        return $rows;
    }

    public function cont(array $params)
    {
       // var_dump($params);exit;
        $this->updateByPk($params['id'],array(
            'back_time'=>$params['newtime'],
        ));
        
    }
       
   public function updateBorrow(array $params)
    {
        //echo "<pre>";var_dump($params);exit;
        $this->updateByPk($params['id'],array(
            'readerid'=>$params['readerid'],
            'bookid'=>$params['bookid'],
            'borrow_time'=>$params['borrow_time'],
            'back_time'=>$params['back_time'],
        ));

    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}