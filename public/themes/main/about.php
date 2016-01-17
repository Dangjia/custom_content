<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

?>

<?php $this->start('header');?>
<?php $this->extend('inc/header'); ?>

<div class="blog-header">
      <div class="container">
        <h1 class="blog-title"><?php echo Comm::config('blog-title');?></h1>
        <p class="lead blog-description"><?php echo Comm::config('blog-title-small');?>.</p>
      </div>
    </div>
    
<?php $this->end();?>

<?php $this->start('body');?>





<div class="row s">
        <div class="col-md-6">
          <h2>刘继发</h2>
          
          <p>
          著名吴式太极传人，生于1939年，从27岁时开始跟随吴式太极拳名师裴祖荫先生学习太极拳。 作为跟随裴先生20多年的徒弟，在文革结束上海鉴泉社复社后，正式拜师裴先生。于八十年代被裴先生引荐给马岳梁和吴英华大师。裴先生去世后，跟随马岳梁和吴英华大师继续学习太极拳。
          <br><img src="<?php echo theme_url('img/liujifa.jpg');?>" />
          </p>
        </div>
        <div class="col-md-6">
          <h2>孙康</h2>
          <p>
          		师承刘继发老师。 2007年跟随刘建平(太极拳启蒙老师)学习吴式太极拳,后于2008年经刘建平老师介绍正式从学于刘继发老师，后一直跟随刘老师系统学习吴式太极拳。 2012年正式拜师。
         	<br><img  style='margin-top:30px;' src="<?php echo theme_url('img/sk.jpg');?>" />
          </p>
       </div>
        
</div>

<hr>

<!-- <div class="alert alert-info" role="alert">
  <strong></strong> 
  
</div> -->

     



 
 
<?php $this->end();?>

