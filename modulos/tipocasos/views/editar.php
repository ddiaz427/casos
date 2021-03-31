<?php echo form_open(base_url().'tipocasos/editar', array('id' => 'form', 'onsubmit' => 'obj_tipocaso.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Caso</h4>
            </div>

            <div class="modal-body">
               <div id="caso">
                    <?php if(!is_null($casos)): ?>
                     <?php foreach($casos as $c): ?> 
                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre del Caso</label>
                             <?php echo form_input(array('name' => 'caso[]', 'id' => 'caso', 'class' => 'form-control', 'placeholder' => 'Nombre del Caso', 'value' => $c->nombre)); ?>
                        </div>
                    </div> 
                    <input type="hidden" name="id[]" value="<?php echo $c->id ?>">
                    <?php endforeach; ?>
                    <?php endif; ?>
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
