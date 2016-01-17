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
foreach($datas as $v){
$i++;
?> 
		
		<div class="header">
            <h1><a href="/post/<?php echo $v->slug;?>" class="entry-more"><?php echo $v->title;?></a></h1>
            <h2><?php echo date('Y年m月d日',$v->created->sec);?></h2>
        </div>

        <div class="content">
        	<?php echo Cls\Comm::b($v->body,1000);?>
        </div>
        
<?php }?>
        
        
<?php echo $page;?>
                       
