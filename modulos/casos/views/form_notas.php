<div class="col-md-6">
<?php echo form_open_multipart(base_url().'casos/notas', array('id' => 'form_notas', 'onsubmit' => 'obj_casos.submitFormnotas(); return false;'), array('enviado' => 'enviado')); ?>
	
  <div class="form-group">
      <label>Nombre de la Nota</label>
       <?php echo form_input(array('name' => 'nombre', 'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => '')); ?>
  </div>

  <div class="form-group">
  	<label>Nota</label>
  	<textarea class="notas" name="notas"></textarea>
  </div>
   <?php echo form_input(array('name' => 'caso_id',  'type' => 'hidden', 'value' => $caso_id)); ?>
  <div class="col-md-12 text-center">
     <button type="submit" class="btn btn-raised btn-primary">Subir</button>
 </div>  

<?php echo form_close(); ?>
</div>

<div class="col-md-6">
	<div id="notascreadas"></div>
</div>

<script type="text/javascript">
	obj_funciones.editortinymce('.notas');	
	obj_casos.globalcontenido('notascreadas','casos/listar_notas','caso_id=<?php echo $caso_id ?>');	
</script>
