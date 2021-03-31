<?php echo form_open(base_url().'casos/editar_documentos', array('id' => 'documentosformedit', 'onsubmit' => 'obj_casos.submitFormdocumentosedit(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Documento </h4>
            </div>

            <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                 <div class="row"> 
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Nombre del Documento</label>
                               <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $documento[0]->titulo)); ?>
                          </div>
                      </div> 

                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="documentos">Documentos</label>
                          <input type="file" name="files" class="form-control">
                            <small><a href="javascript:void(0);" onclick="obj_casos.visor(<?php echo $documento[0]->id ?>);" title="<?php echo$documento[0]->documento ?>"> <b class="text-info"><?php echo $documento[0]->titulo ?></b></a></small>
                      </div>
                    </div>
                    <input type="hidden" name="caso_id" value="<?php echo $documento[0]->caso_id ?>">
                    <input type="hidden" name="id" value="<?php echo $documento[0]->id ?>">
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