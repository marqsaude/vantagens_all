<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 29/04/14
 * Time: 10:06
 */

class Default_Model_SelectJoin_SelectJoins extends Zend_Db_Table
{
    private $dbAdapter;
    private $id;
    private $table;
    private $alias;
    private $arrayJoins = array();
    private $select;
    private $arrayAlias;
    private $tpTabela;
    private $countArrayAlias = 1;

    public function __construct($table, $id=null, $arrayJoins=array(), $arrayJoinsInverso=array())
    {
        $this->arrayAlias = Util_ArrayAliasEnum::getConstants("Util_ArrayAliasEnum");

        $this->alias = "principal";
        $this->table = $table[1];
        $this->tpTabela = $table[0];

        $this->id = $id;
        $this->arrayJoins = $arrayJoins;
        $this->dbAdapter = Zend_Db_Table::getDefaultAdapter();
    }

    public function getResult()
    {
        $this->select = new Zend_Db_Select($this->dbAdapter);
        $this->select->from(array($this->alias => $this->tpTabela.'_'.$this->table), '*');
        $this->processJoins();
        if($this->id != null) {
            $this->select->where('c.co_seq_' . $this->table . '=' . $this->id);
        }
        $this->select->where("principal.st_registro=1");
        $stmt = $this->select->query();
        $result = $stmt->fetchAll();

        return $result;
    }

    private function processJoins(){
        foreach($this->arrayJoins as $join) {
            $teste = new Util_Util();

            $tabela = $teste->getTypeTable($join);
            $this->select->joinLeft(
                array($this->arrayAlias[$this->countArrayAlias] => $tabela[0].$tabela[1]),
                $this->alias . '.co_' . $tabela[1] . ' = ' . $this->arrayAlias[$this->countArrayAlias] . '.co_seq_' . $tabela[1]
            );
            $this->countArrayAlias++;
        }
    }

}