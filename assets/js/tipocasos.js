$(function(){
    obj_funciones.getdatatable('table','tipocasos/mostrar');
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

function class_tipocasos(){

    this.nuevo = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'tipocasos/nuevo',
            datatype: 'html',
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
    }

    this.editar = function(){
        var valores = $('.checkbox1:checked').map(function(){
            return $(this).val();
        }).get();
        
        if (valores.length > 0){
            
            var data = obj_funciones.getajaxsimple({
                url :   base_url+'tipocasos/editar',
                data: {id: valores}, 
                datatype: 'html',
            });
            obj_funciones.mostrarmodalstatic('#modal',data);
        }   
    }


    this.ver = function(){
        var valores = $('.checkbox1:checked').map(function(){
            return $(this).val();
        }).get();
        
        var data = obj_funciones.getajaxsimple({
            url :   base_url+'tipocasos/ver',
            data: {id: valores}, 
            datatype: 'html',
        });
        obj_funciones.mostrarmodalstatic('#modal',data);
        obj_tipocaso.arboldinamico();
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
                  url: base_url + 'tipocasos/borrar',
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
          var newQuestion = $('#caso').html();
          $('#caso').parent().append(newQuestion);
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
}
var obj_tipocaso = new class_tipocasos();
