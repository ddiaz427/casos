<?php echo form_open(base_url().'sistema/editar', array('id' => 'sistema', 'onsubmit' => 'obj_sistema.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Configuraciones del Sistema</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                             <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $config[0]->nombre_sitio)); ?>
                        </div>
                    </div> 

                     <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Descripción</label>
                             <?php echo form_input(array('name' => 'descripcion',   'id' => 'descripcion', 'class' => 'form-control', 'placeholder' => 'Ingrese un Descripción', 'value' => $config[0]->descripcion)); ?>
                        </div>
                    </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Email</label>
                             <?php echo form_input(array('name' => 'email',   'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Ingrese un Código', 'value' => $config[0]->correo)); ?>
                        </div>
                     </div> 

                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Misión</label>
                             <?php echo form_textarea(array('name' => 'mision',   'id' => 'mision', 'class' => 'form-control', 'placeholder' => 'Ingrese un Misión', 'value' => $config[0]->mision, 'rows' => '4')); ?>
                        </div>
                     </div> 

                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Visión</label>
                             <?php echo form_textarea(array('name' => 'vision',   'id' => 'vision', 'class' => 'form-control', 'placeholder' => 'Ingrese un Visión', 'value' => $config[0]->vision, 'rows' => '4')); ?>
                        </div>
                     </div>  

                     <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Estado</label>
                            <select name="estado" class="form-control" id="estado">
                                <option value="" selected="">::Seleccione::</option>
                                <option value="Activado" <?php echo ('Activado' == $config[0]->estado_sitio)?'selected':'' ?>>Activado</option>
                                <option value="Desactivado" <?php echo ('Desactivado' == $config[0]->estado_sitio)?'selected':'' ?>>Desactivado</option>
                                <option value="Inactivo" <?php echo ('Inactivo' == $config[0]->estado_sitio)?'selected':'' ?>>Inactivo</option>
                            </select>
                            
                        </div>
                     </div> 

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Palabras Claves</label>
                             <?php echo form_input(array('name' => 'palabras_clave',   'id' => 'palabras_clave', 'class' => 'form-control', 'placeholder' => 'Ingrese Palabras claves', 'value' => $config[0]->palabras_clave)); ?>
                            
                        </div>
                     </div> 

                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Logo de la empresa</label>
                             <?php echo form_input(array('name' => 'logo',   'id' => 'logo', 'class' => 'form-control', 'placeholder' => 'Ingrese una url', 'value' => $config[0]->logo)); ?>
                            
                        </div>
                     </div>     

                    <input type="hidden" name="id" value="<?php echo $config[0]->id ?>">
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