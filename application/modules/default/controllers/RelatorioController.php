<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 25/01/18
 * Time: 15:10
 */

class Default_RelatorioController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->setLayout("layoutRelatorio");
    }

    public function printAction(){
        $post = $this->_request->getPost();
        $modelCliente = new Admin_Model_DbTable_Cliente();
        if($post["pago"]==1) {
            $dataCliente = $modelCliente->getClientesRelatorioPago("", 1, 999999999999999);
        }else{
            $dataCliente = $modelCliente->getClientesRelatorioNaoPago("", 1, 999999999999999);
        }
        $this->view->count = $dataCliente["count"];
        $this->view->data = $dataCliente["data"];
    }

}