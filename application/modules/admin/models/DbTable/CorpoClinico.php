<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 01/11/17
 * Time: 17:57
 */

class Admin_Model_DbTable_CorpoClinico extends Zend_Db_Table_Abstract{

    public $corpoClinico;

    public function init()
    {
        $this->corpoClinico = new Util_ZendModelGeneric();
        $this->corpoClinico->construtor("corpo_clinico");
    }

    public function getAllCorpoClinico(){
        $this->corpoClinico->query->from(array("cc" => "tb_corpo_clinico"), array('*'));
        $this->corpoClinico->query->joinLeft(array("tcc" => "tb_tipo_corpo_clinico"), "tcc.co_seq_tipo_corpo_clinico=cc.co_tipo_corpo_clinico");
        $this->corpoClinico->query->where('cc.st_registro=?', 1);
        $this->corpoClinico->query->where('tcc.st_registro=?', 1);
        $this->corpoClinico->query->order('cc.nm_corpo_clinico ASC');
        $data = $this->corpoClinico->returnQuery();
        return $data;
    }

    public function getCorpoClinico($id){
        $this->corpoClinico->query->from(array("cc" => "tb_corpo_clinico"), array('*'));
        $this->corpoClinico->query->joinLeft(array("tcc" => "tb_tipo_corpo_clinico"), "cc.co_tipo_corpo_clinico=tcc.co_seq_tipo_corpo_clinico");
        $this->corpoClinico->query->where('cc.co_seq_corpo_clinico = ?', $id);
        $this->corpoClinico->query->where('cc.st_registro = 1');
        $data = $this->corpoClinico->returnQuery();
        return $data;
    }

}