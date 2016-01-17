<?php 
$this->layout('main');
$url = 'admin/config';
?>
<?php 

$this->start('body');
$this->extend('inc/header');
$par = ['s'=>$_GET['s']];

?>

<div class="container">
     
     <table class="table">
      <caption>查看日志. 
      	<span class='pull-right'>
	         
	      </span>
	  </caption>
      <thead>
        <tr>
          <th></th>
           
        </tr>
      </thead>
      <tbody>
      <?php foreach($datas as $data){
      if(!$data){
      	continue;
      }
      	?>
        <tr>
           
          <td><?php $str = htmlspecialchars($data);
          $str = str_replace('[System]',"<span class='btn btn-info'>[System]</span><br>",$str);
          $str = str_replace('.log'.htmlspecialchars('</h3>'),".log<hr>",$str);
          $str = str_replace(htmlspecialchars('<h3>'),"",$str);
          echo $str;
          ?></td>
          
        </tr>
       <?php }?> 
      </tbody>
    </table>
    <?php echo $page['link'];?>
  



</div>
     

<?php 
$this->extend('inc/footer');
$this->end();
?>



 
