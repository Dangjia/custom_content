paginate

安装

	composer require sunkangchina/php-paginate dev-master
	


类似淘宝分页
	 
	$query = DB::w()->from($this->table);
	$row = $query->count()->one();
	
显示分页
	 
	$paginate = new Paginate($row->num,1); 
	$paginate->url = $this->url;
	$limit = $paginate->limit;
	$offset = $paginate->offset;
		
	$paginate = $paginate->show();
	
 
数据 	   
	 $query = DB::w()
	  	->from($this->table)
		->limit($limit)
		->offset($offset);
	 $posts = $query->all();
 

 
 
 