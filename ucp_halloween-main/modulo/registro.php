
<section id="registro" class="section">
    <h2>Registro</h2>
    <form action="index.php?modulo=registro" method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>
        
        <button type="submit">Registrarse</button>
        <button >Registrarse</button>
        <a href="index.php">Volver al inicio</a>
    </form>
</section>


<?php
if(isset($_POST['nombre']) && isset($_POST['clave']))
{
    //verifico que no exista el usuario
    $sql = "SELECT *FROM usuarios where nombre = '".$_POST['nombre']."'";
    $sql = mysqli_query($con, $sql);
    if(mysqli_num_rows($sql)!= 0)
    {
        echo "<script>alert('Error: el usuario ya existe en la BD.');</script>";
    }
        else
        {
            //inserto el usuario nuevo
            $sql = "INSERT INTO usuarios (nombre, clave) values ('".$_POST['nombre']."', '".password_hash($_POST['clave'], PASSWORD_DEFAULT)."')";
            $sql = mysqli_query($con, $sql);
            if(mysqli_error($con))
            {
                echo "<script>alert('Error no se pudo insertar el registro');</script>";
            }
                else
                {
                    echo "<script>alert('Registro insertado con éxito');</script>";
                }     
        }
    //limpio el POST    
    echo "<script>window.location='index.php?modulo=registro';</script>";    
}
?>