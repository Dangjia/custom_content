<?php
/**
 * @author  SUN KANG [sunkang@wstaichi.com]
 * @copyright 
 * @version 1.0
 */
namespace Model;
use Violin\Violin;
class BaseValidateViolinExt extends Violin
{

    public function __construct()
    {
        $this->addRuleMessage('unique', '已存在相同记录');
    }
	/**
	 * 
	 * unique(users,user)
	 * @param unknown $value
	 * @param unknown $input
	 * @param unknown $args
	 */
	public function validate_unique($value, $input, $args)
	{
		$tb = $args[0];
		$name = $args[1];
		if(!$tb || !$name){
			return true;
		}
		$one = mongo($tb)->findOne([$name=>$input[$name]]);
		$flag = false;
		$id = $_GET['id'];
		if($one && $id  && $one->id == $id ){
			$flag = true;
		}
		
		return true;
	}
	
	
	
}
