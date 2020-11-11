<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 07/08/17
 * Time: 17:51
 */

class Default_PagSeguroController extends Zend_Controller_Action {

    private $session_login;
    private $session_gog;
    public $posts;
    private $pagSeguro;
    private $code;

    /*** Constantes ***/
    private $para = "agendamentomarqsaude@gmail.com";
    private $smtp = "smtp.gmail.com";
    private $conta = "agendamentomarqsaude@gmail.com";
    private $senha = "marqsaude2015";
    private $assunto = "Contato Q Saúde Vantagens";
    private $post;
    private $isMobile;

    public function init(){

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('Login');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("nova");
        $this->pagSeguro = new Pagseguro_PagSeguro();
        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
        //header("access-control-allow-origin: https://pagseguro.uol.com.br");
        header("Content-Type: text/html; charset=UTF-8",true);
        date_default_timezone_set('America/Sao_Paulo');

    }

    public function pagarAction(){
        $this->cadastraPagamento();
        $cep = $this->session_gog->cep["nu_cep"];
        $cepSend=substr($cep, 0, -6).".".substr($cep, 2, -3)."-".substr($cep, -3);

        //EFETUAR PAGAMENTO
        $venda2 = array("codigo"=>$this->session_gog->contrato["idPagamento"],
            "valor"=>floatval($this->session_gog->contrato["nu_valor"]),
            "descricao"=>"VENDA DE CARTÃO",
            "nome"=>$this->session_gog->cliente["nm_cliente"],
            "email"=>$this->session_gog->cliente["nm_email"],
            "telefone"=>$this->session_gog->telefone["nu_celular"],
            "rua"=>$this->session_gog->cep["nm_logradouro"],
            "numero"=>"102",
            "bairro"=>$this->session_gog->cep["nm_bairro"],
            "cidade"=>$this->session_gog->cep["nm_localidade"],
            "estado"=>$this->session_gog->cep["nm_uf"], //2 LETRAS MAIÚSCULAS
            "cep"=>$cepSend,
            "codigo_pagseguro"=>"");

        $modelConfiguracao = new Default_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getConfigurationAdmin();
        //var_dump($venda2, $venda);exit;
        $this->sendEmail($this->session_gog->cliente["nm_cliente"], $this->session_gog->cliente["nm_login"], $dataConfiguracao);
        $this->pagSeguro->executeCheckout($venda2, $dataConfiguracao["nm_url_sistema"]."/pag-seguro/return-transaction/");


        //$modelCep = new Default_Model_DbTable_Cep();
        //$dataCep=$modelCep->getByCep($this->session_gog->cep["nu_cep"]);
        //if(count($dataCep)==0){
            //$idCep=$modelCep->cep->insertOne($this->session_gog->cep);
        //}else{
            //$idCep = $dataCep[0]["co_seq_cep"];
        //}
        /*$dataUsuario["co_tipo_usuario"] = 4;
        $dataUsuario["nm_usuario"] = $this->session_gog->cliente["nm_cliente"];
        $dataUsuario["nm_login"] = $this->session_gog->cliente["nm_email"];
        $dataUsuario["nm_senha"] = "fgrb35!@fhgkjRHQw$%.";
        $modelUsuario = new Default_Model_DbTable_Usuario();
        $idUsuario=$modelUsuario->usuario->insertOne($dataUsuario);

        $dataCliente = $this->session_gog->cliente;
        $dataCliente["co_cep"] = $idCep;
        $dataCliente["co_tipo_cliente"] = 1;
        $dataCliente["co_empresa"] = 5;
        $dataCliente["co_usuario"] = $idUsuario;
        $dataCliente["co_usuario_registrou"] = ($this->session_login->logado)?$this->session_gog->vendedor:5;
        $dataCliente["nu_rg"] = str_replace(".", "", $dataCliente["nu_rg"]);
        $dataCliente["nu_rg"] = str_replace("-", "", $dataCliente["nu_rg"]);
        $dataCliente["nu_cpf"] = str_replace(".", "", $dataCliente["nu_cpf"]);
        $dataCliente["nu_cpf"] = str_replace("-", "", $dataCliente["nu_cpf"]);
        $dataCliente["dt_nascimento"] = Util_Util::changeDateToSql($dataCliente["dt_nascimento"]);
        $dataCliente["nm_login"] = $dataCliente["nu_cpf"];
        $dataCliente["nm_senha"] = "fgrb35!@fhgkjRHQw$%.";
        $dataCliente["st_muda_senha"] = 1;
        $dataCliente["st_cliente"] = 1;

        $modelCliente = new Default_Model_DbTable_Cliente();
        $idCliente=$modelCliente->cliente->insertOne($dataCliente);*/

        //$dataTelefone=array();
        //$dataRLClienteTelefone=array();
        //var_dump($this->session_gog->telefone);exit;
        //$utilTelefone = new Util_Telefone();
        //$utilTelefone->registraTelefone($this->session_gog->telefone, "cliente", $idCliente);
        /*foreach($this->session_gog->telefone as $key=>$value){
            $modelTelefone = new Default_Model_DbTable_Telefone();
            $modelRLClienteTelefone = new Default_Model_DbTable_RLClienteTelefone();
            $dataTelefone = array();
            if($value!=false){
                $dataTelefone["nu_telefone"] = substr($value, 5);
                $dataTelefone["nu_telefone"] = str_replace("-", "", $dataTelefone["nu_telefone"]);
                $dataTelefone["nu_ddd"] = substr($value, 1, 2);
                if(count($modelTelefone->getByTelefone($dataTelefone["nu_telefone"], $dataTelefone["nu_ddd"]))==0) {
                    switch ($key) {
                        case "nu_telefone":
                            $dataTelefone["tp_telefone"] = "T";
                            break;
                        case "nu_celular":
                            $dataTelefone["tp_telefone"] = "C";
                            break;
                        case "nu_whatsapp":
                            $dataTelefone["tp_telefone"] = "W";
                            break;
                    }
                    $dataRLClienteTelefone["co_telefone"] = $modelTelefone->telefone->insertOne($dataTelefone);
                    $dataRLClienteTelefone["co_cliente"] = $idCliente;
                    $modelRLClienteTelefone->clienteTelefone->insertOne($dataRLClienteTelefone);
                }
            }
        }*/
        //$modelContratoGog = new Default_Model_DbTable_ContratoGog();
        //$dataContratoGog = $modelContratoGog->getContratoGog($this->session_gog->acordo["co_contrato_gog"]);

        //$modelAcordo = new Default_Model_DbTable_Acordo();
        //$dataAcordo = array();
        //$dataAcordo["co_contrato_gog"] = $this->session_gog->acordo["co_contrato_gog"];
        //$dataAcordo["co_cliente"] = $idCliente;
        //$dataAcordo["co_usuario"] = 5;
        //$dataAcordo["dt_acordo"] = Util_Util::getDateMysqlNow();
        //$dataAcordo["dt_finaliza"] = Util_Util::addMonthToDate($dataAcordo["dt_acordo"], $dataContratoGog[0]["nu_meses"]);
        //$idAcordo = $modelAcordo->acordo->insertOne($dataAcordo);

        //$modelPagamento = new Default_Model_DbTable_Pagamento();
        //$dataPagamento = array();
        //$dataPagamento["co_status_pagamento"] = 1;
        //$dataPagamento["co_acordo"] = $idAcordo;
        //$dataPagamento["co_forma_pagamento"] = $this->session_gog->pagamento["co_forma_pagamento"];
        //$idPagamento=$modelPagamento->pagamento->insertOne($dataPagamento);


        /*$venda = array("codigo"=>"1",
            "valor"=>100.00,
            "descricao"=>"VENDA DE NONONONONONO",
            "nome"=>"Tony Anderson",
            "email"=>"teste@teste.com",
            "telefone"=>"(61) 88888-8888",
            "rua"=>"C 5",
            "numero"=>"102",
            "bairro"=>"Taguatinga Centro (Taguatinga)",
            "cidade"=>"Brasília",
            "estado"=>"DF", //2 LETRAS MAIÚSCULAS
            "cep"=>"72.010-050",
            "codigo_pagseguro"=>"");*/
        /*$modelCaixa = new Default_Model_DbTable_Caixa;
        $dataCaixa = $modelCaixa->getCaixaAtivo();

        $modelExtrato = new Default_Model_DbTable_Extrato();
        $dataExtrato = array();
        $dataExtrato["co_caixa"] = $dataCaixa[0]["co_seq_caixa"];
        $dataExtrato["co_pagamento"] = $idPagamento;
        $dataExtrato["nu_saldo"] = $dataCaixa[0]["nu_saldo"];
        $dataExtrato["nu_valor_transacao"] = floatval($dataContratoGog[0]["nu_valor"]);
        $dataExtrato["tp_transacao"] = 1;
        $dataExtrato["st_pagamento"] = 2;
        $modelExtrato->extrato->insertOne($dataExtrato);

        $modelCartao = new Default_Model_DbTable_Cartao();
        $modelCartao->cartao->insertOne(array("co_cliente"=>$idCliente, "st_cartao"=>2));*/
    }

