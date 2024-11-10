<?php
session_start();
include ("./php/conexion.php");
conectar();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Concurso de disfraces de Halloween</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?modulo=disfraces-list">Ver Disfraces</a></li>
            <li><a href="index.php?modulo=registro">Registro</a></li>
            <li><a href="index.php?modulo=login">Iniciar Sesión</a></li>
            <li><a href="index.php?modulo=procesar_disfraz">Panel de Administración</a></li>
        </ul>
    </nav>
    <header>
        <h1>Concurso de disfraces de Halloween</h1>
    </header>
    <?php
        if(!empty($_SESSION['nombre_usuario']))
        {
            ?>
            <p>Hola <?php echo $_SESSION['nombre_usuario'];?>. usted tiene el ID: <?php echo $_SESSION['id'];?></p>
            <a href="index.php?modulo=login&salir=ok">SALIR</a>
            <?php
        }
        
    ?>
    <main>
    <?php
    if(!empty($_GET['modulo']))
    {
        include('modulo/'.$_GET['modulo'].'.php');
    }
    else
            {
                $sql = "SELECT *FROM disfraces WHERE eliminado=0 ORDER BY votos DESC";
                $sql = mysqli_query($con, $sql);
                if(mysqli_num_rows($sql) != 0)
                {
                    while ($r = mysqli_fetch_array($sql)) 
                    {
                        ?>
                        <section id="disfraces-list" class="section">
                            <!-- Aquí se mostrarán los disfraces -->
                            <div class="disfraz">
                                <h2><?php echo $r['nombre'];?></h2>
                                <p><?php echo $r['descripcion'];?></p>
                                <p>Votos: <?php echo $r['votos'];?></p>
                                <?php
                                if(file_exists('imagenes/'.$r['foto']))
                                {
                                    //unlink('imagenes/'.$r['foto']);//borro las fotos
                                    ?>
                                        <p><img src="imagenes/<?php echo $r['foto'];?>" width="100%"></p>
                                        <!--<p>FOTO BLOB</p>
                                        <p><img src="modulos/mostrar_foto.php?id=<?php //echo $r['id'];?>" width="100%"></p>-->
                                    <?php 
                                }
                                    else
                                    {
                                        echo "<p>Sin fotos</p>";
                                    }
                                ?>
                                
                                <?php
                                if(!empty($_SESSION['nombre_usuario']))
                                {
                                    //consulto si el usuario voto por el disfraz
                                    $sql_votos = "SELECT *FROM votos where id_disfraz=".$r['id']." and id_usuario=".$_SESSION['id'];
                                    $sql_votos = mysqli_query($con, $sql_votos);
                                    if(mysqli_num_rows($sql_votos) == 0)
                                    {
                                        ?>
                                            <button class="votar" id="votarBoton<?php echo $r['id'];?>" onclick="votar(<?php echo $r['id'];?>)">Votar</button>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- Repite la estructura para más disfraces -->
                        </section>
                        <?php
                    }
                }
                    else
                    {
                        ?>
                        <section id="disfraces-list" class="section">
                            <!-- Aquí se mostrarán los disfraces -->
                            <div class="disfraz">
                                <h2>No hay datos.</h2>
                            </div> 
                            <!-- Repite la estructura para más disfraces -->
                        </section>
                        <?php
                    }
            }
        ?>

    </main>
    <script src="js/script.js"></script>
</body>
</html>
