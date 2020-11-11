<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 28/07/17
 * Time: 10:19
 */

class Util_ValidCredCard {

    private $type;
    private $rgCartao;

    public function __construct($rgCartao){
        $this->rgCartao=$rgCartao;
        $this->setType();
    }

    /**
     * Validate credit card number and return card type.
     * Optionally you can validate if it is a specific type.
     *
     * @param string $ccnumber
     * @param string $cardtype
     * @param string $allowTest
     * @return mixed
     */
    public function creditCard($ccnumber, $cardtype = '', $allowTest = false){
        // Check for test cc number
        if($allowTest == false && $ccnumber == '4111111111111111'){
            return false;
        }

        $ccnumber = preg_replace('/[^0-9]/','',$ccnumber); // Strip non-numeric characters

        $creditcard = array(
            'visa'			=>	"/^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/",
            'mastercard'	=>	"/^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/",
            'discover'		=>	"/^6011-?\d{4}-?\d{4}-?\d{4}$/",
            'amex'			=>	"/^3[4,7]\d{13}$/",
            'diners'		=>	"/^3[0,6,8]\d{12}$/",
            'bankcard'		=>	"/^5610-?\d{4}-?\d{4}-?\d{4}$/",
            'jcb'			=>	"/^[3088|3096|3112|3158|3337|3528]\d{12}$/",
            'enroute'		=>	"/^[2014|2149]\d{11}$/",
            'visa13'		=>	"/^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/"
        );

        if(empty($cardtype)){
            $match=false;
            foreach($creditcard as $cardtype=>$pattern){
                if(preg_match($pattern,$ccnumber)==1){
                    $match=true;
                    break;
                }
            }
            if(!$match){
                return false;
            }
        }elseif(@preg_match($creditcard[strtolower(trim($cardtype))],$ccnumber)==0){
            return false;
        }
        $cardtype = ($cardtype=="visa13") ? "visa" : $cardtype;
        $return['valid']	    =	$this->LuhnCheck($ccnumber);
        $return['ccnum']	    =	$ccnumber;
        $return['type']		    =	$cardtype;
        $return['type_valid']   =   ($this->type==$cardtype) ? true : false;
        return $return;
    }

    /**
     * Do a modulus 10 (Luhn algorithm) check
     *
     * @param string $ccnum
     * @return boolean
     */
    private function LuhnCheck($ccnum){
        $checksum = 0;
        for ($i=(2-(strlen($ccnum) % 2)); $i<=strlen($ccnum); $i+=2){
            $checksum += (int)($ccnum{$i-1});
        }

        // Analyze odd digits in even length strings or even digits in odd length strings.
        for ($i=(strlen($ccnum)% 2) + 1; $i<strlen($ccnum); $i+=2){
            $digit = (int)($ccnum{$i-1}) * 2;
            if ($digit < 10){
                $checksum += $digit;
            }else{
                $checksum += ($digit-9);
            }
        }
        if(($checksum % 10) == 0){
            return true;
        }else{
            return false;
        }
    }

    private function setType(){
        if($this->rgCartao==1){
            $this->type = "visa";
        }
        if($this->rgCartao==2){
            $this->type = "mastercard";
        }
        if($this->rgCartao==3){
            $this->type = "amex";
        }
        if($this->rgCartao==4){
            $this->type = "elo";
        }
    }

}