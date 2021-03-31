 <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Procesos y Actividades</h4>
            </div>

	            <div class="modal-body">
	               <div class="row"> 
						<div class="col-md-12 tree" id="permisos">
							<?php if(!is_null($procesos)): ?>
							<?php foreach($procesos as $p): ?>
							<ul class="checktree-root">
								<li class="text-primary parent_li">
									<span title="Ocultar Lista">
										<i class="fa fa-minus-circle"/>
									</span>
									<?php echo $p->nombre ?>

									<?php 
									$datos2['select'] = '*';
									$datos2['tabla'] = 'actividades';
									$datos2['where'] = array(0 => array("campo" => "proceso_id", "valor" => $p->id, "tipo" => "where"),
															 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
										);
									$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
									$actividades = $this->Global_model->mostrar($datos2); ?>

									<?php if (!is_null($actividades)):?>
										<?php foreach($actividades as $a): ?>
											<ul class="checktree-root">
												<li class="text-info parent_li">
													<span title="Ocultar Lista">
													<i class="fa fa-minus-circle"/>
												</span>
												<?php echo $a->nombre ?>
												</li>
											</ul>	
									 	<?php endforeach; ?>
									<?php endif; ?>	
								</li>	
							</ul>
							<?php endforeach; ?>
							<?php endif; ?>		
						</div>
					</div>
		  		</div>
		  	 <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
            </div>

        </div>			