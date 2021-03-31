$(function(){
    obj_funciones.getdatatable('table','clientes/mostrar');
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

function class_clientes(){

    this.nuevo = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'clientes/nuevo',
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
                url :   base_url+'clientes/editar',
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
        if(confirm('¿Realmente Desea Eliminar Este Registro? tenga en cuenta que si borra el cliente automaticamente se borraran todos los archivos asociados a ese id'))
        {
            obj_funciones.loadajax();
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'clientes/borrar',
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

    this.eliminararchivo = function(id){
        if(confirm('¿Realmente Desea Eliminar Este Archivo?'))
        {
            obj_funciones.loadajax();
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'clientes/borrararchivo',
                  data : {id : id}
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

    this.submitForm = function() {
          setTimeout(function(){
              var formData = new FormData($("#clientes")[0]);
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
                     }else{
                        obj_funciones.bootstrapGrowl(data.mensages,'danger');
                     }
                  }
              }); 
          },300);
          return false;
      }

      this.ver = function(){
        var valor = $('.checkbox1:checked').map(function(){
            return $(this).val();
        }).get();
        
        if (valor.length == 1){
            var data = obj_funciones.getajaxsimple({
                url :   base_url+'clientes/archivos',
                data: {id: valor[0]}, 
                datatype: 'html',
            });
            obj_funciones.mostrarmodalstatic('#modal',data);
        }   
    }

      this.distritos = function (id,selected_id){
        if(selected_id == undefined) selected_id = '';
        var data = obj_funciones.getajaxsimple({
            url : base_url + "clientes/get_distritos", 
            data : {pais_id: id}
        });
        var html = '<option value="">..:: Seleccione ::..</option>';
        for(var index in data) { sel = "";
            if(selected_id == data[index].id) sel = 'selected=""';
            html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].departamento)+'</option>';
        }
        $('#distrito').html(html);
    }

    this.ciudades = function (id,selected_id){
        if(selected_id == undefined) selected_id = '';
        var data = obj_funciones.getajaxsimple({
            url : base_url + "clientes/get_ciudades", 
            data : {departamento_id: id}
        });
        var html = '<option value="">..:: Seleccione ::..</option>';
        for(var index in data) { sel = "";
            if(selected_id == data[index].id) sel = 'selected=""';
            html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].ciudad)+'</option>';
        }
        $('#ciudad').html(html);
    }

}
var obj_clientes = new class_clientes();
