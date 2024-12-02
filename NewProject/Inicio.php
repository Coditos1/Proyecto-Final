<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Mantenimiento Industrial</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
     <!-- Header -->
     <header>
        <div class="container">
            <h1><a href="index.html">Gestión de Mantenimiento</a></h1>
            <nav>
                <ul>
                    <li><a href="Inicio.php"><i class="icon-home"></i>Inicio</a></li>
                    <li><a href="detalles.php"><i class="icon-login"></i>Details</a></li>
                    <li><a href="loggin.php"><i class="icon-register"></i>Log In</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <section class="intro">
            <h1><i class="fas fa-cogs"></i> Conoce nuestro Sistema de Gestión de Mantenimiento Industrial</h1>
            <p><i class="fas fa-tools"></i> Un sistema integral diseñado para mejorar la eficiencia y coordinación en el mantenimiento industrial. Facilita la gestión de tareas, el seguimiento de equipos y la comunicación entre operadores, técnicos y supervisores.</p>
            <div class="separator"></div>
            <p><i class="fas fa-briefcase"></i> En nuestra plataforma, podrás gestionar el mantenimiento de maquinaria, registrar fallas, generar órdenes de trabajo, y consultar reportes históricos. Cada usuario tiene acceso a funciones adaptadas a su rol, lo que mejora la eficiencia operativa y permite tomar decisiones informadas.</p>
            <div class="separator"></div>
            <h2><i class="fas fa-question-circle"></i> ¿Cómo funciona el sistema?</h2>
            <p><i class="fas fa-users"></i> El sistema está diseñado con tres tipos de usuarios: Supervisores, Técnicos y Operadores. Cada uno tiene acceso a diferentes funcionalidades según sus necesidades:</p>
            <div class="user-types">
                <div class="user-type">
                    <h3><i class="fas fa-user-shield"></i> Supervisor</h3>
                    <p>El supervisor tiene control total sobre el sistema. Puede registrar nuevos usuarios, crear órdenes de trabajo, asignar tareas a técnicos y operadores, y consultar reportes detallados sobre el estado de las máquinas.</p>
                </div>
                <div class="user-type">
                    <h3><i class="fas fa-user-cog"></i> Técnico</h3>
                    <p>Los técnicos pueden visualizar las órdenes de trabajo asignadas, realizar mantenimiento preventivo o correctivo, y reportar el estado de las máquinas, asegurando que todo el equipo esté en condiciones óptimas.</p>
                </div>
                <div class="user-type">
                    <h3><i class="fas fa-user-tie"></i> Operador</h3>
                    <p>Los operadores son los primeros en detectar fallas en las máquinas. A través del sistema, pueden generar reportes de fallas y alertar a los técnicos para que se tomen acciones correctivas rápidamente.</p>
                </div>
            </div>
        </section>
        <main>
        </section>
        <!-- Galería -->
        <section class="gallery">
           <h2><i class="fas fa-images"></i> Explora las funciones de nuestra galeria</h2>
           <div class="gallery-container">
               <a href="#img1" class="gallery-item">
                   <img src="images/imagen1.png" alt="Máquina industrial">
               </a>
               <a href="#img2" class="gallery-item">
                   <img src="images/imagen 2.png" alt="Equipo de mantenimiento">
               </a>
               <a href="#img3" class="gallery-item">
                   <img src="images/imagen 3.png" alt="Sistema en acción">
               </a>
               <a href="#img4" class="gallery-item">
                   <img src="images/imagen 4.png" alt="Fábrica">
               </a>
           </div>
       
           <!-- Lightboxes -->
           <div id="img1" class="lightbox">
               <a href="#!" class="close">&times;</a>
               <img src="images/imagen1.png" alt="Máquina industrial">
           </div>
           <div id="img2" class="lightbox">
               <a href="#!" class="close">&times;</a>
               <img src="images/imagen 2.png" alt="Equipo de mantenimiento">
           </div>
           <div id="img3" class="lightbox">
               <a href="#!" class="close">&times;</a>
               <img src="images/imagen 3.png" alt="Sistema en acción">
           </div>
           <div id="img4" class="lightbox">
               <a href="#!" class="close">&times;</a>
               <img src="images/imagen 4.png" alt="Fábrica">
           </div>
       </section>
        </main>
        
        
    </main>

</body>
</html>
