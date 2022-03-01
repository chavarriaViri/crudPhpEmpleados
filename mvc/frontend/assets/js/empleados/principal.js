function VerCondiciones(elemento) {
    $('#dialog1').show();
    $('#elemento').html(elemento)
                    setTimeout(function(){
                         $('#dialog1').hide();
                     },1800);
    //console.log(elemento);
 }


$(document).ready(function(){

    $(document).on('click','#btn_agregar_empleado',function(){ //Lo ejecuta cuando se da click por medio del id de boton
        Empleados.mostrar_formulario_empleado(); //Variable Empleados.nombre de la funcion()
        
        $('#btn_reiniciar_form').trigger('click'); //para reiniciar el formulario
        $('#tbody_listado_datos_contacto').html(''); //listado de contactos vacio
        $('#campo_id_empleado').remove();
    });
       
    $(document).on('click','#btn_cancelar_registro_empleado',function(){
        Empleados.mostrar_tablero_empleado();
    });
    
    $(document).on('click','#btn_guardar_empleado',function(){
        if(Empleados.validar_formulario_empleado()){ //Si la validacion ocurre bien
            var actualizar = $('#campo_id_empleado').length != 0 ? true : false;
            Empleados.guardar_empleado(actualizar);
        }
     });

    $(document).on('click','#btn_agregar_row_contacto',function(){ //agregar un nuevo renglon para el dato de contacto
        Empleados.agregar_row_dato_contacto();
    });
    
    $(document).on('click','.btn_eliminar_dato_contacto',function(){
        $(this).closest('tr').remove(); //eliminar fila
    });

    $(document).on('click','.btn_modificar_empleado',function(){
        //obtener el empleado codificador y convertirlo a un objeto json con atob
        var empleado = JSON.parse(atob($(this).data('str_empleado')));
        //setear los datos del empleado al formulario de registro
        var input_id_empleado = '<input type="hidden" id="campo_id_empleado" name="id_empleado" value="'+empleado.id+'">';
        $('#form_empleado').append(input_id_empleado);
        $('#campo_nombre').val(empleado.nombre);
        $('#campo_paterno').val(empleado.paterno);
        $('#campo_materno').val(empleado.materno);
        $('#campo_direccion').val(empleado.direccion);
        $('#campo_fecha_nacimiento').val(empleado.fecha_nacimiento);
        $('#campo_estado_civil').val(empleado.estado_civil);
        $('#campo_seguro_social').val(empleado.seguro_social);
        //terna para la opcion de genero
        empleado.genero == 'H' ? $('#campo_genero_h').attr('checked',true) : $('#campo_genero_m').attr('checked',true);
        //actualizar los datos de contacto
        var contador_dc = 0;
        $('#tbody_listado_datos_contacto').html('');
        empleado.datos_contacto.forEach(function (elemento){
            Empleados.agregar_row_dato_contacto();//para agregar el renglon
            var renglon = $('#tbody_listado_datos_contacto').find('tr')[contador_dc];
            $(renglon).find('select.campo_catalogo_tipo_contacto').val(elemento.catalogo_tipo_contacto_id);
            $(renglon).find('input.campo_dato_contacto').val(elemento.dato_contacto);
            contador_dc++; //para incremetar la busqueda del siguiente renglos
        });

        $('#datos_contacto').fadeOut();
        
        
        $('#contenedor_tablero_empleado').fadeOut();
        $('#contenedor_formulario_empleado').fadeIn(); 
        $('#contenedor_form1').fadeIn();
        $('#contenedor_form2').fadeOut();
       
       
    });

    $(document).on('click','.btn_modificar_empleado2',function(){
        //obtener el empleado codificador y convertirlo a un objeto json con atob
        var empleado = JSON.parse(atob($(this).data('str_empleado')));
        //setear los datos del empleado al formulario de registro
        var input_id_empleado = '<input type="hidden" id="campo_id_empleado" name="id_empleado" value="'+empleado.id+'">';
        $('#form_empleado').append(input_id_empleado);
        // $('#campo_nombre').val(empleado.nombre);
        // $('#campo_paterno').val(empleado.paterno);
        // $('#campo_materno').val(empleado.materno);
        // $('#campo_direccion').val(empleado.direccion);
        // $('#campo_fecha_nacimiento').val(empleado.fecha_nacimiento);
        // $('#campo_estado_civil').val(empleado.estado_civil);
        // $('#campo_seguro_social').val(empleado.seguro_social);
        // //terna para la opcion de genero
        // empleado.genero == 'H' ? $('#campo_genero_h').attr('checked',true) : $('#campo_genero_m').attr('checked',true);
        // //actualizar los datos de contacto
        var contador_dc = 0;
        $('#tbody_listado_datos_contacto').html('');
        empleado.datos_contacto.forEach(function (elemento){
            Empleados.agregar_row_dato_contacto();//para agregar el renglon
            var renglon = $('#tbody_listado_datos_contacto').find('tr')[contador_dc];
            $(renglon).find('select.campo_catalogo_tipo_contacto').val(elemento.catalogo_tipo_contacto_id);
            $(renglon).find('input.campo_dato_contacto').val(elemento.dato_contacto);
            contador_dc++; //para incremetar la busqueda del siguiente renglos
        });
        $('#contenedor_tablero_empleado').fadeOut();
        $('#contenedor_formulario_empleado').fadeIn(); 
        $('#contenedor_form1').fadeOut();
        $('#contenedor_form2').fadeIn();
      
    });

    $(document).on('click','.btn_eliminar_empleado',function(){
        //obtener el id del empleado que esta en el data id_empleado del boton
        var id_empleado = $(this).data('id_empleado');
        var confirmacion = confirm('¿Esta seguro de eliminar el empleado?');
        if(confirmacion){
            Empleados.eliminar(id_empleado);
        }
    });

    Empleados.listado_empleados();
});

