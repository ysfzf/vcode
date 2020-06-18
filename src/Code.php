<?php
namespace Ycpfzf\Vcode;
use Illuminate\Support\Facades\Cache;

class Code
{
    protected $key;
    protected $data;

    protected $code_length=6;
    protected $life=300;  //有效时间
    protected $interval=60;  //间隔时间
    protected $maxCheckTimes=5;  //最大验证次数

    function __construct($key,$config=[])
    {
        $this->key=$key;
        $this->data=Cache::get($this->key);
        if($config){
            if($config['max_check_times']){
                $this->maxCheckTimes=$config['max_check_times'];
            }
            if($config['life']){
                $this->life=$config['life'];
            }
            if($config['code_length']){
                $this->code_length=$config['code_length'];
            }
            if($config['interval']){
                $this->interval=$config['interval'];
            }
        }
    }

    function __get($name)
    {
        if(isset($this->data[$name])){
            return $this->data[$name];
        }
        return null;
    }

    function __set($name, $value)
    {
         $this->data[$name]=$value;
    }


    function life($time){
        $this->life=$time;
        return $this;
    }

    function interval($time){
        $this->interval=$time;
        return $this;
    }

    function length($len){
        $this->code_length=$len;
        return $this;
    }

    function max($times){
        $this->maxCheckTimes=$times;
        return $this;
    }

    function code(){
        $now=time();
        if(empty($this->data)){
            $this->data=[
                'code'=>$this->randomCode($this->code_length),
                'next'=>$now+$this->interval,
                'times'=>0,
                'life'=>$now+$this->life
            ];
        }else{
            if($now<$this->data['next']){
                throw new \Exception('请求太频繁，请稍候再试');
            }
            $this->data=[
                'code'=>$this->data['code'],
                'next'=>$now+$this->interval,
                'times'=>0,
                'life'=>$now+$this->life
            ];
        }
        if(Cache::set($this->key,$this->data,$this->life)){
            return $this->code;
        }
        throw new \Exception('cache error');
    }


    function check($code){
        if(empty($this->data)){
            return false;
        }

        if($code==$this->data['code']){
            Cache::forget($this->key);
            return true;
        }

        $this->data['times']++;
        if($this->data['times']>=$this->maxCheckTimes){
            Cache::forget($this->key);
            return false;
        }
        $now=time();
        $life=$this->data['life']-$now;
        Cache::set($this->key,$this->data,$life);

        return false;
    }

    protected function randomCode($length = 6) {
        $min = pow(10 , ($length - 1));
        $max = pow(10, $length) - 1;
        return mt_rand($min, $max);
    }
}
