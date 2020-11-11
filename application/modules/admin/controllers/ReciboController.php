<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 28/11/17
 * Time: 11:06
 */

class Admin_ReciboController extends Zend_Controller_Action {

    private $post;
    private $modelRecibo;
    public $session_login;
    private $permissions = array(1, 2, 3);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelRecibo = new Admin_Model_DbTable_Recibo();
        if(!Util_Util::isAjax()){
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
                $modelCaixa = new Admin_Model_DbTable_Caixa();
                $this->view->dataCaixaE = $modelCaixa->getCaixaAtivo();
            }else if($this->session_login->coTipoLogin==3) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteFuncionario($this->session_login->coSeqPaciente);
            }else if($this->session_login->coTipoLogin==5){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteVendedor($this->session_login->coSeqPaciente);
            }else
            if($this->session_login->coTipoLogin==4){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
            }
        }
    }

    public function viewAction(){
        $idPagamento = $this->getParam("id");
        $dataRecibo = $this->modelRecibo->getRecibo($idPagamento);
        if(count($dataRecibo)==0){
            $dataRecibo = null;
            $dataRecibo["lk_recibo"] = "test.pdf";
            $dataRecibo["co_pagamento"] = $idPagamento;
            $dataRecibo["tp_recibo"] = "P";
            $this->modelRecibo->recibo->insertOne($dataRecibo);
            $this->modelRecibo->clean();
            $dataRecibo = $this->modelRecibo->getRecibo($idPagamento);
        }
        $this->createCartaoPDF($dataRecibo[0]);
        $this->redirect('/adm/temp/pdfRecibo/'.$dataRecibo[0]["co_seq_recibo"].'.pdf');
    }

    public function cancelamentoAction(){
        $idCliente = $this->getParam("id");
        $modelBoleto = new Admin_Model_DbTable_Boleto();
        $dataBoleto = $modelBoleto->getBoletoByClienteNaoPago($idCliente);
        if(count($dataBoleto)==0) {
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $dataPagamento = $modelPagamento->getByCliente($idCliente);
            $dataRecibo = $this->modelRecibo->getRecibo($dataPagamento["co_seq_pagamento"]);
            if(count($dataRecibo)==0) {
                $dataRecibo = null;
                $dataRecibo["lk_recibo"] = "cancelamento.pdf";
                $dataRecibo["co_pagamento"] = $dataPagamento["co_seq_pagamento"];
                $dataRecibo["tp_recibo"] = "C";
                $this->modelRecibo->recibo->insertOne($dataRecibo);
                $this->modelRecibo->clean();
                $dataRecibo = $this->modelRecibo->getRecibo($dataPagamento["co_seq_pagamento"]);
            }
            $dataRecibo[0]["valor"] = 0;
            $this->createCartaoPDF($dataRecibo[0], true);
            $this->redirect('/adm/temp/pdfRecibo/cancelamento/'.$dataRecibo[0]["co_seq_recibo"].'.pdf');
        }else{
            $countValor = 0;
            foreach ($dataBoleto as $value){
                $countValor = $countValor + 3;
            }
            $dataRecibo = $this->modelRecibo->getRecibo($dataBoleto[0]["co_seq_pagamento"]);
            if(count($dataRecibo)==0) {
                $dataRecibo = null;
                $dataRecibo["lk_recibo"] = "cancelamento.pdf";
                $dataRecibo["co_pagamento"] = $dataBoleto[0]["co_seq_pagamento"];
                $dataRecibo["tp_recibo"] = "C";
                $this->modelRecibo->recibo->insertOne($dataRecibo);
                $this->modelRecibo->clean();
                $dataRecibo = $this->modelRecibo->getRecibo($dataBoleto[0]["co_seq_pagamento"]);
            }
            $dataRecibo[0]["valor"] = $countValor;
            $this->createCartaoPDF($dataRecibo[0], true);
            $this->redirect('/adm/temp/pdfRecibo/cancelamento/'.$dataRecibo[0]["co_seq_recibo"].'.pdf');
        }
    }

    private function getTextRecibo($dataRecibo, $cancelamento){
        $arrayText = array();
        $text  = "";
        $text .= "        A Empresa MarqSaúde Vantagens - Administradora de Cartões de";
        $arrayText[0] = $text;
        $text  = "";
        $text .= "Benefícios LTDA - ME ,inscrito no CNPJ sob o nº: 29.139.123/0001-90,";
        $arrayText[1] = $text;
        $text  = "";
        $text .= "localizada à QS 03 Lotes 3/5/7/9 Sobreloja 113 Edifício Pátio Capital -";
        $arrayText[2] = $text;
        $text  = "";
        $text .= "Águas Claras - DF, declara que recebeu de ";
        if(strlen($dataRecibo["nm_cliente"]) < 29 ) {
            $text .= $dataRecibo["nm_cliente"];
        }
        $arrayText[3] = $text;
        $text  = "";
        if(strlen($dataRecibo["nm_cliente"]) >= 29 ) {
            $text .= $dataRecibo["nm_cliente"] . ",";
            $arrayText[4] = $text;
            $text = "";
        }
        $text .= "inscrito no CPF sob o nº ";
        $text .= $dataRecibo["nu_cpf"];
        $text .= ", a importância de";
        $arrayText[5] = $text;
        $text  = "";
        if($cancelamento){
            $text .= "R$".$dataRecibo["valor"];
            $text .= " (".Util_NumeroExtenso::convertNumberToWords($dataRecibo["valor"])." reais)";
            $text .= " referente ao ";
        }else{
            $text .= "R$".$dataRecibo["nu_valor_transacao"];
            $text .= " (".Util_NumeroExtenso::convertNumberToWords($dataRecibo["nu_valor_transacao"]).")";
            $text .= " referente ao pagamento da Taxa Anual";
        }
        $arrayText[6] = $text;
        $text  = "";
        if($cancelamento) {
            $text .= "cancelamento dos Boletos gerados pelo Plano " . $dataRecibo["nm_contrato_gog"] . ".";
        }else{
            $text .= "administrativa do Plano " . $dataRecibo["nm_contrato_gog"] . ".";
        }
        $arrayText[7] = $text;
        return $arrayText;
    }

    private function getTextDataRecibo(){
        $text  = "";
        $text .= "Águas Claras - DF, ". Util_Util::getDataMesExtenso().".";
        return $text;
    }

    private function createCartaoPDF($dataRecibo, $cancelamento = false){
        $pdf = Zend_Pdf::load(realpath(dirname(__FILE__))."/../../../../inc/recibo.pdf");
        $page = $pdf->pages[0];
        //$OCRAEXTFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/OCRAEXT.TTF');
        $ArialFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/arial.ttf');
        $ArialBoldFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/arial-bold.ttf');
        //$ErasDemiItcFont = Zend_Pdf_Font::fontWithPath(realpath(dirname(__FILE__)).'/../../../../html/adm/fonts/eras-demi-itc.ttf');
        //var_dump($this->getTextRecibo($dataRecibo)[0]);exit;
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[0], 87, 527, 'UTF-8');
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[1], 87, 507, 'UTF-8');
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[2], 87, 487, 'UTF-8');
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[3], 87, 467, 'UTF-8');
        if(strlen($dataRecibo["nm_cliente"]) >= 29) {
            $page->setFont($ArialBoldFont, 12);
            $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
                ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[4], 87, 447, 'UTF-8');
        }
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[5], 87, 427, 'UTF-8');
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[6], 87, 407, 'UTF-8');
        $page->setFont($ArialFont, 12);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextRecibo($dataRecibo, $cancelamento)[7], 87, 387, 'UTF-8');
        $page->setFont($ArialFont, 14);
        $page->setFillColor(Zend_Pdf_Color_Html::color('#3e3e3e'))
            ->drawText($this->getTextDataRecibo(), 37, 77, 'UTF-8');
        //$page->setFont($ErasDemiItcFont, 47);
        //$page->setFillColor(Zend_Pdf_Color_Html::color('#ffffff'))
            //->drawText(strtoupper($dataAcordo["nm_cliente"]), 43, 40);
        //$image = Zend_Pdf_Image::imageWithPath($img);
        //$page1 = $pdf->pages[1];
        //$page1->drawImage($image, 560, 483, 800, 243);
        if($cancelamento){
            $pdf->save('adm/temp/pdfRecibo/cancelamento/'.$dataRecibo["co_seq_recibo"].'.pdf');
        }else{
            $pdf->save('adm/temp/pdfRecibo/'.$dataRecibo["co_seq_recibo"].'.pdf');
        }
    }

}