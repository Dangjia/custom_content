<?php
namespace Modules\Admin;
use Controllers\BaseAdmin;
use Model\Login as LoginModel;
class Login extends BaseAdmin{
	
	public $accessDeny = [
		 
	];
	
	public $obj;
	
	function init(){
		parent::init();
		$this->obj = new LoginModel;
	}
	
	function  createAction(){
		if(!$this->obj->findOne(['user'=>'admin'])){
			$ok = $this->obj->insert(['user'=>'admin','pwd'=>password_hash('admin', PASSWORD_DEFAULT)]);
		}
		d($ok);
	}
	
	function indexAction(){
		$data = [];
		if($_POST && is_ajax()){
			$user = trim($_POST['user']);
			$pwd = trim($_POST['pwd']);
			$data = [
					'status'=>0,
					'msg'=>'登录失败',
					'label'=>'提示信息',
			];
			if($user && $this->obj->tryLogin($user,$pwd)){
				$data = [
						'status'=>1,
						'msg'=>'登录成功了',
						'label'=>'提示信息',
						'url'=>url('post/admin/index')
				];
			}
			exit(json_encode($data));
			
		}
		return $this->view('login',$data);
	}
}