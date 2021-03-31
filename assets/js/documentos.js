$(function(){
    obj_funciones.getdatatable('table','gestiondocumental/mostrar');
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

function class_documentos(){

    this.nuevo = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'gestiondocumental/nuevo',
            datatype: 'html',
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.editar = function(){
        var valor = $('.checkbox1:checked').map(function(){
            return $(this).val();
        }).get();
        
        if (valor.length == 1){
            var data = obj_funciones.getajaxsimple({
                url :   base_url+'gestiondocumental/editar',
                data: {id: valor[0]}, 
                datatype: 'html',
            });
            obj_funciones.mostrarmodalstatic('#modal',data);
        }   
    }

    this.eliminar = function(){
        var valores = $('.checkbox1:checked').map(function(){
            return $(this).val();
        }).get();

      if (valores.length > 0){
        if(confirm('¿Realmente Desea Eliminar Este Registro?'))
        {
            obj_funciones.loadajax();
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'gestiondocumental/borrar',
                  data : {id : valores}
              });
              if(data.success == true){
               obj_funciones.bootstrapGrowl(data.mensages,'success');
                 obj_funciones.reload_table();
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
             },300); 
        }
      }
    }

    this.submitForm = function() {
        obj_funciones.disabledelement();
          setTimeout(function(){
              var formData = new FormData($("#gestiondocu")[0]);
              $.ajax({
                  type: 'POST',
                  url: $('form').attr("action"),
                  xhr: obj_funciones.getprogressbar,
                  data: formData,
                  cache : false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(data){
                      
                     if (data.success == true){
                           obj_funciones.bootstrapGrowl(data.mensages,'success');
                           $('#modal').modal('hide');
                           obj_funciones.reload_table();
                           obj_funciones.enableelements();
                     }else{
                        obj_funciones.bootstrapGrowl(data.mensages,'danger');
                        obj_funciones.enableelements();
                     }
                  }
              }); 
          },300);
          return false;
      }
}
var obj_documentos = new class_documentos();
