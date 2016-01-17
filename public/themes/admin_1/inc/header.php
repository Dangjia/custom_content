<nav class="navbar navbar-fixed-top navbar-dark bg-primary">
    <button class="navbar-toggler hidden-sm-up pull-right" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
        ☰
    </button>
    <a class="navbar-brand" href="<?php echo url('post/admin/index');?>"><?php echo Cls\Comm::config('admin_title')?:"admin_title at admin";?></a>
    <div class="collapse navbar-toggleable-xs" id="collapsingNavbar">
        <ul class="nav navbar-nav pull-right">
        
          <?php 
      
      $menu = [
      	'文章'=>'/post/admin/index|post/admin/index,post/admin/view',
      	'分类'=>'/post/type/index|post/type/index,post/type/view',
      	'菜单'=>'/menu/admin/index|menu/admin',
      	'用户'=>'/admin/user/index|admin/user',
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
      			$act = "class='active'";
      			continue;
      		}
      		if($v1 && strpos($uri,$v1)!==false){
      			$act = "class='active'";
      		}
      	}
      ?>
        <li class="nav-item"<?php echo $act;?> ><a class="nav-link" href="<?php echo $murl;?>"><?php echo $label;?></a></li>
	  <?php }?>   
			   <li class="nav-item <?php echo $act;?>">
                <a class="nav-link" href="<?php echo url('admin/logout/index');?>">退出</a>
             </li>
        </ul>
    </div>
</nav>

 
  


<?php if(has_flash('success')){?>
<div class="page_message page_mess_ok flash"><?php echo flash('success');?></div>
<?php }?>
		

