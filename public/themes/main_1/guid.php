<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

?>

<?php $this->start('body');?>
<div class='am-container top' >
<h1>开班信息</h1>

<div data-am-widget="tabs"
       class="am-tabs am-tabs-default"
        >
      <ul class="am-tabs-nav am-cf">
          <li class="am-active"><a href="[data-tab-panel-0]">基础班</a></li>
          <li class=""><a href="[data-tab-panel-1]">提高班</a></li>
          <li class=""><a href="[data-tab-panel-2]">进阶班</a></li>
      </ul>
      <div class="am-tabs-bd">
          <div data-tab-panel-0 class="am-tab-panel am-active">
            吴式太极拳传统89式拳架、<br>太极养生桩、<br>拳架基本内涵、<br>习练推手之四正手 
            <br><small>目标：熟练掌握吴式太极拳传统89式标准动作，初步了解简单应用和训练方法。</small>
          </div>
          <div data-tab-panel-1 class="am-tab-panel ">
            系统学习吴式太极推手方法,<br>吴式太极十三势推手<br>、定步推手。
          		
          		<br>基础的推手攻防练习
        <br>  	<small>目标：熟练掌握吴式太极拳推手方法。</small>	
          </div>
          <div data-tab-panel-2 class="am-tab-panel ">
            系统深入学习吴式太极推手技法以及活步推手、 <br>太极拳应用 
          <br>  <small>目标：基本达到对整个太极的认知和掌握，日后可自行修习</small>
          </div>
      </div>
  </div>
</div>  


     



 
 
<?php $this->end();?>

