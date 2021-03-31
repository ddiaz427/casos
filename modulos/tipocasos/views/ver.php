 <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Casos Procesos y Actividades</h4>
            </div>

        <div class="modal-body">
           <div class="row"> 
				<div class="col-md-12 tree" id="permisos">
					<?php if(!is_null($casos)): ?>
					<?php foreach($casos as $c): ?>
					<ul class="checktree-root">
						<li class="text-primary parent_li">
							<span title="Ocultar Lista">
								<i class="fa fa-minus-circle"/>
							</span>
							<b>Caso:</b> <?php echo $c->nombre ?>

							<?php 
							$datos2['select'] = '*';
							$datos2['tabla'] = 'tipo_procesos';
							$datos2['where'] = array(0 => array("campo" => "caso_id", "valor" => $c->id, "tipo" => "where"),
													 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
								);
							$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
							$procesos = $this->Global_model->mostrar($datos2); ?>

							<?php if (!is_null($procesos)):?>
								<?php foreach($procesos as $p): ?>
									<ul class="checktree-root">
										<li class="text-primary parent_li">
											<span title="Ocultar Lista">
											<i class="fa fa-minus-circle"/>
										</span>
										<b>Proceso:</b> <?php echo $p->nombre ?>
											<?php 
											$datos2['select'] = '*';
											$datos2['tabla'] = 'sub_procesos';
											$datos2['where'] = array(0 => array("campo" => "proceso_id", "valor" => $p->id, "tipo" => "where"),
																	 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
												);
											$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
											$sub_procesos = $this->Global_model->mostrar($datos2); ?>

											<?php if (!is_null($sub_procesos)):?>
												<?php foreach($sub_procesos as $s): ?>
													<ul class="checktree-root">
														<li class="text-primary parent_li">
															<span title="Ocultar Lista">
															<i class="fa fa-minus-circle"/>
														</span>
														<b>Sub Proceso:</b><?php echo $s->nombre ?>

														<?php 
														$datos3['select'] = '*';
														$datos3['tabla'] = 'actividades';
														$datos3['where'] = array(0 => array("campo" => "sub_proceso_id", "valor" => $s->id, "tipo" => "where"),
																				 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
															);
														$datos3['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
														$actividades = $this->Global_model->mostrar($datos3); ?>

														<?php if (!is_null($actividades)):?>
															<?php foreach($actividades as $a): ?>
																<ul class="checktree-root">
																	<li class="text-primary parent_li">
																		<span title="Ocultar Lista">
																		<i class="fa fa-minus-circle"/>
																	</span>
																	<b>Actividad:</b> <?php echo $a->nombre ?>

																	<?php 
																	$datos4['select'] = '*';
																	$datos4['tabla'] = 'detalleactividad';
																	$datos4['where'] = array(0 => array("campo" => "actividad_id", "valor" => $a->id, "tipo" => "where"),
																							 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
																		);
																	$datos4['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
																	$detalleactividades = $this->Global_model->mostrar($datos4); ?>

																	<?php if (!is_null($detalleactividades)):?>
																		<?php foreach($detalleactividades as $da): ?>
																			<ul class="checktree-root">
																				<li class="text-primary parent_li">
																					<span title="Ocultar Lista">
																					<i class="fa fa-minus-circle"/>
																				</span>
																				<b>Detalle Actividad:</b><?php echo $da->nombre ?>

																				<?php 
																				$datos5['select'] = '*';
																				$datos5['tabla'] = 'articulos';
																				$datos5['where'] = array(0 => array("campo" => "detalle_actividad_id", "valor" => $da->id, "tipo" => "where"),
																										 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
																					);
																				$datos4['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
																				$articulos = $this->Global_model->mostrar($datos4); ?>

																				<?php if (!is_null($articulos)):?>
																					<?php foreach($articulos as $ar): ?>
																						<ul class="checktree-root">
																							<li class="text-primary parent_li">
																								<span title="Ocultar Lista">
																								<i class="fa fa-minus-circle"/>
																							</span>
																							<b>Artículo:</b> <?php echo $ar->nombre ?>
																							</li>
																						</ul>	
																				 	<?php endforeach; ?>
																				<?php endif; ?>	

																				</li>
																			</ul>	
																	 	<?php endforeach; ?>
																	<?php endif; ?>	

																	</li>
																</ul>	
														 	<?php endforeach; ?>
														<?php endif; ?>	
														</li>
													</ul>	
											 	<?php endforeach; ?>
											<?php endif; ?>	
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