    public function retornoAction(){
        $this->post = $this->_request->getPost();
        /*$data = array("nm_email_para"=>"vamos@vamos.com", "nm_nome"=>"Énois", "nm_email_de"=>"agora@agora.com", "nm_assunto"=>"teste", "tx_mensagem"=>$post["notificationCode"], "tp_envio"=>1);
        $modelContato = new Default_Model_DbTable_Contato();
        $modelContato->contato->insertOne($data);*/
        //$file = fopen("/Applications/MAMP/htdocs/qsaude/banco/vai.txt","w");
        //fwrite($file, "hjgfgghj");
        //fclose($file);
        //$response = $this->pagSeguro->executeNotification($post);

        if(isset($this->post['notificationType']) && $this->post['notificationType'] == 'transaction') {
            $response = $this->pagSeguro->executeNotification($this->post);
            $modelPagamento = new Default_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento" => $response->status), array("tx_id_pagseguro" => $response->code));

            if($response->status==4 || $response->status==3) {
                $modelCliente = new Default_Model_DbTable_Cliente();
                $dataCliente = $modelCliente->getClienteByIdPagSeguro($response->code);
                $modelCartao = new Default_Model_DbTable_Cartao();
                if(isset($dataCliente)) {
                    $dataCartao = $modelCartao->getByCliente($dataCliente["co_seq_cliente"]);
                    if(isset($dataCartao)) {
                        $cardNumber = new Util_CardNumber($dataCartao["co_seq_cartao"]);
                        $modelCartao->clean();
                        $modelCartao->cartao->edit(array("nu_cartao" => $cardNumber->getNumberCard(), "st_cartao" => 1), array("co_cliente" => $dataCliente["co_seq_cliente"]));
                    }
                }
                $this->changeValue($response->code);
            }
        }else{
        }
        die();
    }

