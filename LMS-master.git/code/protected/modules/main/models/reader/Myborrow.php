<?php

class MyBorrow extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lms_borrow';
    }

   
    public function getMyBorrow(int $readerid)
    {
        $sql = "select * from `lms_borrow` where readerid="+$readerid+"order by update_time desc";
        $conn = Yii::app()->db_frame;
        $command = $conn->createCommand($sql);
        $rows = $command->queryAll();
        return $rows;
    }
    

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}