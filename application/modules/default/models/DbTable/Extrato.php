<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/09/17
 * Time: 09:37
 */

class Default_Model_DbTable_Extrato  extends Zend_Db_Table_Abstract{

    public $extrato;

    public function init()
    {
        $this->extrato = new Util_ZendModelGeneric();
        $this->extrato->construtor("extrato");
    }

    public function editByCodePagSeguro($code){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=1, c.nu_saldo=(select SUM(e.nu_valor_transacao + c.nu_saldo)) ";
            $sql .= " where p.tx_id_pagseguro='" . $code . "' and e.st_pagamento=2 and e.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editByCodePagSeguroRemove($code){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=2, c.nu_saldo=(select SUM(c.nu_saldo - e.nu_valor_transacao)) ";
            $sql .= " where p.tx_id_pagseguro='" . $code . "' and e.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

}