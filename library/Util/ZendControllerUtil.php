<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 07/05/14
 * Time: 18:09
 */

class Util_ZendControllerUtil extends Zend_Controller_Action {

    protected  $crud;
    protected  $form;
    protected  $model;
    protected  $data;
    protected  $date;
    protected  $url;
    protected  $insertOderTable;
    protected  $numberInsertOderTable;
    protected  $idInsert=0;
    protected  $modelOderTable;
    protected  $arrayInsertOderTable;
    protected  $getPost=false;
    protected  $post=null;
    protected  $campoInicial=null;
    protected  $module=null;
    protected  $controllerUrl=null;
    protected  $redirect=true;
    protected  $erro=false;
    protected  $configProject;
    protected  $setVariavelForm;
    protected  $debugCrud=false;
    protected  $debugOderTables=false;

    public function init(){
        //var_dump($this->crud);exit;
        //var_dump("teste");exit;
        //Zend_Auth::getInstance()->getStorage();
        try{
            $this->read = Zend_Auth::getInstance()->getStorage()->read();
        }catch (Zend_Auth_Exception $e){
            $this->read = false;
        }catch (Exception $e){
            $this->read = false;
        }
        //$this->crud = $crud;
        //$this->model = $model;
        $this->date = new Zend_Date();
        $this->url = $this->getUrlCrud();
        $this->module = $this->getRequest()->getModuleName();
        $this->controllerUrl = ($this->controllerUrl == null)?$this->crud:$this->controllerUrl;
        $this->view->urlPage = 'http://'.$_SERVER['HTTP_HOST'].$this->getFrontController()->getBaseUrl()."/".$this->module."/".$this->controllerUrl;
        //$this->form = $form;
        if($this->form) {
            $this->form->setModel($this->model);
            $this->form->setVariavelForm($this->setVariavelForm);
            $this->form->createForm();
        }
        $frontController = Zend_Controller_Front::getInstance();
        $serviceOptions  = $frontController->getParam('bootstrap')->getOption('projeto');
        $this->configProject = $frontController->getParam('bootstrap')->getOption($serviceOptions["name"]);
    }

    /*********************************** Retorna a url do crud ************************************/
    protected function getUrlCrud(){
        return str_replace("_", "-", $this->crud);
    }

    /*********************************** Transforma objeto em array ************************************/
    protected function objectToArrayAction($object) {
        $arr = array();
        for ($i = 0; $i < count($object); $i++) {
            $arr     = get_object_vars($object);
        }
        return $arr;
    }

    /*********************************** Elimina elementos de um array que estão vazios ************************************/
    protected function eliminaElementosVazio($data=null){
        if($data){
            foreach ($data as $key => $value) {
                if (empty($value))
                    unset($data[$key]);
            }
            return $data;
        }else {
            foreach ($this->data as $key => $value) {
                if (empty($value))
                    unset($this->data[$key]);
            }
        }
    }

    /*********************************** Select da tabela do controler que esta sendo usado ************************************/
    protected  function selectTableId($id){
        $sql = $this->model->select()->where('co_seq_'.$this->crud.' = ?', $id);
        return $this->model->getAdapter()->fetchRow($sql);
    }

