/* ==================== FUNCIONALIDAD GENERAL E-COMMERCE ==================== */
document.addEventListener('DOMContentLoaded', () => {

    // Arreglo global para almacenar los ítems del carrito
    let cart = [];

    // Elementos del DOM
    const cartIcon = document.getElementById('cart-icon');
    const cartCountElement = document.querySelector('.cart-count');
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    const cartModal = document.getElementById('cart-modal');
    const closeCartBtn = document.getElementById('close-cart');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartTotalPrice = document.getElementById('cart-total-price');

    // ==================== LÓGICA DEL CARRITO ====================

    // Función para actualizar la interfaz del carrito
    function updateCartUI() {
        // Limpiar el contenedor de ítems
        cartItemsContainer.innerHTML = '';

        let totalItems = 0;
        let totalPrice = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p style="text-align:center; color:#777;">El carrito está vacío.</p>';
        } else {
            cart.forEach(item => {
                totalItems += item.quantity;
                totalPrice += item.price * item.quantity;

                const itemElement = document.createElement('div');
                itemElement.classList.add('cart-item');
                itemElement.innerHTML = `
                    <div class="cart-item-details">
                        <h5>${item.name}</h5>
                        <p>$${item.price.toLocaleString('es-CO')} COP x ${item.quantity}</p>
                    </div>
                    <div class="cart-item-controls">
                        <button onclick="changeQuantity(${item.id}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="changeQuantity(${item.id}, 1)">+</button>
                        <button class="btn-remove" onclick="removeFromCart(${item.id})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemElement);
            });
        }

        // Actualizar el número de la insignia y el valor total
        cartCountElement.innerText = totalItems;
        cartTotalPrice.innerText = `$${totalPrice.toLocaleString('es-CO')} COP`;
    }

    // Agregar producto al carrito
    addToCartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const productCard = e.target.closest('.product-card');
            const productId = parseInt(productCard.getAttribute('data-id'));
            const productName = productCard.querySelector('h4').innerText;
            const priceText = productCard.querySelector('.product-price').innerText;
            
            // Extraer solo los números del precio
            const price = parseInt(priceText.replace(/[^0-9]/g, ''));

            // Verificar si el producto ya existe en el carrito
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: price,
                    quantity: 1
                });
            }

            updateCartUI();

            // Animación visual del botón
            const originalText = button.innerText;
            button.innerText = '¡AGREGADO!';
            button.style.backgroundColor = '#27ae60';
            button.style.color = '#fff';

            setTimeout(() => {
                button.innerText = originalText;
                button.style.backgroundColor = '';
                button.style.color = '';
            }, 1000);
        });
    });

    // Modificar cantidad (hacer accesible globalmente para el evento en línea)
    window.changeQuantity = function(id, delta) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity += delta;
            if (item.quantity <= 0) {
                removeFromCart(id);
            } else {
                updateCartUI();
            }
        }
    };

    // Eliminar producto del carrito
    window.removeFromCart = function(id) {
        cart = cart.filter(item => item.id !== id);
        updateCartUI();
    };

    // Modales: Abrir y cerrar
    if (cartIcon && cartModal && closeCartBtn) {
        cartIcon.addEventListener('click', (e) => {
            e.preventDefault();
            cartModal.classList.add('open');
        });

        closeCartBtn.addEventListener('click', () => {
            cartModal.classList.remove('open');
        });

        // Cerrar haciendo clic fuera del modal
        cartModal.addEventListener('click', (e) => {
            if (e.target === cartModal) {
                cartModal.classList.remove('open');
            }
        });
    }

    // Inicializar el carrito vacío
    updateCartUI();

    // ==================== ACCIÓN BOTÓN HERO ====================
    const btnExplorar = document.getElementById('btn-explorar');
    if (btnExplorar) {
        btnExplorar.addEventListener('click', () => {
            const productsSection = document.querySelector('.categories-section');
            productsSection.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // ==================== BUSCADOR INTERACTIVO ====================
    const searchInput = document.querySelector('.search-box input');
    const searchButton = document.querySelector('.search-box button');

    function performSearch() {
        const query = searchInput.value.trim();
        if (query !== '') {
            alert(`Buscando productos de tornillería y fijación para: "${query}" en PernosCol.`);
        }
    }

    if (searchButton && searchInput) {
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
});