<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 30/04/14
 * Time: 15:04
 */

class Util_ConfigController extends Zend_Controller_Action {

    protected  $crud;
    protected  $form;
    protected  $model;
    protected  $data;
    protected  $date;
    protected  $url;

    public function init($crud, $model, $form){
        $read = Zend_Auth::getInstance()->getStorage()->read();
        $this->view->read = $read;
        $this->crud = $crud;
        $this->form = $form;
        $this->model = $model;
        $this->date = new Zend_Date();
        $this->url = $this->getUrlCrud();
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
    protected function eliminaElementosVazio(){
        foreach($this->data as $key=>$value){
            if(empty($value))
                unset($this->data[$key]);
        }
    }

    /*********************************** Select da tabela do controler que esta sendo usado ************************************/
    protected  function selectTableId($id){
        $sql = $this->model->select()->where('co_seq_'.$this->crud.' = ?', $id);
        return $this->model->getAdapter()->fetchRow($sql);
    }

    /*********************************** Adiciona campos obrigatórios do include ************************************/
    protected function addCamposObrigatorios(){
        $this->data["nm_inclusao"] = $this->view->read->nm_usuario;
        $this->data["dt_inclusao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
        $this->data["st_registro"] = 1;
    }

    /*********************************** Adiciona campos obrigatórios do include ************************************/
    protected function editCamposObrigatorios(){
        $this->data["nm_alteracao"] = $this->view->read->nm_usuario;
        $this->data["dt_alteracao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
    }

    protected function deleteElemtosArray($arrayExcecao){
        foreach($arrayExcecao as $value) {
            unset($this->data[$value]);
        }
    }







    /*********************************** Metodo que lista registro do crud ************************************/
    protected function indexAction()
    {
        $select = $this->model->select()->where('st_registro = ?', 1);
        $select->order('nm_'.$this->crud.' DESC');
        $stmt = $select->query();
        $this->view->dados = $stmt->fetchAll();
    }



    /*********************************** Metodo que deleta registro no modelo do banco ************************************/
    protected function deleteAction()
    {
        // action body
        if($this->getRequest()->isPost()){
            $del = $this->getRequest()->getPost('del');
            if($del == 'Excluir '.$this->crud){
                $id = $this->getRequest()->getPost('id');
                $this->model->deleteCliente($id);
            }
            $this->_helper->redirector('index');
        }else{
            $id = $this->_getParam('id', 0);
            $where = $this->model->getAdapter()->quoteInto('co_seq_'.$this->crud.' = ?', $id);
            $this->data = array("st_registro"=>2);
            $this->editCamposObrigatorios();
            $this->model->update($this->data, $where);
            $this->_redirect('/admin/'.$this->url.'/');
        }
    }

    /*********************************** Visualiza registro detalhado do crud ************************************/
    protected function viewAction()
    {
        $id = $this->_getParam('id', 0);
        $select = $this->model->select()->where('co_seq_'.$this->crud.' =?', $id);
        $select->where('st_registro=?', 1);
        $select->order('nm_'.$this->crud.' DESC');
        $stmt = $select->query()->fetchAll();
        $this->view->dados = $stmt[0];
    }

    /*********************************** Inclui registro do crud ************************************/
    protected function addAction($arrayExcecao=null)
    {
        //Verifica se o formulário foi postado
        if($this->getRequest()->isPost()){

            //Verifica se os dados são válidos
            if($this->form->isValid($this->getRequest()->getParams())){

                $this->data = $this->form->getValues();
                $this->addCamposObrigatorios();
                (!empty($arrayExcecao) && is_array($arrayExcecao)) ? $this->deleteElemtosArray($arrayExcecao): null;
                $this->model->insert($this->data);
                $this->_redirect("/admin/".$this->url."/");

            }
        }
        $this->view->form = $this->form;
    }

    protected function editAction()
    {
        // action body
        $id = $this->_getParam('id', 0);

        if($this->getRequest()->isPost()){
            $request = $this->getRequest()->getPost('confirmar');
            if($request == 'Confirmar'){
                if($this->form->isValid($this->getRequest()->getParams())){
                    $this->data = $this->form->getValues();
                    $this->editCamposObrigatorios();
                    $this->eliminaElementosVazio();
                    $where = $this->model->getAdapter()->quoteInto('co_seq_'.$this->crud.' = ?', $id);
                    $this->model->update($this->data, $where);
                    $this->_redirect('/admin/'.$this->url);
                }else{
                    echo "Não foi possível atualizar. Tente novamente.";
                }
            }else{
                $this->_redirect('/admin/'.$this->url);
            }
        }else{
            $data = $this->selectTableId($id);
            $this->form->populate($data);
            if(is_array($data)){
                $this->form->setAction($data["co_seq_".$this->crud]);
                $this->form->populate($data);
            }
        }

        $this->view->form = $this->form;
    }

} 