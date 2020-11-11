<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 04/10/17
 * Time: 16:11
 */

class Admin_Model_DbTable_Dependentes  extends Zend_Db_Table_Abstract{

    public $dependentes;

    public function init()
    {
        $this->dependentes = new Util_ZendModelGeneric();
        $this->dependentes->construtor("dependentes");
    }

    public function getDependentesCliente($idCliente){
        $dateNow = Util_Util::getDateMysqlNow();
        $this->dependentes->query->from(array("d" => "tb_dependentes"), array('*'));
        $this->dependentes->query->join(array("a" => "tb_acordo"), "d.co_acordo=a.co_seq_acordo");
        $this->dependentes->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->dependentes->query->join(array("td" => "tb_tipo_dependentes"), "d.co_tipo_dependentes=td.co_seq_tipo_dependentes");
        $this->dependentes->query->where('c.co_seq_cliente = ?', $idCliente);
        $this->dependentes->query->where('a.dt_finaliza >= ?', $dateNow);
        $this->dependentes->query->where('a.dt_acordo <= ?', $dateNow);
        $this->dependentes->query->where('a.st_registro = 1');
        $this->dependentes->query->where('c.st_registro = 1');
        $this->dependentes->query->where('d.st_registro = 1');
        $data = $this->dependentes->returnQuery();
        return $data;
    }

    public function getDependentes($idCliente){
        $this->dependentes->query->from(array("d" => "tb_dependentes"), array('*'));
        $this->dependentes->query->join(array("td" => "tb_tipo_dependentes"), "d.co_tipo_dependentes=td.co_seq_tipo_dependentes");
        $this->dependentes->query->join(array("a" => "tb_acordo"), "d.co_acordo=a.co_seq_acordo");
        $this->dependentes->query->join(array("cg" => "tb_contrato_gog"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->dependentes->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->dependentes->query->where('c.co_seq_cliente = ?', $idCliente);
        $this->dependentes->query->where('c.st_registro = 1');
        $this->dependentes->query->where('d.st_registro = 1');
        $data = $this->dependentes->returnQuery();
        return $data;
    }

    public function getDependente($id){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql  = "select *, d.nu_cpf as cpf_dependente, d.dt_nascimento as nascimento_dependente, d.nu_rg as rg_dependente, d.nm_email as email_dependente from tb_dependentes d ";
        $sql .= "inner join tb_tipo_dependentes td on d.co_tipo_dependentes=td.co_seq_tipo_dependentes ";
        $sql .= "inner join tb_acordo a on d.co_acordo=a.co_seq_acordo ";
        $sql .= "inner join tb_cliente c on c.co_seq_cliente=a.co_cliente ";
        $sql .= "inner join tb_pagamento p on p.co_acordo=a.co_seq_acordo ";
        $sql .= "inner join tb_status_pagamento sp on p.co_status_pagamento=sp.co_seq_status_pagamento ";
        $sql .= "where d.co_seq_dependentes = ".$id;
        $stmt = $db->query($sql);
        $data =  $stmt->fetchAll();
        return (isset($data[0]) ? $data[0] : array());
    }

    public function getDependenteByCliente($idCliente){
        $this->dependentes->query->from(array("d" => "tb_dependentes"), array('*'));
        $this->dependentes->query->join(array("td" => "tb_tipo_dependentes"), "d.co_tipo_dependentes=td.co_seq_tipo_dependentes");
        $this->dependentes->query->join(array("a" => "tb_acordo"), "d.co_acordo=a.co_seq_acordo");
        $this->dependentes->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->dependentes->query->where('a.co_cliente = ?', $idCliente);
        $data = $this->dependentes->returnQuery();
        return (isset($data[0]) ? $data[0] : array());
    }

    public function checkDependentes($idAcordo){
        $this->dependentes->query->from(array("d" => "tb_dependentes"), array('*'));
        $this->dependentes->query->joinLeft(array("a" => "tb_acordo"), "d.co_acordo=a.co_seq_acordo");
        $this->dependentes->query->joinLeft(array("cg" => "tb_contrato_gog"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->dependentes->query->where('a.co_seq_acordo = ?', $idAcordo);
        $this->dependentes->query->where('d.st_registro = 1');
        $this->dependentes->query->where('a.st_registro = 1');
        $data = $this->dependentes->returnQuery();
        return $data;
    }

    public function checkDependenteUsuario($idDependente, $idUsuario=null){
        $this->dependentes->query->from(array("d" => "tb_dependentes"), array('*'));
        $this->dependentes->query->join(array("a" => "tb_acordo"), "d.co_acordo=a.co_seq_acordo");
        $this->dependentes->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->dependentes->query->join(array("u" => "tb_usuario"), "u.co_seq_usuario=c.co_usuario");
        $this->dependentes->query->where('d.co_seq_dependentes = ?', $idDependente);
        if($idUsuario != null){
            $this->dependentes->query->where('u.co_seq_usuario = ?', $idUsuario);
        }
        $this->dependentes->query->where('d.st_registro = 1');
        $this->dependentes->query->where('a.st_registro = 1');
        $data = $this->dependentes->returnQuery();
        return $data;
    }

    public function getQtdDependentes(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "select count(*) as contador from tb_dependentes where st_registro=1";
        $stmt = $db->query($sql);
        $users =  $stmt->fetchAll();
        return $users[0]["contador"];
    }

    public function clean(){
        $this->init();
    }

}