<?php 

$this->layout('main');

?>
 
<?php $this->start('body');?>
 <div class='am-container top' >
 
 <article data-am-widget="paragraph"
           class="am-paragraph am-paragraph-default"
           
           data-am-paragraph="{ tableScrollable: true, pureview: true }">
           
		<div class="header">
            <h1><?php echo $data->title;?></h1>
            <h2><?php echo date('Y年m月d日',$data->created->sec);?></h2>
        </div>

        <div class="content">
        	<?php echo $data->body;?>
        </div>
        
       
  </article>
  <div class="social-share"></div>
  <p></p>
 </div>      

 
 
 
<?php $this->end();?>


<?php $this->start('footer');?>


<!-- share.css -->
<link rel="stylesheet"  href="<?php echo url('misc/share.js/dist/css/share.min.css');?>">

<!-- share.js -->
<script src="<?php echo url('misc/share.js/dist/js/share.min.js');?>"></script>
  



<?php $this->end();?>


 
