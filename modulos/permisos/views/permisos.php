    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>">Inicio</a></li>  
      <li>Seguridad</li>
      <li>Permisos</li>
    </ol>
<div id="msj_alert"></div>
<div class="row">
    <div class="col-md-12 text-left">
        <div class="pull-left">
           <button class="btn btn-primary btn-sm" onclick="obj_funciones.reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recargar</button>
        </div>
        
        <div class="pull-right" id="botonera">
        
        </div>
    </div>
</div>

<div class="col-md-5">
	 <div class="table-responsive">
		<table class="table table-bordered text-center" id="datatable">
			<thead>
			 <tr class="active text-primary">	
				<th class="text-center"><b>OPCIONES</b></th>
				<th class="text-center"><b>PERFIL</b></th>
			 </tr>
			</thead>
			   <?php if(!is_null($perfiles)): ?>	
			  <?php foreach($perfiles as $row): ?>	
			   <tbody>
				   <tr class="warning text-center">	
					    <td>
					    <div class="radio radio-primary">
							<label>
								<input type="radio" name="key" id="key" value="<?php echo $row->id  ?>" onclick="obj_permisos.cargar_permiso_perfil();"/>
								<span class="circle"/>
								<span class="check"/>
							</label>
						</div>
					    </td>
					   	<td>
				   		 	<?php echo $row->nombre; ?>
					   	</td>
				   	</tr>
			   </tbody>
			   <?php endforeach; ?>	
			<?php endif; ?>
		</table>
	</div>
</div>	

<div class="col-md-7 tree well" id="permisos">
	<?php if(!is_null($menu)): ?>
	<?php foreach($menu as $m): ?>
	<ul class="checktree-root">
		<li class="text-primary parent_li">
			<span title="Ocultar Lista">
				<i class="fa fa-minus-circle"/>
			</span>
			<input type="checkbox" name="id_modulo[]" id="id_modulo[]" value="<?php echo $m->id ?>"/>
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
						<input type="checkbox" name="id_submenu[]" id="id_submenu[]" value="<?php echo $sm->id ?>" onclick="obj_permisos"/>
							<?php echo $sm->nombre ?>

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
											<input type="checkbox" name="id_boton[]" id="id_boton[]" value="<?php echo $b->id ?>"/>
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
</div>

<script src="<?php echo base_url('assets/js/permisos.js')?>"></script>