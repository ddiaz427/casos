<?php echo form_open(base_url().'perfiles/editar', array('id' => 'usuario', 'onsubmit' => 'obj_perfiles.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Perfil</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombres</label>
                             <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $perfil[0]->nombre)); ?>
                        </div>
                    </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario">Estado</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="" selected="">::Seleccione::</option>
                                    <option value="Activado" <?php echo ($perfil[0]->estado == 'Activado')? 'selected':'' ?>>Activado</option>
                                    <option value="Desactivado" <?php echo ($perfil[0]->estado == 'Desactivado')? 'selected':'' ?>>Desactivado</option>
                                </select>
                            </div>
                        </div> 

                        <input type="hidden" name="id" value="<?php echo $perfil[0]->id ?>">  
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