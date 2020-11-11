<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 12/01/18
 * Time: 11:54
 */

class Admin_Model_DbTable_DeleteCliente  extends Zend_Db_Table_Abstract{

    private $db;

    public function init(){
        $this->db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    public function deleta($sql){
        try{
            $this->db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

}