$(function(){
    obj_funciones.getdatatable('table','casos/mostrar');
     $('#seleccionartodos').click(function(event){ 
        //alert('clieck');
        if (this.checked){
            $('.checkbox1').each(function(){ 
                this.checked = true;                
            });
        } 
        else{
            $('.checkbox1').each(function(){ 
                this.checked = false;                 
            });
        }
    });
});

function class_casos(){

    this.nuevo = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'casos/nuevo',
            datatype: 'html',
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.submitForm = function() {
          setTimeout(function(){
            var   data = obj_funciones.getajaxsimple({
                  url :  $('form').attr("action"), 
                  data : $('form').serialize(),
              });
              
              if(data.success == true){
                   obj_funciones.bootstrapGrowl(data.mensages,'success');
                   $('#modal').modal('hide');
                   //obj_funciones.reload_table();
                   obj_casos.menu('caso_id='+data.caso_id,data.url,'resultado','html');
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
          },300);
          return false;
      }

      this.submitFormcasos = function() {
          setTimeout(function(){
            var   data = obj_funciones.getajaxsimple({
                  url :  $('form').attr("action"), 
                  data : $('form').serialize(),
              });
              
              if(data.success == true){
                   obj_funciones.bootstrapGrowl(data.mensages,'success');
                   //obj_funciones.reload_table();
                   //obj_casos.menu('caso_id='+data.caso_id,data.url,'resultado','html');
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
          },300);
          return false;
      }

      this.submitFormdocumentos = function() {
          setTimeout(function(){
              var formData = new FormData($("#documentosform")[0]);
              $.ajax({
                  type: 'POST',
                  url: base_url+'casos/documentos',
                  xhr: obj_funciones.getprogressbar,
                  data: formData,
                  cache : false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(data){
                      
                     if (data.success == true){
                           obj_funciones.bootstrapGrowl(data.mensages,'success');
                           obj_casos.globalcontenido('documentoscreadas','casos/listar_documentos','caso_id='+data.caso_id);
                           $('#documentosform').each(function(){
                              this.reset();
                            });
                     }else{
                        obj_funciones.bootstrapGrowl(data.mensages,'danger');
                     }
                  }
              }); 
          },300);
          return false;
      }

      this.submitFormdocumentosedit = function() {
          setTimeout(function(){
              var formData = new FormData($("#documentosformedit")[0]);
              $.ajax({
                  type: 'POST',
                  url: base_url+'casos/editar_documentos',
                  data: formData,
                  cache : false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(data){
                      
                     if (data.success == true){
                           obj_funciones.bootstrapGrowl(data.mensages,'success');
                           $('#modal').modal('hide');
                           obj_casos.globalcontenido('documentoscreadas','casos/listar_documentos','caso_id='+data.caso_id);
                           $('#documentosform').each(function(){
                              this.reset();
                            });
                     }else{
                        obj_funciones.bootstrapGrowl(data.mensages,'danger');
                     }
                  }
              }); 
          },300);
          return false;
      }

      this.submitFormdocumentosedit = function() {
          setTimeout(function(){
              var formData = new FormData($("#notasformedit")[0]);
              $.ajax({
                  type: 'POST',
                  url: base_url+'casos/editar_documentos',
                  data: formData,
                  cache : false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(data){
                      
                     if (data.success == true){
                           obj_funciones.bootstrapGrowl(data.mensages,'success');
                           $('#modal').modal('hide');
                           obj_casos.globalcontenido('documentoscreadas','casos/listar_documentos','caso_id='+data.caso_id);
                           $('#documentosform').each(function(){
                              this.reset();
                            });
                     }else{
                        obj_funciones.bootstrapGrowl(data.mensages,'danger');
                     }
                  }
              }); 
          },300);
          return false;
      }

      this.submitFormnotas = function() {
          setTimeout(function(){
            var   data = obj_funciones.getajaxsimple({
                  url :  $('#notasformedit').attr("action"), 
                  data : $('#notasformedit').serialize(),
              });
              
              if(data.success == true){
                   obj_funciones.bootstrapGrowl(data.mensages,'success');
                  $('#modal').modal('hide');
                   obj_casos.globalcontenido('notascreadas','casos/listar_notas','caso_id='+data.caso_id);
                   $('#notasformedit').each(function(){
                      this.reset();
                    });
                   //$('.notas').html();
                   $('.notas').tinymce().reset();

              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
          },300);
          return false;
      }

      this.eliminar_nota = function(id, caso_id){
        if(confirm('¿Realmente Desea Eliminar Este Registro?'))
        {
            obj_funciones.loadajax();
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'casos/borrar_notas',
                  data : {id : id, caso_id: caso_id}
              });
              if(data.success == true){
               obj_funciones.bootstrapGrowl(data.mensages,'success');
                obj_casos.globalcontenido('notascreadas','casos/listar_notas','caso_id='+data.caso_id);
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
             },300); 
        }
    }

    this.eliminar_documento = function(id, caso_id){
        if(confirm('¿Realmente Desea Eliminar Este Registro?'))
        {
            obj_funciones.loadajax();
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'casos/borrar_documentos',
                  data : {id : id, caso_id: caso_id}
              });
              if(data.success == true){
               obj_funciones.bootstrapGrowl(data.mensages,'success');
               obj_casos.globalcontenido('documentoscreadas','casos/listar_documentos','caso_id='+data.caso_id);
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
             },300); 
        }
    }

    this.generar_expediente = function(){
            obj_funciones.loadajax('Generando Exepiente, Espere por Favor..');
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'casos/generarCodigoExpediente',
              });
              if(data.success == true){
                  $('#expediente').val(data.nro_expediente);
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
             },300); 
    }

    this.visor = function(id){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'casos/visor_documentos',
            datatype: 'html',
            data: {id: id},
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.editar_documento = function(id, caso_id){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'casos/editar_documentos',
            datatype: 'html',
            data: {id: id, caso_id: caso_id},
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.editar_nota = function(id, caso_id){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'casos/editar_notas',
            datatype: 'html',
            data: {id: id, caso_id: caso_id},
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.procesos = function (id,selected_id){
      if(selected_id == undefined) selected_id = '';
      var data = obj_funciones.getajaxsimple({
          url : base_url + "actividades/get_procesos", 
          data : {caso_id: id}
      });
      var html = '<option value="">..:: Seleccione ::..</option>';
      for(var index in data) { sel = "";
          if(selected_id == data[index].id) sel = 'selected=""';
          html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].nombre)+'</option>';
      }
     $("#proceso").html(html);
  }

   this.subprocesos = function (id,selected_id){
      if(selected_id == undefined) selected_id = '';
      var data = obj_funciones.getajaxsimple({
          url : base_url + "actividades/get_subprocesos", 
          data : {proceso_id: id}
      });
      var html = '<option value="">..:: Seleccione ::..</option>';
      for(var index in data) { sel = "";
          if(selected_id == data[index].id) sel = 'selected=""';
          html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].nombre)+'</option>';
      }
     $("#subproceso").html(html);
  }

   this.diagrama = function(){
      var data = obj_funciones.getajaxsimple({
          url : base_url + "casos/ver", 
          data : {caso_id: $('#caso').val(),proceso_id: $('#proceso').val(),sub_proceso_id: $('#subproceso').val()},
          datatype: 'html',
      });
     $("#diagrama").html(data);
     obj_casos.arboldinamico();
  }

   this.arboldinamico = function(){
      $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Ocultar Lista');
      $('.tree li.parent_li > span').on('click', function (e) {
          var children = $(this).parent('li.parent_li').find(' > ul > li');
          if (children.is(":visible")) {
              children.hide('fast');
              $(this).attr('title', 'Expander Lista').find(' > i').removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
          } else {
              children.show('fast');
              $(this).attr('title', 'Ocultar Lista').find(' > i').removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
          }
          e.stopPropagation();
      });
     $('#permisos ul').checktree(); 
  }

  this.menu = function(datos, url, div, datatipo, title){
      obj_funciones.loadajax('10','Cargando Contenido del Caso...');
      setTimeout(function(){
        var data = obj_funciones.getajaxsimple({
                  url: url, 
                  datatype : datatipo,
                  data: datos,
              });
        $('title').html(title);
        $('#'+div).html(data);
        window.history.pushState(null, "Titulo", url);
        obj_funciones.mostrar_div('#'+div);
       },300);  
  }

  this.mostrar_actividad = function(caso_id, actividad_id){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'casos/mostrar_actividad',
            datatype: 'html',
            data: {caso_id: caso_id, actividad_id: actividad_id}
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.globalcontenido = function(div,url,datos){
      setTimeout(function(){
        $.ajax({
            type: "POST",
            url: base_url+url,
            data: datos,
            beforeSend: function (){
                $('#'+div).html('Cangando...<i class="fa fa-refresh fa-spin"></i>');
            },
            success: function(data){
                $('#'+div).html(data).slideDown("slow");
            }
        });
        },300);  
    }
}
var obj_casos = new class_casos();
