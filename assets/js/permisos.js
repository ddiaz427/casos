$(function(){
    obj_permisos.arboldinamico();
});

function class_permisos(){
    //cargar los permisos del usuario
    this.cargar_permiso_perfil = function ()
    {
        $("#permisos input[type=checkbox]").prop('checked', false);
        if($("#key:checked").val() > 0)
        {
            obj_funciones.loadajax();
            setTimeout(function(){
                var data = obj_funciones.getajaxsimple({
                    url: base_url + 'permisos/getperfildatapermisos',
                    datatype : 'html',
                    data: {perfil_id: $("#key:checked").val()},
                });
                $("#permisos").html(data);
                obj_permisos.arboldinamico();
            },300);
        }
    }

    //boton guardar
    this.guardar = function (){
        $('#msj_alert').html('');

        var modulos = new Array();
        var menu = new Array();
        var boton = new Array();
        var con = 0;

       $("input[name='id_modulo[]']:checked").each(function(){
            if($(this).is(':checked')){
                modulos.push($(this).val());
            }
        });
        con = 0;
        
        $("input[name='id_submenu[]']:checked").each(function(){
            if($(this).is(':checked')){
                menu.push($(this).val());
            }
        });
        con = 0;

        $("input[name='id_boton[]']:checked").each(function(){
            if($(this).is(':checked')){
                boton.push($(this).val());
            }
        });
        con = 0;
       
        if(modulos.length == 0){ modulos = ''; }
        if(menu.length == 0){ menu = ''; }
        if(boton.length == 0){ boton = ''; }

        if($("#key:checked").val() > 0)
        {
            obj_funciones.loadajax();
            setTimeout(function(){
                var data = obj_funciones.getajaxsimple({
                    url:    base_url + 'permisos/procesarpermisos',
                    data:   {perfil_id : $("#key:checked").val(),
                            modulos: modulos, menu: menu, boton: boton},
                });
                obj_funciones.mostrar_div("#msj_alert");
                $("#msj_alert").html(data.mensages);
            },300);
        } else {
            alert("Seleccione Un Perfil");
        }
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
var obj_permisos = new class_permisos();