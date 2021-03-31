   <ol class="breadcrumb">
      <li>Directorio</li>
      <li>Consultar Contacto</li>
    </ol>

  
<div class="col-md-6 col-md-offset-3">
     <?php echo form_open(base_url().'directorio/nuevo', array('id' => 'consultar', 'class' => 'form-inline'), array('enviado' => 'enviado')); ?>
               <?php echo form_error('tipo_busqueda'); ?><hr>
               <?php echo form_error('buscar'); ?>
              <div class="form-group">
                    <select name="tipo_busqueda" class="form-control" id="busqueda">
                        <option value="" selected="">...::Seleccione::..</option>
                        <option value="email">Email</option>
                        <option value="nombres">Nombres</option>
                    </select>
                   
              </div>         

            <div class="form-group">
                 <?php echo form_input(array('name' => 'buscar',   'id' => 'buscar', 'class' => 'form-control', 'placeholder' => 'Ingrese la busqueda', 'value' => set_value('buscar'))); ?>

            </div>

            <?php echo form_button(array(
                                'name' => 'button',
                                'id' => 'fenviar',
                                'type' => 'submit',
                                'content' => '<i class="fa fa-check-circle"></i> Consultar',
                                'class' => 'btn btn-raised btn-defauld',
                                )); ?>              

    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
         $("#consultar").submit(function(event)
         {
            event.preventDefault();
            obj_directorio.consultar('#resultado','<?php echo base_url(); ?>directorio/nuevo',$("#consultar").serialize());
         })
    });  
 </script>