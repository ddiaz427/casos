<?php echo form_open_multipart(base_url().'casos/info_caso', array('id' => 'casos', 'onsubmit' => 'obj_casos.submitFormcasos(); return false;'), array('enviado' => 'enviado')); ?>

 <div class="col-md-6">
      <div class="form-group">
          <label>Nombre del Documento</label>
           <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => '')); ?>
      </div>
  </div> 

<div class="col-md-6">
  <div class="form-group">
      <label for="documentos">Documentos</label>
      <input type="file" id="documentos" name="files[]" class="form-control">
  </div>
</div>

<div class="col-md-12 text-center">
	<a href="javascript:void(0);" class="btn btn-raised btn-success" id="fileunput"><i class="fa fa-plus-circle" aria-hidden="true"></i></a> 
</div>

 <div class="col-md-12 text-center">
          <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Guardar</button>
 </div>      
<?php echo form_close(); ?>