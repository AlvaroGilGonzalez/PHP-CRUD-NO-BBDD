<?php

    //---------------FUNCIONES PARA LA ACCION DE INSERTAR------------------------------

    function mostrar_formulario_insertar(){
        echo '<label>Introduzca el nombre del producto</label>
            <input type="text" name="nombre" class="form-control">
            <label>Introduzca la cantidad del producto</label>
            <input type="text" name="cantidad" class="form-control">
            <label>Introduzca el precio del producto</label>
            <input type="text" name="precio" class="form-control">
            <input type="submit" name="insertarElemento" value="Insertar Elemento" class="submit">
            ';
    }

    function insertar_elementos($nombre,$cantidad,$precio,$lista,&$error){
        if(!empty($nombre)){

            array_push($lista,$nombre);

            if(is_numeric($cantidad)){
                array_push($lista,$cantidad);
            }else{
                array_push($lista,' ');
            }

            if(is_numeric($precio)){
                array_push($lista,$precio);
            }else{
                array_push($lista,' ');
            }

            $error=false;
            mostrar_lista($lista);
            return $lista;

        }else{
            $error=true;
            return $lista;
        }
    }

    //---------------FUNCIONES PARA LA ACCION DE MOSTRAR LISTA COMPLETA------------------------------

    function mostrar_lista_completa($lista){
        if(!empty($lista) && count($lista)>=3){
            $fila1="<table><th>Nombre</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th></tr>";
            $filas="";
            for($i=0;$i<count($lista);$i+=3){
                $filas.="<tr><td>".$lista[$i]."</td><td>".$lista[$i+1]."</td><td>".$lista[$i+2]."</td><td>".Calcular_Precio_Total_Producto($lista[$i+1],$lista[$i+2])."</td></tr>";
            }
            $filas.="<tr><td colspan='3' class='precioTotal'>Precio Total de la compra</td><td class='precioTotal'>".Calcular_Precio_Total_Compra($lista)."</td></tr>";
            $filas.="</table>";
            echo $fila1.$filas;
            echo'<br><br><br>';
        }else{
            echo '<p class="error">No se puede mostrar la lista ya que no hay ningun elemento almacenado</p>';
        }
    }

    function Calcular_Precio_Total_Producto($cantidad,$precio){
        if(is_numeric($cantidad) && is_numeric($precio)){
            return $cantidad*$precio;
        }else{
            return ' ';
        }
    }

    function Calcular_Precio_Total_Compra($lista){
        $sumatorio=0;
        for($i=0;$i<count($lista);$i+=3){
            if(is_numeric($lista[$i+1])&& is_numeric($lista[$i+2])){
                 $sumatorio+=Calcular_Precio_Total_Producto($lista[$i+1],$lista[$i+2]);
            }

        }
        return $sumatorio;
    }

    //---------------FUNCIONES PARA LA ACCION DE MODIFICAR------------------------------

    function mostrar_formulario_modificar(){
        echo '
            <label>Introduzca el nombre del producto que desea modificar</label>
            <input type="text" name="nombreOriginal" class="form-control">
            <label>Introduzca el nuevo nombre del producto (Si desea mantener el nombre original escríbalo de nuevo)</label>
            <input type="text" name="nombreModificar" class="form-control">
            <label>Introduzca la nueva cantidad del producto</label>
            <input type="text" name="cantidadModificar" class="form-control">
            <label>Introduzca el nuevo precio del producto</label>
            <input type="text" name="precioModificar" class="form-control">
            <input type="submit" name="modificarElemento" value="Modificar Elemento" class="submit">
            ';
    }

    function modificar_registro($nombreOriginal,$nombre,$cantidad,$precio,$lista,&$error){
        $posicion=array_search($nombreOriginal,$lista);
        if(!empty($nombre)){
            $lista[$posicion]=$nombre;
            if(!empty($cantidad)){
                $lista[$posicion+1]=$cantidad;
            }
            if(!empty($precio)){
                $lista[$posicion+2]=$precio;
            }
            $error=false;
            mostrar_lista($lista);
            return $lista;
        }else{
            $error=true;
            return $lista;
        }
    }

    //---------------FUNCIONES PARA LA ACCION DE ELIMINAR------------------------------

    function mostrar_formulario_eliminar(){
        echo '
             <label>Introduzca el nombre del producto a eliminar</label>
            <input type="text" name="nombreEliminar" class="form-control">
            <input type="submit" name="eliminarElemento" value="EliminarProducto" class="submit">
            ';
    }

    function eliminar_registro($lista,$nombre,&$error){
        if(in_array($nombre,$lista)){
            $posicion=array_search($nombre,$lista);
            unset($lista[$posicion],$lista[$posicion+1],$lista[$posicion+2]);
            //Con array values volvemos a ordenar el array para tener valores desde la posicion 0. Ya que unset elimina pero no reagrupa
            $lista=array_values($lista);
            //echo '<p>Registro eliminado correctamente</p>';
            $error=false;
            mostrar_lista($lista);
            return $lista;
        }else{
            //echo '<p>No existe un elemento con ese nombre, por lo que no ha sido posible eliminarlo</p>';
            $error=true;
            return $lista;
        }
    }

    //---------------FUNCIONES DE AMBITO GENERAL------------------------------

    function mostrar_lista($lista){
        if(!empty($lista) && count($lista)>=3){
            $fila1="<table><th>Nombre</th><th>Cantidad</th><th>Precio Unitario</th></tr>";
            $filas="";
            for($i=0;$i<count($lista);$i+=3){
                $filas.="<tr><td>".$lista[$i]."</td><td>".$lista[$i+1]."</td><td>".$lista[$i+2]."</td></tr>";
            }
            $filas.="</table>";
            echo $fila1.$filas;
            echo'<br><br><br>';
        }else{
            echo '<p class="aviso">Actualmente no hay ningun elemento almacenado</p>';
        }
    }

    function comprobar_nombre_existe_lista($nombre,$lista){
        if(in_array($nombre,$lista)){
            return true;
        }else{
            return false;
        }
    }

?>