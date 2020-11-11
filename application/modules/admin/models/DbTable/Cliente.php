<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 29/03/17
 * Time: 10:16
 */

class Admin_Model_DbTable_Cliente extends Zend_Db_Table_Abstract{

    public $cliente;

    public function init()
    {
        $this->cliente = new Util_ZendModelGeneric();
        $this->cliente->construtor("cliente");
    }

    public function getAllCliente(){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('c.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return $data;
    }

    public function getClienteDefault($id){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("cp" => "tb_cep"), "c.co_cep=cp.co_seq_cep");
        $this->cliente->query->join(array("rct" => "rl_cliente_telefone"), "rct.co_cliente=c.co_seq_cliente");
        $this->cliente->query->join(array("t" => "tb_telefone"), "rct.co_telefone=t.co_seq_telefone");
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('c.co_seq_cliente = ?', $id);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('rct.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return $data[0];
    }

    public function getClienteDependente($id){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->cliente->query->join(array("cg" => "tb_contrato_gog"), "a.co_contrato_gog=cg.co_seq_contrato_gog");
        $this->cliente->query->where('c.co_seq_cliente = ?', $id);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        return $dataCliente;
    }

    public function getClienteDependentes($idUsuario){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->cliente->query->join(array("cg" => "tb_contrato_gog"), "a.co_contrato_gog=cg.co_seq_contrato_gog");
        $this->cliente->query->where('c.co_usuario = ?', $idUsuario);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        return $dataCliente;
    }

    public function checkCliente($idUsuario){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->joinLeft(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->cliente->query->joinLeft(array("p" => "tb_pagamento"), "p.co_acordo=a.co_seq_acordo");
        $this->cliente->query->joinLeft(array("b" => "tb_boleto"), "b.co_pagamento=p.co_seq_pagamento");
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('c.co_usuario = ?', $idUsuario);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return $data;
    }

    public function getCliente($id){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->joinLeft(array("rct" => "rl_cliente_telefone"), "rct.co_cliente=c.co_seq_cliente");
        $this->cliente->query->joinLeft(array("t" => "tb_telefone"), "rct.co_telefone=t.co_seq_telefone");
        $this->cliente->query->joinLeft(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->cliente->query->joinLeft(array("cg" => "tb_contrato_gog"), "a.co_contrato_gog=cg.co_seq_contrato_gog");
        $this->cliente->query->joinLeft(array("e" => "tb_empresa"), "c.co_empresa=e.co_seq_empresa");
        $this->cliente->query->joinLeft(array("cep" => "tb_cep"), "c.co_cep=cep.co_seq_cep");
        $this->cliente->query->joinLeft(array("p" => "tb_pagamento"), "p.co_acordo=a.co_seq_acordo");
        $this->cliente->query->joinLeft(array("sp" => "tb_status_pagamento"), "p.co_status_pagamento=sp.co_seq_status_pagamento");
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('c.co_seq_cliente = ?', $id);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('rct.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        $data = array();
        $i=0;
        foreach($dataCliente as $value){
            $data["telefone"][$i]["nu_telefone"] = $value["nu_telefone"];
            $data["telefone"][$i]["nu_ddd"] = $value["nu_ddd"];
            $data["telefone"][$i]["tp_telefone"] = $value["tp_telefone"];
            $i++;
        }
        $data["cliente"] = $dataCliente[0];
        return $data;
    }

    public function getClienteEdit($id){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->joinLeft(array("rct" => "rl_cliente_telefone"), "rct.co_cliente=c.co_seq_cliente");
        $this->cliente->query->joinLeft(array("t" => "tb_telefone"), "rct.co_telefone=t.co_seq_telefone");
        $this->cliente->query->joinLeft(array("cep" => "tb_cep"), "c.co_cep=cep.co_seq_cep");
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('c.co_seq_cliente = ?', $id);
        $this->cliente->query->where('rct.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        $data = array();
        foreach($dataCliente as $value){
            $data["telefone"][$value["tp_telefone"]]["nu_telefone"] = $value["nu_telefone"];
            $data["telefone"][$value["tp_telefone"]]["nu_ddd"] = $value["nu_ddd"];
            $data["telefone"][$value["tp_telefone"]]["tp_telefone"] = $value["tp_telefone"];
        }
        $data["cliente"] = $dataCliente[0];
        return $data;
    }

    public function getClienteVendedor($id){
        //$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        //$sql = "SELECT COUNT(*) FROM `tb_cliente` WHERE (c.st_registro = 1) AND (c.co_usuario_registrou = ".$id." )";
        //$stmt = $db->query($sql);
        //$data["data"] = $stmt->fetchAll();
        $this->cliente->query->from(array("c" => "tb_cliente"), array('count(*) as q'));
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('c.co_usuario_registrou = ?', $id);
        $data = $this->cliente->returnQuery();
        return $data[0];
    }

    public function getClienteFuncionario($id){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('count(*) as q'));
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('c.co_usuario_registrou = ?', $id);
        $data = $this->cliente->returnQuery();
        return $data[0];
    }

    public function getClientes($search="", $page=1, $per=20){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*20;
        $sql = "SELECT `c`.nm_cliente, `c`.nm_login, `c`.dt_nascimento, `c`.co_seq_cliente, `c`.st_cliente, ( SELECT COUNT(*) FROM tb_cliente as cc WHERE cc.st_registro=1 AND cc.st_cliente=1) as n FROM `tb_cliente` AS `c` WHERE (c.st_registro = 1) AND (c.st_cliente=1) AND (c.nm_cliente LIKE '%".$search."%' ) ORDER BY `c`.`dt_inclusao` DESC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCount();
        return $data;
    }

    public function getClientesExcluido($search="", $page=1, $per=20){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*20;
        $sql = "SELECT `c`.nm_cliente, `c`.nm_login, `c`.dt_nascimento, `c`.co_seq_cliente, `c`.st_cliente, ( SELECT COUNT(*) FROM tb_cliente as cc WHERE cc.st_registro=1 AND cc.st_cliente=1) as n FROM `tb_cliente` AS `c` WHERE (c.st_registro = 1) AND (c.st_cliente=2) AND (c.nm_cliente LIKE '%".$search."%' ) ORDER BY `c`.`dt_inclusao` DESC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCountExcluido();
        return $data;
    }

    public function getClientesByCPF($search="", $page=1, $per=10){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*10;
        $sql = "SELECT `c`.nm_cliente, `c`.nm_login, `c`.dt_nascimento, `c`.co_seq_cliente, `c`.st_cliente FROM `tb_cliente` AS `c` WHERE (c.st_registro = 1) AND (c.nu_cpf = '".$search."' ) ORDER BY `c`.`dt_inclusao` ASC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCount();
        return $data;
    }

    public function getClientesCancela($search="", $page=1, $per=10){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*10;
        $sql = "SELECT `c`.nm_cliente, `c`.nm_login, `c`.dt_nascimento, `c`.co_seq_cliente, `c`.st_cliente, ( SELECT COUNT(*) FROM tb_cliente as cc WHERE cc.st_registro=1 AND cc.st_cliente=1) as n FROM `tb_cliente` AS `c` WHERE (c.st_registro = 1) AND (c.st_cliente=1) AND (c.nm_cliente LIKE '%".$search."%' ) ORDER BY `c`.`dt_inclusao` ASC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCount();
        return $data;
    }

    public function getClientesCancelaCancelados($search="", $page=1, $per=10){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*10;
        $sql = "SELECT `c`.nm_cliente, `c`.nm_login, `c`.dt_nascimento, `c`.co_seq_cliente, `c`.st_cliente, ( SELECT COUNT(*) FROM tb_cliente as cc WHERE cc.st_registro=1 AND cc.st_cliente=2) as n FROM `tb_cliente` AS `c` WHERE (c.st_registro = 1) AND (c.st_cliente=2) AND (c.nm_cliente LIKE '%".$search."%' ) ORDER BY `c`.`dt_inclusao` ASC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCountCancelados();
        return $data;
    }

    public function getClienteByUsuario($idUsuario){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("u" => "tb_usuario"), "c.co_usuario=u.co_seq_usuario");
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('u.co_seq_usuario = ?', $idUsuario);
        $this->cliente->query->where('u.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        return $dataCliente[0];
    }

    public function getClienteByBoleto($idBoleto){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("b" => "tb_boleto"), "b.co_cliente=c.co_seq_cliente");
        $this->cliente->query->where('c.st_registro = ?', 1);
        $this->cliente->query->where('b.co_seq_boleto = ?', $idBoleto);
        $this->cliente->query->where('b.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        return $dataCliente[0];
    }

    public function getPagamentoByCliente($id){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->cliente->query->join(array("p" => "tb_pagamento"), "a.co_seq_acordo=p.co_acordo");
        $this->cliente->query->where('c.co_seq_cliente = ?', $id);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $dataCliente = $this->cliente->returnQuery();
        return (isset($dataCliente[0]))?$dataCliente[0]:array();
    }

    public function getClientesRelatorioPago($search="", $page=1, $per=10){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*10;
        $sql  = "SELECT pago(p.co_status_pagamento, p.co_forma_pagamento, c.co_seq_cliente) AS pagamento, c.nm_cliente, c.co_seq_cliente, c.st_cliente, fp.nm_forma_pagamento, cg.nm_contrato_gog, p.co_status_pagamento, p.co_forma_pagamento, a.dt_finaliza, sp.nm_status_pagamento FROM tb_cliente AS c ";
        $sql .= "INNER JOIN tb_acordo AS a ON c.co_seq_cliente=a.co_cliente ";
        $sql .= "INNER JOIN tb_pagamento AS p ON a.co_seq_acordo=p.co_acordo ";
        $sql .= "INNER JOIN tb_forma_pagamento AS fp ON fp.co_seq_forma_pagamento=p.co_forma_pagamento ";
        $sql .= "INNER JOIN tb_status_pagamento AS sp ON sp.co_seq_status_pagamento=p.co_status_pagamento ";
        $sql .= "INNER JOIN tb_contrato_gog AS cg ON cg.co_seq_contrato_gog=a.co_contrato_gog ";
        $sql .= "WHERE (c.st_registro = 1) AND (c.nm_cliente LIKE '%".$search."%' ) ";
        $sql .= "HAVING pagamento=1 OR pagamento=2 ";
        $sql .= "ORDER BY `c`.`dt_inclusao` DESC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCountRelatorio(true, "");
        return $data;
    }

    public function getClientesRelatorioNaoPago($search="", $page=1, $per=10){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*10;
        $sql  = "SELECT pago(p.co_status_pagamento, p.co_forma_pagamento, c.co_seq_cliente) AS pagamento, c.nm_cliente, c.co_seq_cliente, c.st_cliente, fp.nm_forma_pagamento, cg.nm_contrato_gog, p.co_status_pagamento, p.co_forma_pagamento, a.dt_finaliza, sp.nm_status_pagamento FROM tb_cliente AS c ";
        $sql .= "INNER JOIN tb_acordo AS a ON c.co_seq_cliente=a.co_cliente ";
        $sql .= "INNER JOIN tb_pagamento AS p ON a.co_seq_acordo=p.co_acordo ";
        $sql .= "INNER JOIN tb_forma_pagamento AS fp ON fp.co_seq_forma_pagamento=p.co_forma_pagamento ";
        $sql .= "INNER JOIN tb_status_pagamento AS sp ON sp.co_seq_status_pagamento=p.co_status_pagamento ";
        $sql .= "INNER JOIN tb_contrato_gog AS cg ON cg.co_seq_contrato_gog=a.co_contrato_gog ";
        $sql .= "WHERE (c.st_registro = 1) AND (c.nm_cliente LIKE '%".$search."%' ) AND (c.st_cliente=1) ";
        $sql .= "HAVING pagamento=3 OR pagamento=4 ";
        $sql .= "ORDER BY `c`.`dt_inclusao` DESC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCountRelatorio(false, "");
        return $data;
    }

    public function getClienteByNameCpf($name, $cpf){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql  = "select * from tb_cliente where nm_cliente='".$name."' and nm_login='".$cpf."' order by co_seq_cliente desc limit 1";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data[0];
    }

    private function getCountRelatorio($pago=true, $search=""){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql  = "SELECT pago(p.co_status_pagamento, p.co_forma_pagamento, c.co_seq_cliente) AS pagamento FROM tb_cliente AS c ";
        $sql .= "INNER JOIN tb_acordo AS a ON c.co_seq_cliente=a.co_cliente ";
        $sql .= "INNER JOIN tb_pagamento AS p ON a.co_seq_acordo=p.co_acordo ";
        $sql .= "INNER JOIN tb_forma_pagamento AS fp ON fp.co_seq_forma_pagamento=p.co_forma_pagamento ";
        $sql .= "INNER JOIN tb_status_pagamento AS sp ON sp.co_seq_status_pagamento=p.co_status_pagamento ";
        $sql .= "INNER JOIN tb_contrato_gog AS cg ON cg.co_seq_contrato_gog=a.co_contrato_gog ";
        $sql .= "WHERE (c.st_registro = 1) AND (c.nm_cliente LIKE '%".$search."%' ) AND (c.st_cliente=1) ";
        if($pago==true){
            $sql .= "HAVING pagamento=1 OR pagamento=2 ";
        }else {
            $sql .= "HAVING pagamento=3 OR pagamento=4 ";
        }
        $sql .= "ORDER BY `c`.`dt_inclusao` DESC ";
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        return count($data["data"]);
    }

    private function getCount(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "select count(*) as contador from tb_cliente where st_registro=1 AND st_cliente=1";
        $stmt = $db->query($sql);
        $users =  $stmt->fetchAll();
        return $users[0]["contador"];
    }

    private function getCountExcluido(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "select count(*) as contador from tb_cliente where st_registro=1 AND st_cliente=2";
        $stmt = $db->query($sql);
        $users =  $stmt->fetchAll();
        return $users[0]["contador"];
    }

    private function getCountCancelados(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "select count(*) as contador from tb_cliente where st_registro=1 AND st_cliente=2";
        $stmt = $db->query($sql);
        $users =  $stmt->fetchAll();
        return $users[0]["contador"];
    }

    public function clean(){
        $this->init();
    }

}