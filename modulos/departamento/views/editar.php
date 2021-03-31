<?php echo form_open(base_url().'departamento/editar', array('id' => 'departamento', 'onsubmit' => 'obj_departamento.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Departamento</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Pais</label>
                            <select name="pais_id" id="pais" class="form-control">
                                <option value="" selected="">::Seleccione::</option>
                                <?php if(!is_null($pais)): ?>
                                    <?php foreach ($pais as $p):?>
                                        <option value="<?php echo $p->id ?>" <?php echo ($p->id == $departamento[0]->pais_id)?'selected':'' ?>><?php echo $p->pais ?></option>
                                    <?php endforeach; ?>    
                                <?php endif; ?>    
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Departamento</label>
                             <?php echo form_input(array('name' => 'departamento',   'id' => 'departamento', 'class' => 'form-control', 'placeholder' => 'Ingrese un Departamento', 'value' => $departamento[0]->departamento)); ?>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $departamento[0]->id ?>">
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