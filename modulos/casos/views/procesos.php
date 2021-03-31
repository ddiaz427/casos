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
		$datos2['where'] = array(0 => array("campo" => "id", "valor" => $proceso_id, "tipo" => "where"),
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
						$datos2['where'] = array(0 => array("campo" => "id", "valor" => $subproceso_id, "tipo" => "where"),
												 1 => array("campo" => "estado", "valor" => 'Activado', "tipo" => "where"),
							);
						$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
						$sub_procesos = $this->Global_model->mostrar($datos2); ?>

						<?php if (!is_null($sub_procesos)):?>
							<?php foreach($sub_procesos as $s): ?>
								<ul class="checktree-root">
									<li class="text-info parent_li">
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
												<li class="text-warning parent_li">
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
															<li class="text-danger parent_li">
																<span title="Ocultar Lista">
																<i class="fa fa-minus-circle"/>
															</span>
															<b>Detalle Actividad:</b><?php echo $da->nombre ?>
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