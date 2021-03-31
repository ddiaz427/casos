<div class="col-md-8">
<?php echo form_open_multipart(base_url().'casos/documentos', array('id' => 'documentosform', 'onsubmit' => 'obj_casos.submitFormdocumentos(); return false;'), array('enviado' => 'enviado')); ?>
<div id="sections">
    <div class="section">  
		 <div class="col-md-6">
		      <div class="form-group">
		          <label>Nombre del Documento</label>
		           <?php echo form_input(array('name' => 'nombre[]',   'id' => 'nombre', 'class' => 'form-control', 'placeholder' => 'Ingrese un Nombre')); ?>
		      </div>
		  </div> 

		<div class="col-md-6">
		  <div class="form-group">
		      <label for="documentos">Documentos</label>
		      <input type="file" name="files[]" class="form-control">
		  </div>
		</div>

		 <a href="javascript:void(0);" class="remove col-md-offset-11"><i class="fa fa-window-close text-danger fa-2x text-right" aria-hidden="true"></i></a>
	</div>
</div>		

<div class="col-md-12 text-center">
	<a href="javascript:void(0);" class="btn btn-raised btn-success agregarinpus"><i class="fa fa-plus-circle" aria-hidden="true"></i></a> 
</div>
	
 <input type="hidden" name="caso_id" value="<?php echo $caso_id ?>">

 <div class="col-md-12">
    <div class="progress hidden">
          <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%; display:none" id="hidden_progressbar">
          </div>
    </div>
</div>

 <div class="col-md-12 text-center">
     <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Subir</button>
 </div>      
<?php echo form_close(); ?>
</div>

<div class="col-md-4">
	<div id="documentoscreadas"></div>
</div>

<script type="text/javascript">
	obj_casos.globalcontenido('documentoscreadas','casos/listar_documentos','caso_id=<?php echo $caso_id ?>');
	var template = $('#sections .section:first').clone();
	var sectionsCount = 1;
	$('body').on('click', '.agregarinpus', function() {
	    sectionsCount++;
	    //alert(sectionsCount);
	    if (sectionsCount == 8) {
	    	alert('lo Sentimos Pero El Sistema Solo Soporta 7 Campos Habiertos');
	    	//$('.agregarinpus').addClass('btn-disabled');
			$('.agregarinpus').attr('disabled', 'disabled');
	    	$('.agregarinpus').prop('disabled', true);
	    }else{
		    var section = template.clone().find(':input').each(function(){
		        var newId = this.id + sectionsCount;
		        $(this).prev().attr('for', newId);
		        this.id = newId;
		    }).end()
		    .appendTo('#sections');
		    return false;    	
	    }
	});

	$('#sections').on('click', '.remove', function() {
	    $(this).parent().fadeOut(300, function(){
	        $(this).remove();
	        var numero = 1;
	        var resta = (parseInt(sectionsCount) - parseInt(numero));
	        sectionsCount = resta;	
	        $('.agregarinpus').removeattr('disabled');
	        $('.agregarinpus').prop('disabled', false);
	        //alert(resta);
	        return false;
	    });
	    return false;
	});
</script>