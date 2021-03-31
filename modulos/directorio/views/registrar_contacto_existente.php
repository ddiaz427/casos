<ol class="breadcrumb">
  <li>Directorio</li>
  <li>Registrar Contacto</li>
</ol>
<?php if (isset($mensaje)):?>
    <?php echo $mensaje; ?>
<?php endif; ?>    
<div class="row">

    <?php echo form_open(base_url().'directorio/registrar', array('id' => 'registrar'), array('enviado' => 'enviado')); ?>
    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Nombres</label> 

         <?php echo form_input(array('name' => 'nombre',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Nombres', 'value' => isset($clientes[0]->nombres)?$clientes[0]->nombres:set_value('nombre'))); ?>
        </div>
    </div> 

     <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Fecha de Nacimiento</label> 

         <?php echo form_input(array('name' => 'nacimiento',  'id' => 'nacimiento', 'class' => 'form-control', 'placeholder' => 'Ingrese una fecha', 'value' => set_value('nacimiento'), 'type' => 'date')); ?>
        </div>
    </div>

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Email</label> 

         <?php echo form_input(array('name' => 'email',   'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Ingrese un email', 'value' => isset($clientes[0]->nombres)?$clientes[0]->email:set_value('email'))); ?>
        </div>
    </div>

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Profesión</label> 

        <select name="profesion_id" class="form-control">
            <option value="" selected="">..::Seleccione::..</option>
               <?php if(!is_null($profesion)): ?>
                <?php foreach ($profesion as $p):?>
                    <option value="<?php echo  $p->id ?>" <?php echo (isset($clientes[0]->profesion_id) and $p->id == $clientes[0]->profesion_id)?'selected':'' ?>><?php echo $p->nombre ?></option>
                <?php endforeach; ?>    
               <?php endif; ?> 
        </select>
        </div>
    </div>  

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Cargo</label> 

         <?php echo form_input(array('name' => 'cargo',   'id' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Ingrese un Cargo', 'value' => set_value('cargo'))); ?>
        </div>
    </div>

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Empresa</label> 

         <?php echo form_input(array('name' => 'empresa',   'id' => 'empresa', 'class' => 'form-control', 'placeholder' => 'Ingrese un Empresa', 'value' => set_value('empresa'))); ?>
        </div>
    </div>

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Télefono Empresa</label> 

         <?php echo form_input(array('name' => 'telefono',   'id' => 'telefono', 'class' => 'form-control', 'placeholder' => 'Ingrese un Télefono', 'value' => set_value('telefono'))); ?>
        </div>
    </div>

     <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Télefono Movil</label> 

         <?php echo form_input(array('name' => 'movil',   'id' => 'movil', 'class' => 'form-control', 'placeholder' => 'Ingrese un Movil', 'value' => set_value('movil'))); ?>
        </div>
    </div>


    <div class="col-md-6">  
         <div class="form-group">
        <label for="cedula">Tipo de Identificación</label> 
        <select name="idetificacion_id" class="form-control">
            <option value="" selected="">..::Seleccione::..</option>
               <?php if(!is_null($identificacion)): ?>
                <?php foreach ($identificacion as $i):?>
                    <option value="<?php echo  $i->id ?>"><?php echo $i->nombre ?></option>
                <?php endforeach; ?>    
               <?php endif; ?> 
        </select>
        </div>
    </div> 

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Numero de Identificación</label> 

         <?php echo form_input(array('name' => 'nroidentificacion',   'id' => 'nroidentificacion', 'class' => 'form-control', 'placeholder' => 'Ingrese el Numero de Identificación', 'value' => set_value('nroidentificacion'))); ?>
        </div>
    </div> 

     <div class="col-md-6">  
         <div class="form-group">
        <label for="cedula">Pais</label> 
        <select name="pais_id" class="form-control" onchange="distritos(this.value);">
            <option value="" selected="">..::Seleccione::..</option>
               <?php if(!is_null($pais)): ?>
                <?php foreach ($pais as $pa):?>
                    <option value="<?php echo  $pa->id ?>"><?php echo $pa->pais ?></option>
                <?php endforeach; ?>    
               <?php endif; ?> 
        </select>
        </div>
    </div> 

    <div class="col-md-6">
        <div class="form-group">
            <label for="distrito">Distrito</label>
            <select name="distrito_id" id="distrito" class="form-control" onchange="ciudades(this.value);">
                <option value="" selected="">..::Seleccione::..</option> 
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <select name="ciudad_id" id="ciudad" class="form-control">
                <option value="" selected="">..::Seleccione::..</option> 
            </select>
        </div>
    </div> 

    <div class="col-md-12">  
         <div class="form-group">
             <label for="cedula">Dirección</label> 

         <?php echo form_textarea(array('name' => 'direccion',   'id' => 'direccion', 'class' => 'form-control', 'placeholder' => 'Ingrese una Dirección', 'rows' => '3', 'value' => set_value('direccion'))); ?>
        </div>
    </div>


    <hr>
    <div class="col-md-12 text-center">
             <?php echo form_button(array(
                                    'name' => 'button',
                                    'id' => 'fenviar',
                                    'type' => 'submit',
                                    'content' => '<i class="fa fa-check-circle"></i> Registrar Contacto',
                                    'class' => 'btn btn-raised btn-defauld',
                                    )); ?>                              
    </div> 

      <?php echo form_close(); ?>     
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
         $("#registrar").submit(function(event)
         {
            event.preventDefault();
            obj_directorio.consultar('#resultado','<?php echo base_url(); ?>directorio/registrar',$("#registrar").serialize());
         });
    });  

     function distritos(id, selected_id){
             if(selected_id == undefined) selected_id = '';
            var data = obj_funciones.getajaxsimple({
                url : base_url + "clientes/get_distritos", 
                data : {pais_id: id}
            });
            var html = '<option value="">..:: Seleccione ::..</option>';
            for(var index in data) { sel = "";
                if(selected_id == data[index].id) sel = 'selected=""';
                html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].departamento)+'</option>';
            }
            $('#distrito').html(html);
         }

         function ciudades(id, selected_id){
            if(selected_id == undefined) selected_id = '';
            var data = obj_funciones.getajaxsimple({
                url : base_url + "clientes/get_ciudades", 
                data : {departamento_id: id}
            });
            var html = '<option value="">..:: Seleccione ::..</option>';
            for(var index in data) { sel = "";
                if(selected_id == data[index].id) sel = 'selected=""';
                html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].ciudad)+'</option>';
            }
            $('#ciudad').html(html);
         }

 </script>