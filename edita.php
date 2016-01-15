<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // coger el parámetro que nos permitirá identificar el registro
        // isset() es una función PHP usado para verificar si una variable tiene valor o no
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Registro no encontrado.');
        include 'conexion.php';
            if ($_POST) {
                //proteger ante injeccion
                //$nif=mysqli_real_escape_string($_POST['nif']);
                //$nombre=  mysqli_real_escape_string($_POST['nombre']);
                //No los descomentamos porque tendria que modificar toda la consulta y las variables
            // escribir en la tabla cliente
            $query = "UPDATE clientes "
                    . "SET nif=?, nombre=?, apellido1=?, apellido2=?, "
                    . "email=?, telefono=?, usuario=?, password=? "
                    . "WHERE id = ?";
            //El prepare trata las consultas para que no haya injeccion de codigo ??
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('ssssssssi', $_POST['nif'], $_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['email'], $_POST['telefono'], $_POST['usuario'], $_POST['password'], $id);
            if ($stmt->execute()) {
                    echo "Registro actualizado";
                } else {
                    echo 'Error al actualizar.';
                }
            }           
        // leer el registro de la tabla
        $query = "SELECT nif, nombre, apellido1, apellido2, email, telefono, usuario, password "
        . "FROM clientes  "
        . "WHERE id = ? ";
        if ($stmt = $conexion->prepare($query)) {
        // inicializamos el parámetro
            $stmt->bind_param('d', $id);
        // ejecutamos la consulta
            $stmt->execute();
            $stmt->bind_result($nif, $nombre, $apellido1, $apellido2, $email, $telefono, $usuario, $password);
        // recuperamos la variable
            $stmt->fetch();
        }   
        ?>
        <form action='index.php?accionid=<?php echo htmlspecialchars($id); ?>' method='post' border='0'>
            <table>
                <tr>
                    <td>NIF:</td>
                    <td><input type='text' name='nif' value="<?php echo htmlspecialchars($nif, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td><input type='text' name='nombre' value="<?php echo htmlspecialchars($nombre, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>1er Apellido</td>
                    <td><input type="text" name='apellido1' value="<?php echo htmlspecialchars($apellido1, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>2º Apellido</td>
                    <td><input type='text' name='apellido2' value="<?php echo htmlspecialchars($apellido2, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>email</td>
                    <td><input type="text" name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>Telefono</td>
                    <td><input type='text' name='telefono' value="<?php echo htmlspecialchars($telefono, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>Usuario</td>
                    <td><input type="text" name='usuario' value="<?php echo htmlspecialchars($usuario, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='text' name='password' value="<?php echo htmlspecialchars($password, ENT_QUOTES); ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='button' value='Guardar' onclick="formhash(this.form, this.form.password);"/>
                        <a href='index.php'>Volver a Inicio</a>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
