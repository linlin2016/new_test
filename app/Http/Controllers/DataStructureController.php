<?php
/**
 * Created by PhpStorm.
 * User: linlin
 * Date: 2020-05-25
 * Time: 15:16
 */
namespace App\Http\Controllers;

class DataStructureController extends Controller {

    private $arr = [];
    private $minimum_arr = [];
    public function __construct()
    {
    }


    /**
     * @param $num
     */
    public function push($num){
        $this->arr[] = $num;
        if(count($this->arr)==1 || $num < end($this->minimum_arr)){
            $this->minimum_arr[] = $num;
        }
    }

    public function pop(){
        $zhanding = end($this->arr);
        $min_zhanding = end($this->minimum_arr);
        if($zhanding == $min_zhanding){
            array_pop($this->minimum_arr);
        }
        array_pop($this->arr);
    }


    public function getMin(){
        return end($this->minimum_arr);
    }


    public function testMinimumZhan(){
        $this->push(3);
        $this->push(5);
        $this->push(4);
        $this->push(2);
        $this->push(7);
        $this->pop();
        $this->pop();
        echo $this->getMin();
        $this->push(2);
        $this->push(10);
        $this->pop();
        echo $this->getMin();
        exit;
    }

}