    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Mis Archivos</h4>
            </div>

            <div class="modal-body">

                 <ul class="nav nav-tabs" role="tablist">
                    <li class='active' role="personales">
                        <a href="#datosgenerales" data-toggle="tab"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Archivos</a>
                    </li>

                    <li role="usuario">
                        <a href="#documentos" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Documentos</a>
                    </li>
                </ul>

                  <div class="tab-content row" style="height: auto">
                   
                       <div class="tab-pane active" role="tabpanel" id="datosgenerales" role="tabpanel">
                           <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tablearchivo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="active">
                                            <th class="text-center">Opciones</th>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Nombres</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Fecha Create</th>
                                            <th class="text-center">Fecha Update</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>
                            </div>
                          </div>  
                      </div>

                      <div class="tab-pane" role="tabpanel" id="documentos" role="tabpanel">
                      <?php echo form_open_multipart(base_url().'clientes/cargaarchivos', array('id' => 'archivos', 'onsubmit' => 'obj_clientes.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
                          <div class="col-md-12" id="camposform">
                              <div class="form-group">
                                  <label for="documentos">Documentos</label>
                                  <input type="file" id="documentos" name="files[]" class="form-control">
                              </div>
                          </div>
                          <div class="col-md-12 text-center">
                            <a href="javascript:void(0);" class="btn btn-default" id="fileunput">Subir mas Documentos</a> 
                          </div>
                          <?php echo form_close(); ?>
                      </div>
                   </div>     
                </div>

            <div class="modal-footer">
                <button type="submit" id="btnlogin" class="btn btn-info">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
      </div>
        <!-- /.modal-content -->
    </div>


  <script type="text/javascript">
    $(function(){
       obj_funciones.getdatatable('tablearchivo','clientes/archivosmostrar','<?php echo $cliente_id ?>');
     $('#fileunput').click(function(event){
      var campos ='<div class="form-group">'+
                  '<label for="fecha">Documentos:</label>'+
                        '<input type="file" name="files[]" value="" id="documentos" class="form-control"/>'+
                  '</div>';   
        $("#camposform").append(campos);
     });
    });  
  </script>