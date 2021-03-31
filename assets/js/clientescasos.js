function class_clientes(){

    this.nuevocliente = function(){
        var data = obj_funciones.getajaxsimple({
            url :  base_url+'clientes/nuevo',
            datatype: 'html',
        });
        obj_funciones.mostrarmodalstatic('#modalnuevocliente',data);
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
                           $('#modalnuevocliente').modal('hide');
                           obj_funciones.reload_table();
                     }else{
                        obj_funciones.bootstrapGrowl(data.mensages,'danger');
                     }
                  }
              }); 
          },300);
          return false;
      }

      this.recargaclientes = function (selected_id){
        var data = obj_funciones.getajaxsimple({
            url : base_url + "casos/get_clientes", 
        });
        var html = '<option value="">..:: Seleccione ::..</option>';
        for(var index in data) { sel = "";
            if(selected_id == data[index].id) sel = 'selected=""';
            html += '<option value="'+data[index].id+'" '+sel+' >'+obj_funciones.ucwords(data[index].nombres)+'</option>';
        }
        $('#clientes').html(html);
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
