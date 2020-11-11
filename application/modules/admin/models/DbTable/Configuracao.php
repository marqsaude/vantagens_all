<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 16/09/17
 * Time: 01:30
 */

class Admin_Model_DbTable_Configuracao extends Zend_Db_Table_Abstract{

    public $configuracao;

    public function init()
    {
        $this->configuracao = new Util_ZendModelGeneric();
        $this->configuracao->construtor("configuracao");
    }

    public function getAll(){
        $this->configuracao->query->from(array("c" => "tb_configuracao"), array('*'));
        $this->configuracao->query->order('c.dt_inclusao ASC');
        $this->configuracao->query->where('c.st_registro = ?', 1);
        $data = $this->configuracao->returnQuery();
        return $data;
    }

}