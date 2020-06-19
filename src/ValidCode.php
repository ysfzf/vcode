<?php
namespace Ycpfzf\Vcode;

use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ValidCode
{
    protected $name;  //手机或邮箱
    protected $driver='sms';  //发送短信或邮件
    protected $scene='default'; //场景

    protected $key='_validate_code_';
    protected $config;

    protected $assign=[];  //邮件传递给视图的变量
    protected $subject='';  //邮件主题
    protected $view_path='emails';
    function __construct()
    {
        $this->config=config('vcode.code');
    }

    function scene($scene){
        $this->scene=$scene;
        return $this;
    }
    function name($name){
        $this->name=$name;
        return $this;
    }

    function sms(){
        $this->driver='sms';
        return $this;
    }

    function email(){
        $this->driver='email';
        return $this;
    }

    function assign($data){
        $this->assign=$data;
        return $this;
    }

    function subject($subject){
        $this->subject=$subject;
        return $this;
    }

    function send(){
        $key=$this->getKey();
        $handle=new Code($key,$this->config);
        $code_num=$handle->code();
        if($this->driver=='sms'){
            return $this->sendSms($code_num);
        }else{
            return $this->sendEmail($code_num);
        }
    }

    function check($code){
        if($this->config['debug'] && $code=='123123'){
            return true;
        }
        $handle=new Code($this->getKey(),$this->config);
        return $handle->check($code);
    }

    function queue(){
        if($this->driver=='sms' && !self::isMobile($this->name)){
            throw new \Exception('手机号格式不正确');
        }
        if($this->driver=='email' && !self::isEmail($this->name)){
            throw new \Exception('邮箱格式不正确');
        }
        SendJob::dispatch($this);
        return true;
    }

    protected function getKey(){
        if(empty($this->scene)||empty($this->name)||empty($this->driver)){
            throw new \Exception('缺少参数');
        }
        return md5("{$this->name}{$this->key}{$this->driver}_{$this->scene}");
    }
    protected function sendSms($code){
        if(!self::isMobile($this->name)){
            throw new \Exception('手机号格式不正确');
        }
        $config=config('vcode.sms');
        if(!key_exists($this->scene,$config['templates'])){
            throw new \Exception("场景值{$this->scene}不存在");
        }
        if(empty($config['templates'][$this->scene])){
            throw new \Exception("场景值{$this->scene}不能为空");
        }
        $client  = new Client([
                'accessKeyId'    => $config['accessKeyId'],
                'accessKeySecret' => $config['accessKeySecret'],
        ]);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($this->name);
        $sendSms->setSignName($config['signName']);
        $sendSms->setTemplateCode($config['templates'][$this->scene]);
        $sendSms->setTemplateParam(['code' => $code]);
        $sendSms->setOutId('notice');
        $result = $client->execute($sendSms);
        if (isset($result->Code) && $result->Code == "OK"){
            return true;
        }
        Log::error(json_encode($result));
        return false;
    }

    protected function sendEmail($code){
        if(!self::isEmail($this->name)){
            throw new \Exception('邮箱格式不正确');
        }

        if(strpos($this->scene,'.')>0){
            $view=$this->scene;
        }else{
            $view=$this->view_path.'.'.$this->scene;
        }

        $data=$this->assign;
        $data['code']=$code;

        Mail::send($view,$data,function($message){
            $message->to($this->name)->subject($this->subject);
        });
        $err=Mail::failures();
        if(count($err)>0){
            Log::error(json_encode($err));
            return false;
        }
        return true;

    }

    static function isMobile($mobile)
    {
        if(preg_match("/^1[345789]{1}\d{9}$/",$mobile)){
            return true;
        }else{
            return false;
        }

    }

    static function isEmail($mail){
         if(preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/",$mail)){
             return true;
         }else{
             return false;
         }
    }

}
