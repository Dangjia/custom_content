 <?php 
 use Cls\Front\DB;
 use Core\Img;
 use Cls\Comm;
 use Model\Post;
 
$data = Post::getByCate([
	'url'=>'/',
	'size'=>10,
		
]);
$page = $data['page'];
$datas = $data['datas'];
$j  = count($datas);
$i = 0;

?> 

  <div data-am-widget="list_news" class="am-list-news am-list-news-default" >
  <!--列表标题-->
    <div class="am-list-news-hd am-cf">
          <h2><?php echo $title1;?></h2>
    </div>

		  <div class="am-list-news-bd">
		  <ul class="am-list">
		 
		      <?php 
		      foreach($datas as $v){
		      	$i++;
		      ?>
		      <li class="am-g">
		          <a href="/post/<?php echo $v->slug;?>" class="am-list-item-hd "><?php echo $v->title;?></a>
		
					<div class="am-list-item-text"><?php echo Cls\Comm::b($v->body,1000);?></div>
		
		      </li>
		      <?php }?>
		  </ul>
		  </div>

</div>
    
	 
        
        
        
<?php echo $page;?>
                       