//variable que sera tratada como una clase en programacion
var Empleados = {

    mostrar_formulario_empleado : function(){ //mostrar fomulario en tablero cuando se le de en el boton agregar
        $('#contenedor_tablero_empleado').fadeOut();//hide() - JS se esconda  el tablero
        $('#contenedor_formulario_empleado').fadeIn();//show() - JS se muestre
        $('#contenedor_form1').fadeIn();
        $('#contenedor_form2').fadeIn();
    },

    esconder_formulario_contacto : function(){
       
        $('#datos_contacto').fadeOut();
    },

    esconder_formulario_empleado : function(){
       
         $('#contenedor_formulario_empleado').fadeOut();
    },

    mostrar_formulario_contacto : function(){
        $('#contenedor_tablero_empleado').fadeOut();//hide() - JS se esconda  el tablero
        $('#datos_contacto_empleado').fadeIn();
    },

    mostrar_tablero_empleado : function(){ //Para cuando se de en el boton cancelar se muestre el tablero
        $('#contenedor_tablero_empleado').fadeIn();//hide() - JS
        $('#contenedor_formulario_empleado').fadeOut();//show() - JS
        $('#btn_agregar_empleado').fadeIn();
    },

    listado_empleados :function(){ 
        $('#tbodyTableroEmpleados').html('<tr><td colspan="6" style="text-align: center"><span class="spinner-border"></span>Procesando Datos</td></tr>');
        $.ajax({
            type : 'post',
            url : URL_BACKEND + 'peticion=empleados&funcion=listado', // url de consumo del servicio
            data : {},
            dataType : 'json',
            success : function(respuestaAjax){
                if(respuestaAjax.success){
                    var html_listado_empleados = '';
                    respuestaAjax.data.empleados.forEach(function(empleado){
                        var stringEmpleado = btoa(JSON.stringify(empleado));//almacenar los datos del empleado(para modificar)
                        var html_datos_contacto_empleado = '';
                        empleado.datos_contacto.forEach(function(contacto){//iterar los datos de contacto
                            html_datos_contacto_empleado += '<li>'+contacto.dato_contacto+'</li>';
                        });
                        html_listado_empleados += '<tr>' +
                                '<td>'+empleado.id+'</td>' +
                                '<td>'+empleado.nombre +' '+empleado.paterno+ ' '+empleado.materno+'</td>' +
                                '<td>'+empleado.direccion+'</td>' +
                                '<td>'+empleado.fecha_nacimiento+'</td>' +
                                '<td>'+html_datos_contacto_empleado+'</td>' +
                                '<td>' +
                                    '<button type="button" data-str_empleado="'+stringEmpleado+'" class="btn btn-outline-warning btn-sm btn_modificar_empleado" style ="margin-right:10px"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></button>' +
                                    '<button type="button" data-str_empleado="'+stringEmpleado+'" class="btn btn-outline-primary btn-sm  btn_modificar_empleado2" style ="margin-right:10px"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg></button>' +
                                    '<button type="button" data-id_empleado="'+empleado.id+'" class="btn btn-outline-danger btn-sm bi btn_eliminar_empleado" style="margin-left:10px padding: 10px;"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg></button>' +
                                    
                                    '</td>' +
                            '</tr>';
                    });
                    $('#tbodyTableroEmpleados').html(html_listado_empleados);
                }else{
                    var html_msg_error = '<div class="alert alert-warning">';
                    respuestaAjax.msg.forEach(function(elemento){ //msg la variable viene del backend
                        html_msg_error += '<li>'+elemento+'</li>';
                    });
                    html_msg_error += '</div>';
                    $('#mensajes_sistema').html(html_msg_error);
                    setTimeout(function(){
                        $('#mensajes_sistema').html('');//lo reinicie a cadena vacia
                    },5000);
                }
            },error : function(error){
                console.log(error);
                alert('error en el catalogo');
            }
        });
    },

    validar_formulario_empleado : function(){
        var validacion = $('#form_empleado').validate({});
        validacion.form();
        var resultado = validacion.valid();
        return resultado;
    },

    guardar_empleado : function(actualizar = false){ //funcion sobrecargada
        var url = actualizar ? URL_BACKEND + 'peticion=empleados&funcion=actualizar' : URL_BACKEND + 'peticion=empleados&funcion=agregar';
        $.ajax({
            type : 'post',
            url : url, // url de consumo del servicio,
            data : $('#form_empleado').serialize(), //Se serializa el formulario para mandar los datos al backend
            // data : { //forma manual, sin serialize()
            //     nombre : $('#campo_nombre').val(),
            //     paterno : $('#campo_paterno').val(),
            // }
            dataType: 'json',
            success : function(respuestaAjax){
                if(respuestaAjax.success){ //Si la respuesta es satisfactoria
                    Empleados.listado_empleados();
                    Empleados.mostrar_tablero_empleado();
                }
                    var html_msg_error = '<a>';
                    
                    respuestaAjax.msg.forEach(function(elemento){
                        html_msg_error += VerCondiciones(elemento);
                    });
                                       
                    html_msg_error += '</a>';
                    
            },error : function(error){
                Empleados.listado_empleados();
                Empleados.mostrar_tablero_empleado();
            }
        });
    },

    agregar_row_dato_contacto : function(){ 
        var numero_datos_contacto = $('#tbody_listado_datos_contacto').find('tr').length; //busqueda de renglones y contar
        var html_row_dato_contacto = '<tr>' +
                '<td>' +
                    '<select class="form-select campo_catalogo_tipo_contacto" required name="listado_datos_contacto['+numero_datos_contacto+'][catalogo_tipo_contacto_id]">' +
                        Catalogos.html_catalogos+
                    '</select>' +
                '</td>' +
                '<td><input type="text" class="form-control campo_dato_contacto" required name="listado_datos_contacto['+numero_datos_contacto+'][dato_contacto]" placeholder="Ingresa el dato de contacto"></td>' +
                '<td><button type="button" class="btn btn-outline-danger btn-sm btn_eliminar_dato_contacto">Eliminar</button></td>' +
            '</tr>';
        $('#tbody_listado_datos_contacto').append(html_row_dato_contacto); //añadir, el html que esta y agregarlo al final antes de la etiqueta de cierre
    },

    eliminar : function(id_empleado){
        $.ajax({
            type : 'post',
            url : URL_BACKEND + 'peticion=empleados&funcion=eliminar',
            data : {
                id : id_empleado
            },
            dataType : 'json',
            success : function(respuestaAjax){
                if(respuestaAjax.success){
                    Empleados.listado_empleados();
                }
                var html_msg_error = '<div>';
                respuestaAjax.msg.forEach(function(elemento){
                    html_msg_error += VerCondiciones(elemento);
                });
                html_msg_error += '</div>';
            },error : function(error){
                alert('Ocurrio un error en la peticion');
            }
        });
    }
}