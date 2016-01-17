<?php   namespace sunkangchina\phppdo;
use  sunkangchina\phplog\Log;
/**
  *  ＭＹＳＱＬ　数据库操作,本地SQL如果有错误会自动打开错误，线上无法打开错误信息。
  *
  *  如果用到 order by,group by 这类对应的方法为　order_by group_by
  * 
  * @author Sun <sunkang@wstaichi.com>
  * @license 数据库操作
  * @copyright http://www.wstaichi.com 
  * @time 2014-2015
  */
/** 
*  
* <code> 
*
*连接数据库
*DB::w(["mysql:dbname=hello;host=127.0.0.1","root","123456",'drupal']);
*
*主库
*DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test"])
*
*从库
*DB::r([ ["mysql:dbname=cdn;host=127.0.0.1","test","test"] ]);
*
*自定义连接数据库
*DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test" ,"user"])
*注意其中 user 当操作数据库时需要使用　DB::w('user')
*
*支持mysql 数据库。如order by ,
*请在 $db->table('table')->order_by('id desc');
*其他方法依次类推
*
*
*以下为操作数据库的具体事例
*
*主库
*$db = DB::w();
*
*从库
*$db = DB::r();　
*
*写入数据库记录
*echo $db->insert('posts',['name'=>'test']);
*	 	
*更新数据库记录
*$db->update('posts',['name'=>'abcaaa'],'id=?',[1]);
*	 	
*删除记录
*$db->delete('posts','id=?',[1]);
*
*打开DEBUG查看具体的sql,仅限本地使用。
*
*$db->log();
*$r = $db->table('posts')
*	->select('a.id,a.name')
*	->left_join('aa as b')
*	->on('b.id=a.id')
*	->where('a.name=?',['abc']) 
*	->or_where('a.name=?',['abc'])
*	->limit(10)
*	->offset(1)
*	->order_by('a.id asc')
*	->all(); 
*		
* 对应生成的sql如下
*
*	select a.id ,a.name from posts
*	left join aa as b 
*	on b.id = a.id
*	where a.name=?
*	or a.name = ?
*	limit 10
*	offset 1
*	order by a.id asc
*		
*输出数据库lgo	
*dump($db->log());
*			
*
*
*数据库查寻
*
*查寻一条记录
*$r = $db->table('posts')
*	->where('name=?',['abc'])  
*	->one();  
*
* 
*
*DB::w()->from(table)
*	->page([
*	   'url'=>url,
*	   'page'=>10,
*	   'class'=>'pagination',
*	   'count'=>'count(*) num'
*	]);
*		
*IN 操作
*$in = [1,2];
*DB::w()->from('files')
*	->where('id in ('.DB::in($in).')',$in)
*	->all(); 
*
*按值排序
*DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)
*		->order_by("FIELD ( id ,".implode(',' , $in).") ")
*		->all(); 
*		
*
*指写入数据
*	DB::w()->insert_batch('user',[
*		 ['username'=>'admin','email'=>'test@msn.com'],
*		 ['username'=>'admin','email'=>'test@msn.com'],
*	])
*
*
*导入文件到数据库　(如果要避免重复，需要设置唯一索引)
*	 DB::w()->load_file('test',WEB.'/1.csv',[
*		'body'
*	]); 
*		
*</code>
**/
use PDO;
class DB{ 
	/**
	*　pdo句柄
	*/
	public $pdo; 
	/**
	* query
	*/
	public $query;
	/**
	* ar结构
	*/
	protected $ar;
	 
	/**
	* 日志
	*/
	static $log;
	static $debug = true;
	/**
	*sql 
	*/
	protected $sql;
	/**
	*sql对应的value
	*/
	protected $value;
	protected $key;
	/**
	* 数据库连接是否成功
	*/
	public $active = false;
	/**
	*where 条件
	*/
	public $where; 
	/**
	*　DSN连接信息
	*/
	protected $dsn;
	/**
	* 数据库用户名
	*/
	protected $user;
	/**
	*数据库密码
	*/
	protected $pwd;
	public $connect;
	 
