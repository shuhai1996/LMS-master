<?php

class User extends MActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '`lms_user`';
    }

    /**
     * getUserWithRole 
     *
     * 获取用户信息包含Role详情
     * @author yu_hang <[hgyuhang@qq.com]>
     * @param string $condition 'unmae=:name' or 'uid=:id'
     * @param array $params  绑定信息 array(':name'=>$name)
     * @return void
     * @author yu_hang <[hgyuhang@qq.com]>
     */
    public function getUserWithRole($condition='',$params=array())
    {
        if(!empty($condition)) {
            $sql = "
                SELECT u.*,r.rid,r.rname  
                FROM `lms_user` u 
                LEFT JOIN `lms_role` r ON u.rid=r.rid
                where {$condition} order by u.uname;
            ";
        } else {
            $sql = "
                SELECT u.*,r.rid,r.rname 
                FROM `lms_user` u 
                LEFT JOIN `lms_role` r ON u.rid=r.rid order by u.uname
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

    /**
     * getUserWithAction 
     *
     * 获取用户拥有权限的action
     * 
     * @param string $condition 
     * @param array $params 
     * @return void
     * @author yu_hang <[hgyuhang@qq.com]>
     */
    public function getUserWithAction($condition='',$params=array())
    {
        if(!empty($condition)) {
            $sql = "
                SELECT u.*,a.aid,a.aname,a.route,a.is_menu,a.first_menu  
                FROM `lms_user` u 
                INNER JOIN `lms_role_action` ra ON u.rid=ra.rid
                INNER JOIN `m-action` a ON ra.aid=a.aid
                where {$condition};
            ";
        } else {
            $sql = "
                SELECT u.*,a.aid,a.aname,a.route,a.is_menu,a.first_menu 
                FROM `lms_user` u 
                INNER JOIN `lms_role_action` ra ON u.rid=ra.rid
                INNER JOIN `m-action` a ON ra.aid=a.aid
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

    public function delUser($id)
    {
        $this->deleteByPk($id);
    }
}
