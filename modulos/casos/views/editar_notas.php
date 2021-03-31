<?php echo form_open(base_url().'casos/editar_notas', array('id' => 'notasformedit', 'onsubmit' => 'obj_casos.submitFormnotas(); return false;'), array('enviado' => 'enviado')); ?>
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Editar Nota </h4>
          </div>

          <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
               <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Título</label>
                             <?php echo form_input(array('name' => 'titulo',   'id' => 'titulo', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $nota[0]->titulo)); ?>
                        </div>
                    </div> 

                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Nota</label>
                        <textarea class="notas" name="notas"><?php echo $nota[0]->nota ?></textarea>
                    </div>
                  </div>
                  <input type="hidden" name="caso_id" value="<?php echo $nota[0]->caso_id ?>">
                  <input type="hidden" name="id" value="<?php echo $nota[0]->id ?>">
                </div>
             </div>
             </div>    
          </div>
          <div class="modal-footer">
              <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Actualizar</button>
              <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
<?php echo form_close(); ?>

<script type="text/javascript">
  obj_funciones.editortinymce('.notas');  
</script>