<?php 
$this->layout('main');
?>
<?php 

$this->start('body');
$this->extend('inc/header');

?>

<div class="container">
     <h1>数据备份</h1>
      <a class="btn btn-default" href="<?php echo url('mongo/admin/a');?>">备份</a>
     
     <p></p>
     <?php foreach($data as $k=>$v){?>
     <p> 
	     <?php echo $k;?>
	     <hr>
     </p>
     <?php }?>
     


</div>
     

<?php 
$this->extend('inc/footer');
$this->end();
?>



 
