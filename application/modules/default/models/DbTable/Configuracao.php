<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 14/09/17
 * Time: 16:50
 */

class Default_Model_DbTable_Configuracao extends Zend_Db_Table_Abstract{

    public $configuracao;

    public function init(){
        $this->configuracao = new Util_ZendModelGeneric();
        $this->configuracao->construtor("configuracao");
    }

    public function getConfigurationAdmin(){
        $this->configuracao->query->from(array("c" => "tb_configuracao"), array('*'));
        $this->configuracao->query->where('c.st_registro=?', 1);
        $this->configuracao->query->where('c.co_tipo_usuario=?', 1);
        $data = $this->configuracao->returnQuery();
        return $data[0];
    }

    public function clean(){
        $this->init();
    }

}