<?php if(!is_null($menu)): ?>
	<?php foreach($menu as $m): ?>
	<ul class="checktree-root">
		<li class="text-primary parent_li">
			<span title="Ocultar Lista">
				<i class="fa fa-minus-circle"/>
			</span>
			<?php
				$datos = array(
			    'tabla' => 'detallepermiso',
			    'where' => array(
			    				 0 => array("campo" => "perfil_id", "valor" => $perfil_id, "tipo" => "where_in"),
			   					 1 => array("campo" => "permiso_id", "valor" => $m->id, "tipo" => "where_in")
			   					 ),
			    );
				$permisosmodulo = $this->Global_model->mostrar($datos);?>

				<input type="checkbox" name="id_modulo[]" id="id_modulo[]" value="<?php echo $m->id ?>" <?php echo !is_null($permisosmodulo)?'checked=""':'' ?>/>

			<?php echo $m->nombre ?>
			<?php 
				$datos2['select'] = '*';
				$datos2['tabla'] = 'menu';
				$datos2['where'] = array(0 => array("campo" => "menu_id", "valor" => $m->id, "tipo" => "where"),
										 1 => array("campo" => "tipo_relacion", "valor" => 'Menu', "tipo" => "where"),
					);
				$datos2['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
				$submenu = $this->Global_model->mostrar($datos2); ?>

				<?php if (!is_null($submenu)):?>
					<?php foreach($submenu as $sm): ?>
					<ul class="checktree-root">
						<li class="text-info parent_li">
							<span title="Ocultar Lista">
							<i class="fa fa-minus-circle"/>
						</span>

						<?php
						$datos = array(
					    'tabla' => 'detallepermiso',
					    'where' => array(
					    				 0 => array("campo" => "perfil_id", "valor" => $perfil_id, "tipo" => "where_in"),
					   					 1 => array("campo" => "permiso_id", "valor" => $sm->id, "tipo" => "where_in")
					   					 ),
					    );
						$permisosmenumodulo = $this->Global_model->mostrar($datos);?>

						<input type="checkbox" name="id_submenu[]" id="id_submenu[]" value="<?php echo $sm->id ?>" <?php echo !is_null($permisosmenumodulo)?'checked=""':'' ?>/>
							<?php echo $sm->nombre; ?>

							<?php 
							$datos3['select'] = '*';
							$datos3['tabla'] = 'menu';
							$datos3['where'] = array(0 => array("campo" => "menu_id", "valor" => $sm->id, "tipo" => "where"),
													 1 => array("campo" => "tipo_relacion", "valor" => 'Boton', "tipo" => "where"),
								);
							$datos3['order_by'] =  array(0 => array("campo" => "id", "valor" => "DESC", "tipo" => "NORMAL"));// 
							$boton = $this->Global_model->mostrar($datos3); 
							?>	
							<?php if (!is_null($boton)):?>
								<?php foreach($boton as $b): ?>
									<ul class="checktree-root">
										<li class="text-danger">
											<?php
											$datos = array(
										    'tabla' => 'detallepermiso',
										    'where' => array(
										    				 0 => array("campo" => "perfil_id", "valor" => $perfil_id, "tipo" => "where_in"),
										   					 1 => array("campo" => "permiso_id", "valor" => $b->id, "tipo" => "where_in")
										   					 ),
										    );
											$permisosboton = $this->Global_model->mostrar($datos);?>
											<input type="checkbox" name="id_boton[]" id="id_boton[]" value="<?php echo $b->id ?>" <?php echo !is_null($permisosboton)?'checked=""':'' ?>/>
											<?php echo $b->nombre ?>
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