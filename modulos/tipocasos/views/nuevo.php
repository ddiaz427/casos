<?php echo form_open(base_url().'tipocasos/nuevo', array('id' => 'form', 'onsubmit' => 'obj_tipocaso.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Caso</h4>
            </div>

            <div class="modal-body">
                <div class="col-md-12 text-center"> 
                    <a href="javascript:void(0)" class="btn btn-raised btn-success btn-xs" onclick="obj_tipocaso.generarcampos();"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    <small>Ingrese uno o mas casos a la vez</small>
               </div>
               <div id="caso">
                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre del Caso</label>
                             <?php echo form_input(array('name' => 'caso[]', 'id' => 'caso', 'class' => 'form-control', 'placeholder' => 'Nombre del Caso', 'value' => set_value('caso'))); ?>
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
