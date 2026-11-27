<?php
session_start();
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PernosCol - Venta de pernos de alta resistencia">
    <meta name="keywords" content="pernos, PERNOS, Pernos, Colombia, PernosCol, pernoscol,">
  <meta name="author" content="Leonardo Montoya">
    <title>PERNOSCOL - Soluciones de Fijación y Herramientas</title>
    <!-- Enlace a la hoja de estilos CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Enlace a FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="img/favicon.ico">
</head>
<body>

    <!-- ==================== HEADER / NAVEGACIÓN ==================== -->
    <header class="main-header">
        <div class="top-bar container">
            <div class="logo-container">
                <img src="img/logo-pernoscol.png" alt="PERNOSCOL Logo" id="pernoscol-logo" class="logo-img">
                <div class="logo-text">
                    <h1>PERNOSCOL</h1>
                    <p>Soluciones de Fijación y Herramientas</p>
                </div>
            </div>
            <div class="search-user-bar">
                <div class="search-box">
                    <input type="text" placeholder="Search">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <?php if(isset($_SESSION['usuario_nombre'])): ?>
                    <a href="#" class="user-account"><i class="fa-regular fa-user"></i> Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></a>
                    <a href="logout.php" class="user-account" style="color: #e74c3c; font-size: 12px;">Salir</a>
                <?php else: ?>
                    <a href="login.php" class="user-account"><i class="fa-regular fa-user"></i> Mi Cuenta</a>
                <?php endif; ?>
                <a href="#" class="cart-icon" id="cart-icon"><i class="fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a>
            </div>
        </div>

        <nav class="main-nav">
            <ul class="container nav-links">
                <li><a href="#">Pernos Estructurales</a></li>
                <li><a href="#">Tornillería Especial</a></li>
                <li><a href="#">Anclajes</a></li>
                <li><a href="#">Herramientas Industriales</a></li>
                <li><a href="#">Catálogo Completo</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contáctenos</a></li>
            </ul>
        </nav>
    </header>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="hero-section" style="background-image: url('assets/banner-hero-bg.jpg');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2>¡SOLUCIONES DE FIJACIÓN DE CLASE MUNDIAL PARA COLOMBIA!</h2>
            <button class="btn-primary" id="btn-explorar">EXPLORAR NUESTRO CATÁLOGO</button>
        </div>
    </section>

    <!-- ==================== CATEGORÍAS DESTACADAS ==================== -->
    <section class="categories-section container">
        <h2>Categorías Destacadas</h2>
        <div class="categories-grid">
            <div class="category-card card-blue">
                <div class="category-info">
                    <h3>Pernos de Alta Resistencia</h3>
                </div>
                <div class="category-img-box">
                    <img src="img/pernos-alta-resistencia.png" alt="Pernos de Alta Resistencia" id="cat-alta-resistencia">
                </div>
            </div>
            <div class="category-card card-yellow">
                <div class="category-info">
                    <h3>Tornillería en Acero Inoxidable</h3>
                </div>
                <div class="category-img-box">
                    <img src="img/tornilleria-inoxidable1.png" alt="Tornillería en Acero Inoxidable" id="cat-acero-inoxidable">
                </div>
            </div>
            <div class="category-card card-blue">
                <div class="category-info">
                    <h3>Anclajes Químicos</h3>
                </div>
                <div class="category-img-box">
                    <img src="img/anclajes-quimicos1.png" alt="Anclajes Químicos" id="cat-anclajes">
                </div>
            </div>
            <div class="category-card card-yellow">
                <div class="category-info">
                    <h3>Herramientas de Torque</h3>
                </div>
                <div class="category-img-box">
                    <img src="img/herramientas-torque.png" alt="Herramientas de Torque" id="cat-herramientas">
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== PRODUCTOS MÁS VENDIDOS (DESDE LA BD) ==================== -->
    <section class="products-section container">
        <h2>Productos Más Vendidos</h2>
        <div class="products-grid">
            <?php
            $resultado = $conexion->query("SELECT * FROM productos");
            if ($resultado && $resultado->num_rows > 0) {
                while($row = $resultado->fetch_assoc()) {
                    $precio_formateado = number_format($row['precio'], 0, ',', '.');
                    echo '
                    <div class="product-card" data-id="'.$row['id'].'">
                        <img src="'.$row['imagen'].'" alt="'.$row['nombre'].'" class="product-img">
                        <h4>'.$row['nombre'].'</h4>
                        <p class="product-desc">'.$row['descripcion'].'</p>
                        <span class="product-price">$'.$precio_formateado.' COP</span>
                        <div class="product-rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <button class="btn-add-cart">AGREGAR AL CARRITO</button>
                    </div>';
                }
            }
            ?>
        </div>
    </section>

    <!-- ==================== SERVICIO AL CLIENTE ==================== -->
    <section class="services-banner container">
        <h2>Servicio al Cliente</h2>
        <div class="services-grid">
            <div class="service-item">
                <i class="fa-solid fa-truck-fast"></i>
                <div>
                    <h4>Envíos Nacionales Rápidos</h4>
                    <p>Envíos Nacionales Rápidos a todo el país</p>
                </div>
            </div>
            <div class="service-item">
                <i class="fa-solid fa-headset"></i>
                <div>
                    <h4>Asesoría Técnica Especializada</h4>
                    <p>Asesoría Técnica Especializada en proyectos</p>
                </div>
            </div>
            <div class="service-item">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <h4>Garantía de Calidad</h4>
                    <p>Garantía de Calidad certificada en tornillería</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="main-footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h4>Acerca de PernosCol</h4>
                <p>Bogotá: 1ra PernosCol, 6, Bogotá, Bogotá, Bogotá, LTA 6062</p>
            </div>
            <div class="footer-col">
                <h4>Términos y Condiciones</h4>
                <p><a href="#">Políticas de Privacidad</a></p>
                <p><a href="#">Mapa del Sitio</a></p>
            </div>
            <div class="footer-col">
                <h4>Preguntas Frecuentes</h4>
                <p><i class="fa-solid fa-phone"></i> 958 689 3788</p>
                <p><i class="fa-solid fa-envelope"></i> widest@pernoscol.com</p>
            </div>
            <div class="footer-col social-col">
                <h4>Síguenos</h4>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 PERNOSCOL - Todos los derechos reservados. Version: 1.0</p>
        </div>
    </footer>

    <!-- ==================== MODAL DEL CARRITO DE COMPRAS ==================== -->
    <div class="cart-modal" id="cart-modal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h3>Carrito de Compras</h3>
                <button class="close-cart" id="close-cart">&times;</button>
            </div>
            <div class="cart-modal-body" id="cart-items-container">
                <!-- Se llena dinámicamente con JavaScript -->
            </div>
            <div class="cart-modal-footer">
                <div class="cart-total">
                    <span>Total:</span>
                    <strong id="cart-total-price">$0 COP</strong>
                </div>
                <button class="btn-checkout" id="btn-checkout">Finalizar Compra</button>
            </div>
        </div>
    </div>

    <!-- Enlace al archivo JavaScript -->
    <script src="script.js"></script>
</body>
</html>