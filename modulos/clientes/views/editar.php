<?php echo form_open_multipart(base_url().'clientes/editar', array('id' => 'clientes', 'onsubmit' => 'obj_clientes.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Cliente</h4>
            </div>

            <div class="modal-body">

                 <ul class="nav nav-tabs" role="tablist">
                    <li class='active' role="personales">
                        <a href="#datosgenerales" data-toggle="tab"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Datos Personales</a>
                    </li>

                      <li role="usuario">
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
                                     <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $cliente[0]->nombres)); ?>
                                </div>
                            </div> 

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_persona">Tipo de Persona</label>
                                    
                                    <select name="tipo_persona" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Natural" <?php echo ('Natural' == $cliente[0]->tipo_persona)?'selected':'' ?>>Natural</option>
                                        <option value="Juridica" <?php echo ('Juridica' == $cliente[0]->tipo_persona)?'selected':'' ?>>Juridica</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cedula">Cédula</label>
                                     <?php echo form_input(array('name' => 'cedula',   'id' => 'cedula', 'class' => 'form-control', 'placeholder' => 'Ingrese una Cédula', 'value' => $cliente[0]->cedula)); ?>
                                </div>
                            </div> 

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genero">Genero</label>
                                    
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Masculino" <?php echo ('Masculino' == $cliente[0]->sexo)?'selected':'' ?>>Masculino</option>
                                        <option value="Femenino"  <?php echo ('Femenino' == $cliente[0]->sexo)?'selected':'' ?>>Femenino</option>
                                    </select>
                                </div>
                            </div> 

                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="civil">Estado Civil</label>
                                    
                                    <select name="civil" id="civil" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Solter@" <?php echo ('Solter@' == $cliente[0]->civil)?'selected':'' ?>>Solter@</option>
                                        <option value="Casad@" <?php echo ('Casad@' == $cliente[0]->civil)?'selected':'' ?>>Casad@</option>
                                        <option value="Viud@" <?php echo ('Viud@' == $cliente[0]->civil)?'selected':'' ?>>Viud@</option>
                                        <option value="Divorciad@" <?php echo ('Divorciad@' == $cliente[0]->civil)?'selected':'' ?>>Divorciad@</option>
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
                                            <option value="<?php echo $p->id ?>" <?php echo ($p->id == $cliente[0]->profesion_id)?'selected':'' ?>><?php echo $p->nombre ?></option>
                                          <?php endforeach; ?>  
                                        <?php endif; ?>  
                                    </select>
                                </div>
                            </div> 

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono">Telefono (Casa)</label>
                                     <?php echo form_input(array('name' => 'telefono',   'id' => 'telefono', 'class' => 'form-control', 'placeholder' => 'Ingrese una Telefono de Casa', 'value' => $cliente[0]->telefono)); ?>
                                </div>
                            </div>  

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="movil">Telefono (Movil)</label>
                                     <?php echo form_input(array('name' => 'movil',   'id' => 'movil', 'class' => 'form-control', 'placeholder' => 'Ingrese una Telefono Movil', 'value' => $cliente[0]->movil)); ?>
                                </div>
                            </div>  


                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                     <?php echo form_input(array('name' => 'fax', 'id' => 'fax', 'class' => 'form-control', 'placeholder' => 'Ingrese un fax', 'value' => $cliente[0]->fax)); ?>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Email</label>
                                     <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Ingrese un Email', 'value' => $cliente[0]->email)); ?>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                     <?php echo form_input(array('name' => 'avatar', 'id' => 'avatar', 'class' => 'form-control', 'placeholder' => 'Ingrese una url de Imagen', 'value' => $cliente[0]->avatar)); ?>
                                </div>
                            </div>  


                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                     <select name="estado" class="form-control">
                                        <option value="" selected="">..::Seleccione::..</option>
                                        <option value="Activado" <?php echo ('Activado' == $cliente[0]->estado)?'selected':'' ?>>Activado</option>
                                        <option value="Desactivado" <?php echo ('Desactivado' == $cliente[0]->estado)?'selected':'' ?>>Desactivado</option>
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
                                            <option value="<?php echo $pa->id ?>" <?php echo ($pa->id == $cliente[0]->pais_id)?'selected':'' ?>><?php echo $pa->pais ?></option>
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
                                     <?php echo form_textarea(array('name' => 'observacion', 'id' => 'observacion', 'class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '3', 'value' => $cliente[0]->observacion)); ?>
                                </div>
                            </div> 

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Dirección</label>
                                     <?php echo form_textarea(array('name' => 'direccion', 'id' => 'direccion', 'class' => 'form-control', 'placeholder' => 'Dirección', 'rows' => '3', 'value' => $cliente[0]->direccion)); ?>
                                </div>
                            </div>  

                        <input type="hidden" name="id" value="<?php echo $cliente[0]->id ?>"> 
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
      
    obj_clientes.distritos(<?php echo $cliente[0]->pais_id ?>, <?php echo $cliente[0]->departamento_id ?>); 
    obj_clientes.ciudades(<?php echo $cliente[0]->departamento_id ?>, <?php echo $cliente[0]->ciudad_id ?>); 
  </script>