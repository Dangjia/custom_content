<?php 

$this->layout('main');

?>


 
<?php $this->start('body');?>
<?php $this->extend('inc/header'); ?>


<h2>Example body text</h2>
<?php foreach($datas as $data){?>
	<article class="wrap">
		<h4>
			<a href="/post/<?php echo (string)$data->_id;?>" title="<?php echo $data->title;?>"> <?php echo $data->title;?></a>
		</h4>

		<div class="content">
			<?php echo Cls\Str::cut($data->body,50);?>
		</div>

		<span <p class="text-muted">
			时间： <time datetime="<?php echo date('Y-m-d H',$data->created->sec);?>"><?php echo date('Y-m-d H',$data->created->sec);?></time>
		</span>
	</article>
<?php }?>
 
 
<?php $this->end();?>


 
