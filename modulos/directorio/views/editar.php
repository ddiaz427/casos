<?php echo form_open(base_url().'directorio/editar', array('id' => 'directorio', 'onsubmit' => 'obj_directorio.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
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
                             <label for="cedula">Nombres</label> 

                         <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Nombres', 'value' => isset($directorio[0]->nombres)?$directorio[0]->nombres:set_value('nombre'))); ?>
                        </div>
                    </div> 

                     <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Fecha de Nacimiento</label> 

                         <?php echo form_input(array('name' => 'nacimiento',  'id' => 'nacimiento', 'class' => 'form-control', 'placeholder' => 'Ingrese una fecha', 'value' =>  isset($directorio[0]->fecha_nacimiento)?$directorio[0]->fecha_nacimiento:set_value('nacimiento'), 'type' => 'date')); ?>
                        </div>
                    </div>

                    <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Email</label> 

                         <?php echo form_input(array('name' => 'email',   'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Ingrese un email', 'value' => isset($directorio[0]->correo)?$directorio[0]->correo:set_value('email'))); ?>
                        </div>
                    </div>

                    <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Profesión</label> 

                        <select name="profesion_id" class="form-control">
                            <option value="" selected="">..::Seleccione::..</option>
                               <?php if(!is_null($profesion)): ?>
                                <?php foreach ($profesion as $p):?>
                                    <option value="<?php echo  $p->id ?>" <?php echo (isset($directorio[0]->profesion_id) and $p->id == $directorio[0]->profesion_id)?'selected':'' ?>><?php echo $p->nombre ?></option>
                                <?php endforeach; ?>    
                               <?php endif; ?> 
                        </select>
                        </div>
                    </div>  

                    <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Cargo</label> 

                         <?php echo form_input(array('name' => 'cargo',   'id' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Ingrese un Cargo', 'value' => $directorio[0]->cargo)); ?>
                        </div>
                    </div>

                    <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Empresa</label> 

                         <?php echo form_input(array('name' => 'empresa',   'id' => 'empresa', 'class' => 'form-control', 'placeholder' => 'Ingrese un Empresa', 'value' => $directorio[0]->empresa)); ?>
                        </div>
                    </div>

                    <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Télefono Empresa</label> 

                         <?php echo form_input(array('name' => 'telefono',   'id' => 'telefono', 'class' => 'form-control', 'placeholder' => 'Ingrese un Télefono', 'value' => $directorio[0]->telefono_empresa)); ?>
                        </div>
                    </div>

                     <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Télefono Movil</label> 

                         <?php echo form_input(array('name' => 'movil',   'id' => 'movil', 'class' => 'form-control', 'placeholder' => 'Ingrese un Movil', 'value' => $directorio[0]->movil)); ?>
                        </div>
                    </div>


                    <div class="col-md-6">  
                         <div class="form-group">
                        <label for="cedula">Tipo de Identificación</label> 
                        <select name="idetificacion_id" class="form-control">
                            <option value="" selected="">..::Seleccione::..</option>
                               <?php if(!is_null($identificacion)): ?>
                                <?php foreach ($identificacion as $i):?>
                                    <option value="<?php echo  $i->id ?>" <?php echo (isset($directorio[0]->tipo_identificacion_id) and $i->id == $directorio[0]->tipo_identificacion_id)?'selected':'' ?>><?php echo $i->nombre ?></option>
                                <?php endforeach; ?>    
                               <?php endif; ?> 
                        </select>
                        </div>
                    </div> 

                    <div class="col-md-6">  
                         <div class="form-group">
                             <label for="cedula">Numero de Identificación</label> 

                         <?php echo form_input(array('name' => 'nroidentificacion',   'id' => 'nroidentificacion', 'class' => 'form-control', 'placeholder' => 'Ingrese el Numero de Identificación', 'value' => $directorio[0]->numero_identificacion)); ?>
                        </div>
                    </div> 

                     <div class="col-md-6">  
                         <div class="form-group">
                        <label for="cedula">Pais</label> 
                        <select name="pais_id" class="form-control" onchange="distritos(this.value);">
                            <option value="" selected="">..::Seleccione::..</option>
                               <?php if(!is_null($pais)): ?>
                                <?php foreach ($pais as $pa):?>
                                    <option value="<?php echo  $pa->id ?>"  <?php echo (isset($directorio[0]->pais_id) and $pa->id == $directorio[0]->pais_id)?'selected':'' ?>><?php echo $pa->pais ?></option>
                                <?php endforeach; ?>    
                               <?php endif; ?> 
                        </select>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="distrito">Distrito</label>
                            <select name="distrito_id" id="distrito" class="form-control" onchange="ciudades(this.value);">
                                <option value="" selected="">..::Seleccione::..</option> 
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <select name="ciudad_id" id="ciudad" class="form-control">
                                <option value="" selected="">..::Seleccione::..</option> 
                            </select>
                        </div>
                    </div> 

                    <div class="col-md-12">  
                         <div class="form-group">
                             <label for="cedula">Dirección</label> 

                         <?php echo form_textarea(array('name' => 'direccion',   'id' => 'direccion', 'class' => 'form-control', 'placeholder' => 'Ingrese una Dirección', 'rows' => '3', 'value' => $directorio[0]->direccion)); ?>
                        </div>
                    </div>    

                    <input type="hidden" name="id" value="<?php echo $directorio[0]->id ?>">
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

  <script type="text/javascript">
  obj_directorio.distritos('<?php echo $directorio[0]->pais_id ?>', '<?php echo $directorio[0]->departamento_id ?>');
  obj_directorio.ciudades('<?php echo $directorio[0]->departamento_id ?>', '<?php echo $directorio[0]->ciudad_id ?>');
  </script>