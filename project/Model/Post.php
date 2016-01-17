<?php
namespace Model;

class Post extends Base{
	public $tb = 'posts';
	public $tbVersion = "version_posts";
	/**
	 * 允许保存到数据库的字段 
	 * @var array $allowFields
	 */
	public $allowFields = [
		'title',
		'body',
		'file',
		'category',
		'status',
		'slug'
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
		'title'  => 'required',
		'body'  => 'required',
		'category'=>'required',
		'slug'=>'required|unique(posts,slug)',
	];
	/**
	 * 验证错误提示信息
	 * @var array $validateMessage
	 */
	public $validateMessage = [
		'title'  => [
					'required'=>'标题不能为空',
				],
		'body'  => [
					'required'=>'内容不能为空',
			],
		'category'  => [
					'required'=>'请选择分类',
			],
		'slug'  => [
					'required'=>'url不能为空',
					'unique'=>'已存在设置的URL',
			],
	];
	/**
	 * 
	 * @param array $page
	 */
	static function getByCate($page = []){
		$c = obj('Model\Category');
		$slug = $page['slug'];
		unset($page['slug']);
		if($slug){
			$cate = $c->findOne(['slug'=>$slug]);
			if($cate){
				$id = $cate->id;
			}
		}
		$c = obj('\Model\Post');
		$condition = $page['condition'];
		if($id){
			$condition['category'] = $id;
		}
		$condition['status'] = 1;
		$page['condition'] = $condition;
		$all = $c->page($page);
		return $all;
	}
	
	/**
	 * 记录VERSION
	 * @param unknown $data
	 * @param unknown $condition
	 */
	function beforeUpdate($data,$condition){
		$data = $this->filterData($data);
		$mo = mongo($this->tbVersion);
		if(!$data){
			return true;
		}
		foreach($data as $k=>$v){
			$mo->$k = $v;
		}
		if(!$data['file']){
			$this->data['file'] = [];
		}
		 
		$mo->nodeid = $condition['_id'];
		$mo->save();
		return true;
	}
	
	
	/*public function test(){
		for($i-0;$i<100;$i++){
			$faker = \Faker\Factory::create();
			$mo  =  mongo($this->tb);
			$mo->title = $faker->word;
			$mo->body = $faker->text;
			$mo->status = 1;
			$mo->created = new \MongoDate();
			$mo->updated = new \MongoDate();
			$mo->save();
		}
	}*/
	
	
	
}