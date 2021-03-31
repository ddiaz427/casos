$(function(){
    obj_funciones.getdatatable('table','ciudad/mostrar');
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

function class_ciudad(){

    this.nuevo = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'ciudad/nuevo',
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
                url :   base_url+'ciudad/editar',
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
        if(confirm('¿Realmente Desea Eliminar los registros seleccionados?'))
        {
            obj_funciones.loadajax();
            setTimeout(function()
            { 
              var data = obj_funciones.getajaxsimple({
                  url: base_url + 'ciudad/borrar',
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
         
          setTimeout(function(){
            var   data = obj_funciones.getajaxsimple({
                  url :  $('form').attr("action"), 
                  data : $('form').serialize(),
              });
              
              if(data.success == true){
                   obj_funciones.bootstrapGrowl(data.mensages,'success');
                   $('#modal').modal('hide');
                   obj_funciones.reload_table();
              }else{
                   obj_funciones.bootstrapGrowl(data.mensages,'danger');
              }
          },300);
          return false;
      }

      this.distritos = function (id,selected_id){
        if(selected_id == undefined) selected_id = '';
        var data = obj_funciones.getajaxsimple({
            url : base_url + "ciudad/distritos", 
            data : {pais_id: id}
        });
        var html = '<option value="">..:: Seleccione ::..</option>';
        for(var index in data) { sel = "";
            if(selected_id == data[index].id) sel = 'selected=""';
            html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].departamento)+'</option>';
        }
        $('#distrito').html(html);
    }

}
var obj_ciudad = new class_ciudad();
