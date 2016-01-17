<?php
namespace Controllers;
/**
 * 
 * 自动化控制器
 * 
 * @author SUN KANG 
 * @email sunkang@wstaichi.com
 * @date 2015
 */
class BaseAdminAutoController extends BaseAdmin  {
	 
	public $jump = 'post/type/index';
	public $per_page = 10;
	public $sort = ['created'=>-1];
	public $condition = [];
	public $view = 'index';
	public $data = [];
	public $info = '操作已完成';
	public $disable = false;
	function statusAction(){
		if($this->disable === true){
			return;
		}
		if(!$_GET['id']){
			return;
		}
		$one = $this->obj->view();
		$s = $one->status==1?0:1;
		$condition = ['_id'=>new \MongoId($_GET['id'])];
		$this->obj->update($condition,['status'=>(int)$s]);
		flash('success',$this->info);
		redirect(url($this->jump,$_GET));
	}
	
	function removeAction(){
		if($this->disable === true){
			return;
		}
		if(!$_GET['id']){
			return;
		}
		$condition = ['_id'=>new \MongoId($_GET['id'])];
		$this->obj->remove($condition);
		flash('success',$this->info);
		redirect(url($this->jump,$_GET));
	}
	
	/**
	 * form
	 */
	function viewAction(){
		if($this->disable === true){
			return;
		}
		if($_GET['id']){
			$data['data'] = $this->obj->view();
		}
		$data['view'] = true;
		if($_POST && is_ajax()){
			$setData = $_POST;
			if($_GET['id']){
				$condition = ['_id'=>new \MongoId($_GET['id'])];
				$rt = $this->obj->updateValidate($condition,$setData);
			}else{
				$rt = $this->obj->insertValidate($setData);
			}
			$data['status'] = 0;
			$data['label'] = '系统未知错误';
			$data['msg'] = '保存数据失败！！！';
			if(is_array($rt) && $rt['errors']){
				$data['msg'] = $rt['errors'];
			}elseif(is_object($rt)){
					$data = [
							'status'=>1,
							'msg'=>'添加成功',
							'label'=>'提示信息',
					];
			}elseif($rt){
				$data = [
						'status'=>1,
						'msg'=>'更新成功',
						'label'=>'提示信息',
				];
			}
			exit(json_encode($data));
		}
		if($this->data){
			$data = $data + $this->data;
		}
		$this->data = $data;
		return $this->view($this->view,$data);
	}
	
	
	function indexAction(){
		if($this->disable === true){
			return;
		}
		$data = $this->obj->page([
				'url'=>$this->jump,
				'size'=>$this->per_page,
				'sort'=>$this->sort,
				'condition'=>$this->condition,
		]);
		
		$data['list'] = true;
		if($this->data){
			$data = $data + $this->data;
		}
		$this->data = $data;
		return $this->view($this->view,$data);
	}
	 
	 
}
