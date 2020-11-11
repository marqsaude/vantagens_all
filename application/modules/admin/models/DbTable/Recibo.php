<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 28/11/17
 * Time: 11:07
 */

class Admin_Model_DbTable_Recibo  extends Zend_Db_Table_Abstract {

    public $recibo;

    public function init()
    {
        $this->recibo = new Util_ZendModelGeneric();
        $this->recibo->construtor("recibo");
    }

    public function getRecibo($idPagamento){
        $this->recibo->query->from(array("r" => "tb_recibo"), array('*'));
        $this->recibo->query->join(array("p" => "tb_pagamento"), "p.co_seq_pagamento=r.co_pagamento");
        $this->recibo->query->join(array("a" => "tb_acordo"), "a.co_seq_acordo=p.co_acordo");
        $this->recibo->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->recibo->query->join(array("e" => "tb_extrato"), "p.co_seq_pagamento=e.co_pagamento");
        $this->recibo->query->join(array("cg" => "tb_contrato_gog"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->recibo->query->where("r.st_registro=?", 1);
        $this->recibo->query->where("r.dt_inclusao <= ?", Util_Util::getDateTimeMysqlNow());
        $this->recibo->query->where("r.co_pagamento=?", $idPagamento);
        $data = $this->recibo->returnQuery();
        return $data;
    }

    public function clean(){
        $this->init();
    }

}