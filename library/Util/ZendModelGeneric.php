<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 28/04/14
 * Time: 16:46
 */

class Util_ZendModelGeneric extends Zend_Db_Table_Abstract
{

    public $_name = '';
    public $nm='';
    public $query;
    public $dbAdapter;
    protected $_primary = '';
    protected $_nameModel = '';
    protected $read = '';
    protected $date = '';
    protected $session_login;

    private $data;

    public function construtor($nameModel)
    {
        $this->nm = $nameModel;
        $this->_name = 'tb_' . $nameModel;
        $this->_primary = 'co_seq_' . $nameModel;
        $this->_nameModel = $nameModel;
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->read = Zend_Auth::getInstance()->getStorage()->read();
        $this->date = new Zend_Date();
        $this->newQuery();
    }

    public function construtorRL($nameModel)
    {
        $this->nm = $nameModel;
        $this->_name = 'rl_' . $nameModel;
        $this->_primary = 'co_seq_' . $nameModel;
        $this->_nameModel = $nameModel;
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->read = Zend_Auth::getInstance()->getStorage()->read();
        $this->date = new Zend_Date();
        $this->newQuery();
    }

    public function construtorView($nameModel)
    {
        $this->nm = $nameModel;
        $this->_name = 'vw_' . $nameModel;
        $this->_primary = 'id';
        $this->_nameModel = $nameModel;
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->read = Zend_Auth::getInstance()->getStorage()->read();
        $this->date = new Zend_Date();
        $this->newQuery();
    }

    public function newQuery(){
        $this->dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $this->query = new Zend_Db_Select($this->dbAdapter);
    }

    public function get($id){
        $id = (int)$id;
        $row = $this->fetchRow('co_seq_'.$this->_nameModel.' = '.$id);
        if(!$row){
            throw new Exception("Nenhum registro encontrado $id");
        }
        return $row->toarray();

    }

