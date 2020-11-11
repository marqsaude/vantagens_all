<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 05/09/17
 * Time: 09:00
 */

class Admin_Model_DbTable_Contato  extends Zend_Db_Table_Abstract{

    public $contato;

    public function init()
    {
        $this->contato = new Util_ZendModelGeneric();
        $this->contato->construtor("contato");
    }

    public function getAllContato(){
        $this->contato->query->from(array("c" => "tb_contato"), array('*'));
        $this->contato->query->order('c.dt_inclusao ASC');
        $this->contato->query->where('c.st_registro = 1');
        $data = $this->contato->returnQuery();
        return $data;
    }

    public function getContato($id){
        $this->contato->query->from(array("c" => "tb_contato"), array('*'));
        $this->contato->query->join(array("rlct" => "rl_contato_telefone"), "c.co_seq_contato=rlct.co_contato");
        $this->contato->query->join(array("t" => "tb_telefone"), "t.co_seq_telefone=rlct.co_telefone");
        $this->contato->query->order('c.dt_inclusao ASC');
        $this->contato->query->where('c.co_seq_contato = ?', $id);
        $this->contato->query->where('c.st_registro = 1');
        $data = $this->contato->returnQuery();
        return $data;
    }

    public function getContatoVisualizado(){
        /*$this->contato->query->from(array("c" => "tb_contato"), array('*'));
        $this->contato->query->order('c.dt_inclusao ASC');
        $this->contato->query->where('c.st_registro = 1');
        $data = $this->contato->returnQuery();*/
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "SELECT *, (select count(*) from `tb_contato` where st_visualizado=2) as n FROM `tb_contato` c ORDER BY c.dt_inclusao DESC LIMIT 0, 10";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

}