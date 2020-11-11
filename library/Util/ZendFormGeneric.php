<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 02/05/14
 * Time: 11:05
 */

class Util_ZendFormGeneric extends Zend_Form {

    protected $model;
    protected $form;
    protected $methods;
    protected $read;
    protected $nameAction;
    protected $date;
    protected $setVariavelForm;

    public function init(){
        $this->read = Zend_Auth::getInstance()->getStorage()->read();
        $this->nameAction = Util_Util::getNameAction();
        $this->date = new Zend_Date();
    }

    public function setModel($model){
        $this->model = $model;
    }

    public function setVariavelForm($setVariavelForm){
        $this->setVariavelForm = $setVariavelForm;
    }

    public function createForm(){
        $this->methods = new Util_UtilGetMethod($this, "get");
        $this->form = $this->getObjectMethod();
        array_push($this->form, $this->submit());
        $this->addElements($this->form);
    }

    public function getObjectMethod(){
        $t = $this->methods->getMethods();
        foreach($t as $value){
            $j[] = $this->{$value}();
        }
        return $j;
    }

    public function setDefaultOption($opt, $text){
        $selecione = array($text);
        array_push($selecione, $opt);
        $i=0;
        $options=array();
        foreach($selecione as $key=>$value){
            if($key==0){
                $s = $value;
            }else{
                foreach($value as $k=>$v){
                    if($i==0){
                        $options[0] = $s;
                    }
                    $options[$k] = $v;
                    $i++;
                }
            }
        }
        return $options;
    }

} 