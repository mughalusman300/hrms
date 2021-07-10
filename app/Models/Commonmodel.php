<?php
namespace App\Models;
use CodeIgniter\Model;
class Commonmodel extends Model {

    
    public function db(){
      return $db      = \Config\Database::connect();  
    }
    //======================================================================
    //START--------------Generic Function For Model-------------------------
    //======================================================================
    
    public function Delete_record($tablename, $columnname, $conditionvalue){
    $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->delete();
    return true; 
    }
    
    public function Delete_double_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
    $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->delete();
    }

    public function Delete_all_record(){
    $this->db->table($tablename)->delete(); 
    }

    public function Duplicate_check($tablename, $columnname, $conditionvalue){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->get()->getNumRows();
             return  $query;
          
    }

    public function Duplicate_double_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->get()->getNumRows();
             return  $query;
                }

    
    public function Duplicate_triple_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->where($columnname2, $conditionvalue2)
             ->get();
    return  $this->db->getNumRows();
    }
    
    public function rows_number($tablename){
    $query = $this->db->table($tablename)->get()->getNumRows();
    return  $query;
    }


    public function Update_record($tablename, $columnname, $conditionvalue, $data){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->update($data); 
    return $query;     
    }

    public function Update_double_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $data){
        $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->update($data); 
    return $this->db->affectedRows();
    }
    
    
    public function Update_triple_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2, $data){
    $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->where($columnname2, $conditionvalue2)
             ->update($data); 
    return $this->db->affectedRows();      
    }

    public function Insert_record($tablename, $data){
    $this->db->table($tablename)->insert($data);  
    return $this->db->insertID();
    }

    public function Get_all_record($tablename){
    $query = $this->db->table($tablename)
             ->get()
             ->getResultArray();
    return $query;
    }

    public function Get_record_by_condition($tablename, $columnname, $conditionvalue){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->get()
             ->getResult();
    return $query;
    }

    public function Get_record_by_double_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->get()
             ->getResultArray();
    return $query;
    }

    public function Get_record_by_triple_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,$columnname2, $conditionvalue2){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->where($columnname2, $conditionvalue2)
             ->get()
             ->getResultArray();
    return $query;
    }

    public function Get_record_by_condition_array($tablename, $columnname, $conditionvalue){
    $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->get()
             ->getResultArray();
    return $query;
    }
    
     public function Get_record_by_double_condition_array($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
        $query = $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->where($columnname1, $conditionvalue1)
             ->get()
             ->getResultArray();
    return $query;
    }
    
    public function Custom_query_wor($query){
    return $this->db->query($query);
    }
    
    public function Sms_Refiner(){
    $query="UPDATE `saimtech_send_sms` SET `sms_status`='E' where `sms_phone`='' or LENGTH(sms_phone)<>11";  
    $this->db->query($query);
    }
    
    public function Custom_query_array($query){
    return $this->db->query($query)->getResultArray();
    }
    
    
    public function Custom_query_rows($query){
    return $this->db->query($query)->getResult();
    }
    //======================================================================
    //START--------------Generic Function For Model-------------------------
    //======================================================================
    public function transBegin()
    {
        return $this->db->transBegin();
    }
    public function Inert_log()
    {
        //
    }
    

}
