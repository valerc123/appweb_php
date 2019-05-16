<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $modulo ?> | <?php echo $descripcion?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("incluidos/css.php");?>
</head>

<body>

 
    <?php include("incluidos/aside.php") ?>
        <div class="all-content-wrapper">
    <?php include("incluidos/menu.php") ?>
    <?php include("incluidos/menu.movil.php") ?>
    <?php include("incluidos/menu.movi.fin.php") ?>
    </div>

    <div class="breadcome-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <span id="mensaje_carrito" class="btn btn-info">
                        El pedido va en 
                    </span>
                </div>
            </div>
        </div>
    </div>
   
<?php 
$atributos=array("id"=>"formapedidos","name"=>"formapedidos");
echo form_open('pedidos/agregar/', $atributos);
?>

<div id="example-basic">
    <h3>Shopping Cart</h3>
    <section>
        <h3 class="product-cart-dn">Shopping</h3>
        <div class="product-list-cart">
            <div class="product-status-wrap border-pdt-ct">
                <table>
                    <tr>
                        <th>Imagen</th>
                        <th>Referencia</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                        <th>Impuestos</th>
                        <th>Subtotal</th>
                        <th>Opciones</th>
                    </tr>
                    <?php 
                    $i=0;
                    foreach ($listaproductos as $fila) {
                        $i++;
                    ?>
                    <tr>
                        <td>
                            <?php
                                if($fila["foto1"]<>""){
                                     ?>
                                     <img src="<?php echo base_url(); ?>/assets/uploads/productos/<?php echo $fila["foto1"]?>" style="width:10px;">
                             <?php   }  ?>
                            
                        </td>
                        <td>
                            <h3><?php echo $fila["ref"] ?> </h3>
                            <p><?php echo$fila["nombre"]?></p>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="cant_<?php echo $i; ?>" id="cant_<?php echo $i; ?>"  maxlength="4" style="width: 60px" onblur="calcular('<?php echo $i?>');">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="valor_<?php echo $i; ?>" id="valor_<?php echo $i; ?>"  value="<?php echo$fila["precio"] ?>" maxlength="10" style="width: 100px"  onblur="calcular('<?php echo $i ?>');">
                        </td>
                         <td>
                            <input type="number" class="form-control" name="impuesto_<?php echo $i; ?>" id="impuesto_<?php echo $i; ?>" value="<?php echo$fila["iva"] ?>"  maxlength="2" style="width: 60px"  onblur="calcular('<?php echo $i ?>');">
                        </td>
                         <td>
                            <input type="number" class="form-control" name="subtotal_<?php echo $i; ?>" id="subtotal_<?php echo $i; ?>" readonly style="width: 200px; color: #000 !important">
                        </td>
                        <td>
                            <button data-toggle="tooltip" title="Adicionar" onclick="agregar('<?php echo $i; ?>',1)" type="button" class="pd-setting-ed"><i class="fa fa-pencil-square-o"></i></button>

                            <button  type="button" onclick="agregar('<?php echo $i; ?>',2)" data-toggle="tooltip" title="Eliminar" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                            <input type="hidden" name="ref_<?php echo $i ?>" id="ref_<?php echo $i ?>" value="<?php echo $fila["ref"] ?>">

                           <input type="hidden" name="token_<?php echo $i ?>" id="token_<?php echo $i ?>" value="<?php echo $token ?>">
                           <span id="mensaje_<?php echo $i;?>"></span>
                        </td>
                    </tr>

                <?php  } ?>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th colspan="3">
                                DATOS DEL CLIENTE
                                <select name="cliente" id="cliente" class="form-control" onchange="cargarcliente();">
                                    <option value="">Seleccione...</option>
                                    <?php 
                                        foreach ($listadoclientes as $fila)  {?>
                                          <option value="<?php echo $fila["id"];?>"><?php echo $fila["nombre"]." ".$fila["comercial"];?></option>
                                       <?php } ?>
                                </select>
                                <span id="mensajes_cliente"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="nit" id="nit" placeholder=" Digite el nit" required maxlength="50">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder=" Digite el nombre" required maxlength="50">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="comercial" id="comercial" placeholder=" Digite el nombre comercial" required maxlength="50">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="email" class="form-control" name="correo" id="correo" placeholder=" Digite el correo" required maxlength="100">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="telefono" id="telefono" placeholder=" Digite el telefono" required maxlength="50">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="direccion" id="direccion" placeholder=" Digite la direccion"  maxlength="255">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <button class="btn btn-info" name="enviar" id="enviar">
                                    GENERAR PEDIDO
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


</form>
    <!--Pie de página-->    
    <?php include("incluidos/footer.php") ?>
    
    <?php include("incluidos/js.php") ?>

