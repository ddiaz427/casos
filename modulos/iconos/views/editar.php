<?php echo form_open(base_url().'iconos/editar', array('id' => 'icono', 'onsubmit' => 'obj_iconos.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Icono</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                             <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $icono[0]->nombre)); ?>
                        </div>
                    </div> 

                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Código</label>
                             <?php echo form_input(array('name' => 'codigo',   'id' => 'codigo', 'class' => 'form-control', 'placeholder' => 'Ingrese un Código', 'value' => $icono[0]->codigo)); ?>
                        </div>
                    </div> 

                    <input type="hidden" name="id" value="<?php echo $icono[0]->id ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Guardar</button>
                <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
  <?php echo form_close(); ?>