	public $key_batch;
	static $mark = []; //记录所有连接的最后值
	/**
	* 从库
	*/
	static $read;
	/**
	* 主库
	*/
	static $write;
	/**
	*where 条件 
	*/
	static $_set_where;
 
	
	
	public $queryCount = 0;
	public $queries = array();
	
	protected function getTime() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		return $start;
	}
	protected function logQuery($query, $start) {
		$query['time'] = ($this->getTime() - $start)*1000;
		array_push($this->queries, $query);
	}
	protected function getReadableTime($time) {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret,3,'.','') . ' ' . $formats[$formatter];
		return $ret;
	}
	
	
	
	/**
	* 数据库分页
	* @example 　DB::w()->from(table)->page(['url'=>url,'page'=>10,'class'=>'pagination','count'=>'count(*) num']);  
	* @param array $condition 　 
	* @return 数组　['data','pages']
	*/
	function page($condition = []){   
		$url = $condition['url'];
		$count = $condition['count']?:"count(*) num";
		$class =$condition['class']?:"pagination"; 
		$per_page = $condition['per_page']; 
		if(!$per_page)
			$per_page = $condition['page']?:10;   
 		unset($condition['url'],$condition['per_page'],$condition['page'],$condition['class']); 
		if($condition){
 			foreach ($condition as $conditionkey => $conditionValue) { 
		 		if( strpos($conditionkey,'where')!==false ){
					$this->$conditionkey($conditionValue[0],$conditionValue[1]); 
		 		}else{
					$this->$conditionkey($conditionValue);
				}
		 	}
		}
 		$this->count($count); 
		$this->_query(true);  
		$query = $this->query;
		 
		$row = $query->fetch(PDO::FETCH_OBJ);  
		$paginate = new Paginate($row->num,$per_page); 
		$paginate->url = $url;
		$limit = $paginate->limit;
		$offset = $paginate->offset;  
		//显示分页条，直接输出 $paginate
		$pages = $paginate->show($class);    
		if($condition){
 			foreach ($condition as $conditionkey => $conditionValue) { 
		 		if( strpos($conditionkey,'where')!==false ){
					$this->$conditionkey($conditionValue[0],$conditionValue[1]); 
		 		}else{
					$this->$conditionkey($conditionValue);
				}
		 	}
		}
		$this->limit($limit);
		$this->offset($offset);
		$this->_query(true); 

		

		$posts = $this->query->fetchAll();
		unset($this->ar,$this->where);  
		return (object)[
			'data'=>$posts,
			'pager'=>$pages,
			'count' =>$row->num
		];
	}
	 
	/**
	* mysql in() 特殊操作，由于pdo中使用占位符?
	*
	* DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)->all(); 
	*
	* @example 　
	*
	* $in = [1,2];
	*
	* DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)->all(); 
	*
	* @param array $name 　 
	* @return string
	*/ 
	static function in($name){
		return str_repeat ('?, ',  count ($name) - 1) . '?';
	}
	/**
	* 与table 方法相同
	* @example 　DB::w()->from(table)
	* @param string $table 　 
	* @return object
	*/
	function from($table){  
		$this->table($table);
		return $this;
	}
	 
	/**
	* 直接返回主键一行对象 无需要再加->one()
	* @example 　DB::w()->from(table)->pk(1);
	* @param int $id 　 
	* @return object
	*/
	function pk($id){
		return $this->where('id=?',[$id])->one();
	}
    
	/**
	* 构造函数
	* @param string $dsn 　  mysql:dbname=testdb;host=127.0.0.1
	* @param string $user 　  dbuser
	* @param string $pwd 　  dbpass
	* @return 
	*/
	public function __construct($dsn,$user,$pwd,$exceptions = false){  
		try {
			$this->dsn = $dsn;
			$this->user = $user;
			$this->pwd = $pwd;
		    $this->pdo = new PDO($dsn, $user, $pwd,[
		    	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
		    	PDO::ATTR_CASE => PDO::CASE_LOWER,
		     	PDO::ATTR_DEFAULT_FETCH_MODE =>  PDO::FETCH_OBJ,
		     	PDO::MYSQL_ATTR_LOCAL_INFILE => true,
		    ]);
		    $this->active = true;
		    $this->connect = [
		    	'dsn'=>$dsn,
		    	'user'=>$user,
		    	'pwd'=>$pwd,
		    	'active'=>$active, 
		    ];
		} catch (PDOException $e) { 
			Log::info("Database Pdo connect failed!");
			$this->active = false; 
		} 
	} 
	/**
	* 设置从库的连接以及打开从库，随机打开一个从库连接
	* @example 设置从库　DB::r([ ["mysql:dbname=taijimr;host=127.0.0.1","test","test"] ]);
	* @example 读取从库　DB::r();
	* @param int $db　可指定要打开的从库的第几个 　 
	* @return DBobject
	*/
	static function r($db = NULL){
		if(!isset(static::$read)){
			$i = array_rand ($db , 1);
			$config = $db[$i];
			if(!$config)
				$config = $db; 
			static::$read = new Static($config[0],$config[1],$config[2]); 
		}
		$default = 'r'; 
		static::$mark[$default] = $default;
		unset(static::$read[$default]->ar,static::$read[$default]->where);
		return static::$read;
	}
	/**
	
	
	*/
	/**
	* 设置主库的连接以及打开从库，随机打开一个从库连接
	* @example 设置主库　DB::w(["mysql:dbname=taijimr;host=127.0.0.1","test","test"]);
	* @example 设置主库t　DB::w(["mysql:dbname=taijimr;host=127.0.0.1","test","test",'t']);
	*
	*
	* @example 读取主库　DB::w();
	* @example 读取主库t　DB::w('t');
	* @param string $config　指定打开哪个主库　默认 w　 
	* @return DBobject
	*/
	static function w($config='w'){
		if(is_array($config)) $default = $config[3]?:'w';
		else $default = $config;
		if(!isset(static::$write[$default])){  
			static::$mark[$default] = $default;
			static::$write[$default] = new Static($config[0],$config[1],$config[2],true);  
		} 
		unset(static::$write[$default]->ar,static::$write[$default]->where); 
		return static::$write[$default];
	}

	/**
	* 返回SQL 信息
	*  
 	* @example 　dump(DB::w()->log()); 
	* @return array
	*/	
	function log(){
		 return static::$log;
	}
 
	/**
	* select 查寻字段
	* @example  DB::w()->select("id,name");
	* @param string $str　数据库中的字段以,分隔　 
	* @return DBobject
	*/
	function select($str = "*"){
		$this->ar['SELECT'] = $str;
		return $this;
	}
	/**
	* 统计
	* @example  DB::w()->select("id,name")->count("count(*) num")->one();
	* @param string $str　count(*) num 
	* @return DBobject
	*/
	function count($str = "count(*) num"){
		$this->ar['SELECT'] = $str;
		return $this;
	}
	/**
	* 内部函数 将 ['username'=>'admin','email'=>'test@msn.com'] 
	* 转换成 "username = ? ,email = ? " ,['admin' , 'test@msn.com']
	* @param array $arr 
	* @return void
	*/ 
	protected function _to_sql($arr){
		foreach($arr as $k=>$v){
			$key[] = "`".$k."`=? "; 
		} 
		$key = implode(",",$key);  
		$value = array_values($arr); 
		$this->key = $key;
		$this->value = $value;
	} 
	/**
	* 批量写入数据
	*
	* @example  
	*<code>
	*
	*	insert_batch('user',[
	*		['username'=>'admin','email'=>'test@msn.com'],
	* 		['username'=>'admin','email'=>'test@msn.com'],
	*	])
	*</code>
	* @param string $table
	* @param array $arr
	* @return object
	*/
	function insert_batch($table,$arr = []){ 
		$this->_to_sql_batch($arr);
		$this->sql = "INSERT INTO $table ($this->key) $this->key_batch";   
		return $this->exec(true);
	} 
	/**
	* 内部函数
	*/
	protected function _to_sql_batch($arrs){ 
		$set_value = false;
		unset($this->key_batch);
		foreach($arrs as $arr){
			unset($vo,$vs);
			foreach($arr as $k=>$v){
				$key[$k] = "`".$k."`";   
				$vo[] = "?";
				$value[] = $v; 
			}   
			if(false === $set_value ) $vs = "values";  
			$this->key_batch[] = "$vs(".implode(',',$vo).") ";
			$set_value = true;
		}
		$key = implode(",",$key);   
		$this->key = $key;
		$this->key_batch = implode(",",$this->key_batch);   
		$this->value = $value;  
	}
	/**
	* 加载文件到数据库，导入大数据时使用
	* 如果要避免重复，需要设置唯一索引
	*
	* @example 
	*
	*<code>
	*
	*	DB::w()->load_file('test',WEB.'/1.csv',[
	*		'body'
	*	]); 
	*
	*</code>
	* @param string $str　count(*) num 
	* @return int
	*/
	function load_file($table,$file,$data = [],$arr = [
		'FIELDS'=>',',
		'ENCLOSED'=>'\"',
		'LINES'=>'\r\n',
		'CHARACTER'=>"utf8",
		//'IGNORE'=>1,
	]){
		$file = str_replace('\\','/',$file);
		if($data){
			$filed = "(`".implode('`,`',$data);
			$filed .="`)"; 
		}
		foreach($arr as $k=>$v){
			$arr[strtoupper($k)] = $v;
		}
		$this->sql = "LOAD DATA LOCAL INFILE '".$file."' REPLACE INTO  TABLE ".$table."
		  CHARACTER SET ".$arr['CHARACTER']."
		  FIELDS TERMINATED BY '".$arr['FIELDS']."' ENCLOSED BY '".$arr['ENCLOSED']."'
		  LINES TERMINATED BY '".$arr['LINES'] ."' ".$filed;
		if($arr['IGNORE'])
			$this->sql .= " IGNORE ".$arr['IGNORE']." LINES;"; 
		return $this->exec(true); 
	}
	/**
	* 写入数据
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->insert('user',['username'=>'admin','email'=>'test@msn.com'])
	*
	*</code>
	* @param string $table　表名
	* @param array $arr　字段名对应值　
	* @return int
	*/
	function insert($table,$arr = []){ 
		$this->_to_sql($arr);
		$this->sql = "INSERT INTO $table SET ".$this->key; 
		return $this->exec(true);
	} 
	/**
	* 删除数据
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->delete('posts','id=?',[1]); 
	*
	*</code>
	* @param string $table  表名
	* @param string $condition  　条件　
	* @param array $value   	条件对应的值，可为字符，多值时必须是数组
	* @return int
	*/
	function delete($table,$condition=null,$value=[]){ 
		$this->sql = "DELETE FROM $table ";
		if($condition)
			$this->sql .= "WHERE $condition ";
		if($value){
			if(!is_array($value)) $value = [$value];
			$this->_to_sql($value); 
		}   
		return $this->exec();
	}
	/**
	* 更新数据
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->update('posts',['name'=>'abc2'],'id=?',[1]); 
	*
	*</code>
	* @param string $table  表名
	* @param array $set  更新　字段对应值　
	* @param string $condition  　条件　
	* @param array $value   	条件对应的值，可为字符，多值时必须是数组
	* @return int
	*/
	function update($table,$set = [] ,$condition=null,$value=[]){
		$this->_to_sql($set);
		$this->sql = "UPDATE $table SET ".$this->key;
		if($condition)
			$this->sql .= "WHERE $condition ";
		if($value){
			if(!is_array($value)) $value = [$value];
 			$this->value = array_merge($this->value,$value);
		}  
		return $this->exec();
	}
	/**
	* 表名
	* 　
	* @param string $table  表名
	*
	* @return object
	*/
	function table($table){ 
		$this->ar['TABLE'] = $table; 
		return $this;
	}
	/**
	* 执行查寻一条记录
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->table('user')->one();
	*
	*</code>
	*
	* @return object
	*/
	function one(){
		$this->_query();
		return $this->query->fetch(PDO::FETCH_OBJ);
	}
 	/**
	* 执行查寻多条条记录
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->table('user')->all();
	*
	*</code>
	*
	* @return object
	*/
	function all(){
		$this->_query(); 
		return $this->query->fetchAll(); 
	}
	/**
	* 支持纯SQL,直接返回查寻的结果集对象
	*  
	* @example 
	*
	*<code>
	*
	*	DB::w()->sql('select * from user where id=?',1); 
	*
	*</code>
	* @param string $sql 完整的ＳＱＬ
	* @param array $value  pdo bind value
 	*
	* @return object
	*/
	function sql($sql,$value=null){
		$this->sql = $sql;
		if($value && !is_array($value)) $value = [$value];
		$this->value = $value;   
		$this->exec(); 
		return $this;
	}
	/**
	* 内部函数
	*/
	protected function _query($keep_ar = false){  
		static::$_set_where = false;
		$value = [];
		if(!$this->ar['TABLE']) return $this;
		$sql = "select ".($this->ar['SELECT']?:'*')." FROM ".$this->ar['TABLE'];
		$s = $this->ar['SELECT'];
		$t = $this->ar['TABLE'];
		unset($this->ar['SELECT'],$this->ar['TABLE']); 
 		if($this->ar){
			foreach($this->ar AS $key=>$condition){
				if(strpos($key,'WHERE')!==false && static::$_set_where===false){
					$sql .= " WHERE 1=1  "; 
					static::$_set_where = true;
				}
				if(is_array($condition)){
					foreach($condition as $str=>$vo){
				 		$sql .= " ". $k." ".$str." "; 
				 	 	$value = array_merge($value,$vo);
				 	}
				}else{
					if(strpos($key,'WHERE')!==false)
						 $sql .= " ". $condition." ";
					else
						$sql .= " ".$key." ". $condition." ";
			 	}
			}
		}   
		//使用后要删除 $this->ar
		if(false === $keep_ar){
			unset($this->ar,$this->where); 
		}else{
			$this->ar['SELECT'] = "*";
			$this->ar['TABLE'] = $t;
		}
		$this->sql = $sql;
		$this->value = $value;   
		$this->exec(); 
		return $this;
	 
	}
	/**
	*　内部函数
	*/
	protected function exec($insert = false){  
		//记录日志 
		$this->query = $this->pdo->prepare($this->sql , [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);  
		$execute = $this->query->execute( $this->value );
		$last_id = $this->pdo->lastInsertId();  
		
        if(!$execute){ 
        	$info = $this->query->errorInfo()[2];  
         	Log::error("MYSQL query failed.sql:".$this->sql)." BindValue:".json_encode($this->value)." ErrorInfo:".$info;
        	return false;
        }
        Log::info("MYSQL query failed.sql:".$this->sql)." BindValue:".json_encode($this->value)." ErrorInfo:".$info;
	    return $last_id?:null; 
	}
	/**
	*　方法名不存在时，执行该函数. 支持mysql更多的方法
	*/
	function __call ($name ,$arg = [] ){ 
		$name = strtoupper($name);
		$key = $arg[0];
		$vo = $arg[1];
		if($name=='WHERE') $name = "AND_WHERE";
		$name = str_replace('_',' ',$name);  
		if(strpos($name,'WHERE')!==false){  
			$arr = explode(' ',$name);
			$key = $arr[0]." ".$key;
			if(!is_array($vo)) $vo = [$vo];
		} 
		if($vo){
			$this->ar[$name][$key] = $vo;
		}else if($key){  
			$this->ar[$name] = $key;
		}

		return $this;
	} 


}
