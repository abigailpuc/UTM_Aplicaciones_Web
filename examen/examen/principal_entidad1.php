<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Entidades</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <header>
        <h1>entidad1</h1>
    </header>
    <main>
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="img/casa1.jpg" class="slide-image">
            </div>
            <div class="mySlides fade">
                <img src="img/casa2.jpg" class="slide-image">
            </div>
            <div class="mySlides fade">
                <img src="img/casa3.png" class="slide-image">
            </div>
        </div>
        <br>
        <div class="nav-icons">
            <a href="ver_entidad1.php" class="card" style= "background-image: url('img/agentes.jpg');">
            </a>
            <a href="agregar_entidad1.php" class="card" style="background-image: url('img/agregar_registro.jpg');">
                <p>Agregar Registro</p>
            </a>
            <a href="modificar_entidad1.php" class="card" style="background-image: url('img/modificar_registro.jpg');">
                <p>Modificar Registro</p>
            </a>
            <a href="eliminar_entidad1.php" class="card" style="background-image: url('img/eliminar_registro.jpg');">
                <p>Eliminar Registro</p>
            </a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Gestor de Entidades. Todos los derechos reservados.</p>
    </footer>
   </script>
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("mySlides");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}    
            slides[slideIndex-1].style.display = "block";  
            setTimeout(showSlides, 3000); // Cambia la imagen cada 3 segundos
        }
    </script>
</body>
</html>