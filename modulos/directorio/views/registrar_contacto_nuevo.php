<ol class="breadcrumb">
  <li>Directorio</li>
  <li>Registrar Contacto</li>
</ol>

<div class="row">

    <div class="col-md-12 text-center">
    <?php if (isset($mensaje)):?>
        <?php echo $mensaje; ?>
    <?php endif; ?>    
    </div>

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Cédula</label> 

         <?php echo form_input(array('name' => 'buscar',   'id' => 'buscar', 'class' => 'form-control', 'placeholder' => 'Ingrese la busqueda', 'value' => set_value('buscar'))); ?>
        </div>
    </div> 

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Cédula</label> 

         <?php echo form_input(array('name' => 'buscar',   'id' => 'buscar', 'class' => 'form-control', 'placeholder' => 'Ingrese la busqueda', 'value' => set_value('buscar'))); ?>
        </div>
    </div>    

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Cédula</label> 

         <?php echo form_input(array('name' => 'buscar',   'id' => 'buscar', 'class' => 'form-control', 'placeholder' => 'Ingrese la busqueda', 'value' => set_value('buscar'))); ?>
        </div>
    </div>  

    <div class="col-md-6">  
         <div class="form-group">
             <label for="cedula">Cédula</label> 

         <?php echo form_input(array('name' => 'buscar',   'id' => 'buscar', 'class' => 'form-control', 'placeholder' => 'Ingrese la busqueda', 'value' => set_value('buscar'))); ?>
        </div>
    </div> 

    <hr>
    <div class="col-md-12 text-center">
             <?php echo form_button(array(
                                    'name' => 'button',
                                    'id' => 'fenviar',
                                    'type' => 'submit',
                                    'content' => '<i class="fa fa-check-circle"></i> Consultar',
                                    'class' => 'btn btn-default',
                                    )); ?>                              
    </div>      
</div>
