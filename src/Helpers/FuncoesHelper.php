<?php
namespace Api\Helpers;


abstract class FuncoesHelper
{
    public static function modifyNameKeysArray($prefixName, $valoresOR)
    {
        $newArray = [];
        foreach($valoresOR as $key => $value)
            $newArray[$prefixName.$key] = $value;
        return $newArray;
    }
}