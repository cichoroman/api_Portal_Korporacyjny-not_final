<?php
/**
 * Created by PhpStorm.
 * User: alicj
 * Date: 06.03.2019
 * Time: 14:13
 */

class User extends Database
{
    public function  getAllUsers(){
        $stmt = $this->getConnection()->query("SELECT * FROM users");
        while ($row = $stmt->fetch()){
            $uid = $row['uidUsers'];
            return $uid;
        }
    }

    public  function getUsersWithCountCheck(){
        $id =5;
        $uid = "ala";
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE idUsers=? AND uidUsers=?");
        $stmt->execute([$id,$uid]);

    if($stmt->rowCount())   //boolen czy wgl jest jakis wiersz
        while($row = $stmt->fetch()){
        return $row['emailUsers'];
        }

    }
    public function getUserByIdOrEmail($mailuid){
        $stmt = $this->getConnection()->prepare("SELECT * FROM users WHERE emailUsers=? OR uidUsers=?");
        $stmt->execute([$mailuid,$mailuid]);
        if($stmt->rowCount()){
            while($row = $stmt->fetch()){
                return $row;
            }
        }else{
            return false;
        }

    }



}