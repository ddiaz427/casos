<?php echo form_open_multipart(base_url().'clientes/nuevo', array('id' => 'clientes', 'onsubmit' => 'obj_clientes.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Cliente</h4>
            </div>

            <div class="modal-body">

                 <ul class="nav nav-tabs" role="tablist">
                    <li class="active" role="personales">
                        <a href="#datosgenerales" data-toggle="tab"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Datos Personales</a>
                    </li>

                      <li role="info">
                        <a href="#dastosopcionales" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Información Adicional</a>
                    </li>

                    <li role="usuario">
                        <a href="#documentos" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Documentos</a>
                    </li>
                </ul>

                  <div class="tab-content row" style="height: auto">

                       <div class="tab-pane active" role="tabpanel" id="datosgenerales" role="tabpanel">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombres</label>
                                     <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => set_value('nombre'))); ?>
                                </div>
                            </div> 

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_persona">Tipo de Persona</label>
                                    
                                    <select name="tipo_persona" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Natural">Natural</option>
                                        <option value="Juridica">Juridica</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cedula">Cédula</label>
                                     <?php echo form_input(array('name' => 'cedula',   'id' => 'cedula', 'class' => 'form-control', 'placeholder' => 'Ingrese una Cédula', 'value' => set_value('cedula'))); ?>
                                </div>
                            </div> 

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genero">Genero</label>
                                    
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div> 

                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="civil">Estado Civil</label>
                                    <select name="civil" id="civil" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Solter@">Solter@</option>
                                        <option value="Casad@">Casad@</option>
                                        <option value="Viud@">Viud@</option>
                                        <option value="Divorciad@">Divorciad@</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profesion">Profesión</label>
                                    
                                    <select name="profesion_id" id="profesion" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <?php if(!is_null($profesion)): ?>
                                          <?php foreach ($profesion as $p):?>
                                            <option value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
                                          <?php endforeach; ?>  
                                        <?php endif; ?>  
                                    </select>
                                </div>
                            </div> 

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono">Telefono (Casa)</label>
                                     <?php echo form_input(array('name' => 'telefono',   'id' => 'telefono', 'class' => 'form-control', 'placeholder' => 'Ingrese una Telefono de Casa', 'value' => set_value('telefono'))); ?>
                                </div>
                            </div>  

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="movil">Telefono (Movil)</label>
                                     <?php echo form_input(array('name' => 'movil',   'id' => 'movil', 'class' => 'form-control', 'placeholder' => 'Ingrese una Telefono Movil', 'value' => set_value('movil'))); ?>
                                </div>
                            </div>  


                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                     <?php echo form_input(array('name' => 'fax', 'id' => 'fax', 'class' => 'form-control', 'placeholder' => 'Ingrese un fax', 'value' => set_value('fax'))); ?>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Email</label>
                                     <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Ingrese un Email', 'value' => set_value('email'))); ?>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                     <?php echo form_input(array('name' => 'avatar', 'id' => 'avatar', 'class' => 'form-control', 'placeholder' => 'Ingrese una url de Imagen', 'value' => set_value('avatar'))); ?>
                                </div>
                            </div>  


                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                     <select name="estado" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Activado">Activado</option>
                                        <option value="Desactivado">Desactivado</option>
                                    </select>
                                </div>
                            </div> 
                      </div>

                      <div class="tab-pane" role="tabpanel" id="dastosopcionales" role="tabpanel">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pais">País</label>
                                    
                                    <select name="pais_id" id="pais" class="form-control" onchange="obj_clientes.distritos(this.value);">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <?php if(!is_null($pais)): ?>
                                          <?php foreach ($pais as $pa):?>
                                            <option value="<?php echo $pa->id ?>"><?php echo $pa->pais ?></option>
                                          <?php endforeach; ?>  
                                        <?php endif; ?>  
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="distrito">Distrito</label>
                                    <select name="distrito_id" id="distrito" class="form-control" onchange="obj_clientes.ciudades(this.value);">
                                        <option value="" selected="">..::Seleccione::..</option> 
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <select name="ciudad_id" id="ciudad" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option> 
                                    </select>
                                </div>
                            </div> 

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                     <?php echo form_textarea(array('name' => 'observacion', 'id' => 'observacion', 'class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '3')); ?>
                                </div>
                            </div> 

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Dirección</label>
                                     <?php echo form_textarea(array('name' => 'direccion', 'id' => 'direccion', 'class' => 'form-control', 'placeholder' => 'Dirección', 'rows' => '3')); ?>
                                </div>
                            </div>   
                      </div>
                      <div class="tab-pane" role="tabpanel" id="documentos" role="tabpanel">
                          <div class="col-md-12" id="camposform">
                              <div class="form-group">
                                  <label for="documentos">Documentos</label>
                                  <input type="file" id="documentos" name="files[]" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-12 text-center">
                            <a href="javascript:void(0);" class="btn btn-default" id="fileunput">Subir mas Documentos</a> 
                          </div>
                      </div>
                   </div>     
                </div>

            <div class="modal-footer">
                <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Guardar</button>
                <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
      </div>
        <!-- /.modal-content -->
    </div>
  <?php echo form_close(); ?>

  <script type="text/javascript">
    $(function(){
     $('#fileunput').click(function(event){
      var campos ='<div class="form-group">'+
                  '<label for="fecha">Documentos:</label>'+
                        '<input type="file" name="files[]" value="" id="documentos" class="form-control"/>'+
                  '</div>';   
        $("#camposform").append(campos);
     });
    });  
  </script>