<?php echo form_open(base_url().'articulos/nuevo', array('id' => 'form', 'onsubmit' => 'obj_articulo.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Artículo</h4>
            </div>

            <div class="modal-body">
               <div id="procesos">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Caso</label>
                            <select name="caso_id" id="caso" class="form-control" onchange="obj_articulo.procesos(this.value);">
                                <option value="" selected="">::Seleccione::</option>
                                <?php if(!is_null($casos)): ?>
                                    <?php foreach($casos as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nombre ?></option>
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
                            <select name="actividad_id" id="actividad" class="proceso form-control" onchange="obj_articulo.actividaddetalle(this.value);">
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
                            <label>Artículo</label>
                             <?php echo form_textarea(array('name' => 'articulo', 'id' => 'articulo', 'class' => 'form-control', 'placeholder' => 'Ingrese un Artículo', 'value' => set_value('articulo'),'rows' => '4')); ?>
                        </div>
                    </div> 
                    <!--<a class="btn btn-raised btn-danger btn-xs text-center" href="javascript:void(0)" id="remove"><span class="fa fa-times"></span></a>-->
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