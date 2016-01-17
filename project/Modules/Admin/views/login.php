<?php 
$this->layout('main');
?>
<?php 

$this->start('body');
$this->extend('inc/header');
$par = ['s'=>$_GET['s']];

?>
<div class="container">
<form method="POST" class='ajaxform'  enctype="multipart/form-data">
	  <div class="form-group">
	    <label >用户名</label>
	    <input type="input" class="form-control"  name='user' >
	  </div>
	 
	 <div class="form-group">
	    <label >密码</label>
	    <input type="password" class="form-control"  name='pwd' >
	  </div>
	 
	  
	  
	   
	  <button type="submit" id='submit' class="btn btn-default">登录</button>
	</form>
</div>
<?php 
$this->extend('inc/footer');
$this->end();
?>