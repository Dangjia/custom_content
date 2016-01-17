<?php
/**
 * @author  SUN KANG [sunkang@wstaichi.com]
 * @copyright 
 * @version 1.0
 */
namespace Model;
use Cls\TreeHelper;
use Cls\Comm;
class  Base extends BaseValidate{
	
	public $tb;
	public $int = [];
	public $allowFields = [];
	public $data = [];
	public $ignoreFiles = [];
	function __construct(){
		parent::__construct();
		if($this->int){
			foreach($this->int as $v){
				$_POST[$v] = (int)$_POST[$v]?:0;
				$_GET[$v] = (int)$_GET[$v]?:0;
			}
		}
		$this->init();
	}
	function init(){
		
	}
	
	/**
	 * 忽略字段
	 * @param unknown $ignoreFiles
	 */
	function ignore($ignoreFiles){
		$this->ignoreFiles = $ignoreFiles;
		foreach($this->validate as $k=>$v){
			if(in_array($k,$ignoreFiles)){
				unset($this->validate[$k]);
			}
		}
	}
	
	function _arrayToString($arr){
		if(!$arr){
			return;
		}
		foreach($arr as $k=>$v){
			$str .=$k."=".$v." ,";
		}
		return substr($str,0,-1);
			
	}
	
	function _log($str){
		$str .= "IP: ".Comm::ip()." User ID:".cookie('adminId')." UserName:".cookie('adminUser');
		log_sys($str);
	}
	
	
	/**
	 * 表单中的树，可以选任意节点
	 * 生成option
	 * 字段  id title pid
	 * @param array $all
	 */
	function getTree($selectValue = null){
		$all = $this->find([]);
		foreach($all as $v){
			$new[] = (object)[
					'id'=>(string)$v->_id,
					'title'=>$v->title,
					'pid'=>$v->pid?:0,
			];
		}
		$new = TreeHelper::toTree($new,0,$selectValue);
		return $new;
	}
	
	/**
	 *  生成列表可以分得清的层级关系
	 *  字段  id title pid
	 * @var unknown
	 */
	static $_treeList_baseModel;
	static $_treeList_baseModel_I = 0;
	static function tableTree($arr,$pid = 0 ,$span = "&nbsp"){
		if(!$arr){
			return;
		}
		foreach($arr as $v){
			if($v->pid == $pid){
				static::$_treeList_baseModel[] = $v;
				static::_tableTreeHelper($arr,$v);
			}
		}
		return static::$_treeList_baseModel;
	}
	
	static function _tableTreeHelper($arr ,$v){
		$n = static::$_treeList_baseModel_I++;
		$str = "";
		for($i=0;$i<=$n;$i++){
			$str .= "------";
		}
		$str .= "|";
		foreach($arr as $vo){
			if($vo->pid == $v->id){
				$vo->title = $str.$vo->title;
				static::$_treeList_baseModel[] = $vo;
				static::_tableTreeHelper($arr, $vo);
			}
		}
	
	}
	
	
	/**
	 * 验证数据是否为设置好的字段
	 * @param unknown $data
	 * @return unknown[]
	 */
	protected function filterData($data){
		$Fdata = [];
		$allow = $this->allowFields;
		$ignore = $this->ignoreFiles;
		
		foreach($data as $k=>$v){
			if($ignore && in_array($k,$ignore)){
				continue;		
			}
			if(in_array($k,$allow)){
				if(is_string($v)){
					$v = trim($v);
				}
				$Fdata[$k] = $v;
			}
		}
		return $Fdata;
	}
	/**
	 * 更新全部数据
	 * @param 条件 $condition
	 * @param 更新的数组 $setData
	 */
	public function updateAll($condition = null,$setData = null){
		return $this->update($condition,$setData,true);
	}
	/**
	 * beforeUpdateValidate($data),beforeSaveValidate
     *
	 * @param unknown $condition
	 * @param unknown $setData
	 */
	public function updateValidate($condition = null,$setData = null){
		if(method_exists($this,'beforeUpdateValidate')){
			$this->beforeUpdateValidate($setData);
		}
		if(method_exists($this,'beforeSaveValidate')){
			$this->beforeSaveValidate($setData);
		}
		$e = $this->validate();
		if($e !== true){
			return [
					'errors'=>implode("<br>",$e),
			];
		}
		return  $this->update($condition,$setData,false);
	}
	/**
	 * 更新数据  beforeUpdate($setData,$condition) ,afterUpdate($updatedExisting,$setData),beforeSave,afterSave
	 * @param 条件 $condition
	 * @param 更新的数组 $setData
	 * @param string $updateAll
	 */
	public function update($condition = null,$setData = null,$updateAll = false){
		if(method_exists($this,'beforeUpdate')){
				$this->beforeUpdate($setData,$condition);
		}
		if(method_exists($this,'beforeSave')){
			$this->beforeSave($setData,$condition);
		}
				if(!$condition){
					$condition  = ['_id'=>new \MongoId($_GET['id'])];
				}
				if(!$setData){
					$setData = $_POST;
				}
				$setData = $this->filterData($this->data+$setData);
				if(!$setData){
					return false;
				}
				$setData['updated'] = new \MongoDate();
				
				if($updateAll){
					$log = "All ";
				}
				$this->_log(
					'Update '.$log.' Collection: ['.$this->tb.'],Condition: '.
					 $this->_arrayToString($condition)." ".
					 "Data:".$this->_arrayToString($setData)." "
				);
				$updatedExisting =  mongo($this->tb)->getMapper()->update(
						$condition,
						['$set' => $setData],
						['multiple' => $updateAll===true?true:false]
						)['updatedExisting'];
				
				if(method_exists($this,'afterUpdate')){
					$this->afterUpdate($updatedExisting,$setData);
				}
				if(method_exists($this,'afterSave')){
					$this->afterSave($updatedExisting,$setData);
				}
				return $updatedExisting;
	
	}
    
