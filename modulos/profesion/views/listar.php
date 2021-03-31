    <ol class="breadcrumb">
      <li>Configuraciones</li>
      <li>Profesión</li>
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
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Fecha Create</th>
                    <th class="text-center">Fecha Update</th>
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
<script src="<?php echo base_url('assets/js/profesion.js')?>"></script>