<style>
    /* =========================================
       GRILLA DE SERVICIOS (2 COLUMNAS)
       ========================================= */
    .services-grid {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important; 
        gap: 60px 40px !important; 
        max-width: 1200px !important;
        margin: 0 auto !important;
    }

    @media (max-width: 1024px) {
        .services-grid {
            grid-template-columns: 1fr !important;
            gap: 45px !important;
            padding: 0 20px !important;
        }
    }

    .service-card {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
        background: #ffffff !important;
        box-shadow: none !important; 
        border: none !important;
        border-radius: 8px !important;
        overflow: hidden !important;
    }

    .service-media {
        width: 100% !important;
        height: 420px !important; 
        position: relative !important;
        overflow: hidden !important;
    }

    .service-media img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important; 
        object-position: center !important; 
        display: block !important;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1) !important;
    }

    .service-card:hover .service-media img {
        transform: scale(1.05) !important; 
    }

    .service-body {
        padding: 30px !important; 
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .service-body h3 {
        font-family: 'Playfair Display', serif !important; 
        font-size: 24px !important;
        color: #c5a059 !important; 
        margin-bottom: 12px !important;
        font-weight: 400 !important;
    }

    .service-body p {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 14px !important;
        color: #4a433c !important; 
        line-height: 1.6 !important;
        margin-bottom: 20px !important;
    }

    .service-link {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 13px !important;
        text-transform: uppercase !important;
        letter-spacing: 2px !important;
        color: #4a433c !important;
        text-decoration: none !important;
        border-bottom: 1px solid #c5a059 !important;
        padding-bottom: 4px !important;
        background: none !important;
        cursor: pointer !important;
        transition: color 0.3s ease, border-color 0.3s ease !important;
        margin-top: auto !important; 
    }

    .service-link:hover {
        color: #c5a059 !important;
        border-color: #4a433c !important;
    }

    /* =========================================
       ✨ MODAL DIVIDIDO (TEXTO ARRIBA E IMAGEN GIGANTE) ✨
       ========================================= */
    .service-modal {
        position: fixed !important;
        inset: 0 !important;
        background: rgba(42, 37, 33, 0.8) !important; 
        backdrop-filter: blur(5px) !important;
        display: none !important; 
        align-items: center !important;
        justify-content: center !important;
        padding: 20px !important;
        z-index: 9999 !important;
        opacity: 0;
        transition: opacity 0.3s ease !important;
    }

    .service-modal.is-open {
        display: flex !important;
        opacity: 1;
    }

    .service-modal__content {
        background: #fbf9f6 !important; 
        border-radius: 12px !important;
        max-width: 1000px !important; /* 🌟 Más ancho para que la foto no se recorte tanto */
        width: 100% !important;
        height: 550px !important; /* 🌟 Un poco más alto */
        padding: 0 !important; 
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25) !important;
        position: relative !important;
        border: 1px solid #e6dec1 !important; 
        transform: translateY(20px);
        transition: transform 0.3s ease !important;
        display: flex !important; 
        overflow: hidden !important; 
    }

    .service-modal.is-open .service-modal__content {
        transform: translateY(0);
    }

    /* Lado Izquierdo: Texto */
    .service-modal__left {
        flex: 1 !important;
        padding: 60px 50px !important; /* 🌟 El padding-top empuja el texto hacia abajo lo justo y necesario */
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important; /* 🌟 Alinea el contenido arriba en vez del centro */
        text-align: left !important;
    }

    .service-modal__left h3 {
        font-family: 'Playfair Display', serif !important;
        color: #c5a059 !important;
        font-size: 32px !important;
        margin-bottom: 20px !important;
        font-weight: 400 !important;
        margin-top: 0 !important;
    }

    .service-modal__left h3::after {
        content: '';
        display: block;
        width: 50px;
        height: 1px;
        background-color: #c5a059;
        margin: 20px 0 0 0;
    }

    .service-modal__left p {
        font-family: 'Montserrat', sans-serif !important;
        color: #4a433c !important;
        line-height: 1.8 !important;
        font-size: 15px !important;
        margin-top: 25px !important;
    }

    /* Lado Derecho: Imagen gigante */
    .service-modal__right {
        flex: 1.4 !important; /* 🌟 Le damos más peso a la imagen para que se vea más completa */
        position: relative !important;
        background: #e8e0d6 !important;
    }

    .service-modal__right img {
        width: 100% !important;
        height: 100% !important;
        /* Si notas que aún te corta algo que querés mostrar, podés probar cambiar 'cover' por 'contain' */
        object-fit: cover !important;
        position: absolute !important;
        top: 0;
        left: 0;
    }

    /* Botón X superpuesto */
    .service-modal__close {
        position: absolute !important;
        top: 15px !important;
        right: 20px !important;
        background: rgba(255,255,255,0.8) !important; 
        border: none !important;
        font-size: 24px !important;
        cursor: pointer !important;
        color: #2a2521 !important; 
        transition: all 0.2s ease !important;
        line-height: 1 !important;
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 10 !important;
    }

    .service-modal__close:hover {
        background: #c5a059 !important;
        color: white !important;
        transform: scale(1.1) !important;
    }

    /* Adaptación a celulares */
    @media (max-width: 768px) {
        .service-modal__content {
            flex-direction: column !important;
            height: auto !important;
            max-height: 90vh !important;
            overflow-y: auto !important;
        }
        .service-modal__right {
            min-height: 300px !important;
            flex: none !important;
        }
        .service-modal__left {
            padding: 40px 30px !important;
        }
    }
