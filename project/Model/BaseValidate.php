<?php
namespace Model;
/**
 * composer require alexgarrett/violin
 * @author sun kang
 *
 */

class BaseValidate{
	public $validateObj;
	public $validate = [
		//'title'  => 'required',
		//'body'  => 'required|int',
	];
	public $validateMessage = [
		//	'username' => [
		//			'required' => 'You need to enter a username to sign up.'
		//	],
		//	'age' => [
		//			'required' => 'I need your age.',
		//			'int'      => 'Your age needs to be an integer.',
		//	]
			
	];
	public $allowFields;
	
	function __construct(){
		$this->validateObj = new BaseValidateViolinExt;
		
	}
	
	
	
	/**
	 * 验证数据
	 * @param unknown $data
	 */
	function validate(){
		if($this->validate){
			foreach($this->validate as $k=>$v){
				$value = trim($_POST[$k]);
				$data[$k] = [$value,$v];
			}
		}
		$this->validateMessage();
		$this->validateObj->addFieldMessages($this->validateMessage);
		$this->validateObj->validate($data);
		if($this->validateObj->passes()) {
			return true;
		} else {
			return $this->validateObj->errors()->all();
		}
	}
	
	
	protected function validateMessage(){
		$lang = [
				'alnum'=>'{field}不是字母或数字',
				'alnumDash'=>'{field}不是字母或下划线',
				'alpha'=>'{field}不是字母',
				'array'=>'{field}不是数组',
				'between'=>'{field}区间{min},{max}',
				'bool'=>'{field}不是布尔类型',
				'email'=>'{field}不是正确的邮件地址',
				'int'=>'{field}不是整型',
				'number'=>'{field}不是数字',
				'ip'=>'{field}不是IP地址',
				'min'=>'{field}最小值为{value}',
				'max'=>'{field}最大值为{value}',
				'matches'=>'{field}匹配错误',
				'url'=>'{field}不是正确的网址',
				'date'=>'{field}时间格式错误',
				'checked'=>'{field}没有选中',
				'required' => '{field}不能为空',
				'regex'      => '字段{field}不符合表达式.',
		];
		$this->validateObj->addRuleMessages($lang);
	}
	
}