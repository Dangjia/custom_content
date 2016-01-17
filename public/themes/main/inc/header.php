<?php 
use Cls\Comm;
?>    
<div class="pure-menu">
            <a class="pure-menu-heading" href="/"><?php echo Comm::config('front_title_logo');?></a>

            <ul class="pure-menu-list">
                
                <?php $menu = [
                      '首页'=>'/',
                      '活动'=>'/posts/huodong|huodong',
        			  '新闻'=>'/posts/news|news',
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
                          $act = "active";
                          continue;
                        }
                        if($v1 && strpos($uri,$v1)!==false){
                          $act = "active";
                        }
                      }
                    ?>
                    <li class="pure-menu-item <?php echo $act;?>"><a href="<?php echo $murl;?>" class="pure-menu-link"><?php echo $label;?></a></li>
                    
                  <?php }?>
            </ul>
        </div>
 
 

