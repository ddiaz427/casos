<?php echo form_open(base_url().'tipoidentificacion/editar', array('id' => 'proceso', 'onsubmit' => 'obj_tiposidentificacion.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Tipo de Identificación</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                             <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $proceso[0]->nombre)); ?>
                        </div>
                    </div> 
                    <input type="hidden" name="id" value="<?php echo $proceso[0]->id ?>">
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