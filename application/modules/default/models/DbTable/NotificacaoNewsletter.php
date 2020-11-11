<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 16:24
 */

class Default_Model_DbTable_NotificacaoNewsletter extends Zend_Db_Table_Abstract{

    public $notificacaoNewsletter;

    public function init()
    {
        $this->notificacaoNewsletter = new Util_ZendModelGeneric();
        $this->notificacaoNewsletter->construtor("notificacao_newsletter");
    }

    public function getAllNotificacaoNewsletter(){
        $this->notificacaoNewsletter->query->from(array("nn" => "tb_notificacao_newsletter"), array('*'));
        $this->notificacaoNewsletter->query->order('nn.dt_inclusao ASC');
        $this->notificacaoNewsletter->query->where('nn.st_registro = 1');
        $data = $this->notificacaoNewsletter->returnQuery();
        return $data;
    }

}