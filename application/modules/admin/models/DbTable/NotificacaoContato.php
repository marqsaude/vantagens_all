<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 20/09/17
 * Time: 16:25
 */

class Admin_Model_DbTable_NotificacaoContato extends Zend_Db_Table_Abstract{

    public $notificacaoContato;

    public function init()
    {
        $this->notificacaoContato = new Util_ZendModelGeneric();
        $this->notificacaoContato->construtor("notificacao_contato");
    }

    public function getNotificacaoVisualizado($idUsuario){
        /*$this->contato->query->from(array("c" => "tb_contato"), array('*'));
        $this->contato->query->order('c.dt_inclusao ASC');
        $this->contato->query->where('c.st_registro = 1');
        $data = $this->contato->returnQuery();*/
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "SELECT *, (SELECT count(*) FROM `tb_notificacao_contato` nc LEFT JOIN `tb_contato` c ON nc.co_contato=c.co_seq_contato WHERE nc.co_usuario=".$idUsuario." AND st_visualizado=2) as n FROM `tb_notificacao_contato` nc LEFT JOIN `tb_contato` c ON nc.co_contato=c.co_seq_contato WHERE nc.co_usuario=".$idUsuario." ORDER BY nc.dt_inclusao DESC LIMIT 0, 5";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

}