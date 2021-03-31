<?php echo form_open(base_url().'sistema/editar', array('id' => 'sistema', 'onsubmit' => 'obj_sistema.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Configuraciones del Sistema</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                        
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                              <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 Datos Generales
                                </a>
                              </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                              <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                    <img width="100" src="<?php echo ($config[0]->logo != NULL)?$config[0]->logo:base_url('assets/images/default-logo.png'); ?>">
                                    </div>    
                                    <b class="text-danger">Nombre del Sitio:</b> <b><?php echo $config[0]->nombre_sitio ?></b></p>
                                    <b class="text-danger">Descripción:</b> <b><?php echo $config[0]->descripcion ?></b></p>
                                    <b class="text-danger">Email:</b> <b><?php echo $config[0]->correo ?></b></p>
                                    <b class="text-danger">Estado del Sistema:</b> <b><?php echo $config[0]->estado_sitio ?></b></p>
                              </div>
                            </div>
                          </div>
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                              <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Misión y Visión
                                </a>
                              </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                              <div class="panel-body">
                                <b class="text-danger">Misión:</b> <b><?php echo $config[0]->mision ?></b></p>
                                <b class="text-danger">Visión:</b> <b><?php echo $config[0]->vision ?></b></p>
                              </div>
                            </div>
                          </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-warning" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
  <?php echo form_close(); ?>