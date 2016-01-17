<?php
namespace Modules\Admin;
use Controllers\BaseAdmin;
class Logout extends BaseAdmin{
	
	public $accessDeny = [
		'*'
	];
	
	
	function init(){
		parent::init();
	}
	
	 
	
	function indexAction(){
		cookie_delete(['adminId','adminUser']);
		flash('success','退出成功');
		redirect(url('admin/login/index'));
	}
}