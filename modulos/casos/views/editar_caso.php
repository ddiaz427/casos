<?php echo form_open(base_url().'casos/info_caso', array('id' => 'casos', 'onsubmit' => 'obj_casos.submitFormcasos(); return false;'), array('enviado' => 'enviado')); ?>
 <div class="row"> 
      <div class="col-md-6">
          <div class="form-group">
              <label>Cliente</label>
              <select name="cliente_id" id="cliente" class="form-control">
                  <option value="" selected="">::Seleccione::</option>
                  <?php if(!is_null($clientes)): ?>
                     <?php foreach ($clientes as $c): ?>
                       <option value="<?php echo $c->id ?>" <?php echo ($c->id == $casosinfo[0]->cliente_id)?'selected':'' ?>><?php echo $c->nombres ?></option>
                     <?php endforeach; ?>     
                  <?php endif;?>    
              </select>
          </div>
      </div>  

      <div class="col-md-6">
          <div class="form-group">
              <label>Nombre del Caso</label>
               <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => $casosinfo[0]->nombre_caso)); ?>
          </div>
      </div> 

       <div class="col-md-4">
          <div class="form-group">
              <label>Tipo de Caso</label>
              <select name="caso_id" id="caso" class="form-control" onchange="obj_casos.procesos(this.value);" disabled>
                  <option value="" selected="">::Seleccione::</option>
                  <?php if(!is_null($casos)): ?>
                      <?php foreach($casos as $c): ?>
                      <option value="<?php echo $c->id ?>" <?php echo ($c->id == $casosinfo[0]->tipo_caso_id)?'selected':'' ?>><?php echo $c->nombre ?></option>
                      <?php endforeach; ?>
                   <?php endif; ?>   
              </select>
          </div>
      </div> 

       <div class="col-md-4">
          <div class="form-group">
              <label>Tipo de Proceso</label>
              <select name="proceso_id" id="proceso" class="proceso form-control" onchange="obj_casos.subprocesos(this.value);" disabled>
                  <option value="" selected="">::Seleccione::</option>
              </select>
          </div>
      </div> 

      <div class="col-md-4">
          <div class="form-group">
              <label>Tipo de Sub Proceso</label>
              <select name="subproceso_id" id="subproceso" class="proceso form-control" onchange="obj_casos.diagrama();" disabled>
                  <option value="" selected="">::Seleccione::</option>
              </select>
          </div>
      </div> 

      <div class="col-md-12">
          <div class="form-group">
              <label>Descripción</label>
               <?php echo form_textarea(array('name' => 'descripcion',   'id' => 'descripcion', 'class' => 'form-control', 'placeholder' => 'Descripcíon de Caso', 'value' => $casosinfo[0]->descripcion,'rows' => '3')); ?>
          </div>
      </div> 
      <div class="col-md-6">
          <div class="form-group">
          <label>Rol del Cliente</label>
           <select class="form-control" name="rol" id="rol">
             <option value="" selected="">::Seleccionar::</option>
             <option value="Demandado" <?php echo ('Demandado' == $casosinfo[0]->rol)?'selected':'' ?>>Demandado</option>
             <option value="Demandante" <?php echo ('Demandante' == $casosinfo[0]->rol)?'selected':'' ?>>Demandante</option>
           </select>
         </div>
     </div>

     <div class="col-md-6">
          <div class="form-group">
              <label>Numero de Expediente</label>
                <div class="input-group">
                 <?php echo form_input(array('name' => 'expediente',   'id' => 'expediente', 'class' => 'form-control', 'placeholder' => 'Numero de Expediente', 'value' => $casosinfo[0]->expediente)); ?>
                 <span class="input-group-addon"  onclick="obj_casos.generar_expediente();" title="Generar Expediente" style="cursor: pointer"><i class="fa fa-refresh"></i></span>
               </div>
          </div>
      </div> 
     <input type="hidden" name="id" value="<?php echo $casosinfo[0]->id ?>">
     <div class="col-md-12 text-center">
          <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Guardar</button>
     </div>      
  </div>
<?php echo form_close(); ?>

<script type="text/javascript">
  obj_casos.procesos('<?php echo $casosinfo[0]->tipo_caso_id ?>','<?php echo $casosinfo[0]->tipo_proceso_id ?>');
  obj_casos.subprocesos('<?php echo $casosinfo[0]->tipo_proceso_id ?>','<?php echo $casosinfo[0]->tipo_sub_proceso_id ?>');
</script>