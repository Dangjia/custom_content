PDO

依赖 

    composer require sunkangchina/php-log dev-master


安装

	composer require sunkangchina/php-pdo dev-master
	

	use sunkangchina\phppdo\DB;

连接数据库

	DB::w(["mysql:dbname=hello;host=127.0.0.1","root","123456",'drupal']);

主库

	DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test"])

从库

	DB::r([ ["mysql:dbname=cdn;host=127.0.0.1","test","test"] ]);

自定义连接数据库
	
	DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test" ,"user"])
	
注意其中 user 当操作数据库时需要使用　

	DB::w('user')

支持mysql 数据库。如order by ,
请在 
	
	$db->table('table')->order_by('id desc');

其他方法依次类推


以下为操作数据库的具体事例

主库

	$db = DB::w();

从库
	
	$db = DB::r();　

写入数据库记录
	
	echo $db->insert('posts',['name'=>'test']);
	 	
更新数据库记录

	$db->update('posts',['name'=>'abcaaa'],'id=?',[1]);
	 	
删除记录

	$db->delete('posts','id=?',[1]);

打开DEBUG查看具体的sql,仅限本地使用。

	$r = $db->table('posts')
		->select('a.id,a.name')
		->left_join('aa as b')
		->on('b.id=a.id')
		->where('a.name=?',['abc']) 
		->or_where('a.name=?',['abc'])
		->limit(10)
		->offset(1)
		->order_by('a.id asc')
		->all(); 
			
 对应生成的sql如下

	select a.id ,a.name from posts
	left join aa as b 
	on b.id = a.id
	where a.name=?
	or a.name = ?
	limit 10
	offset 1
	order by a.id asc
		

	 
			


数据库查寻

查寻一条记录

	$r = $db->table('posts')
	->where('name=?',['abc'])  
	->one();  

 

	DB::w()->from(table)
		->page([
		   'url'=>url,
		   'page'=>10,
		   'class'=>'pagination',
		   'count'=>'count(*) num'
		]);
		
IN 操作

	$in = [1,2];
	DB::w()->from('files')
		->where('id in ('.DB::in($in).')',$in)
		->all(); 

按值排序

	DB::w()->from('files')->where('id in ('.DB::in($in).')',$in)
		->order_by("FIELD ( id ,".implode(',' , $in).") ")
		->all(); 
		

指写入数据

	DB::w()->insert_batch('user',[
		 ['username'=>'admin','email'=>'test@msn.com'],
		 ['username'=>'admin','email'=>'test@msn.com'],
	])


导入文件到数据库　(如果要避免重复，需要设置唯一索引)

	 DB::w()->load_file('test',WEB.'/1.csv',[
		'body'
	]); 
		
