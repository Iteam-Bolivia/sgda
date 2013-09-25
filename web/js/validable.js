// JavaScript Document 
// Validate with jquery version 1.3
// more validations added and uses name instead if div
var filters = {
    required: function(el) {
        if($(el).val() != '' && $(el).val() != -1){
            return true;
        }else{
            $.msgbox("Error: Debe completar los datos. \n O existen caracteres invalidos!");
            return false;
        }
    },
    email: function(el) {
        res =  /^[A-Za-z\.][A-Za-z0-9_\.]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/.test($(el).val());
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese un formato de email correcto");
            return false;
        }
    },
    phone: function(el){
        res =  /^[0-9 -]*$/.test($(el).val());
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese telefono correcto");
            return false;
        }
    },
    numeric: function(el){
        res = /^[0-9 \,.]*\.?[0-9]*$/.test($(el).val()); 
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese valor numerico con puntos decimales");
            return false;
        }
    },
    //alpha: function(el){res = /^[a-zA-Z áéíóúÁÉÍÓÚÑñ\.,;:\|)(º_@><#&\'\"\?¿¡!/\%\-]*$/.test($(el).val());
    alpha: function(el){
        res = /^[a-zA-Z Ññ\.,;:\|)(º_@><#&\?¿¡!/\%\-\+]*$/.test($(el).val());
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese solo letras, no caracteres especiales ni acentos");
            return false;
        }
    },
    //alphanum: function(el){res = /^[a-zA-Z0-9 áéíóúÁÉÍÓÚÑñ\.,;:\|)(º_@><#&\'\"\?¿¡!/\%\-]*$/.test($(el).val());
    alphanum: function(el){
        res = /^[a-zA-Z0-9 Ññ\.,;:\|)(º_@><#&\?¿¡!/\%\-\+]*$/.test($(el).val());
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese solo letras y numeros, no caracteres especiales ni acentos");
            return false;
        }
    },
    //alphanumeric: function(el){res = /^[a-zA-Z0-9 áéíóúÁÉÍÓÚÑñ\.,;:\|)(º_@><#&\'\"\?¿¡!/\%\-]*$/.test($(el).val());
    alphanumeric: function(el){
        res = /^[a-zA-Z0-9 Ññ\.,;:\|)(º_@><#&\?¿¡!/\%\-\+]*$/.test($(el).val());
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese solo letras y numeros, no caracteres especiales ni acentos");
            return false;
        }
    },
    pin: function(el){
        return /^[a-zA-Z0-9]*$/.test($(el).val());
    },
    onlynumeric: function(el){
        res = /^[0-9]*$/.test($(el).val());
        if(res || $(el).val() == ''){
            return true;
        }else{
            $.msgbox("Error de validacion del campo: \nIngrese un valor entero");
            return false;
        }
    }
};	
$.extend({
    /* PARAMOS LA EJECUCIÓN*/
    stop: function(e){
        if (e.preventDefault) e.preventDefault();
        if (e.stopPropagation) e.stopPropagation();
    }, 
    /* PERSONALIZAMOS LA SALIDA POR PANTALLA */
    alert: function(str) {
        $.msgbox(str);	
    }
});