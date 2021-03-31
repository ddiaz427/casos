<?php echo form_open(base_url().'casos/mostrar_actividad', array('id' => 'detalleactividad', 'onsubmit' => 'obj_casos.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Actividad: <b class="text-danger"><?php echo $actividad[0]->nombre ?></b></h4>
            </div>

            <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
               <small><b>Detalle de Actividad</b></small>
                 <div class="row"> 
                    <?php if (!is_null($detalleactividad)): ?>
                       <ul class="list-group">
                      <?php foreach ($detalleactividad as $key => $da): ?>
                          <li class="list-group-item" style="margin: 0 0 3px 0;"><i class="fa fa-asterisk" aria-hidden="true"></i> <?php echo  $da->nombre ?> <a href="#"><i class="fa fa-folder" aria-hidden="true"></i> Crear</a> -- <a href="#"><i class="fa fa-upload" aria-hidden="true"></i> Subir</a></li>
                      <?php endforeach; ?>
                      </ul>  
                    <?php endif; ?>  
                  </div>   
               </div>
               
                <div class="col-md-6">
                  <small><b>Artículos</b></small>
                   <div class="row" id="diagrama" style="margin-top:10px;">
                      <div class="col-md-12 tree">
                        <?php if(!is_null($detalleactividad)): ?>
                        <?php foreach ($detalleactividad as $key => $da): ?>
                          <?php  

                          $datos['select'] = '*';
                          $datos['tabla'] = 'articulos';
                          $datos['where'] = array(0 => array("campo" => "detalle_actividad_id", "valor" => $da->id, "tipo" => "where"));
                          $articulos = $this->Global_model->mostrar($datos);// Le paso los datos de la consulta
                          ?>
                          <?php if (!is_null($articulos)): ?>
                          <?php foreach ($articulos as $key => $ar): ?>
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample<?php echo $ar->id ?>" aria-expanded="true" aria-controls="collapseExample<?php echo $ar->id ?>">
                              <i class="fa fa-folder" aria-hidden="true"></i> <?php echo  $da->nombre ?> -- <?php echo  $ar->nombre ?>
                            </a>
                            <div class="collapse" id="collapseExample<?php echo $ar->id ?>">
                              <div class="well">
                                 <?php echo  $ar->descripcion ?>
                              </div>
                            </div>
                            <?php endforeach; ?>
                          <?php endif; ?>  

                        <?php endforeach; ?>
                      <?php endif; ?>  
                       </div>
                   </div>
                 </div>
               </div>    
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Finalizar</button>
                <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
  <?php echo form_close(); ?>