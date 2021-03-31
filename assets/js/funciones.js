function class_funciones(){

    var table;

    this.loadajax = function(sec, title){
        if(sec == undefined) sec = 10;
        if(title == undefined) title = 'Espere Por Favor';

        $.blockUI
        ({
            css: {
            border: 'none',
            padding: '20px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#FFFFFF'
        },
            message: "<h5>"+title+"</h5> <img src='"+base_url+"/assets/images/ajax-loader.gif'/>"
        });
       setTimeout($.unblockUI, sec * 100);  
   }

    this.disabledelement = function(){
        $("select,:input").attr('readonly','readonly');
        $(":input[type='submit'],:button,a,div").attr("disabled", "disabled");
    }
    this.enableelements = function(){
        $("select,:input").removeAttr('readonly');
        $(":input[type='submit'],:button,a,div").removeAttr("disabled");
    }

   this.mostrar_div = function(id,sec){
        if(id == undefined) id = "";
        if(sec == undefined){ sec = 1*1000; }
        $(id).show();
        $('html,body').animate({scrollTop: $(id).position().top}, 800, 'swing');
        return false;
    }

    this.bootstrapGrowl = function(data, type){
        if (data == undefined){data  = ''}
        if (type == undefined){type  = 'success'}
        $.bootstrapGrowl(data, {
            type: type,
            delay: 3000,
            //allow_dismiss: true
        });
        return false;
    }

    this.getDatePicker = function (id,fnchange){
        if(fnchange == undefined) fnchange = function(){};
        id = this.tab_content_active().find(id);
        id.attr("data-date-format","DD/MM/YYYY");
        id.removeAttr("readonly");
        id.datetimepicker({
            language: 'es',
            pickDate: true,
            pickTime: false,
            useCurrent: false,
        }).change(fnchange);
    }
    this.getTimePicker = function (id,defaultt){
        if(defaultt == undefined) defaultt = '07:00 AM';
        var id = this.tab_content_active().find(id);
        id.attr("data-date-format","hh:mm A");
        id.removeAttr("readonly");
        id.datetimepicker({
            language: 'es',
            pickDate: false,
            pickTime: true,
            useCurrent: true,
            defaultDate: defaultt,
        });
    }
    this.is_object = function (mixed_var) {
        if (Object.prototype.toString.call(mixed_var) === '[object Array]') {
            return false;
        }
        return mixed_var !== null && typeof mixed_var === 'object';
    }
    this.readonlyselect = function (select,readonly){
        if(readonly == undefined) readonly = false;
        if(readonly){
            this.tab_content_active().find(select+" option").attr("disabled","true");
            this.tab_content_active().find(select+" option:selected").removeAttr("disabled","disabled");
        } else {
            this.tab_content_active().find(select).removeAttr("readonly");
            this.tab_content_active().find(select+" option").removeAttr("disabled","disabled");
            this.tab_content_active().find(select).val("");//.select2("val","");
        }
    }
    this.ucwords = function (str) {
        return (str + '')
        .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
        return $1.toUpperCase();
        });
    }
    this.number_format = function (number, decimals, dec_point, thousands_sep) {
        number = (number + '')
        .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
            .toFixed(prec);
        };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
        .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
            .join('0');
        }
        return s.join(dec);
    }
    this.strip_tags = function (input, allowed) {
        allowed = (((allowed || '') + '')
        .toLowerCase()
        .match(/<[a-z][a-z0-9]*>/g) || [])
        .join(''); 
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
        return input.replace(commentsAndPhpTags, '')
        .replace(tags, function($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    }
    this.mostrarmodalstatic = function (div,htmll,black){
        if(htmll == undefined) htmll = '';
        $(div).html(htmll);
        $(div).modal({
            backdrop: 'static',
            keyboard : false,
            show: true,
        });
        if(black != undefined){
            $(".modal").css('background-color','#000');
        }
    }
    this.windowsopen = function (url){
        var importantStuff = window.open('', '_blank');
        importantStuff.location.href = url;
    }
    this.isNumeric = function (n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    this.setselect2 = function (div){
        $(div).select2({
            placeholder: "Seleccionar", 
            language: "es",
            allowClear: true,
        });
    }
    this.str_pad = function (input, pad_length, pad_string, pad_type) {
        var half = '',pad_to_go;
        var str_pad_repeater = function(s, len) {
            var collect = '',
            i;

            while (collect.length < len) {
            collect += s;
            }
            collect = collect.substr(0, len);

            return collect;
        };
        input += '';
        pad_string = pad_string !== undefined ? pad_string : ' ';

        if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
            pad_type = 'STR_PAD_RIGHT';
        }
        if ((pad_to_go = pad_length - input.length) > 0) {
            if (pad_type === 'STR_PAD_LEFT') {
                input = str_pad_repeater(pad_string, pad_to_go) + input;
            } else if (pad_type === 'STR_PAD_RIGHT') {
                input = input + str_pad_repeater(pad_string, pad_to_go);
            } else if (pad_type === 'STR_PAD_BOTH') {
                half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
                input = half + input + half;
                input = input.substr(0, pad_length);
            }
        }
        return input;
    }
    this.validemail = function (email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    this.getslug = function (s, opt) {
        s   = String(s);
        opt = Object(opt);

        var defaults = {
            'delimiter': '-',
            'limit': undefined,
            'lowercase': true,
            'replacements': {},
            'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
        };

        for (var k in defaults) {
            if (!opt.hasOwnProperty(k)) {
                opt[k] = defaults[k];
            }
        }

        var char_map = {
            'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
            'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
            'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
            'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
            'ß': 'ss',
            'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
            'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
            'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
            'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
            'ÿ': 'y',

            '©': '(c)',

            'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
            'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
            'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
            'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
            'Ϋ': 'Y',
            'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
            'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
            'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
            'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
            'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

            'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
            'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g',

            'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
            'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
            'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
            'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
            'Я': 'Ya',
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
            'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
            'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
            'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
            'я': 'ya',

            'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
            'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

            'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U',
            'Ž': 'Z',
            'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
            'ž': 'z',

            'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z',
            'Ż': 'Z',
            'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
            'ż': 'z',

            'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N',
            'Š': 'S', 'Ū': 'u', 'Ž': 'Z',
            'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
            'š': 's', 'ū': 'u', 'ž': 'z'
        };

        for (var k in opt.replacements) {
            s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
        }

        if (opt.transliterate) {
            for (var k in char_map) {
                s = s.replace(RegExp(k, 'g'), char_map[k]);
            }
        }
        var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
        s = s.replace(alnum, opt.delimiter);
        s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);
        s = s.substring(0, opt.limit);
        s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');

        return opt.lowercase ? s.toLowerCase() : s;
    }
    this.validar_numero = function (id) {
        this.tab_content_active().find(id).validCampoAPP('0123456789.');
    }
    this.validar_telefono = function (id) {
        this.tab_content_active().find(id).validCampoAPP('0123456789#*-');
    }
    this.validar_decimal = function (id) {
        this.tab_content_active().find(id).validCampoAPP('0123456789.');
    }
    this.validar_fecha = function (id) {
        this.tab_content_active().find(id).validCampoAPP('0123456789/');
    }
    this.validar_hora = function (id) {
        this.tab_content_active().find(id).validCampoAPP('0123456789:');
    }
    this.Validar_Funcion = function (id) {
        this.tab_content_active().find(id).validCampoAPP('0123456789.*+-/()^');
    }
    this.change_theme = function (id)
    {
        obj_funciones.inicio_ajax();
        $(".container-fluid,nav,#menunav").css("display","none");
        $('link').each(function(){
            if($(this).attr('role') == 'theme'){
                url = base_url+"backend/assets/bootstrap/css/"+(id.toLowerCase())+".min.css";
                $(this).attr('href',url);
            }
        });
        setTimeout(function(){
            $(".container-fluid,nav,#menunav").css("display","block");
        },1500);
    }
    this.getajaxsimple = function(objeto){
        var datta = [];//$.extend($("#form"), {'session': false}).serialize()
        if(objeto == undefined) objeto = {};
        if(objeto.url == undefined) objeto.url = base_url;
        if(objeto.data == undefined) objeto.data = {};
        if(objeto.async == undefined) objeto.async = false;
        if(objeto.session == undefined) objeto.session = true;
        if(objeto.datatype == undefined) objeto.datatype = 'json';
        $.ajax({
            type : 'POST',
            url : objeto.url,
            data: objeto.data,
            cache : false,
            async : objeto.async,
            dataType : objeto.datatype,
            success: function(data){
                if(objeto.session != undefined && objeto.session && data.verysession != undefined && data.verysession == 0) obj_funciones.session_expirada();
                else datta = data;
            }
        });
        return datta;
    }
    this.getajaxasync = function(objeto){
        var datta = [];
        if(objeto == undefined) objeto = {};
        if(objeto.url == undefined) objeto.url = base_url;
        if(objeto.data == undefined) objeto.data = {};
        if(objeto.session == undefined) objeto.session = true;
        if(objeto.datatype == undefined) objeto.datatype = 'json';
        $.ajax({
            type : 'POST',
            url : objeto.url,
            data: objeto.data,
            cache : false,
            async : true,
            dataType : objeto.datatype,
            success: function(data){
                if(objeto.session && data.verysession !== undefined && data.verysession == 0) obj_funciones.session_expirada();
                datta = data;
            }
        });
        var myVar = setInterval(function(){
            if(datta.length > 0){
                clearInterval(myVar);
                return datta;
            }
        }, 1000);      
    }
    this.session_expirada = function (objeto){
        if(objeto == undefined) objeto = {};
        if(objeto.text == undefined) objeto.text = 'Lo sentimos pero su Sesión a Expirado, intente Iniciar Sesión Nuevamente';
        this.modalmsj({
            title : "Advertencia!",
            text : objeto.text,
            type: "warning",
            showCancelButton : false,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Salir del Sistema",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false,
            funcion : function(isConfirm){
                if (isConfirm) {
                    window.location = base_url + 'panel/salir';
                }
            }
        });
    }


    this.clearalertmodal = function(div){
        obj_funciones.tab_content_active().find('#modaldiv').scrollTop(0); 
        obj_funciones.tab_content_active().find(div).html('');
    }
    this.getprogressbar = function(){
        var xhr =  $.ajaxSettings.xhr();    
        //Upload Progress
         xhr.upload.addEventListener("progress", function(evt) {
          var hidden = $('.progress-bar').parents('.hidden').first();
          hidden.removeClass('hidden').attr('id','hidden_progressbar');
          if (evt.lengthComputable) {
              var percent = (evt.loaded / evt.total) * 100;
              var valor   = Math.round(percent);
              $('.progress-bar').attr('aria-valuenow',valor);
              $('.progress-bar').attr('style',"width: "+valor+"%;");
              $('.progress-bar').html(valor+"%");
          }
      }, false);

    //Download progress
     xhr.addEventListener("load", function(evt) {
          $('.progress-bar').attr('aria-valuenow',0);
          $('.progress-bar').attr('style',"width: 0%;");
          $('.progress-bar').html("0%");
          var hidden = $('#hidden_progressbar');
          hidden.addClass('hidden').removeAttr('id');
      }, false);

      xhr.addEventListener("error", function(evt) {
          console.log("Error al subir el archivo.");
      }, false);
      xhr.addEventListener("abort", function(evt) {
          console.log("El archivo a subir ha sido abortado.");
      }, false);

    return xhr;
    }

    this.resizablewindow = function(){
        var height = $(window).height();
        var width = $(window).width();
        $('.tab-content').css({
            'min-height': (height-260)+'px'
        });
    }
   
    this.eliminarurl = function (str,id){
        var valor = str.replace(base_url, "");
        this.tab_content_active().find(id).val(valor);
    }

    this.getdatatable = function(div, url, id){
            table = $('#'+div).DataTable({ 
            responsive: true,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
     
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url+url,
                "type": "POST",
                 "data": {
                            "id": id
                         }
            },
     
            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [0], //last column
                //"targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],
        });
    }

    this.reload_table = function ()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
        $("#seleccionartodos").prop("checked", "");
    }

    this.editortinymce = function (div){
        tinymce.init({ 
            selector: div,
            language : "es",
            height : 200,
            // file_browser_callback_types: 'file image media',
        });
    }

}
var obj_funciones = new class_funciones();
