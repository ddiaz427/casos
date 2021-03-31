<?php echo form_open(base_url().'subprocesos/editar', array('id' => 'form', 'onsubmit' => 'obj_subproceso.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Sub Proceso</h4>
            </div>

            <div class="modal-body">

               <div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Caso</label>
                            <select name="caso_id" id="caso" class="form-control" onchange="obj_subproceso.proceso(this.value);">
                                <option value="" selected="">::Seleccione::</option>
                                <?php if(!is_null($casos)): ?>
                                    <?php foreach($casos as $c): ?>
                                    <option value="<?php echo $c->id ?>" <?php echo ($c->id == $subproceso[0]->caso_id)?'selected':'' ?>><?php echo $c->nombre ?></option>
                                    <?php endforeach; ?>
                                 <?php endif; ?>   
                            </select>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Proceso</label>
                            <select name="proceso_id" id="proceso" class="form-control">
                                <option value="" selected="">::Seleccione::</option>
                            </select>
                        </div>
                    </div> 

                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Sub Proceso</label>
                             <?php echo form_textarea(array('name' => 'subproceso', 'id' => 'subproceso', 'class' => 'form-control', 'placeholder' => 'Ingrese una Sub Proceso', 'value' => $subproceso[0]->nombre,'rows' => '3')); ?>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $subproceso[0]->idproceso ?>">
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
   obj_subproceso.proceso('<?php echo $subproceso[0]->caso_id ?>','<?php echo $subproceso[0]->proceso_id ?>');
  </script>