    /*********************************** Adiciona campos obrigatórios do include ************************************/
    protected function addCamposObrigatorios($data=null, $table=null){
        if($data){
            $data["nm_inclusao"] = $this->view->read->nm_usuario;
            $data["dt_inclusao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
            $data["st_registro"] = (isset($data[$table.".st_registro"])) ? $data[$table.".st_registro"] : 1;
            if(isset($data[$table.".st_registro"])){
                $data = $this->deleteElemtosArray($data, $table.".st_registro");
            }
            return $data;
        }else {
            $this->data["nm_inclusao"] = $this->view->read->nm_usuario;
            $this->data["dt_inclusao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
            $this->data["st_registro"] = 1;
        }
    }

    /*********************************** Adiciona campos obrigatórios do include ************************************/
    protected function editCamposObrigatorios($data=null){
        if($data){
            $data["nm_alteracao"] = $this->view->read->nm_usuario;
            $data["dt_alteracao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
            return $data;
        }else {
            $this->data["nm_alteracao"] = $this->view->read->nm_usuario;
            $this->data["dt_alteracao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
        }
    }

    /*********************************** Deleta elementos do array de inserção ************************************/
    protected function deleteElemtosArray($arrayExcecao, $elemento=null){
        if($elemento===null) {
            foreach ($arrayExcecao as $value) {
                unset($this->data[$value]);
            }
        }else{
            if(is_array($elemento)){
                foreach($elemento as $value){
                    unset($arrayExcecao[$value]);
                }
            }else {
                unset($arrayExcecao[$elemento]);
            }
            return $arrayExcecao;
        }
    }

    /********* Monta o array de inserção de outra tabela para ser retirado do array de inserção principal **********/
    protected function montaArrayExcecaoOutraTabela(){
        $arrayExcecao = array();
        foreach($this->insertOderTable as $key=>$value){
            foreach($value as $value2) {
                array_push($arrayExcecao, $value2);
            }
        }
        $this->setArrayOderTable();
        return $arrayExcecao;
    }

    /*********************************** Seta array de inserção de outras tabelas ************************************/
    protected function setArrayOderTable(){

        foreach($this->insertOderTable as $key=>$v) {
            foreach ($this->data as $key2 => $value) {
                if (array_search($key2, $v) !== False) {
                    $this->arrayInsertOderTable[$key][$key2] = $value;
                }
            }
            $this->arrayInsertOderTable[$key]["count"] = $v["count"];
        }

    }

    /*********************************** Insere elementos em outra tabela ************************************/
    protected function insertOderTables(){
        foreach($this->arrayInsertOderTable as $key=>$value){
            $count = $value["count"];
            $value = $this->deleteElemtosArray($value, "count");
            for($i=0; $i<$count; $i++) {
                $data = $this->addCamposObrigatorios($value, $key);
                $data["co_".$this->crud] = $this->idInsert;
                $data = ($i==0) ? $data : $this->formatData($data, $value, $i, $key) ;
                if($this->debugOderTables) {
                    var_dump($key, $data);
                }else {
                    $this->modelOderTable[$key]->insert($data);
                }
            }
        }
        if($this->debugOderTables) {
            exit;
        }
    }

    /*********************************** Formata dados ************************************/
    protected function formatData($data, $v, $i, $table=null){
        foreach($v as $key=>$value){
            $data[$key] = $this->post[$key.$i];
        }
        $data = $this->deleteElemtosArray($data, $table.".st_registro");
        return $data;
    }

    /**************************** Recupera contador de um certo campo q esta vindo repetido no post *****************************/
    protected function getCountContainer($campo){
        $count=0;
        foreach($_POST as $key=>$value){
            if(strpos($key, $campo) !== false){
                $count++;
            }
        }
        return $count;
    }

    /*********************************** Retorna valor somado de campos ************************************/
    protected function getTotal($array, $campo){
        $total=0;
        foreach($array as $value){
            $total = intval($value[$campo]) + $total;
        }
        return $total;
    }

    /*********************************** Retorna campos ************************************/
    protected function getCampos($campo){
        $campos = array();
        foreach($_POST as $key=>$value){
            if(strpos($key, $campo) !== false){
                $campos[] = $value;
            }
        }
        return $campos;

    }

    /*********************************** Retorna dados de um formulário ************************************/
    protected function getDataForm(){
        if($this->getRequest()->isPost()) {
            if ($this->form->isValid($this->getRequest()->getParams())) {
                return $this->form->getValues();
            }
        }
    }

    /*********************************** Redireciona URL ************************************/
    protected function redirectUrl($url){
        $this->_redirect("/admin/".$url."/");
    }

    /*********************************** Formata o preço de mostragem ************************************/
    protected function formataPreco($preco){
        $preco = strval(floatval(str_replace(",", ".", $preco)));
        if(strpos($preco, '.') == false){
            $preco = $preco.',00';
        }else{
            $preco = str_replace('.', ',', $preco);
            $preco = ($preco{strlen($preco)-2} == ',') ? $preco.'0' : $preco;
        }
        return $preco;
    }

    /*********************************** Formata o preço ************************************/
    protected function formataPrecoInsert($preco){
        $preco = str_replace(".", "", $preco);
        $preco = strval(floatval(str_replace(",", ".", $preco)));
        return floatval($preco);
    }

    /*********************************** Formata data para inserir no banco ************************************/
    protected function formataDataInsercaoBanco($data){
        $date = ($data!="")?implode("-",array_reverse(explode("/",$data)))." 00:00:00":"";
        return $date;
    }

    /*********************************** Formata data de extração no banco ************************************/
    protected function formataDataExtracaoBanco($data){
        $data = substr($data, 0, 10);
        return implode("/",array_reverse(explode("-",$data)));
    }

    /*********************************** Redireciona ************************************/
    protected function redirecionar($controller=null, $action=null){
        $controller = ($controller) ? $controller : $this->url ;
        $action = ($action) ? $action . "/" : "";
        $this->_redirect("/admin/" . $controller . "/" . $action);
    }

    function __destruct() {

    }

} 