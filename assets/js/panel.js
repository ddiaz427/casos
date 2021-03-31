$(function(){
    //
    obj_panel.ajaxfull();
    $('.collapse').on('shown.bs.collapse', function(){
      $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
    }).on('hidden.bs.collapse', function(){
      $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });
    /**/    
});
function class_panel(){
    
    this.verysession = function (){
        var data = obj_funciones.getajaxsimple({
            url: base_url + 'panel/verysession'
        });
        if(data == 0){
            setTimeout(function(){
                window.location = base_url; return;
            },200);
        }
    }

    this.ajaxfull = function(){
         obj_funciones.loadajax('10','Cargando Datos...');
        setTimeout(function(){
            var data = obj_funciones.getajaxsimple({
                url : base_url + "panel/consolidadoajax"
            });

            obj_panel.getdatosusuario(data.getProfileUser);
            obj_panel.getdatosempresa(data.getdatosempresa);
            obj_panel.getdatosclientes(data.getclientes);
            obj_panel.getdatoscasoshoy(data.getcasoshoy);
            obj_panel.getdatoscasossemana(data.getcasossemana);
            obj_panel.getdatoscasosmes(data.getcasosmes);
            obj_panel.getdatoscasosanio(data.getcasosanio);
            
           $("#nav_modulos").html(data.getdatosmodulo);
         },200);
    }

     this.menu = function(datos, url, div){
        obj_funciones.loadajax();
        setTimeout(function(){
            var data = obj_funciones.getajaxsimple({
                    url: url, 
                    datatype : 'html',
                    data: datos,
                });
            $('#'+div).html(data);
            $('title').html('Panel');
            window.history.pushState(null, "Titulo", base_url+'panel');
            obj_panel.botones(datos);
            obj_funciones.mostrar_div('#'+div);
         },300);    
    }

    this.botones = function(datos){
        setTimeout(function(){
            var data = obj_funciones.getajaxsimple({
                    url: base_url+'panel/botones', 
                    data: datos,
                });
            $('#botonera').html(data.botones);
         },300);    
    }

  
    this.getdatosusuario = function(data){
        var data1 = data.data1;
        var html = '';
        if(obj_funciones.is_object(data1)){
            var url_img = data1.avatar;
            if(url_img == "") url_img = base_url + 'assets/images/anonimo.jpg';

            html = '<div class="col-md-4 col-lg-4 text-center">'+
                         '<img alt="User Pic" src="'+url_img+'" class="img-circle" width="140">'+
                         '<p class="text-center">'+data1.descripcion.substring(0,200)+'...</p><hr>Hora del Sistema: <p class="text-center text-danger" id="horaserver"></p>'+
                    '</div>'+
                    '<div class=" col-md-8 col-lg-8">'+
                         '<table class="table table-user-information">'+
                              '<tbody>'+
                                   '<tr>'+
                                        '<td><strong>Nom. Ape.:</strong></td>'+
                                        '<td>'+obj_funciones.ucwords(data1.nombres)+'</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>Usuario:</strong></td>'+
                                        '<td>'+data1.usuario+'</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>Perfil:</strong></td>'+
                                        '<td>'+obj_funciones.ucwords(data1.perfilnombre)+'</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>E-mail:</strong></td>'+
                                        '<td>'+
                                            '<a href="javascript:void(0)">'+data1.email+'</a>'+
                                        '</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>Fecha de Registro:</strong></td>'+
                                        '<td>'+data1.fecha_registro+'</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>Fecha de ult. ingreso:</strong></td>'+
                                        '<td>'+data1.fecha_ult_ingreso+'</td>'+
                                   '</tr>'+
                                    '<tr>'+
                                        '<td><strong>Estado:</strong></td>'+
                                        '<td>'+'<a href="javascript:void(0)">'+data1.estado+'</a>'+'</td>'+
                                   '</tr>'+
                              '</tbody>'+
                         '</table>'+
                    '</div>';
            $("#name_persona").html('<b><i class="fa fa-user" aria-hidden="true"></i> '+data1.nombres+' <i class="fa fa-caret-down"></i></b>');
        }
        $("#profile_w").html(html);
    }
   
   this.getdatosempresa = function (data){

     if(obj_funciones.is_object(data)){
        var url_img = base_url+"assets/images/default-logo.png";
        if(data.logo != null) var url_img = data.logo;

        var html =  '<div class="col-md-4 col-lg-4 text-center">'+
                         '<img alt="User Pic" src="'+url_img+'" class="img-circle" width="140">'+
                         '<p class="text-left">'+data.descripcion.substring(0,200)+'...</p>'+
                    '</div>'+
                    '<div class=" col-md-8 col-lg-8">'+
                         '<table class="table table-user-information">'+
                              '<tbody>'+
                                   '<tr>'+
                                        '<td><strong>Nombre:</strong></td>'+
                                        '<td>'+obj_funciones.ucwords(data.nombre)+'</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>Misión:</strong></td>'+
                                        '<td>'+data.mision.substring(0,200)+'...</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>Visión:</strong></td>'+
                                        '<td>'+data.vision.substring(0,200)+'...</td>'+
                                   '</tr>'+
                                   '<tr>'+
                                        '<td><strong>E-mail:</strong></td>'+
                                        '<td>'+
                                             '<a href="javascript:void(0)">'+data.email+'</a>'+
                                        '</td>'+
                                   '</tr>'+
                              '</tbody>'+
                         '</table>'+
                    '</div>';
        $("#empresa_w").html(html);
        $("#name_empresa").text(data.nombre);
        }
    }

    this.getdatosclientes = function(data){
          if(data.length > 0){
             var row = '<table class="table table-bordered">';
                    row += '<thead><tr>';
                    row += '<th class="text-center">Avatar</th>';
                    row += '<th class="text-center">Nombre</th>';
                    row += '<th class="text-center">Email</th>';
                    row += '<th class="text-center">Estado</th>';
                    row += '</tr></thead>';
                    row += ' <tbody>';
                for (i=0;i<data.length;i++) {
                      var url_img = data[i].avatar;
                      if(url_img == "") url_img = base_url + 'assets/images/anonimo.jpg';
                    row += '<tr class="text-center">';
                    row += '<td class="text-center"><img alt="User Pic" src="'+url_img+'" class="img-circle" width="50"></td>';
                    row += '<td class="text-center">'+data[i].nombres+'</td>';
                    row += '<td class="text-center">'+data[i].email+'</td>';
                    row += '<td class="text-center">'+data[i].estado+'</td>';
                    row += '</tr>';
                }
                    row += '</tbody>';
                    row += '</table>';
                $('#list_clientes').html(row);
          }      
    }

    this.getdatoscasoshoy = function(data){
          if(data.length > 0){
                var row = '';
                for (i=0;i<data.length;i++) {                
                    row += '<tr class="text-center">';
                    row += '<td class="text-center"><a href="">'+data[i].nombre_caso+'</a></td>';
                    row += '<td class="text-center"><a href="">'+data[i].cliente+'</a></td>';
                    row += '<td class="text-center">'+data[i].tipocaso+'</td>';
                    row += '<td class="text-center">'+data[i].estado+'</td>';
                    row += '<td class="text-center">'+data[i].fechacreado+'</td>';
                    row += '</tr>';
                }
                $('#totalcasoshoy').html(parseInt(data[0].subtotal));
                $('#casoshoy').html(row);
          }      
    } 

    this.getdatoscasossemana = function(data){
          if(data.length > 0){
                var row = '';
                for (i=0;i<data.length;i++) {                
                    row += '<tr class="text-center">';
                    row += '<td class="text-center"><a href="">'+data[i].nombre_caso+'</a></td>';
                    row += '<td class="text-center"><a href="">'+data[i].cliente+'</a></td>';
                    row += '<td class="text-center">'+data[i].tipocaso+'</td>';
                    row += '<td class="text-center">'+data[i].estado+'</td>';
                    row += '<td class="text-center">'+data[i].fechacreado+'</td>';
                    row += '</tr>';
                }
                $('#totalcasossemana').html(parseInt(data[0].subtotal));
                $('#casossemana').html(row);
          }      
    }

    this.getdatoscasosmes = function(data){
          if(data.length > 0){
                var row = '';
                for (i=0;i<data.length;i++) {                
                    row += '<tr class="text-center">';
                    row += '<td class="text-center"><a href="">'+data[i].nombre_caso+'</a></td>';
                    row += '<td class="text-center"><a href="">'+data[i].cliente+'</a></td>';
                    row += '<td class="text-center">'+data[i].tipocaso+'</td>';
                    row += '<td class="text-center">'+data[i].estado+'</td>';
                    row += '<td class="text-center">'+data[i].fechacreado+'</td>';
                    row += '</tr>';
                }
                $('#totalcasosmes').html(parseInt(data[0].subtotal));
                $('#casosmes').html(row);
          }      
    }

    this.getdatoscasosanio = function(data){
        if(data.length > 0){
              var row = '';
              for (i=0;i<data.length;i++) {                
                  row += '<tr class="text-center">';
                  row += '<td class="text-center"><a href="">'+data[i].nombre_caso+'</a></td>';
                  row += '<td class="text-center"><a href="">'+data[i].cliente+'</a></td>';
                  row += '<td class="text-center">'+data[i].tipocaso+'</td>';
                  row += '<td class="text-center">'+data[i].estado+'</td>';
                  row += '<td class="text-center">'+data[i].fechacreado+'</td>';
                  row += '<td class="text-center">'+data[i].diastranscurridos+' Dias</td>';
                  row += '</tr>';
              }
              $('#totalcasosanio').html(parseInt(data[0].subtotal));
              $('#casosanio').html(row);
        }      
    }   
   
    this.horaServisor = function(){   
        var tiempo = new Date();
        var hora = tiempo.getHours();
        var minutos = tiempo.getMinutes();
        var segundos = tiempo.getSeconds();
        
        minutos = (minutos < 10 ? "0" : "") + minutos;
        segundos = (segundos < 10 ? "0" : "") + segundos;
        
        var tiempodia = (hora < 12 ) ? "AM" : "PM";
        hora = ( hora > 12 ) ? hora - 12 : hora;
        hora = ( hora == 0 ) ? 12 : hora;
        
        var datos = this.GetTodayDate() + " " + hora + ":" + minutos + ":" + segundos + " " + tiempodia;
        
        //return datos;
        $('#horaserver').html(datos);
    }
    setInterval("obj_panel.horaServisor()", 1000);

    this.GetTodayDate = function(){
       var tdate = new Date();
       var dd = tdate.getDate(); //yields day
       var MM = tdate.getMonth(); //yields month
       var yyyy = tdate.getFullYear(); //yields year
       var fecha = dd + "/" +( MM+1) + "/" + yyyy;

       return fecha;
    }
}
var obj_panel = new class_panel();
