<?php  
echo isset($head)? $head :'';
echo isset($nav)? $nav :'';
?>
<div class="container contenido">
	<div class="row serparador">
	   <div class="col-xs-12 col-lg-12">
	   	  <h2 class="text-success" style="margin-top: -1px;"><i class="fa fa-balance-scale" aria-hidden="true"></i> Alcance General <small class="text-danger">SOFTWARE DERECHO</small></h2>
          <div id="resultado">
       		<?php echo isset($cuerpo)? $cuerpo:''; ?>
       	  </div>        
		</div>
	</div>	
</div>   

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
</div>

<div class="modal fade" id="modalnuevocliente" data-backdrop="static"></div>
<?php
echo isset($footer)? $footer:'';
?>