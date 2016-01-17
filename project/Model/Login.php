<?php
namespace Model;
class Login extends Base{
	public $tb = 'users';
	
	/**
	 * 允许保存到数据库的字段
	 * @var array $allowFields
	 */
	public $allowFields = [
		'user',
		'pwd',
		'status'
	];
	/**
	 * INT类型的字段说明
	 * @var unknown
	 */
	public $int = [
			'status'
	];
	/**
	 * 验证规则
	 * @var unknown
	 */
	public $validate = [
		'user'  => 'required|unique(users,user)',
		'pwd'  => 'required',
	];
	/**
	 * 验证错误提示信息
	 * @var array $validateMessage
	 */
	public $validateMessage = [
		'user'  => [
					'required'=>'用户名不能为空',
				],
		'pwd'  => [
					'required'=>'密码不能为空',
			],
	];
	
	public $uid;
	public $uname;
	function init(){
			parent::init();
			$this->uid =  cookie('adminUid');
			$this->uname =  cookie('adminUser');
	}
	
	/**
	 * 登录
	 * @param unknown $user
	 * @param unknown $pwd
	 */
	function tryLogin($user,$pwd){
		$hash = password_hash($pwd, PASSWORD_DEFAULT);
		$one = $this->findOne(['user'=>$user]);
		if(!$one){
			return;
		}
		if(!password_verify($pwd,$one->pwd)){
			return;
		}
		cookie('adminId',(string)$one->_id);
		cookie('adminUser',$one->user);
		return true;
	}
	/**
	 * 更新数据时，如密码为空就忽略pwd字段 
	 * @param unknown $data
	 */
	function beforeUpdateValidate($data){
		if(!$data['pwd']){
			$this->ignore(['pwd']);
		}
	}
	
	
	/**
	 * 添加或更新
	 */
	
	function beforeSave($data,$condition = null){
		if( trim($data['user'])!=$this->uname || $this->uname != (config('app.supperAdminName')?:'admin')){
			exit(json_encode([
				'status'=>0,
				'label'=>'异常错误',
				'msg'=>'仅限超级管理员['.$this->uname.']执行该操作!'
			]));
		}
		
		
		if(trim($data['pwd'])){
			$this->data['pwd'] = password_hash(trim($data['pwd']), PASSWORD_DEFAULT);
		} 
	}
	
	
	
	
	
	
}