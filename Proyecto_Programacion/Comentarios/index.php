<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Comentarios</title>
</head>

<style>
/* Fondo general y tipografía */
body {
    background: linear-gradient(135deg, #6f2cfb, #34d1bf);
    font-family: 'Arial', sans-serif;
    color: #fff;
    padding: 50px;
    text-align: center;
}

/* Logo */
.logo {
    max-width: 120px; /* Tamaño reducido del logo */
    margin: 80px 0 40px 0; /* Añadir un margen superior más grande */
    animation: pulse 2s infinite;
}

.navbar-logo {
    max-width: 80px; /* Tamaño reducido del logo de navbar */
    margin-bottom: 20px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Navbar */
.navbar {
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}
.navbar-toggle {
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.navbar-menu {
    display: none;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.navbar-menu.active {
    display: flex;
}

.navbar-menu li {
    margin-right: 20px;
}

.navbar-menu a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

/* Formularios */
form div {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: none;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

button {
    background: #34d1bf;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
    transition: background 0.3s ease, transform 0.3s ease;
    box-shadow: 0 5px 15px rgba(52, 209, 191, 0.4);
}

button:hover {
    background: #2cbba5;
    transform: translateY(-3px);
}

/* Comentarios existentes */
.comentario {
    background: rgba(255, 255, 255, 0.2);
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    text-align: left;
    box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
}

.comentario p {
    color: #fff;
    font-size: 16px;
    line-height: 1.5;
}

.comentario strong {
    color: #34d1bf; /* Resaltar el texto "Nombre", "Escuela", etc. */
    font-size: 18px;
}

hr {
    border: 0;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
}
</style>
<body>

    <!-- Menú de navegación -->
    <nav class="navbar">
        <div class="navbar-toggle" onclick="toggleNavbar()">Ξ</div>
        <ul class="navbar-menu">
            <li><a href="../2doSemestre/index.html">2do Semestre</a></li>
            <li><a href="../3erSemestre/index.html">3er Semestre</a></li>
            <li><a href="../4toSemestre/index.html">4to Semestre</a></li>
            <li><a href="../5toSemestre/index.html">5to Semestre</a></li>
            <li><a href="../6toSemestre/index.html">6to Semestre</a></li>
            <li><a href="../Principal/index.html">Menu Principal</a></li>
        </ul>
        <img src="CecyLibro.gif" alt="Logo" class="navbar-logo">
    </nav>

    <img src="CecyLibro.gif" alt="Logo" class="logo">

    <h2>Agregar Comentario</h2>
    <form action="guardar_comentario.php" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <br>
        <div>
            <label for="escuela">Escuela:</label>
            <select id="escuela" name="escuela" required>
                <option value="">Seleccione una opción</option>
                <option value="Bachillerato Tecnologico">Colegio de Estudios Científicos y Tecnológicos del Estado de México</option>
                <option value="Otra">Otra</option>
            </select>
        </div>
        <br>
        <div>
            <label for="semestre">Semestre:</label>
            <select id="semestre" name="semestre" required>
                <option value="">Seleccione el semestre</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
        </div>
        <br>
        <div>
            <label for="comentario">Comentario:</label>
            <textarea id="comentario" name="comentario" required rows="4" cols="50"></textarea>
        </div>
        <br>
        <button type="submit">Enviar Comentario</button>
    </form>

    <h2>Comentarios Existentes</h2>
    <?php
    include 'conexion.php';

    $query = "SELECT * FROM comentarios ORDER BY fecha_creacion DESC";
    $resultado = mysqli_query($conexion, $query);

    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='comentario'>";
        echo "<p><strong>Nombre:</strong> " . htmlspecialchars($fila['nombre']) . "</p>";
        echo "<p><strong>Escuela:</strong> " . htmlspecialchars($fila['escuela']) . "</p>";
        echo "<p><strong>Semestre:</strong> " . htmlspecialchars($fila['semestre']) . "</p>";
        echo "<p><strong>Comentario:</strong> " . htmlspecialchars($fila['comentario']) . "</p>";
        echo "<p><strong>Fecha:</strong> " . $fila['fecha_creacion'] . "</p>";
        echo "<hr>";
        echo "</div>";
    }

    mysqli_close($conexion);
    ?>
    
    <script>
        function toggleNavbar() {
            var menu = document.querySelector('.navbar-menu');
            menu.classList.toggle('active');
        }
    </script>

</body>
</html>
