<?php 

$this->layout('main');

?>


 
<?php $this->start('body');?>
<?php $this->extend('inc/header'); ?>


<h2><?php echo $data->title;?></h2>

<p>

	<?php echo $data->body;?>
</p> 


<span <p class="text-muted">
	时间： <time datetime="<?php echo date('Y-m-d H',$data->created->sec);?>"><?php echo date('Y-m-d H',$data->created->sec);?></time>
</span>
 
 
<?php $this->end();?>


 
