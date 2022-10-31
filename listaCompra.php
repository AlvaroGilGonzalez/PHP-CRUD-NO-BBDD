<!DOCTYPE html>
<html lang="es">
<!--Ejercicio Realizado por Álvaro Gil Gonzalez.-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilo.css">
    <link rel="stylesheet" href="estilos/bootstrap.min.css">
    <title>Lista de la compra</title>
</head>

<body>

    <h1>Lista de la compra</h1>

    <?php
        //Incluimos el archivo donde estan todas las funciones
        include "funciones.php";

        //Si tenemos informacion en el input hidden la guardamos en el array, si no lo creamos vacio
        if(!empty($_POST['listaCompra'])){
            $elementos=explode(",",$_POST['listaCompra']);
           }else{
            $elementos=array();
        }

    ?>

    <form method="post" action="">
        <div class="contenido">
            <?php

                //---------------ACCION DE INSERTAR ELEMENTO------------------------------
                if(isset($_POST['insertar'])){
                    mostrar_formulario_insertar();
                    mostrar_lista($elementos);
                }

                if(isset($_POST['insertarElemento'])){
                    $error=false;
                    $elementos=insertar_elementos($_POST['nombre'],$_POST['cantidad'],$_POST['precio'],$elementos,$error);
                    if($error){
                        echo '<p class="error">No se ha podido insertar el elemento</p>';
                    }else{
                        echo '<p class="completado">La insercion se ha realizado correctamente</p>';
                    }
                }

                //---------------ACCION DE MOSTRAR ELEMENTO------------------------------
                if(isset($_POST['mostrar'])){
                    mostrar_lista_completa($elementos);
                }

                //---------------ACCION DE MODIFICAR ELEMENTO------------------------------
                if(isset($_POST['modificar'])){
                    mostrar_lista($elementos);
                    if(!empty($elementos)){
                        mostrar_formulario_modificar();
                    }else{
                        echo '<p class="error">No es posible modificar ningun elemento</p>';
                    }
                }

                if(isset($_POST['modificarElemento'])){
                    $elemento_existe=comprobar_nombre_existe_lista($_POST['nombreOriginal'],$elementos);
                    //Debemos comprobar si el nombre del elemento que se desea modificar existe
                    if($elemento_existe){
                        $error=false;
                        $elementos=modificar_registro($_POST['nombreOriginal'],$_POST['nombreModificar'],$_POST['cantidadModificar'],$_POST['precioModificar'],$elementos,$error);
                        if($error){
                            echo '<p class="error">El campo nombre a modificar no puede estar vacio</p>';
                        }else{
                            echo '<p class="completado">Se ha realizado la modificacion correctamente</p>';
                        }
                    }else{
                        echo '<p class="error">El nombre original introducido no existe en la lista, por tanto no se puede modificar</p>';
                    }
                }

                //---------------ACCION DE ELIMINAR ELEMENTO------------------------------
                if(isset($_POST['eliminar'])){
                    mostrar_lista($elementos);
                    if(!empty($elementos)){
                        mostrar_formulario_eliminar();
                    }else{
                        echo '<p class="error">No es posible eliminar ningun elemento</p>';
                    }

                }

                if(isset($_POST['eliminarElemento'])){
                    $error=false;
                    $elementos=eliminar_registro($elementos,$_POST['nombreEliminar'],$error);
                    if($error){
                        mostrar_lista($elementos);
                        echo '<p class="error">No ha sido posible eliminar ningun elemento con el nombre introducido</p>';
                    }else{
                        echo '<p class="completado">Se ha eliminado el registro correctamente</p>';
                    }
                }
            ?>
        </div>

        <!--MENU PRINCIPAL CON LOS BOTONES DE LAS ACCIONES POSIBLES-->
        <div class="menuPrincipal">
            <input type="submit" name="insertar" value="Insertar Elementos">
            <input type="submit" name="modificar" value="Modificar Elementos">
            <input type="submit" name="eliminar" value="Eliminar Elementos">
            <input type="submit" name="mostrar" value="Mostrar Elementos">
        </div>

        <input name="listaCompra" type="hidden" value="<?php if (isset($elementos)) echo implode(",",$elementos);?>">

    </form>

</body>

</html>