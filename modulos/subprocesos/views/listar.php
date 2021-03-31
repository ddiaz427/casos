    <ol class="breadcrumb">
      <li>Configuraciones</li>
      <li>Actividades</li>
    </ol>

    <div class="row">
        <div class="col-md-12 text-left">
            <div class="pull-left">
               <button class="btn btn-primary btn-sm" onclick="obj_funciones.reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recargar</button>
            </div>
            
            <div class="pull-right" id="botonera">
            
            </div>
        </div>
    </div> 

    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr class="active">
                    <th class="text-center"><label for="seleccionartodos">
                    <input id="seleccionartodos" type="checkbox"><i></i></label></th>
                    <th class="text-center">Caso</th>
                    <th class="text-center">Proceso</th>
                    <th class="text-center">Sub Proceso</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Fecha Pulicado</th>
                    <th class="text-center">Fecha Actualización</th>
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
<script src="<?php echo base_url('assets/js/subprocesos.js')?>"></script>