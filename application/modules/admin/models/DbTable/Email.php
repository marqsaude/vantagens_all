<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 26/01/18
 * Time: 15:36
 */

class Admin_Model_DbTable_Email extends Zend_Db_Table_Abstract{

    public $email;

    public function init(){
        $this->email = new Util_ZendModelGeneric();
        $this->email->construtor("email");
    }

    public function checkExist($code){
        $this->email->query->from(array("e" => "tb_email"), array('*'));
        $this->email->query->where('e.st_registro=?', 1);
        $this->email->query->where('e.nm_code=?', $code);
        $data = $this->email->returnQuery();
        return (count($data)>0)?true:false;
    }

    public function checkClientByCode($code){
        $this->email->query->from(array("e" => "tb_email"), array('*'));
        $this->email->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=e.co_cliente");
        $this->email->query->where('e.st_registro=?', 1);
        $this->email->query->where('c.st_registro=?', 1);
        $this->email->query->where('c.st_cliente=?', 1);
        $this->email->query->where('c.st_muda_senha=?', 1);
        $this->email->query->where('e.nm_code=?', $code);
        $data = $this->email->returnQuery();
        return $data;
    }

    public function checkEmailSend($idCliente){
        $this->email->query->from(array("e" => "tb_email"), array('*'));
        $this->email->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=e.co_cliente");
        $this->email->query->where('e.st_registro=?', 1);
        $this->email->query->where('e.st_email=?', 1);
        $this->email->query->where('c.st_registro=?', 1);
        $this->email->query->where('c.co_seq_cliente=?', $idCliente);
        $data = $this->email->returnQuery();
        return (isset($data[0]))?((count($data[0])>0)?false:true):true;
    }

    public function checkEmailExist($idCliente){
        $this->email->query->from(array("e" => "tb_email"), array('*'));
        $this->email->query->where('e.st_registro=?', 1);
        $this->email->query->where('e.tp_email=?', 1);
        $this->email->query->where('e.co_cliente=?', $idCliente);
        $data = $this->email->returnQuery();
        return (isset($data[0]))?((count($data[0])>0)?false:true):true;
    }

    public function getEmailResend($idCliente){
        $this->email->query->from(array("e" => "tb_email"), array('*'));
        $this->email->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=e.co_cliente");
        $this->email->query->join(array("a" => "tb_acordo"), "c.co_seq_cliente=a.co_cliente");
        $this->email->query->join(array("p" => "tb_pagamento"), "a.co_seq_acordo=p.co_acordo");
        $this->email->query->where('e.st_registro=?', 1);
        $this->email->query->where('e.st_email=?', 1);
        $this->email->query->where('e.tp_email=?', 1);
        $this->email->query->where('c.st_registro=?', 1);
        $this->email->query->where('c.co_seq_cliente=?', $idCliente);
        $data = $this->email->returnQuery();
        return $data;
    }

    public function clean(){
        $this->init();
    }

}