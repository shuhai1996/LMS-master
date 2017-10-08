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

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('bookcode',$this->bookcode,true);
        $criteria->compare('bid',$this->bid,true);
        $criteria->compare('typeid',$this->typeid,true);
        $criteria->compare('price',$this->price);
        $criteria->compare('stroge',$this->stroge,true);
        $criteria->compare('in_time',$this->in_time,true);
        $criteria->compare('is_delete',$this->is_delete);
        $criteria->compare('location',$this->location,true);
        $criteria->compare('page',$this->page,true);
        $criteria->compare('update_time',$this->update_time,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getBookType($condition='',$params=array())
    {
        //var_dump($condition);die();
        if(!empty($condition)) {
            $sql = "
            SELECT b.*,t.id,t.name
            FROM `lms_book` b
            LEFT JOIN `lms_book_type` t ON b.typeid=t.id 
            where {$condition} order by b.typeid;
            ";
        } else {
            $sql = "
                SELECT b.*,t.id,t.name
                FROM `lms_book` b
                LEFT JOIN `lms_book_type` t ON b.typeid=t.id order by b.typeid
            ";
        }
       
        $conn = Yii::app()->db_frame;
        $command = $conn->createCommand($sql);
        foreach($params as $key=>$value) {
            $command->bindParam($key,$value);
        }
        $rows = $command->queryAll();
        return $rows;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}