	/**
	 * beforeInsertValidate($data),beforeSaveValidate
	 * 更改 $this->validate = []
	 * 
	 * @param array $data
	 */
	public function insertValidate($data = []){
		if(method_exists($this,'beforeInsertValidate')){
			$this->beforeInsertValidate($data);
		}
		if(method_exists($this,'beforeSaveValidate')){
			$this->beforeSaveValidate($data);
		}
		$e = $this->validate();
		if($e !== true){
			return [
					'errors'=>implode("<br>",$e),
			];
		}
		return $this->insert($data);
	}
	/**
	 * 写入数据  beforeInsert($data) , afterInsert($upserted,$data) ,afterSave
	 * @param array $data
	 */
	public function insert($data = []){
		if(method_exists($this,'beforeInsert')){
			$this->beforeInsert($data);
		}
		if(method_exists($this,'beforeSave')){
			$this->beforeSave($data);
		}
		$mo  =  mongo($this->tb);
		$data = $this->filterData($this->data+$data);
		if(!$data){
			return false;
		}
		foreach($data as $k=>$v){
			$mo->$k = $v;
		}
		$mo->created = new \MongoDate();
		$mo->updated = new \MongoDate();
		
		$this->_log(
				'Insert Collection: ['.$this->tb.'],'.
				"Data:".$this->_arrayToString($data)." "
				);
		
		$upserted =  $mo->save()['upserted'];
		
		if(method_exists($this,'afterInsert')){
			$this->afterInsert($upserted,$data);
		}
		if(method_exists($this,'afterSave')){
			$this->afterSave($upserted,$data);
		}
		return $upserted;
	}
	
	/**
	 * 直接以_id显示数据
	 */
	public function view(){
		$id = $_GET['id'];
		return $this->findOne(['_id'=>new \MongoId($id)]);
	}
	/**
	 * 计数COUNT
	 * @param unknown $condition
	 */
	public function count($condition = null){
		return mongo($this->tb)->getMapper()
				->count($condition);
	}
	/**
	 * 查寻数据 
	 * $par[
	 * 	'sort'=> ['created' => -1 ] ,
	 *	'skip'=> [$pageArray['offset']],
	 *	'limit'=>$size,
	 * ]
	 * @param 条件 $condition
	 * @param array|排序 limit等 $par
	 */ 
	public function find($par = [] ){
		$condition = $par['condition']?:[];
		unset($par['condition']);
		$mo = mongo($this->tb)->getMapper();
		$mo = $mo->find($condition);
		if($par){
			foreach ($par as $k=>$v){
				$mo = $mo->$k($v);
			}
		}
		return $mo->get();
	}
	/**
	 * 查寻一条记录
	 * @param 条件 $condition
	 */
	public function findOne($condition){
		return mongo($this->tb)->findOne($condition);
	}
	/**
	 * 删除数据 
	 * @param 条件 $condition
	 */
	public function remove($condition = null){
		$mo = mongo($this->tb)->getMapper();
		
		$this->_log(
				'Remove Collection: ['.$this->tb.'],'.
				"Condition:".$this->_arrayToString($condition)." "
				);
		
		return $mo->remove($condition);
	}
	/**
	 * 分页
	 * $data = $this->obj->page([
	 *			'url'=>'/posts',
	 *			'size'=>10,
	 *			'sort'=>[
	 *				'created'=>-1
	 *			],
	 *			'condition'=>[
	 *				'status'=>1	
	 *			],
	 *	]);
	 *	return view('post',$data);
	 * @param array $par
	 */
	public function page($par = []){
		$url = $par['url']?:'/posts';
		$size = $par['size']?:10;
		$condition = $par['condition']?:[];
		unset($par['url'],$par['size'],$par['condition']);
		
		$count = mongo($this->tb)->getMapper()
				->count($condition);
		
		$pageArray =  page($url,$count,$size);
		$data['page'] = $pageArray['link'];
		$mo = mongo($this->tb)->getMapper()
			->find($condition);
		
		if($par){
			foreach ($par as $k=>$v){
				$mo = $mo->$k($v);
			}
		}
		$mo = $mo->skip($pageArray['offset']);
		$mo = $mo->limit($size);
		$data['datas'] = $mo->get();
		$data['count'] = $count;
		return $data;
	}
	
	
	
}