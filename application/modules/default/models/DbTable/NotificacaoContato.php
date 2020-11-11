<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/09/17
 * Time: 18:07
 */

class Default_Model_DbTable_NotificacaoContato  extends Zend_Db_Table_Abstract{

    public $notificacaoContato;

    public function init()
    {
        $this->notificacaoContato = new Util_ZendModelGeneric();
        $this->notificacaoContato->construtor("notificacao_contato");
    }

}