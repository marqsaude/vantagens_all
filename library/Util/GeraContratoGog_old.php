<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 08/05/2018
 * Time: 15:16
 */

class Util_GeraContratoGog {

    private $idCliente;

    function __construct($idCliente){
        $this->idCliente = $idCliente;
    }

    public function gerar(){
        $modelConfiguracao = new Default_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getConfigurationAdmin();
        $modelContratoGog = new Admin_Model_DbTable_ContratoGog();
        $dataContratoGog = $modelContratoGog->getContratoByCliente($this->idCliente);
        $url[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contrato/".$dataContratoGog["nm_contrato_gog"].".htm";
        //$url[1] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoPlus.htm";
        //$url[2] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoMaster.htm";
        $urlOut[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/".$dataContratoGog["nm_contrato_gog"].$this->idCliente.".pdf";
        //$urlOut[1] = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/contratoPlus.pdf";
        //$urlOut[2] = $dataConfiguracao["nm_url_absoluta"] . "/site/pdf/contrato/contratoMaster.pdf";
        $urlTemp[0] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contrato/".$dataContratoGog["nm_contrato_gog"].$this->idCliente.".htm";
        //$urlTemp[1] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoPlusTemp.htm";
        //$urlTemp[2] = $dataConfiguracao["nm_url_absoluta"] . "/site/html/contratoMasterTemp.htm";
        $urlCss = $dataConfiguracao["nm_url_absoluta"] . "/site/css/contrato.css";
        $replace = array("#???????"=>$dataContratoGog["nm_cliente"].", CPF: ".Util_Util::organizeCPF($dataContratoGog["nu_cpf"]).", Rg: ".$dataContratoGog["nu_rg"]." e Residente: ".$dataContratoGog["nm_logradouro"]." ".$dataContratoGog["nm_bairro"], "???????"=>$dataContratoGog["nm_cliente"]);
        $isSingle = ($dataContratoGog["co_seq_contrato_gog"]==12)?true:false;
        $pdf = new Util_PDF($url, $urlOut, $urlCss, $urlTemp, $isSingle);
        $pdf->generatePDF($replace);
        return $dataContratoGog;
    }

}