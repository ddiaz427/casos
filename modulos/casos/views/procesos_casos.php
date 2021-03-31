    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>">Inicio</a></li>  
      <li>Proceso</li>
      <li>Mis Casos</li>
      <li class="active"><?php echo $infocaso[0]->nombre_caso ?></li>
    </ol>

    <div class="col-md-7">
        <h2><?php echo $infocaso[0]->nombre_caso ?></h2></p>
        <small><b>Estado:</b> <?php echo $infocaso[0]->estado ?></small>
    </div>

    <div class="col-md-5">
    <?php if ($infocaso[0]->avatar == NULL) {
            $img = base_url('assets/images/anonimo.jpg');
        }else{
            $img = $infocaso[0]->avatar;
        } ?>
        <div class="col-md-4 col-lg-4 text-center">   
            <img width="100" class="img-responsive img-thumbnail" src="<?php echo $img ?>">
        </div>

        <div class=" col-md-8 col-lg-8">
            <b>Cliente:</b> <?php echo $infocaso[0]->cliente ?></p>
            <?php echo $infocaso[0]->email ?> / Tel <?php echo $infocaso[0]->movil ?>
        </div>
    </div>
 <div class="col-md-12">    
    <br>
 </div>   
<div class="tab-content custom-tab-content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active" role="personales">
            <a href="<?php echo base_url(); ?>casos/seguimiento" role="tab" data-target="#seguimiento" data-toggle="tab"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Seguimiento</a>
        </li>

        <li role="presentation">
            <a href="<?php echo base_url(); ?>casos/info_caso" role="tab" data-target="#infocasos" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Informacion del Caso</a>
        </li>

        <li role="presentation">
            <a href="<?php echo base_url(); ?>casos/equipocaso" role="tab" data-target="#equipocaso" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Equipo del Caso</a>
        </li>

        <li role="presentation">
            <a href="<?php echo base_url(); ?>casos/documentos" role="tab" data-target="#documentos" data-toggle="tab"><i class="fa fa-folder-o" aria-hidden="true"></i> Documentos</a>
        </li>

         <li role="presentation">
            <a href="<?php echo base_url(); ?>casos/notas" role="tab" data-target="#notas" data-toggle="tab"><i class="fa fa-file-text-o" aria-hidden="true"></i> Notas</a>
        </li>

        <li role="presentation">
            <a href="<?php echo base_url(); ?>casos/facturacion" role="tab" data-target="#facturacion" data-toggle="tab"><i class="fa fa-file-text-o" aria-hidden="true"></i> Facturación</a>
        </li>
    </ul>

    <div class="tab-content" style="height: auto">
           <div class="tab-pane active" role="tabpanel" id="seguimiento"></div>

           <div class="tab-pane" role="tabpanel" id="infocasos"></div>

           <div class="tab-pane" role="tabpanel" id="equipocaso"></div>

           <div class="tab-pane" role="tabpanel" id="documentos"></div>

           <div class="tab-pane" role="tabpanel" id="notas"></div>

           <div class="tab-pane" role="tabpanel" id="facturacion"></div>
     </div>
  </div>   

<!--Tab cargados con ajax-->
  <script type="text/javascript">
    $(document).ready(function(){
        obj_funciones.loadajax('10','Cargando Contenido Del Caso <?php echo $infocaso[0]->nombre_caso ?>..');
        setTimeout(function(){
        var data = obj_funciones.getajaxsimple({
                  url: '<?php echo base_url(); ?>casos/seguimiento', 
                  datatype : 'html',
                  data: {caso_id: <?php echo $caso_id ?>},
              });
            $('#seguimiento').html(data);
            obj_funciones.mostrar_div(div);
           },300);  

          $(this).tab('show');
          return false;
       });   

      $('[data-toggle="tab"]').on('click', function(){
        url = $(this).attr('href'),
        div = $(this).attr('data-target');
        if($(div).is(':empty')){
        obj_funciones.loadajax('10','Cargando Contenido..');
        setTimeout(function(){
        var data = obj_funciones.getajaxsimple({
                  url: url, 
                  datatype : 'html',
                  data: {caso_id: <?php echo $caso_id ?>},
              });
            $(div).html(data);
            obj_funciones.mostrar_div(div);
           },300);  

          $(this).tab('show');
          return false;
       }   
    });
  </script>
  <!--Tab cargados con ajax--->