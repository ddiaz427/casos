<?php echo form_open(base_url().'casos/nuevo', array('id' => 'casos', 'onsubmit' => 'obj_casos.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Caso</h4>
            </div>

            <div class="modal-body">
            <div class="row">
              <div class="col-md-7">
                 <div class="row"> 
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Cliente</label>
                                <div class="input-group">
                                <select name="cliente_id" id="clientes" class="form-control">
                                    <option value="" selected="">::Seleccione::</option>
                                    <?php if(!is_null($clientes)): ?>
                                       <?php foreach ($clientes as $c): ?>
                                         <option value="<?php echo $c->id ?>"><?php echo $c->nombres ?></option>
                                       <?php endforeach; ?>     
                                    <?php endif;?>    
                                </select>
                                <span class="input-group-addon"  onclick="obj_clientes.recargaclientes();" title="Recargar Clientes" style="cursor: pointer"><i class="fa fa-refresh"></i></span>
                               </div> 
                          </div>
                      </div>  

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Nombre del Caso</label>
                               <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre', 'value' => set_value('nombre'))); ?>
                          </div>
                      </div> 


                       <div class="col-md-4">
                          <div class="form-group">
                              <label>Tipo de Caso</label>
                              <select name="caso_id" id="caso" class="form-control" onchange="obj_casos.procesos(this.value);">
                                  <option value="" selected="">::Seleccione::</option>
                                  <?php if(!is_null($casos)): ?>
                                      <?php foreach($casos as $c): ?>
                                      <option value="<?php echo $c->id ?>"><?php echo $c->nombre ?></option>
                                      <?php endforeach; ?>
                                   <?php endif; ?>   
                              </select>
                          </div>
                      </div> 

                       <div class="col-md-4">
                          <div class="form-group">
                              <label>Tipo de Proceso</label>
                              <select name="proceso_id" id="proceso" class="proceso form-control" onchange="obj_casos.subprocesos(this.value);">
                                  <option value="" selected="">::Seleccione::</option>
                              </select>
                          </div>
                      </div> 

                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Tipo de Sub Proceso</label>
                              <select name="subproceso_id" id="subproceso" class="proceso form-control" onchange="obj_casos.diagrama();">
                                  <option value="" selected="">::Seleccione::</option>
                              </select>
                          </div>
                      </div> 

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Descripción</label>
                               <?php echo form_textarea(array('name' => 'descripcion',   'id' => 'descripcion', 'class' => 'form-control', 'placeholder' => 'Descripcíon de Caso', 'value' => set_value('descripcion'),'rows' => '3')); ?>
                          </div>
                      </div> 
                      <div class="col-md-12">
                          <div class="form-group">
                          <label>Rol del Cliente</label>
                           <select class="form-control" name="rol" id="rol">
                             <option value="" selected="">::Seleccionar::</option>
                             <option value="Demandado">Demandado</option>
                             <option value="Demandante">Demandante</option>
                           </select>
                         </div>
                     </div>  


                      <div class="col-md-4">
                             <a class="btn btn-raised btn-info" href="javascript:void(0);" onclick="obj_clientes.nuevocliente();" role="button"><i class="fa fa-user" aria-hidden="true"></i> Nuevo Cliente</a>
                       </div>   

                  </div>
               </div>
               
                <div class="col-md-5">
                  <small><b>Diagrama de Flujo Según el Tipo Caso</b></small>
                   <div class="row" id="diagrama" style="margin-top:10px;">
                      <div class="col-md-12 tree">
                         <img class="img-rounded" width="450" src="<?php echo base_url(); ?>assets/images/digrama.png"> 
                       </div>
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