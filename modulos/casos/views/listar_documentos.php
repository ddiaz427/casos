<?php if (!is_null($documentos)):?>
  <div class="panel panel-default" style="max-height: 400px; overflow: scroll;">
      <!-- Default panel contents -->
      <div class="panel-heading text-center"><i class="fa fa-folder-open" aria-hidden="true"></i> Archivos del caso</div>
        <br>
        <ul class="list-group">  
      <?php foreach($documentos as $documento): ?>
              <?php $tipo = extension($documento->documento); ?>
              <?php  
                if ($tipo == 'Office-Document/Word'):?>
                   <li class="list-group-item">
                       <a href="javascript:void(0);" onclick="obj_casos.visor(<?php echo $documento->id ?>);" title="<?php echo $documento->documento ?>"><i class="fa fa-file-word-o fa-2x" aria-hidden="true"></i> <b class="text-warning"><?php echo $documento->titulo ?></b></a>
                        <div class="pull-right">

                            <a href="javascript:void(0);" onclick="obj_casos.editar_documento('<?php echo $documento->id ?>','<?php echo $documento->caso_id ?>');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                            <a href="<?php echo base_url(); ?>assets/casosarchivos/<?php echo $documento->caso_id ?>/<?php echo $documento->documento ?>" download><i class="fa fa-download text-warning" aria-hidden="true"></i></a>

                            <a href="javascript:void(0);" onclick="obj_casos.eliminar_documento('<?php echo $documento->id ?>','<?php echo $documento->caso_id ?>');"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <hr>
                  <?php elseif($tipo === 'image/png' or $tipo === 'image/jpg' or $tipo === 'image/gif' or $tipo === 'image/jpeg'):?>
                <!-- List group -->
                    <li class="list-group-item">
                         <a href="javascript:void(0);" onclick="obj_casos.visor(<?php echo $documento->id ?>);" title="<?php echo $documento->documento ?>"><i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i> <b class="text-warning"><?php echo $documento->titulo ?></b></a>

                        <div class="pull-right">

                            <a href="javascript:void(0);" onclick="obj_casos.editar_documento('<?php echo $documento->id ?>','<?php echo $documento->caso_id ?>');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                            <a href="<?php echo base_url(); ?>assets/casosarchivos/<?php echo $documento->caso_id ?>/<?php echo $documento->documento ?>" download><i class="fa fa-download text-warning" aria-hidden="true"></i></a>

                            <a href="javascript:void(0);" onclick="obj_casos.eliminar_documento('<?php echo $documento->id ?>','<?php echo $documento->caso_id ?>');"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <hr>
                  <?php elseif($tipo === 'Office-Document/Excel'):?>
                    <!-- List group -->
                    <li class="list-group-item">
                         <a href="javascript:void(0);" onclick="obj_casos.visor(<?php echo $documento->id ?>);" title="<?php echo $documento->documento ?>"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <b class="text-warning"><?php echo $documento->titulo ?></b></a>

                        <div class="pull-right">
                              <a href="javascript:void(0);" onclick="obj_casos.editar_documento('<?php echo $documento->id ?>','<?php echo $documento->caso_id ?>');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                              <a href="<?php echo base_url(); ?>assets/casosarchivos/<?php echo $documento->caso_id ?>/<?php echo $documento->documento ?>" download><i class="fa fa-download text-warning" aria-hidden="true"></i></a>

                            <a href="javascript:void(0);" onclick="obj_casos.eliminar_documento('<?php echo $documento->id ?>','<?php echo $documento->caso_id ?>');"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <hr>
                <?php endif; ?>  

      <?php endforeach; ?> 
          </ul>
      </div>            
  </div> 
<?php else: ?>
  <h3 style="font-size:15px" class="text-danger text-center">No hay Documentos Creados para este Caso</h3>
<?php endif; ?>  