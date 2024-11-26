<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Mantenimiento Industrial</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1><a href="Inicio.html">Gestión de Mantenimiento</a></h1>
            <nav>
                <ul>
                    <li><a href="Inicio.php"><i class="icon-home"></i>Inicio</a></li>
                    <li><a href="loggin.php"><i class="icon-register"></i>Log In</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <section class="testimonials">
            <h2><i class="fas fa-quote-left"></i> Lo que dicen nuestros usuarios</h2>
            <div class="testimonial-container">
                <div class="testimonial">
                    <p>"El sistema ha transformado nuestra manera de gestionar el mantenimiento. Ahora todo está centralizado y es mucho más fácil hacer un seguimiento de las tareas." - <strong>Juan Pérez, Supervisor</strong></p>
                </div>
                <div class="testimonial">
                    <p>"Como técnico, puedo acceder rápidamente a mis órdenes de trabajo y reportar el estado de las máquinas de manera eficiente. Esto ha mejorado nuestra productividad." - <strong>Ana García, Técnica</strong></p>
                </div>
                <div class="testimonial">
                    <p>"Como operador, puedo generar reportes de fallas de manera simple. El sistema ha mejorado la comunicación entre los equipos." - <strong>Carlos Ruiz, Operador</strong></p>
                </div>
            </div>
        </section>
        <section class="faq">
            <h2>Preguntas Frecuentes</h2>
            <div class="faq-item">
                <input type="checkbox" id="faq1">
                <label for="faq1">¿Qué es el Sistema de Gestión de Mantenimiento Industrial?</label>
                <div class="answer">
                    <p>Es una plataforma diseñada para optimizar la gestión de mantenimiento, mejorando la eficiencia en la organización y el seguimiento de tareas.</p>
                </div>
            </div>
            <div class="faq-item">
                <input type="checkbox" id="faq2">
                <label for="faq2">¿Qué beneficios ofrece para los supervisores?</label>
                <div class="answer">
                    <p>Los supervisores pueden registrar usuarios, asignar tareas, y consultar reportes detallados sobre el estado de las máquinas.</p>
                </div>
            </div>
            <div class="faq-item">
                <input type="checkbox" id="faq3">
                <label for="faq3">¿El sistema es accesible desde cualquier dispositivo?</label>
                <div class="answer">
                    <p>Sí, el sistema es accesible desde cualquier dispositivo con conexión a internet, lo que facilita la gestión remota.</p>
                </div>
            </div>
        </section>
        <section class="success-cases">
            <h2><i class="fas fa-trophy"></i> Casos de Éxito</h2>
            <div class="case">
                <h3><i class="fas fa-industry"></i> Industrias TecnoMec</h3>
                <p>
                    <strong>Ubicación:</strong> Monterrey, México<br>
                    <strong>Sector:</strong> Manufactura de maquinaria pesada<br>
                    <strong>Resultados:</strong> Gracias a la implementación de nuestro sistema, TecnoMec logró reducir un 35% los tiempos de inactividad de su maquinaria crítica, mejorando su productividad y disminuyendo costos operativos en un 20%.
                </p>
            </div>
            <div class="case">
                <h3><i class="fas fa-warehouse"></i> AgroSoluciones S.A.</h3>
                <p>
                    <strong>Ubicación:</strong> Córdoba, Argentina<br>
                    <strong>Sector:</strong> Agroindustria<br>
                    <strong>Resultados:</strong> AgroSoluciones utilizó nuestro sistema para optimizar su programa de mantenimiento preventivo, evitando fallas en época de cosecha. Esto se tradujo en un aumento del 15% en la eficiencia operativa.
                </p>
            </div>
            <div class="case">
                <h3><i class="fas fa-oil-can"></i> PetroQuim Líder</h3>
                <p>
                    <strong>Ubicación:</strong> Bogotá, Colombia<br>
                    <strong>Sector:</strong> Energía y Petróleo<br>
                    <strong>Resultados:</strong> PetroQuim implementó nuestro sistema para centralizar la gestión de mantenimiento en tres plantas. El seguimiento en tiempo real permitió ahorrar $200,000 anuales en reparaciones correctivas.
                </p>
            </div>
        </section>
         <!-- Galería -->
         <section class="gallery">
            <h2><i class="fas fa-images"></i> Nuestra Galería</h2>
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

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión de Mantenimiento. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
