<?php
namespace Modules\Mongo;
use Controllers\BaseAdmin;
class Admin extends BaseAdmin{
	
	public $accessDeny = [
			'*'
	];
	function indexAction(){
		$list = array_unique(file_find(BASE."/data")['dir']);
		foreach($list as $v){
			$q = substr($v,strrpos($v,'/')+1);
			if($q==config('mongodb.db')){
				$k = substr($v,0,strrpos($v,'/'));
				$k = substr($k,strrpos($k,'/')+1);
				$o[$k] = $v;
			}
		}
		arsort($o);
		$data['data'] = $o;
		return $this->view('index',$data);
	}
	
	function aAction(){
		$dir = BASE."/data/".date('Y-m-d-H-i-s');
		if(!is_dir($dir)){
			mkdir($dir,0777,true);
		}
		$c = config('mongodb.cmd')."mongodump -h ".config('mongodb.host')." -d ".config('mongodb.db')." -o  ".$dir;
		log_sys($c);
		exec($c,$o);
		flash('success',"备份数据完成");
		redirect(url('mongo/admin/index'));
	}
	
	function bAction(){
		exit;
		$dir = BASE."/data/".$_GET['q'];
		$c = config('mongodb.cmd')."mongorestore -h ".config('mongodb.host')." -d ".config('mongodb.db')." --dir  ".$dir;
		log_sys($c);
		exec($c,$o);
		flash('success',"恢复数据完成");
		redirect(url('mongo/admin/index'));
	}
	
}