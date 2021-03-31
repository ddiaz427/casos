<?php if (!is_null($notas)):?>
      <h3 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Mis Nota Creadas</h3>
      <ul class="timeline">
      <?php foreach($notas as $nota): ?>
        <li style="list-style:none;">
          <div class="timeline-badge"><i class="fa fa-pencil" aria-hidden="true"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><?php echo $nota->titulo ?></h4>
              <p><small class="text-muted"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo fechaseteada($nota->created_at); ?></small></p>
            </div>
            <div class="timeline-body">
              <p><?php echo $nota->nota; ?></p>
              <p>
              <a href="javascript:void(0);" onclick="obj_casos.editar_nota('<?php echo $nota->id ?>','<?php echo $nota->caso_id ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

              <a href="javascript:void(0);" onclick="obj_casos.eliminar_nota('<?php echo $nota->id ?>','<?php echo $nota->caso_id ?>');"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
              </p>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
      </ul> 
<?php else: ?>
  <h3 style="font-size:15px" class="text-danger text-center">No hay Notas Creadas para este Caso</h3>
<?php endif; ?>  