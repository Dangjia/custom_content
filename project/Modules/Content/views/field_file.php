<div class="form-group">
	    <label><?php echo $label;?></label>
	  	<?php 
	  	widget('JUI');
	  	widget('Plupload',[
	  			'ele'=>'file',
	  			'option'=>[
		  			'CKEDITOR'=>$field,
					'maxSize'=>'30',
	  				'class'=>'upload',
	  				'count'=>100,
	  				'data'=>$data->$field,
		  		]			
		]);
	  	?>
		<?php //widget('ckeditor',['ele'=>$ele]);?>       
	  </div>