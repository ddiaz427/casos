<?php echo form_open(base_url().'usuarios/nuevo', array('id' => 'usuario', 'onsubmit' => 'obj_usuarios.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Usuario</h4>
            </div>

            <div class="modal-body">

              <ul class="nav nav-tabs" role="tablist">
                <li class='active' role="personales">
                    <a href="#datospersonales" data-toggle="tab"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Datos Personales</a>
                </li>

                  <li role="usuario">
                    <a href="#datosusuario" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Datos Usuario</a>
                </li>
            </ul>

              <div class="tab-content row" style="height: auto">

                   <div class="tab-pane active" role="tabpanel" id="datospersonales" role="tabpanel">
                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombres</label>
                                 <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => set_value('nombre'))); ?>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="apellido">Apellidos</label>
                                 <?php echo form_input(array('name' => 'apellido',   'id' => 'apellido', 'class' => 'form-control', 'placeholder' => 'Ingrese un Apellido', 'value' => set_value('apellido'))); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="apellido">Cédula</label>
                                 <?php echo form_input(array('name' => 'cedula',   'id' => 'cedula', 'class' => 'form-control', 'placeholder' => 'Ingrese una Cédula', 'value' => '')); ?>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                                 <select id="sexo" name="sexo" class="form-control">
                                   <option value="" selected="">::Seleccione::</option>
                                   <option value="Masculino">Masculino</option>
                                   <option value="Femenino">Femenino</option>
                                 </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="civil">Estado Civil</label>
                                 <select id="civil" name="civil" class="form-control">
                                   <option value="" selected="">::Seleccione::</option>
                                   <option value="Solter@">Solter@</option>
                                   <option value="Casad@">Casad@</option>
                                   <option value="Viud@">Viud@</option>
                                   <option value="Divorciad@">Divorciad@</option>
                                 </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                 <?php echo form_input(array('name' => 'email',   'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Ingrese una Email', 'value' => '')); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                 <?php echo form_input(array('name' => 'telefono',   'id' => 'telefono', 'class' => 'form-control', 'placeholder' => 'Ingrese una Telefono', 'value' => '')); ?>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Avatar</label>
                                 <?php echo form_input(array('name' => 'avatar',   'id' => 'avatar', 'class' => 'form-control', 'placeholder' => 'Ingrese una url', 'value' => '')); ?>
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                 <?php echo form_textarea(array('name' => 'direccion',   'id' => 'direccion', 'class' => 'form-control', 'placeholder' => 'Ingrese una Dirección', 'value' => '','rows' => '2')); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Descripción</label>
                                 <?php echo form_textarea(array('name' => 'descripcion',   'id' => 'descripcion', 'class' => 'form-control', 'placeholder' => 'Ingrese una descripcion', 'value' => '', 'rows' => '2')); ?>
                            </div>
                        </div>

                   </div>

                   <div class="tab-pane" role="tabpanel" id="datosusuario" role="tabpanel">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                 <?php echo form_input(array('name' => 'usuario',   'id' => 'usuario', 'class' => 'form-control', 'placeholder' => 'Ingrese un usuario', 'value' => '')); ?>
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario">Clave</label>
                                 <?php echo form_input(array('name' => 'clave',   'id' => 'clave', 'class' => 'form-control', 'placeholder' => 'Ingrese una clave', 'value' => '', 'type' => 'password')); ?>
                            </div>
                        </div>

                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario">Perfil</label>
                                <select name="perfil_id" id="perfiles" class="form-control">
                                  <option value="" selected="">::Seleccione::</option>
                                  <?php if(!is_null($perfiles)): ?>  
                                    <?php foreach ($perfiles as $p): ?>
                                      <option value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
                                    <?php endforeach; ?> 
                                  <?php endif; ?> 
                                </select>
                            </div>
                        </div>

                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario">Estado</label>
                                <select name="estado_usuario" id="estado_usuario" class="form-control">
                                    <option value="" selected="">::Seleccione::</option>
                                    <option value="Activado">Activado</option>
                                    <option value="Desactivado">Desactivado</option>
                                    <option value="Activado">Bloqueado</option>
                                </select>
                            </div>
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