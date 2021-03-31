$(function(){
    obj_funciones.getdatatable('table','detalleactividad/mostrar');
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

function class_detalleactividad(){

    this.nuevo = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'detalleactividad/nuevo',
            datatype: 'html',
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.editar = function(){
        var valores = $('.checkbox1:checked').map(function(){
            return $(this).val();
        }).get();
        
        if (valores.length == 1){
            
            var data = obj_funciones.getajaxsimple({
                url :   base_url+'detalleactividad/editar',
                data: {id: valores}, 
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
                  url: base_url + 'detalleactividad/borrar',
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

      this.generarcampos = function() {
          var newQuestion = $('#procesos').html();
          //newQuestion = newQuestion.replace('#proceso', '#proceso1');
          $('#procesos').parent().append(newQuestion);
      }

      this.procesos = function (id,selected_id){
        if(selected_id == undefined) selected_id = '';
        var data = obj_funciones.getajaxsimple({
            url : base_url + "detalleactividad/get_procesos", 
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
            url : base_url + "detalleactividad/get_subprocesos", 
            data : {proceso_id: id}
        });
        var html = '<option value="">..:: Seleccione ::..</option>';
        for(var index in data) { sel = "";
            if(selected_id == data[index].id) sel = 'selected=""';
            html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].nombre)+'</option>';
        }
       $("#subproceso").html(html);
    }

     this.actividad = function (id,selected_id){
        if(selected_id == undefined) selected_id = '';
        var data = obj_funciones.getajaxsimple({
            url : base_url + "detalleactividad/get_actividades", 
            data : {proceso_id: id}
        });
        var html = '<option value="">..:: Seleccione ::..</option>';
        for(var index in data) { sel = "";
            if(selected_id == data[index].id) sel = 'selected=""';
            html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].nombre)+'</option>';
        }
       $("#actividad").html(html);
    }

    
}
var obj_detalleactividad = new class_detalleactividad();
