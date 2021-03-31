 <div class="col-md-7">
 <h3 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actividades Pendiente</h3>

 <?php if(!is_null($procesosarealizar)): ?>
    <?php foreach ($procesosarealizar as $key => $pa):?>

        <?php if($key == 0): ?>
        <table class="table table-striped table-bordered table-list">
          <thead>
            <tr class="info">
                <th class="text-center">Estado</th>
                <th class="text-center">Actividad</th>
                <th class="text-center">Fecha</th>
            </tr> 
          </thead>
          <tbody>
              <tr>
                <td class="text-center"><?php echo $pa->estado ?></td>
                <td class="text-center"><a href="javascript:void(0);" onclick="obj_casos.mostrar_actividad('<?php echo $pa->caso_id ?>','<?php echo $pa->actividad_id ?>');"><?php echo $pa->actividad ?></a></td>
                <td class="text-center"><?php echo $pa->created_at ?></td>
              </tr>
          </tbody>
        </table>
        <?php endif; ?>
    <?php endforeach ?>
 <?php endif; ?>  
</div>

 <div class="col-md-5">
 <h3 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Proximas Actividades</h3><p>

    <?php if(!is_null($procesosarealizar)): ?>
        <ul class="timeline">
        <?php foreach ($procesosarealizar as $key => $pa):?>
            <?php if($key != 0): ?>
              <li style="list-style:none;">
                <div class="timeline-badge"><i class="fa fa-level-down" aria-hidden="true"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading text-center">
                      <h4 class="timeline-title"><i class="fa fa-asterisk" aria-hidden="true"></i> <?php echo $pa->actividad ?></p></h4>
                    </div>
                    <div class="timeline-body text-center">
                      <p> <a href="javascript:void(0);" class="testimonial-writer-company"><i class="fa fa-plus-circle" aria-hidden="true"></i> Insertar Actividad</a></p>
                    </div>
                  </div>
                </li>
              <?php endif; ?>
        <?php endforeach ?>
         </ul> 
      <?php endif; ?>     
 </div>
 <div class="col-md-12">
    <?php if(!is_null($actuazionesproceso)): ?>
    <?php foreach ($actuazionesproceso as $key => $ap):?>

        <?php if($key == 0): ?>
        <table class="table table-striped table-bordered table-list">
          <thead>
            <tr class="success">
                <th class="text-center"><b>Actividades Realizadas</b></th>
            </tr> 
          </thead>
          <tbody>
              <tr>
                <td class="text-center">Cerró con estado <b><?php echo $ap->estado ?></b> la actividad <b><?php echo $ap->actividad ?></b></td>
              </tr>
          </tbody>
        </table>
        <?php endif; ?>
    <?php endforeach ?>
 <?php endif; ?>  
 </div>