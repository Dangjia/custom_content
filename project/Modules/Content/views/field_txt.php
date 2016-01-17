<div class="form-group">
    <label ><?php echo $label;?></label>
    <textarea type="input" class="form-control" id="<?php echo $field;?>"   name='<?php echo $field;?>' ><?php echo $data->$field;?>
    
    </textarea>
</div>

<?php 
widget('Redactor',[
		'ele'=>'#'.$field,
]);
?>