<?php echo form_open(base_url().'profesion/nuevo', array('id' => 'profesion', 'onsubmit' => 'obj_profesion.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nueva Profesión</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombres</label>
                             <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => set_value('nombre'))); ?>
                        </div>
                    </div>

                     <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario">Estado</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="" selected="">::Seleccione::</option>
                                    <option value="Activado">Activado</option>
                                    <option value="Desactivado">Desactivado</option>
                                </select>
                            </div>
                        </div>   
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