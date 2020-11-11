<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 28/04/14
 * Time: 14:35
 */

abstract class Util_ReflectionEnum
{

    public static function getConstants($getReflection)
    {
        return self::mountArrayEnum(self::getReflection($getReflection));
    }

    public static function getReflection($getReflection)
    {
        $reflect = new ReflectionClass($getReflection);
        return $reflect->getConstants();
    }

    public static function getConstant($getReflection, $const)
    {
        $constants = self::getReflection($getReflection);
        return $constants[self::validaNumero($const)];
    }

    public static function validaNumero($value)
    {
        return (is_numeric($value)) ? "__".$value : $value;
    }

    public static function mountArrayEnum($array){
        foreach($array as $key=>$value){
            $arrayEnum[self::removeAndescor($key)] = $value;
        }
        return $arrayEnum;
    }

    public static function removeAndescor($string){
        $numero = str_replace("__" , "",$string);
        return ($string==$numero) ? $string : intval($numero);
    }

}