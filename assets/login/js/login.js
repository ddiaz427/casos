function class_login(){
    this.submit = function(){
       $('#fenviar').text("Procesando..").attr('disabled',true)
        setTimeout(function(){
            var data = obj_funciones.getajaxsimple({
                url :  $("#login").attr('action'), 
                data : $("#login").serialize(),  session : false
            });
            if(data.success == true){
                $.bootstrapGrowl(data.mensages,{ type: "success",ele:"#login" });
                setTimeout(function(){
                    window.location = data.respuesta;
                  }, 2000); 
            } 
            else{
               $('#fenviar').text("Iniciar Sesión").attr('disabled',false);
               $.bootstrapGrowl(data.mensages,{ type: "danger",ele:"#login" });
            }
        },500);   
    }
}
var o_login = new class_login();