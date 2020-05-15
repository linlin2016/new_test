<?php
/**
 * Created by PhpStorm.
 * User: linlin
 * Date: 2020-05-14
 * Time: 19:02
 */
namespace App\Service;

class Fibonacci implements \Iterator{

    private $previous = 1;//第一个1 当做前一个，从第二个开始  (最前面有个0？)
    private $current = 0;
    private $key = 0;
    private $num = 10;

    public function current(){
        return $this -> current;
    }
    public function key(){//返回当前元素的key
        return $this -> key;
    }

    public function next() {
        $newprevious = $this->current;

        $this->current += $this->previous;//下一个当前的 = 现在当前的+上一个（当前的 也会不停的变）
        $this->previous = $newprevious;//下一个前一个 = 现在当前的（前一个是会不停的变）
        $this->key++;

    }

    public function valid() {//检查当前位置是否有效 可用于控制循环停止
        if($this->key == $this->num){
            return false;
        }else{
            return true;
        }
    }

    public function rewind(){//返回到迭代器的第一个元素 指针
//        $this->previous = 1;
//        $this->current = 0;
        //$this->key = 0;
    }
}