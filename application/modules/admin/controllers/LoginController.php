<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 26/08/15
 * Time: 10:47
 */

class Admin_LoginController extends Zend_Controller_Action{

    private $post;
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("login");
    }

    public function indexAction(){
        //$this->view->erroLogin = $this->getParam("erroLogin");
        //$this->session_login->logado = false;
    }

    // LOGA USUÁRIOS
    public function logarAction(){
        $this->post = $this->_request->getPost();
        //$form = new Default_Form_Login();
        //var_dump($this->post["nm_login"], $this->post["nm_senha"]);exit;
        if ($this->getRequest()->isPost()) {
            //var_dump($this->post);exit;
            if (isset($this->post["nm_login"]) && isset($this->post["nm_senha"])){
                /*$modelPaciente = new Admin_Model_DbTable_Paciente();
                $autenticacaoLogin = $modelPaciente->paciente->findOptionArray(array(
                    "nm_login"=>$this->post["nm_login"],
                    "nm_senha"=>$this->post["nm_senha"]
                ));
                if (count($autenticacaoLogin)>0) {
                    $this->session_login->logado = true;
                    $this->session_login->coSeqPaciente = $autenticacaoLogin[0]["co_seq_paciente"];
                    $this->session_login->nmLogin = $autenticacaoLogin[0]["nm_login"];
                    $this->session_login->nmPaciente = $autenticacaoLogin[0]["nm_paciente"];
                    $this->session_login->coTipoLogin = 0;

                    die(json_encode(array("type"=>1, "msg"=>"Logado com sucesso!")));
                } else {*/
                $modelUsuario = new Admin_Model_DbTable_Usuario();
                $autenticacaoLogin = $modelUsuario->checkLogin($this->post["nm_login"], $this->post["nm_senha"]);
                $msg = "";
                $logar = false;
                if(count($autenticacaoLogin)>0){
                    if($autenticacaoLogin[0]["st_cliente"]==2 && $autenticacaoLogin[0]["registro_acordo"]==2){
                        $msg = "Contrato cancelado pelo cliente! Qualquer dúvida, favor entrar em contato com o Marq Saúde Vantagens por esse número (61)2026-1313.";
                        $logar=false;
                    } else if($autenticacaoLogin[0]["st_cliente"]==2){
                        $msg = "Cliente cancelado pelo Marq Saúde Vantagens! Qualquer dúvida, favor entrar em contato com o Marq Saúde Vantagens por esse número (61)2026-1313.";
                        $logar=false;
                    } else{
                        if($autenticacaoLogin[0]["co_tipo_usuario"]==4){
                            $modelCliente = new Admin_Model_DbTable_Cliente();
                            $dataCliente = $modelCliente->checkCliente($autenticacaoLogin[0]["co_seq_usuario"]);
                            if($dataCliente[0]["co_status_pagamento"] != 3 && $dataCliente[0]["co_status_pagamento"] != 4){
                                $msg = "Acordo ainda não foi quitado ou falta confirmação do pagamento pela administração Marq Saúde Vantagens, telefone: (61) 2026-1313.";
                                $logar=false;
                            }else{
                                $dataNow = intval(Util_Util::getDateBoletoNow());
                                $dataFinaliza = intval(str_replace("-", "", $dataCliente[0]["dt_finaliza"]));
                                if($dataNow>$dataFinaliza){
                                    $msg = "Contrato terminado! Necessário renovar.";
                                    $logar=false;
                                }else{
                                    $i=0;
                                    $stPago=1;
                                    foreach($dataCliente as $value) {
                                        $dataVencimento[$i] = intval(str_replace("-", "", $value["dt_vencimento"]));
                                        //$anoMesVencimento=substr($dataVencimento[$i], 0, -2);
                                        //$anoMesNow=substr($dataNow, 0, -2);
                                        if($dataVencimento[$i] <= $dataNow){
                                            if($value["st_pago"]==2){
                                                $stPago = 2;
                                            }
                                        }
                                        $i++;
                                    }
                                    if($stPago == 2){
                                        $msg = "Boleto não pago, confirma na administração da Marq Saúde Vantagens ou entrar em contato pelo telefone (61) 2026-1313!";
                                        $logar=false;
                                    }else{
                                        $msg = "Logado com sucesso!";
                                        $logar=true;
                                    }
                                }
                            }
                        }else {
                            $msg = "Logado com sucesso!";
                            $logar=true;
                        }
                    }
                }else{
                    $msg = "Login ou Senha incorreto!";
                    $logar=false;
                }
                if ($logar) {
                    $this->session_login->logado = true;
                    $this->session_login->coSeqPaciente = $autenticacaoLogin[0]["co_seq_usuario"];
                    $this->session_login->nmLogin = $autenticacaoLogin[0]["nm_login"];
                    $this->session_login->nmPaciente = $autenticacaoLogin[0]["nm_usuario"];
                    $this->session_login->coTipoLogin = $autenticacaoLogin[0]["co_tipo_usuario"];
                    die(json_encode(array("type"=>1, "msg"=>$msg)));
                } else {
                    //if(isset($this->post['requisicao']) && $this->post['requisicao']=="ajax"){
                    die(json_encode(array("type" => 2, "msg" => $msg)));
                }
                //}

            } else {
                if($this->post['requisicao']=="normal") {
                    die(json_encode(array("type"=>2, "msg"=>"erro, não existe paciente")));
                }else{
                    die(json_encode(array("type"=>2, "msg"=>"erro, não existe paciente")));
                }
            }

        }else{
            if($this->post['requisicao']=="normal") {
                die(json_encode(false));
            }else{
                die(json_encode(false));
            }
        }
    }

    // LOGOUT
    public function logoutAction()
    {
        $login = $_POST;
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        Zend_Session::destroy(true);
        if($login['requisicao']=="ajax" && isset($login)) {
            die(json_encode(true));
        }else{
            $this->_redirect('');
        }
    }

}