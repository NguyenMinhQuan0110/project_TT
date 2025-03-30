<?php
class Don extends Model{
    public function get30Don() {
        $this->db->query("call get30Don()");
        return $this->db->resultSet();
    }
    public function getUserByLoaiUserAndPhongBan($loaiuser,$phongban){
        $this->db->query("call getUserByLoaiUserAndPhongBan(:loaiuser,:phongban)");
        $this->db->bind(":loaiuser",$loaiuser);
        $this->db->bind(":phongban",$phongban);
        return $this->db->resultSet();
    }
    public function getTotalAllDonByNguoiDuyet($nguoiduyet){
        $this->db->query("call getTotalAllDonByNguoiDuyet(:nguoiduyet)");
        $this->db->bind(":nguoiduyet",$nguoiduyet);
        $row= $this->db->single();
        return $row->toltal;
    }
    public function getAllDonByNguoiDuyet($limits, $offsets,$nguoiduyet){
        $this->db->query("call getAllDonByNguoiDuyet(:limits,:offsets,:nguoiduyet)");
        $this->db->bind(":limits",$limits);
        $this->db->bind(":offsets",$offsets);
        $this->db->bind(":nguoiduyet",$nguoiduyet);
        return $this->db->resultSet();
    }
    public function getTotalSearchDon($keyword){
        $this->db->query("call getTotalSearchDon(:keyword)");
        $this->db->bind(":keyword",$keyword);
        $row= $this->db->single();
        return $row->toltal;
    }
    public function searchDon($keyword,$limits,$offsets){
        $this->db->query("call searchDon(:keyword,:limits,:offsets)");
        $this->db->bind(":keyword",$keyword);
        $this->db->bind(":limits",$limits);
        $this->db->bind(":offsets",$offsets);
        return $this->db->resultSet();
    }
    public function getDonById($id){
        $this->db->query("call getDonById(:id)");
        $this->db->bind(":id",$id);
        return $this->db->single();
    }
    public function duyetdon($trangthai,$id,$ngayduyet){
        $this->db->query("call duyetdon(:trangthai,:id,:ngayduyet)");
        $this->db->bind(":trangthai",$trangthai);
        $this->db->bind(":id",$id);
        $this->db->bind(":ngayduyet",$ngayduyet);
        return $this->db->execute();
    }
    public function insertDon($title,$noidung,$nguoiduyet,$loaidon,$startdate,$enddate,$dinhkem,$trangthai,$userid){
        $this->db->query("CALL insertDon(:title, :noidung, :nguoiduyet, :loaidon, :startdate, :enddate, :dinhkem, :trangthai, :userid)");
        $this->db->bind(":title", $title);
        $this->db->bind(":noidung", $noidung);
        $this->db->bind(":nguoiduyet", $nguoiduyet);
        $this->db->bind(":loaidon", $loaidon);
        $this->db->bind(":startdate", $startdate);
        $this->db->bind(":enddate", $enddate);
        $this->db->bind(":dinhkem", $dinhkem);
        $this->db->bind(":trangthai", $trangthai);
        $this->db->bind(":userid", $userid);
        return $this->db->execute();
    }
    public function getDonByUserId($userid){
        $this->db->query("call 	getDonByUserId(:userid)");
        $this->db->bind(":userid",$userid);
        return $this->db->resultSet();
    }
}