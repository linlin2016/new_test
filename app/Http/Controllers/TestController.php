<?php
/**
 * Created by PhpStorm.
 * User: linlin
 * Date: 2020-05-14
 * Time: 14:47
 */
namespace App\Http\Controllers;

use App\Service\Fibonacci;
use App\Service\SeasonService;

class TestController extends Controller{



    public function __construct($num = 11)
    {

        //$this->testf(11);
        //$this->aa();

    }

//    public function __call($method, $parameters)
//    {
//        //parent::__call($method, $parameters); // TODO: Change the autogenerated stub
//        echo 'im not exist';
//    }

    public function testf($num = 11){
        $m = 1;
        $n = [];

        for($i=1;$i<=$num;$i++){
            if(in_array($i,[1,2])){
                $n[1] = $n[2] = $m;
            }else{
                $n[$i] = $n[$i-1] + $n[$i-2];
            }
        }
        return $n;
    }


    public function testc(){
        $obj = new SeasonService();
        foreach ($obj as $k=>$v){
            echo $k.'='.$v;
        }
    }

    public function testfib(){
        $obj = new Fibonacci();
        foreach ($obj as $k=>$v){
            echo $v.' ';
        }
    }

}