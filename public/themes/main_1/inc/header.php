<?php 
use Cls\Comm;
?>    

<header class="am-topbar am-topbar-fixed-top">
  <div class="am-container">
    <h1 class="am-topbar-brand">
      <a href="/"><?php echo Comm::config('front_title_logo');?></a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only"
            data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">导航切换</span> <span
        class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="collapse-head">
      <ul class="am-nav am-nav-pills am-topbar-nav">
      
       <?php $menu = [
                      '首页'=>'/',
                     // '活动'=>'/posts/huodong|huodong',
        			  '视频'=>'/posts/video|video',
        			  '文章'=>'/posts/default|default',
        			  '学拳指南'=>'/guid|guid',
                      '关于我们'=>'/about|about',
                    ];
                    $uri = substr($_SERVER['REQUEST_URI'],1);
                    foreach ($menu as $label=>$v){
                      $ar = explode('|',$v);
                      $murl = $ar[0];
                      $select = explode(',',$ar[1]);
                      if(!$select[0]){
                        $select = [''];
                      }
                      unset($act);
                      foreach($select as $v1){
                        if(!$v1 && !$uri){
                          $act = "am-active";
                          continue;
                        }
                        if($v1 && strpos($uri,$v1)!==false){
                          $act = "am-active";
                        }
                      }
                    ?>
                    <li class=" <?php echo $act;?>"><a href="<?php echo $murl;?>"><?php echo $label;?></a></li>
        		<?php }?>
        </li>
      </ul>

      
    </div>
  </div>
</header>
 

