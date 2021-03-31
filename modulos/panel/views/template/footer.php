<!--<div class="container footer">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 4col-lg-4">
			<h4>Datos de Interes</h4>
	          <p>Aqui van los datos de interes.</p>
	          <p>Soluciones<br>
	          </p>
	        </div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<h4>Sistema Desarrollado por:</h4>
			<ol>
				<li>DSDSoftweb Soluciones web a su medida</li>
			</ol>
			
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<h4>Redes Sociales</h4>
		
			<a href="" target="_blank"><i class="fa fa-facebook-square fa-3x"></i></a>
			<a href="" target="_blank"><i class="fa fa-twitter-square fa-3x"></i></a>
			<a href="" target="_blank"><i class="fa  fa-google-plus-square fa-3x"></i></a>
		</div>
		</div>
	</div>
	-->
<script type="text/javascript">var base_url = '<?php echo base_url()?>';</script>
<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/bootstrap/js/material.js"></script>
<script src="<?php echo base_url();?>assets/bootstrap/js/ripples.min.js"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url();?>assets/js/jquery.bootstrap-growl.min.js"></script>
<script src="<?php echo base_url();?>assets/js/treeview.js"></script>
<script src="<?php echo base_url();?>assets/js/pace.min.js"></script>
<script src="<?php echo base_url();?>assets/js/ajaxload.js"></script> 
<script src="<?php echo base_url();?>assets/js/funciones.js"></script>
<script src="<?php echo base_url();?>assets/js/panel.js"></script>
<script>
  $.material.init();
</script>
<!--Js Adicionales vienes del controlador-->   
<?php if (isset($jsvista)): ?>
		<?php //echo $jsvista ?>
	<?php foreach($jsvista as $js): ?>
		<script src="<?php echo base_url().$js;?>"></script>
	<?php endforeach; ?>
<?php endif; ?>
</body>
</html>