    public function busca($id){
        try{
            $sql = $this->select()
                ->where('co_seq_'.$this->_nameModel.' = ?', $id)
                ->where('st_registro=?', 1);
            $row = $this->fetchRow($sql);

            if($row !== null){
                return $row->toArray();
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function buscaMenos($id){
        try{
            $select = $this->select();
            $select ->where('co_seq_'.$this->_nameModel.' != ?', $id)
                ->where('st_registro=?', 1);
            $result = $select->query()->fetchAll();

            if($result !== null){
                return $result;
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function excluir($id, $campo=null, $in=null){
        $where="";
        if(is_array($id)){
            foreach($id as $key=>$value){
                /*if(is_array($value)){
                    $i=0;
                    foreach ($value as $k=>$val) {
                        if($i>0){
                            $where .= " AND ";
                        }
                        $where .= $this->getAdapter()->quoteInto($k . ' = ?', $val);
                        $i++;
                    }
                }else{*/
                $where .= $this->getAdapter()->quoteInto($key . ' = ?', $value);
                //}
            }
        }else {
            $where .= $this->getAdapter()->quoteInto($campo . ' = ?', $id);
        }
        $dados="";
        $i=1;
        $k=0;
        if($in){
            foreach($in as $key=>$value) {
                $l = count($value);
                //if(is_array($value)){
                    foreach($value as $k=>$v)
                    {
                        $dados .= ($i==$l) ? $v : $v.", ";
                        $i++;
                    }
                    if(is_numeric($k)) {
                        $where = $where . " AND " . $key . " IN(" . $dados . ")";
                    }
                //}else{

                //}
            }
            if(!is_numeric($k)){
                $where = $where . " AND " . $k . " IN(" . $dados . ")";
            }
        }
        $data = array("st_registro"=>2);
        $data = $this->editCamposObrigatorios($data);
        //var_dump($data, $where);exit;
        return $this->update($data, $where);
    }

    public function reativar($id, $campo){
        $where = $this->getAdapter()->quoteInto($campo . ' = ?', $id);
        $data = array("st_registro"=>1);
        $data = $this->editCamposObrigatorios($data);
        $this->update($data, $where);
    }

    public function editCamposObrigatorios($data){
        $data["nm_alteracao"] = $this->session_login->nmUsuario;
        $data["dt_alteracao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
        return $data;
    }

    /*********************************** Adiciona campos obrigatórios do include ************************************/
    protected function addCamposObrigatorios($data=null, $table=null){
        if($data){
            $data["nm_inclusao"] = $this->session_login->nmUsuario;
            $data["dt_inclusao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
            if($table==null) {
                $data["st_registro"] = (isset($data["st_registro"])) ? $data["st_registro"] : 1;
            }else{
                $data["st_registro"] = ($data[$table . ".st_registro"]) ? $data[$table . ".st_registro"] : 1;
            }
            return $data;
        }else {
            if($this->session_login->nmUsuario==null){
                $this->data["nm_inclusao"] = "Ele mesmo";
            }else {
                $this->data["nm_inclusao"] = $this->session_login->nmUsuario;
            }
            $this->data["dt_inclusao"] = $this->date->get('YYYY-MM-dd HH:mm:ss');
            $this->data["st_registro"] = 1;
        }
    }

    public function getOptions(){
        try {
            $select = $this->select()
                ->from($this, array('co_seq_'.$this->_nameModel, 'nm_'.$this->_nameModel))
                ->order('nm_'.$this->_nameModel.' ASC')
                ->where('st_registro=1');

            $options = $this->getAdapter()->fetchPairs($select);
            return $options;
        }
        catch(Exception $e) {
            return null;
        }
    }

    public function getInOptions($array){
        $limit = count($array);
        try{
            $select = $this->select()
                ->where('co_seq_'.$this->_nameModel.' IN(?)', $array)
                ->limit($limit);

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function findArray($array){
        try{
            $select = $this->select();
            $i=0;
            $where = "";
            foreach($array as $key=>$value){
                $keyConditional = (strstr($key, '&')=="") ? ((strstr($key, '|')=="") ? "" : "OR") : "AND" ;
                if(empty($keyConditional) && $i==0) {
                    $select->where($key . " =?", array($value));
                }else{
                    $i++;
                    $key=str_replace("&", "", $key);
                    $key=str_replace("|", "", $key);
                    $where .= $key . " = ".$value." ".$keyConditional." ";
                }
            }
            if($i>0){
                $select->where($where);
            }
            $select->where("st_registro=?", array(1));
            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function findOptionArray($array){
        try{
            $select = $this->select();
            $i=0;
            $where="";
            $flag=false;
            foreach($array as $key=>$value){
                $keyConditional =(strstr($key, '&')=="") ? ((strstr($key, '|')=="") ? "" : "OR") : "AND" ;
                if(empty($keyConditional) && $flag==false) {
                    $select->where($key . " LIKE '%" . $value . "%'");
                }else {
                    $i++;
                    $key = str_replace("&", "", $key);
                    $key = str_replace("|", "", $key);
                    $where .= $key . " LIKE '%" . $value . "%' " . $keyConditional . " ";
                    $flag=true;
                }
            }
            if($i>0){
                $select->where($where);
            }
            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function getAllOptions(){
        try{
            $this->query->from(array("e" => $this->_name), '*');
            $this->query->columns("*");
            $this->query->where("e.st_registro=1");
            $result = $this->returnQuery();
            return $result;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function updateOptions($array){
        try{
            $i=0;
            foreach($array as $key=>$value) {
                if($i==0) {
                    $where = $this->getAdapter()->quoteInto($key . ' = ?', $value);
                    unset($array[$key]);
                }
                $i++;
            }
            $this->update($array, $where);
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function edit($array, $id){
        if(is_array($id))
        {
            foreach($id as $key=>$value){
                $where = $this->getAdapter()->quoteInto($key . ' = ?', $value);
            }
        }else {
            $where = $this->getAdapter()->quoteInto($this->_primary . ' = ?', $id);
        }
        $where = $where." AND st_registro=1";
        $array=$this->editCamposObrigatorios($array);
        return $this->update($array, $where);
    }

    public function returnQuery(){
        return $this->query->query()->fetchAll();
    }

    public function inserts($datas){
        foreach($datas as $data) {
            $data = $this->addCamposObrigatorios($data);
            $this->insert($data);
        }
    }

    public function insertsTeste($datas){
        $sql = "INSERT INTO `".$this->_name."` ";
        $colums="";
        $values="";
        $i=0;
        foreach($datas as $data) {
            if($i==0){
                $colums=$colums . " (";
                $values="(";
                $j=0;
                $data = $this->addCamposObrigatorios($data);
                foreach($data as $key=>$value) {
                    if($j==0){
                        $values=$values."'".$value."'";
                        $colums=$colums."`".$key."`";
                    }else{
                        $values=$values.", '".$value."'";
                        $colums=$colums.", `".$key."`";
                    }
                    $j++;
                }
                $values=$values.")";
                $colums=$colums.")";
            }else{
                $values=$values.", (";
                $j=0;
                $data = $this->addCamposObrigatorios($data);
                foreach($data as $key=>$value) {
                    if($j==0){
                        $values=$values."'".$value."'";
                    }else{
                        $values=$values.", '".$value."'";
                    }
                    $j++;
                }
                $values=$values.")";
            }
            $i++;
        }
        $sql = $sql.$colums." VALUES ".$values;
        $stmt = $this->getAdapter()->prepare($sql);
        $stmt->execute();
    }

    public function insertOne($data){
        $this->data = $data;
        $this->addCamposObrigatorios();
        try {
            return $this->insert($this->data);
        }catch (Exception $e){
            var_dump($e->getMessage());exit;
        }
    }

    public function selectGeneric($campoInicial){
        $select = $this->select()->where('st_registro = ?', 1);
        $select->order($campoInicial . ' DESC');
        $stmt = $select->query();
        return $stmt->fetchAll();
    }

    /********** Debug da query **********/
    public function debug(){
        var_dump($this->query->query());exit;
    }

}