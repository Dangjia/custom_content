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
        <h1 class="blog-title">课程说明</h1>
        <p class="lead blog-description"><?php echo Comm::config('blog-title-small');?>.</p>
      </div>
    </div>
    
<?php $this->end();?>

<?php $this->start('body');?>


<div class="row s">
        <div class="col-md-4">
          <h2>课程一</h2>
          
          <p>
          吴式太极拳传统89式拳架、太极养生桩、拳架基本内涵、习练推手之四正手 
          
          <small>目标：熟练掌握吴式太极拳传统89式标准动作，初步了解简单应用和训练方法。</small>
          
          </p>
        </div>
        <div class="col-md-4">
          <h2>课程二</h2>
          <p>
          		系统学习吴式太极推手方法,吴式太极十三势推手、定步推手。
          		
          		基础的推手攻防练习
          		
          		<small>目标：熟练掌握吴式太极拳推手方法。</small>
          </p>
       </div>
        <div class="col-md-4">
          <h2>课程三</h2>
          <p>
          	系统深入学习吴式太极推手技法以及活步推手、 太极拳应用 
          	
          	<small>目标：基本达到对整个太极的认知和掌握，日后可自行修习</small>

			</p>
        </div>
      </div>

<hr>

<div class="alert alert-info" role="alert">
  <strong>私人领教,了解更多可关注微信公众号 "起合太极" 或添加微信好友 "sunkangchina"</strong> 
  
</div>







     



 
 
<?php $this->end();?>

