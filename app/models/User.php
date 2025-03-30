<?php
class User extends Model {
    public function getTotalAllUser(){
        $this->db->query("call getTotalAllUser()");
        $row= $this->db->single();
        return $row->toltal;
    }
    public function getAllUser($limits, $offsets){
        $this->db->query("call getAllUser(:limits,:offsets)");
        $this->db->bind(":limits",$limits);
        $this->db->bind(":offsets",$offsets);
        return $this->db->resultSet();
    }
    public function getUserByLoginnameAndPassword($loginname,$password){
        $this->db->query("call getUserByLoginNameAndPassword(:loginname,:password)");
        $this->db->bind(":loginname",$loginname);
        $this->db->bind(":password",$password);
        return $this->db->single();
    } 
    public function insert($loginname,$username,$password,$email,$birthday,$loaiuser,$phongban,$trangthai){
        $this->db->query("call 	insertUser(:loginname,:username,:password,:email,:birthday,:loaiuser,:phongban,:trangthai)");
        $this->db->bind(":loginname",$loginname);
        $this->db->bind(":username",$username);
        $this->db->bind(":password",$password);
        $this->db->bind(":email",$email);
        $this->db->bind(":birthday",$birthday);
        $this->db->bind(":loaiuser",$loaiuser);
        $this->db->bind(":phongban",$phongban);
        $this->db->bind(":trangthai",$trangthai);
        return $this->db->execute();
    }
    public function getUserById($id){
        $this->db->query("call 	getUserById(:id)");
        $this->db->bind(":id",$id);
        return $this->db->single();
    }
    public function updateUser($id,$loginname,$username,$password,$email,$loaiuser,$phongban,$birthday,$trangthai){
        $this->db->query("call 	updateUser(:id,:loginname,:username,:password,:email,:loaiuser,:phongban,:birthday,:trangthai)");
        $this->db->bind(":id",$id);
        $this->db->bind(":loginname",$loginname);
        $this->db->bind(":username",$username);
        $this->db->bind(":password",$password);
        $this->db->bind(":email",$email);
        $this->db->bind(":loaiuser",$loaiuser);
        $this->db->bind(":phongban",$phongban);
        $this->db->bind(":birthday",$birthday);
        $this->db->bind(":trangthai",$trangthai);
        return $this->db->execute();
    }
    public function deleteUserById($id){
        $this->db->query("call deleteUserById(:id)");
        $this->db->bind(":id",$id);
        return $this->db->execute();
    }
    public function getTotalSearchUser($keyword){
        $this->db->query("call getTotalSearchUser(:keyword)");
        $this->db->bind(":keyword",$keyword);
        $row= $this->db->single();
        return $row->toltal;
    }
    public function seachUser($keyword,$limits,$offsets){
        $this->db->query("call 	searchUser(:keyword,:limits,:offsets)");
        $this->db->bind(":keyword",$keyword);
        $this->db->bind(":limits",$limits);
        $this->db->bind(":offsets",$offsets);
        return $this->db->resultSet();
    }
}