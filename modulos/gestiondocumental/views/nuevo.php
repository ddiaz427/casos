<?php echo form_open_multipart(base_url().'gestiondocumental/nuevo', array('id' => 'gestiondocu', 'onsubmit' => 'obj_documentos.submitForm(); return false;'), array('enviado' => 'enviado')); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Formulario de Gestión Documental</h4>
            </div>

            <div class="modal-body">
               <div class="row"> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Titulo</label>
                             <?php echo form_input(array('name' => 'titulo',   'id' => 'titulo', 'class' => 'form-control', 'placeholder' => 'Ingrese un titulo', 'value' => set_value('titulo'))); ?>
                        </div>
                    </div>

                       <!-- 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Documento</label>
                                <select name="tipo_documento" id="estado" class="form-control">
                                    <option value="" selected="">::Seleccione::</option>
                                    <option value="Img">Img</option>
                                    <option value="Pdf">Pdf</option>
                                    <option value="Word">Word</option>
                                    <option value="Excel">Excel</option>
                                </select>
                            </div>
                        </div> 
                        -->

                        <div id="default_preview" style="display: none;">
                              <div class="col-md-3">  
                                <img id="preview_default" class="img-responsive img-rounded img_preview" src="" 
                                    height="100" width="100" alt="" style="cursor: pointer; margin: 5px">
                              </div>      
                        </div>
                        <div id="default_input" style="display: none;">
                            <!-- <input type="file" name="diap_1" class="diapositiva" style="display: none;"> -->
                        </div>

                         <input id="name_files" name="name_files" type="hidden">
                         <div id="list_files">
                            <input type="file" name="archivo_1" class="archivos" style="display: none;">
                         </div>   

                          <div class="col-md-12">
                            <div class="form-group">
                               <div id="card_preview" style="display: none;">
                                    <div id="list_previews">
                                        
                                    </div>
                                </div>
                              </div>
                           </div>     

                        <div class="col-md-12">    
                            <div id="preview_zone" style="
                                padding-top: 50px;
                                padding-bottom: 50px;
                                padding-left: 30%;
                                padding-right: 25px;
                                border: 3px dashed #66bb6a;
                            ">
                                <a id="preview_upload" href="#" style="text-decoration: none;">
                                    <strong>Click aquí</strong>
                                </a> 
                                o arraste para cargar una imagen escaneada
                            </div>
                        </div>
                        <hr> 
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>
                             <?php echo form_textarea(array('name' => 'descipcion',   'id' => 'descipcion', 'class' => 'form-control', 'placeholder' => 'Ingrese un Descipción', 'value' => set_value('descipcion'),'rows' => '3')); ?>
                        </div>
                    </div>
                </div>   

                <div class="col-md-12">
                    <div class="progress hidden">
                          <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%; display:none" id="hidden_progressbar">
                          </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnlogin" class="btn btn-raised btn-primary">Guardar</button>
                <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
  <?php echo form_close(); ?>


<script type="text/javascript"> 
    var previewPrototype = $('#default_preview').html(),
        filePrototype = $('#list_files').html(),
        filesDrop = {},
        stats_archivos = {
            total: 1,
            total_drop: 1,
        };

    var readURL = function (input, option) {
        // var name = $(input).attr('name').split('_')[1],
        var new_file = filePrototype,
            new_preview = previewPrototype;

        if (input.files && input.files[0]) {
            var reader = new FileReader(),
                preview_selector = '';

            if (option == 'input') {
                preview_selector = '#input_' + stats_archivos.total;
                new_preview = new_preview.replace(/preview_default/g, 'input_' + stats_archivos.total);

                stats_archivos.total += 1;

                new_file = new_file.replace(/_1/g, '_' + stats_archivos.total);
                $('#list_files').parent().append(new_file);

            } else if (option == 'drop') {
                preview_selector = '#drop_' + stats_archivos.total_drop;
                new_preview = new_preview.replace(/preview_default/g, 'drop_' + stats_archivos.total_drop);

                stats_archivos.total_drop += 1;
            }

            $('#list_previews').parent().append(new_preview);

            reader.onload = function (e) {
                // return;
                $(preview_selector).attr('src', e.target.result);
                $(preview_selector).css('display', '');
                if ($('#card_preview').css('display') == 'none') {
                    $('#card_preview').css('display', '')
                }

                if ($('#card_preview').css('display') == 'none') {
                    $('#card_preview').css('display', '');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('change', '.archivos', function () {
        readURL(this, 'input');
    });

    $(document).on('click', '.img_preview', function (event) {
        event.preventDefault();
        var id = $(this).attr('id').split('_');

        $(this).remove();

        if ($('#list_previews').children().length == 0) {
            $('#card_preview').css('display', 'none');
        }

        if (id[0] == 'input') {
            $('#list_files').find('input[name=archivo_' + id[1] + ']').remove();
        } else if (id[0] == 'drop') {
            if (filesDrop[$(this).attr('id')] != undefined) {
                delete filesDrop[$(this).attr('id')];
            }
        }
    });

    $('#preview_upload').on('click', function (event) {
        event.preventDefault();
        //alert(stats_diapositiva.total);
        $('input[name=archivo_' + stats_archivos.total + ']').click();
    });

    $('#preview_zone').on('dragover', function (event) {
        event.preventDefault();
        event.stopPropagation();
        // $(this).unbind('dragover').dragover();
    });    

    $('#preview_zone').on('drop', function (event) {
        event.preventDefault();
        event.stopPropagation();

        filesDrop['drop_' + stats_archivos.total_drop] = (event.originalEvent.dataTransfer.files[0]);

        readURL(event.originalEvent.dataTransfer, 'drop');
    }); 
</script>