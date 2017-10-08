<?php

class Reader extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lms_reader';
    }

    public static function findIdByUid($uid)
    {
        $sql = "select * from `lms_reader` where uid=".+$uid;
        $conn = Yii::app()->db_frame;
        $command = $conn->createCommand($sql);
        $rows = $command->queryAll();
        if($rows !=null)return $rows[0];
        else return "";
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}