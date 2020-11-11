<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 28/04/14
 * Time: 17:51
 */

class Util_UtilGetMethod {

    private $object = "";
    private $type = "";
    private $methods = array();

    public function __construct($object, $type){
        $this->object = $object;
        $this->type = $type;
        $this->callMethod();
    }

    private function callMethod(){
        switch($this->type) {
            case "print":
                $this->printMethod();
                break;
            case "get":
                $this->getAllMethod();
                break;
        }
    }

    protected function printMethod(){
        foreach (get_class_methods(get_class($this->object)) as $cMethod)
        {
            echo '<li>' . $cMethod . '</li>';
        }
        echo '</ul><br><br>';exit;
    }

    protected function getAllMethod(){
        foreach (get_class_methods($this->object) as $cMethod)
        {
            if(strpos($cMethod, "Formulario")){
                $this->methods[] = $cMethod;
            }
        }

        return $this->methods;
    }

    public function getMethods(){
        return $this->methods;
    }

} 