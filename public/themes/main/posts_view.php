<?php 

$this->layout('main');

?>
 
<?php $this->start('body');?>
 
		<div class="header">
            <h1><?php echo $data->title;?></h1>
            <h2><?php echo date('Y年m月d日',$data->created->sec);?></h2>
        </div>

        <div class="content">
        	<?php echo $data->body;?>
        </div>
        

 
 
<?php $this->end();?>


 
