<?php echo form_open(base_url().'articulos/editar', array('id' => 'form', 'onsubmit' => 'obj_articulo.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Artículo</h4>
            </div>

            <div class="modal-body">

               <div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Caso</label>
                            <select name="caso_id" id="caso" class="form-control" onchange="obj_articulo.procesos(this.value);">
                                <option value="" selected="">::Seleccione::</option>
                                <?php if(!is_null($casos)): ?>
                                    <?php foreach($casos as $c): ?>
                                    <option value="<?php echo $c->id ?>" <?php echo ($c->id == $articulo[0]->caso)?'selected':'' ?>><?php echo $c->nombre ?></option>
                                    <?php endforeach; ?>
                                 <?php endif; ?>   
                            </select>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Proceso</label>
                            <select name="proceso_id" id="proceso" class="form-control" onchange="obj_articulo.subprocesos(this.value);">
                                <option value="" selected="">::Seleccione::</option>
                            </select>
                        </div>
                    </div> 

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Sub Proceso</label>
                            <select name="subproceso_id" id="subproceso" class="proceso form-control" onchange="obj_articulo.actividad(this.value);">
                                <option value="" selected="">::Seleccione::</option>
                            </select>
                        </div>
                    </div> 

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Actividad</label>
                            <select name="actividad_id" id="actividad" class="proceso form-control">
                                <option value="" selected="">::Seleccione::</option>
                            </select>
                        </div>
                    </div> 

                    
                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Detalle Actividad</label>
                            <select name="detalle_actividad_id" id="detalleactividad" class="proceso form-control">
                                <option value="" selected="">::Seleccione::</option>
                            </select>
                        </div>
                    </div> 


                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Detalle Actividad</label>
                             <?php echo form_textarea(array('name' => 'articulo', 'id' => 'articulo', 'class' => 'form-control', 'placeholder' => 'Ingrese una Actividad', 'value' => $articulo[0]->articulo,'rows' => '3')); ?>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $articulo[0]->id ?>">
                    <!--<a class="btn btn-raised btn-danger btn-xs text-center" href="javascript:void(0)" id="remove"><span class="fa fa-times"></span></a>-->
                 </div>   
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Guardar</button>
                <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
           </div> 
        </div>
        <!-- /.modal-content -->
  <?php echo form_close(); ?>

  <script type="text/javascript">
   obj_articulo.procesos('<?php echo $articulo[0]->caso ?>','<?php echo $articulo[0]->proceso ?>');
   obj_articulo.subprocesos('<?php echo $articulo[0]->proceso ?>','<?php echo $articulo[0]->subproceso ?>');  
   obj_articulo.actividad('<?php echo $articulo[0]->subproceso ?>','<?php echo $articulo[0]->actividad ?>');   
   obj_articulo.actividaddetalle('<?php echo $articulo[0]->actividad ?>','<?php echo $articulo[0]->detalleactividad ?>');   

   
  </script>