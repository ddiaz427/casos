<?php echo form_open(base_url().'ciudad/editar', array('id' => 'ciudad', 'onsubmit' => 'obj_ciudad.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Ciudad</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">País</label>
                            <select name="pais_id" id="pais" class="form-control" onchange="obj_ciudad.distritos(this.value)">
                                <option value="" selected="">::Seleccione::</option>
                                <?php if(!is_null($pais)): ?>
                                    <?php foreach ($pais as $p):?>
                                        <option value="<?php echo $p->id ?>" <?php echo ($p->id == $ciudad[0]->pais_id)?'selected':'' ?>><?php echo $p->pais ?></option>
                                    <?php endforeach; ?>    
                                <?php endif; ?>    
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Departamento</label>
                            <select name="distrito_id" id="distrito" class="form-control">
                                <option value="" selected="">::Seleccione::</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre">Ciudad</label>
                             <?php echo form_input(array('name' => 'ciudad',   'id' => 'ciudad', 'class' => 'form-control', 'placeholder' => 'Ingrese una ciudad', 'value' => $ciudad[0]->ciudad)); ?>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $ciudad[0]->id ?>">
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
      obj_ciudad.distritos(<?php echo $ciudad[0]->pais_id ?>, <?php echo $ciudad[0]->departamento_id ?>);
  </script>