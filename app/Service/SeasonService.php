<?php
/**
 * Created by PhpStorm.
 * User: linlin
 * Date: 2020-05-14
 * Time: 17:26
 */
namespace App\Service;


class SeasonService implements \Iterator {

    private $position = 0;//指针指向0
    private $arr = array('春','夏','秋','冬');
    public function rewind(){//返回到迭代器的第一个元素 指针
        return $this -> position = 0;
    }
    public function current(){
        return $this -> arr[$this -> position];
    }
    public function key(){//返回当前元素的key
        return $this -> position;
    }
    public function next() {
        ++$this -> position;
    }

    public function valid() {//检查当前位置是否有效
        return isset($this -> arr[$this -> position]);
    }

}