    private function changeValue($codePagSeguro){
        $modelExtrato = new Default_Model_DbTable_Extrato();
        $modelExtrato->editByCodePagSeguro($codePagSeguro);
    }

    public function getStatusAction(){
        if(isset($_GET['reference'])){
            $P = $this->pagSeguro->getStatusByReference($_GET['reference']);
            echo $this->pagSeguro->getStatusText($P->status);
        }else{
            echo "Parâmetro \"reference\" não informado!";
        }
    }

    public function returnTransactionAction(){
        $this->post = $this->_request->getPost();
        $this->gerarCodigo();
        $id_transaction_q = ($this->getRequest()->getParam('id_transaction_q')=="")?$this->post["id_transaction_q"]:$this->getRequest()->getParam('id_transaction_q');
        if( isset($id_transaction_q) || !empty($id_transaction_q) ) {
            $objPagSeguro = $this->pagSeguro->getTransactionByCode($id_transaction_q);
            //$pagamento = $this->pagSeguro->getStatusByCode($id_transaction_q);
            $modelPagamento = new Default_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento" => 0, "tx_id_pagseguro"=>$id_transaction_q), $objPagSeguro->reference);
            $modelCliente = new Default_Model_DbTable_Cliente();
            $this->view->dataCliente = $modelCliente->getClienteByIdPagSeguro($id_transaction_q);
            $modelConfiguracao = new Default_Model_DbTable_Configuracao();
            $dataConfiguracao = $modelConfiguracao->getConfigurationAdmin();
            $emailSendEmail = new Email_SendEmail($this->view->dataCliente, $this->code, array("nm_contrato_gog"=>$this->view->dataCliente["nm_contrato_gog"]), $id_transaction_q);
            $emailSendEmail->send(null, $dataConfiguracao, false);
            if($this->session_login->logado){
                $userRegister= new Zend_Session_Namespace('UserRegister');
                $userRegister->coSeqCliente = $this->view->dataCliente["co_seq_cliente"];
                $userRegister->nmCliente = $this->view->dataCliente["nm_cliente"];
                $userRegister->nmEmail = $this->view->dataCliente["nm_email"];
                $this->_helper->redirector("return-transaction", "pag-seguro", "admin");
            }
            $modelCartao = new Default_Model_DbTable_Cartao();
            if(isset($dataCliente)) {
                $dataCartao = $modelCartao->getByCliente($this->view->dataCliente["co_seq_cliente"]);
                if(isset($dataCartao)) {
                    $cardNumber = new Util_CardNumber($dataCartao["co_seq_cartao"]);
                    $modelCartao->clean();
                    $modelCartao->cartao->edit(array("nu_cartao" => $cardNumber->getNumberCard(), "st_cartao" => 1), array("co_cliente" => $this->view->dataCliente["co_seq_cliente"]));
                }
            }
        }
    }

    private function cadastraPagamento(){
        $this->session_gog->cep;
    }

    private function gerarCodigo(){
        $this->code=Util_Util::getGenerateCode();
    }

    private function sendEmail($name, $login, $dataConfiguracao){
        $modelCliente = new Admin_Model_DbTable_Cliente();
        $dataCliente = $modelCliente->getClienteByNameCpf($name, $login);
        $this->code = $this->gerarCodigo();
        $emailSendEmail = new Email_SendEmail($dataCliente, $this->code, null, null);
        return $emailSendEmail->send(null, $dataConfiguracao[0], false);
    }

}