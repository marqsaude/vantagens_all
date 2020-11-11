<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 30/04/14
 * Time: 15:04
 */

class Util_ZendControllerGeneric extends Util_ZendControllerUtil {



    public function init($crud, Util_ZendModelGeneric $model=null, $form=null){
        $this->crud = $crud;
        $this->model = $model;
        $this->form = $form;
        parent::init();
        //$this->view->read = Zend_Auth::getInstance()->getStorage()->read();
    }

    /**
     *
     * Actions dos controlers
     *
     */



    /*********************************** Metodo que lista registro do crud ************************************/
    public function indexAction($dados=null)
    {
        if($this->crud) {
            if (!$dados) {
                $this->campoInicial = ($this->campoInicial == null) ? 'nm_' . $this->crud : $this->campoInicial;
                $this->view->dados = $this->model->selectGeneric($this->campoInicial);
            } else {
                $this->view->dados = ($dados===true) ? array() : $dados;
            }
        }else{
            //crud desabilitado pelo controller
        }
    }

    /*********************************** Metodo que deleta registro no modelo do banco ************************************/
    protected function deleteAction()
    {
        if($this->crud) {
            if ($this->getRequest()->isPost()) {
                $del = $this->getRequest()->getPost('del');
                if ($del == 'Excluir ' . $this->crud) {
                    $id = $this->getRequest()->getPost('id');
                    $this->model->deleteCliente($id);
                }
                $this->_helper->redirector('index');
            } else {
                $id = $this->_getParam('id', 0);
                $this->model->delete($id, 'co_seq_' . $this->crud);
                if ($this->redirect)
                    $this->redirecionar();
            }
        } else {
            //crud desabilitado pelo controller
        }
    }

    /*********************************** Visualiza registro detalhado do crud ************************************/
    protected function viewAction($dados=null)
    {
        if($this->crud) {
            if (!$dados) {
                $id = $this->_getParam('id', 0);
                $this->campoInicial = ($this->campoInicial == null) ? 'nm_' . $this->crud : $this->campoInicial;
                $select = $this->model->select()->where('co_seq_' . $this->crud . ' =?', $id);
                $select->where('st_registro=?', 1);
                $select->order($this->campoInicial . ' DESC');
                $stmt = $select->query()->fetchAll();
                $this->view->dados = $stmt[0];
            } else {
                $this->view->dados = $dados;
            }
        } else {
            //crud desabilitado pelo controller
        }
    }

    /*********************************** Inclui registro do crud ************************************/
    protected function addAction($arrayExcecao=null)
    {
        if($this->crud) {
            if ($this->getRequest()->isPost() && !$this->erro) {
                //Verifica se os dados são válidos
                if ($this->form->isValid($this->getRequest()->getParams())) {

                    $this->post = ($this->getPost && !$this->post) ? $_POST : $this->post;
                    $this->data = ($this->data) ? $this->data : $this->form->getValues();
                    $this->addCamposObrigatorios();
                    $arrayExcecao = (!empty($this->insertOderTable) && is_array($this->insertOderTable)) ? $this->montaArrayExcecaoOutraTabela() : $arrayExcecao;
                    (!empty($arrayExcecao) && is_array($arrayExcecao)) ? $this->deleteElemtosArray($arrayExcecao) : null;
                    if($this->debugCrud){
                        var_dump($this->data);exit;
                    }else {
                        if(!$this->debugOderTables) {
                            $this->idInsert = $this->model->insert($this->data);
                        }
                    }
                    if (!empty($this->insertOderTable)) {
                        $this->insertOderTables();
                    }
                    if ($this->redirect) {
                        $this->redirecionar();
                    }
                }
            }
            $this->view->form = $this->form;
        } else {
            //crud desabilitado pelo controller
        }
    }

    /*********************************** Edita registro do crud ************************************/
    protected function editAction($model=null)
    {
        if($this->crud) {
            $id = $this->_getParam('id', 0);

            if ($this->getRequest()->isPost()) {
                $request = $this->getRequest()->getPost('confirmar');
                if ($request == 'Confirmar') {
                    if ($this->form->isValid($this->getRequest()->getParams())) {
                        $this->data = ($this->data) ? $this->data : $this->form->getValues();
                        if ($model) {
                            $this->model = $model["model"];
                            $this->crud = $model["crud"];
                        }
                        $this->editCamposObrigatorios();
                        $this->eliminaElementosVazio();
                        $where = $this->model->getAdapter()->quoteInto('co_seq_' . $this->crud . ' = ?', $id);
                        //var_dump($this->data);exit;
                        $this->model->update($this->data, $where);
                        if ($this->redirect) {
                            $this->redirecionar();
                        }
                    } else {
                        echo "Não foi possível atualizar. Tente novamente.";
                    }
                } else {
                    if ($this->redirect)
                        $this->redirecionar();
                }
            } else {
                $this->data = ($this->data) ? $this->data : $this->selectTableId($id);
                //var_dump($this->data);exit;
                $this->form->populate($this->data);
                if (is_array($this->data)) {
                    $this->form->setAction($this->data["co_seq_" . $this->crud]);
                    $this->form->populate($this->data);
                }
            }

            $this->view->form = $this->form;
        } else{
            //crud desabilitado pelo controller
        }
    }

} 