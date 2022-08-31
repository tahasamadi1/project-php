<?php

class data
{
    public $data=array();
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key,$this->data)){
                if (!is_numeric($value)){
                    $this->data[$key]=$value;
                }
                else{
                    $this->data[$key]=(int) $value;
                }
            }
        }
    }
    public function __get($property){
        if (array_key_exists($property,$this->data)){
            return $this->data[$property];
        }
    }
}