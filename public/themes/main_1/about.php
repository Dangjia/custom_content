<?php 
use Cls\Front\DB;
use Core\Img;
use Cls\Comm;
use Model\Post;
$this->layout('main');

?>

<?php $this->start('body');?>
<div class='am-container top' >
<h3>关于我们</h3>
<ul data-am-widget="gallery" class="am-gallery am-avg-sm-2
  am-avg-md-3 am-avg-lg-4 am-gallery-overlay" data-am-gallery="{ pureview: true }" >
      <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-1.jpg" class="">
              <img src="http://s.amazeui.org/media/i/demos/bing-1.jpg"  alt="远方 有一个地方 那里种有我们的梦想"/>
                <h3 class="am-gallery-title">远方 有一个地方 那里种有我们的梦想</h3>
                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
      </li>
      <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-2.jpg" class="">
              <img src="http://s.amazeui.org/media/i/demos/bing-2.jpg"  alt="某天 也许会相遇 相遇在这个好地方"/>
                <h3 class="am-gallery-title">某天 也许会相遇 相遇在这个好地方</h3>
                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
      </li>
      <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-3.jpg" class="">
              <img src="http://s.amazeui.org/media/i/demos/bing-3.jpg"  alt="不要太担心 只因为我相信"/>
                <h3 class="am-gallery-title">不要太担心 只因为我相信</h3>
                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
      </li>
      <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-4.jpg" class="">
              <img src="http://s.amazeui.org/media/i/demos/bing-4.jpg"  alt="终会走过这条遥远的道路"/>
                <h3 class="am-gallery-title">终会走过这条遥远的道路</h3>
                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
      </li>
  </ul>
  
  <h3>授拳地点</h3>
  
  <div data-am-widget="map" class="am-map am-map-default"
      data-name="授拳地点:由刘继发师父亲传。" data-address="上海市文化广场" data-longitude="" data-latitude="" data-scaleControl="" data-zoomControl="true" data-setZoom="17" data-icon="http://amuituku.qiniudn.com/mapicon.png">
    <div id="bd-map"></div>
  </div>
  
</div>  
<?php $this->end();?>  
  <?php return;?>
<div class="blog-header">
      <div class="container">
        <h1 class="blog-title"><?php echo Comm::config('blog-title');?></h1>
        <p class="lead blog-description"><?php echo Comm::config('blog-title-small');?>.</p>
      </div>
    </div>
    


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