</body>

</html>
<script type="text/javascript">
    /*
        funciones que permiten calcular el subtotal y funciones de agregar y eliminar productos del pedido
        para calcular tomamos la posicion para agregar y eliminar usamos AJAX para realizar el proceso de modo en paralelo
    */

    function calcular(pos){
        //capturar los id de cant, iva, precio y subtotal para realizar operaciones
        $("#subtotal_"+pos).val(0);
        var cant=$("#cant_"+pos).val();
        var precio=$('#valor_'+pos).val();
        var iva=$('#impuesto_'+pos).val();

        if(cant>0 && precio > 0 && iva>=0){
            subtotal=eval(cant*precio) + (cant*precio*(iva/100)); 
        }
        $("#subtotal_"+pos).val(subtotal);
    }


//funcion agregar que captura la ruta desde el action del formulario y pasamos los parametros al controlador pedidos/agregar
//el metodo agregar recibirá  un tipo 
// 1 = que agregue
//2= que elimine
// el tipo se pasa de acuerdo a la funcion que se invoque en este caso. Agregar sera 1 eliminar sera 2

function agregar(pos, tipo){
    var ruta = $('#formapedidos').attr('action');
    //los parametros los vamos a pasar en un array
    var cant=$("#cant_"+pos).val();
    var precio=$('#valor_'+pos).val();
    var iva=$('#impuesto_'+pos).val();
    var subtotal=$("#subtotal_"+pos).val();
    var ref=$('#ref_'+pos).val();
    var token=$('#token_'+pos).val();

    if(subtotal <= 0){
        mensaje="<span class='btn btn-danger'>El subtotal debe ser mayor de cero</span>";

        $("#mensaje_"+pos).html(mensaje);
        $("#mensaje_"+pos).fadeOut(5000);
        return;
    }

    //invocar la funcion ajax que nos permite cargar el controlador y la funcion que esta en el action del formulario (pedidos/agregar)

    //1. preparar los datos para ajax
    // los datos se deben pasar como un array o vector 

    parametros = {
        "cant" : cant,
        "precio" : precio,
        "iva": iva,
        "subtotal": subtotal,
        "ref" : ref,
        "token" : token,
        "tipo": tipo
    };

    //2. la ruta o url ya esta capturda en la parte de arriba
    //3. definir el metodo de transporte post o get
    type="POST";
    //4. invocar el ajax
    $.ajax({

        data: parametros,
        url: ruta,
        type: type,
        beforesend : function()
        {
            $("#mensaje_"+pos).html("<span class='btn btn-warning'>Procesando...</span>");
            $("#mensaje_"+pos).show();
        },
        // el success siempre devuelve una respuesta en este caso por memotecnia se llama response
        success: function(response)
        {
                $("#mensaje_"+pos).show();
                if(tipo ==1) txt="Agregado";
                if(tipo ==2) txt="Eliminado";
                $("#mensaje_" + pos).html("<span class='btn btn-success'>"+txt+"</span>");
                $("#mensaje_" + pos).fadeOut(5000);
                $("#mensaje_carrito").html(response);


        },
        //capturar el error y mostrar en la capa mensaje
        error: function(jqXHR,textStatus,errorThrown)
        {
            $("#mensaje_"+pos).html("<span class='btn btn-danger'>Error al procesar: " + textStatus+"," + errorThrown+ "</span>");
            $("#mensaje_"+pos).show();
        }

    });
}
//funcion que emvia el id del cliente, consulta y devuelve los datos en formato JSON
function cargarcliente(){
    var ruta = $("#formapedidos").attr("action");
    ruta=ruta.replace("agregar","cargarcliente");
    parametros={
        "cliente" :$("#cliente").val()
    }
    $.ajax({
        data: parametros,
        type: "POST",
        url: ruta,
        beforesend: function(){
            $("#mensajes_cliente").html("<span class='btn btn-danger'> Procesando...</span>");
            $("#mensajes_cliente").show();
        },
        success : function(response){
                 $("#mensajes_cliente").hide();
                 //aplicar parse para leer un vector o array en JSON
                 data=JSON.parse(response);
                 $("#nombre").val(data[0].nombre);
                 $("#comercial").val(data[0].comercial);
                 $("#telefono").val(data[0].telefono);
                 $("#direccion").val(data[0].direccion);
                 $("#nit").val(data[0].nit);
                 $("#correo").val(data[0].correo);


        },
        error : function(jqXHR, textStatus,errorThrown) {
            $("#mensajes_cliente").html("<span class='btn btn-danger'>Error al procesar: " + textStatus+"," + errorThrown+ "</span>");
            $("#mensajes_cliente").show();
        }
    })
}
</script>