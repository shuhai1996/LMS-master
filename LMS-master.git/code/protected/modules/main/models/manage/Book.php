<?php

class Book extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lms_book';
    }

   
    public function getAllBook()
    {
        $sql = "select * from `lms_book` where is_delete=0 order by typeid desc";
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