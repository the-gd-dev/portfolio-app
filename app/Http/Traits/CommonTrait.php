<?php
namespace App\Http\Traits;
trait CommonTrait
{
    public function strArrayToInt(Array $arr){
        $transformedArr = [];
        foreach ($arr as $value) {
            if(gettype($value) == 'string'){
                array_push($transformedArr, intval($value));
            }
        }
        return $transformedArr;
    }
    public function intArrayToStr(Array $arr){
        $transformedArr = [];
        foreach ($arr as $value) {
            if(gettype($value) == 'integer'){
                array_push($transformedArr, strval($value));
            }
        }
        return $transformedArr;
    }
}