</style>

<section class="servicios">
    <h2>Nuestros Servicios</h2>
    <div class="services-grid">
        @php
            $items = [
                [
                    'title' => 'Corte', 
                    'text' => 'Diseñado a medida, respetando tu estilo y la forma de tu rostro.', 
                    'info' => 'Incluye diagnóstico de rostro y tipo de cabello, corte preciso y asesoramiento para mantenerlo perfecto en casa.', 
                    'img' => 'img/servicios/corte.jpeg',
                    'img_modal' => 'img/servicios/corte.jpeg' /* 🌟 Acá podés poner la foto original sin recortar si tenés una */
                ],
                [
                    'title' => 'Balayage', 
                    'text' => 'Sutil, elegante, y de bajo mantenimiento.', 
                    'info' => 'Técnica de coloración artesanal que aporta luz natural, volumen y un efecto suavemente degradado.', 
                    'img' => 'img/servicios/balayage.jpeg',
                    'img_modal' => 'img/servicios/balayage.jpeg'
                ],
                [
                    'title' => 'Alisado', 
                    'text' => 'Consigue un cabello liso y sedoso con nuestros tratamientos.', 
                    'info' => 'Ideal para controlar el frizz y lograr un acabado brillante, con productos pensados para cuidar la fibra.', 
                    'img' => 'img/servicios/alisado.jpeg',
                    'img_modal' => 'img/servicios/alisado.jpeg'
                ],
                [
                    'title' => 'Nutrición / Tratamiento', 
                    'text' => 'Consigue un cabello sano y brillante con nuestros tratamientos.', 
                    'info' => 'Tratamiento profundo de hidratación y reparación intensa para restaurar la elasticidad y el brillo natural.', 
                    'img' => 'img/servicios/tratamiento.jpeg',
                    'img_modal' => 'img/servicios/tratamiento.jpeg'
                ],
                [
                    'title' => 'Lavado', 
                    'text' => 'Un ritual pensado para relajar y cuidar tu experiencia en el salón.', 
                    'info' => 'Incluye masaje capilar neurosedante, elección del shampoo ideal según tu cuero cabelludo y secado.', 
                    'img' => 'img/servicios/lavado.jpeg',
                    'img_modal' => 'img/servicios/lavado.jpeg'
                ],
                [
                    'title' => 'Peinado', 
                    'text' => 'Peinados personalizados para cada ocasión.', 
                    'info' => 'Perfecto para eventos, fiestas o días especiales, con opciones de recogidos u ondas que se adaptan a tu outfit.', 
                    'img' => 'img/servicios/peinado.jpeg',
                    'img_modal' => 'img/servicios/peinado.jpeg'
                ],
                [
                    'title' => 'Barrido', 
                    'text' => 'Decoloración suave para limpiar tonos viejos o aclarar tu base.', 
                    'info' => 'Elimina pigmentos acumulados de tinturas anteriores para preparar el cabello hacia un nuevo color reflejo.', 
                    'img' => 'img/servicios/barrido.jpeg',
                    'img_modal' => 'img/servicios/barrido.jpeg'
                ],
                [
                    'title' => 'Color Completo', 
                    'text' => 'Renovación total de tu color de raíz a puntas.', 
                    'info' => 'Aplicación global de tinturas premium con alta protección para lograr un color uniforme, vibrante y duradero.', 
                    'img' => 'img/servicios/color completo.jpeg',
                    'img_modal' => 'img/servicios/color completo.jpeg'
                ],
                [
                    'title' => 'Coloración de Raíces', 
                    'text' => 'Mantenimiento preciso para cubrir canas o crecimiento.', 
                    'info' => 'Retoque localizado en el crecimiento de la raíz para emparejar tu color global y asegurar una cobertura del 100%.', 
                    'img' => 'img/servicios/coloracion de rices.jpeg',
                    'img_modal' => 'img/servicios/coloracion de rices.jpeg'
                ],
                [
                    'title' => 'Mechas Balayage', 
                    'text' => 'Contraste y definición de luz para tu melena.', 
                    'info' => 'Combinación avanzada de iluminación localizada que genera un contraste armónico y tridimensional.', 
                    'img' => 'img/servicios/mechas balayage.jpeg',
                    'img_modal' => 'img/servicios/mechas balayage completa.jpeg'
                ],
                [
                    'title' => 'Mechas Tradicionales', 
                    'text' => 'Reflejos definidos desde la raíz para un rubio impactante.', 
                    'info' => 'Técnica clásica con papel aluminio para conseguir una distribución uniforme de reflejos claros y luminososos.', 
                    'img' => 'img/servicios/mechas.jpeg',
                    'img_modal' => 'img/servicios/mechas.jpeg'
                ],
                [
                    'title' => 'Corte de Flequillo', 
                    'text' => 'Un cambio rápido para enmarcar tu mirada.', 
                    'info' => 'Diseño y texturización de flequillo (recto, cortina o desmechado) para renovar tu look sin tocar el largo general.', 
                    'img' => 'img/servicios/flequillo.jpeg',
                    'img_modal' => 'img/servicios/flequillo.jpeg'
                ],
            ];
        @endphp

       
        @foreach($items as $item)
            <article class="service-card">
                <div class="service-media">
                    <img src="{{ asset($item['img']) }}" alt="{{ $item['title'] }}">
                </div>
                <div class="service-body">
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['text'] }}</p>
                    <!-- 🌟 Ahora lee la ruta de 'img_modal' que puede ser distinta a 'img' -->
                    <button type="button" class="service-link" 
                        data-service-title="{{ $item['title'] }}" 
                        data-service-info="{{ $item['info'] }}"
                        data-service-img="{{ asset($item['img_modal']) }}">
                        Ver más
                    </button>
                </div>
            </article>
        @endforeach
    </div>
</section>

<!-- ESTRUCTURA DEL MODAL DIVIDIDO -->
<div id="service-modal" class="service-modal" aria-hidden="true">
    <div class="service-modal__content">
        <button type="button" class="service-modal__close" id="service-modal-close" aria-label="Cerrar">×</button>
        
        <div class="service-modal__left">
            <h3 id="service-modal-title"></h3>
            <p id="service-modal-info"></p>
        </div>

        <div class="service-modal__right">
            <img id="service-modal-img" src="" alt="Servicio en detalle">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('service-modal');
        const title = document.getElementById('service-modal-title');
        const info = document.getElementById('service-modal-info');
        const img = document.getElementById('service-modal-img'); 
        const closeBtn = document.getElementById('service-modal-close');

        document.querySelectorAll('.service-link').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                title.textContent = this.dataset.serviceTitle;
                info.textContent = this.dataset.serviceInfo;
                img.src = this.dataset.serviceImg; 
                
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        const closeModal = () => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            setTimeout(() => { img.src = ""; }, 300); 
        };

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>