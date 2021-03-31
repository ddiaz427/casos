 <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Visor de Documentos: <?php echo $visor[0]->titulo ?></h4>
            </div>

            <div class="modal-body">
            	<div class="row">
                    <?php $tipo = extension($visor[0]->documento); ?>
            		<?php if (strpos($tipo, 'Office-Document') !== false): ?>  
                    <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url(); ?>assets/casosarchivos/<?php echo $visor[0]->caso_id ?>/<?php echo $visor[0]->documento ?>" style="zoom:0.60" width="99.6%" height="800" frameborder="0"></iframe>

                    <?php elseif (strpos($tipo, 'image') !== false): ?>
                       <div class="col-md-12 text-center"> 
                            <img class="img-responsive" src="<?php echo base_url(); ?>assets/casosarchivos/<?php echo $visor[0]->caso_id ?>/<?php echo $visor[0]->documento ?>">
                        </div>
                	<?php endif; ?>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
</div>