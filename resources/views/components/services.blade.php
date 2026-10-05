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

    .servicios h2 {
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase !important;
        font-size: 30px !important;
        color: #8C6243 !important; 
        margin-bottom: 12px !important;
        font-weight: 400 !important;
        text-align: center !important;
        margin: 40px !important;
    }

    .service-body h3 {
        font-family: 'Montserrat', sans-serif;
        text-transform: uppercase !important; 
        font-size: 18px !important;
        color: #8C6243 !important; 
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
        color: #2a2521 !important;
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
        font-family: 'Montserrat', sans-serif !important;
        text-transform: uppercase !important;
        color: #8C6243 !important;
        font-size: 32px !important;
        margin-bottom: 20px !important;
        font-weight: 400 !important;
        margin-top: 0 !important;
        width: fit-content !important;
        border-bottom: 1px solid #8C6243 !important;
        padding-bottom: 12px !important;
    }

    .service-modal__left h3::after {
        content: '';
        display: none !important; /* Ocultamos la línea inferior ya que ahora usamos border-bottom */
        width: 50px;
        height: 1px;
        background-color: #8C6243;
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
    <h2>Servicios Pensados para vos</h2>
    <div class="services-grid">
       @php
    $items = [
        [
            'title' => 'Corte', 
            'text' => 'Diseñado para vos, tu cabello y tu estilo.', 
            'info' => 'Cada corte comienza con una breve consulta para conocer qué buscás, tus hábitos y cómo se comporta naturalmente tu cabello. El diseño se adapta a tus facciones, textura y movimiento, buscando un resultado que puedas mantener fácilmente en casa.<br><br>Incluye lavado, corte y terminación.<br><br>Tiempo aproximado: 45 min a 1 hs.', 
            'img' => 'img/servicios/corte.jpeg',
            'img_modal' => 'img/servicios/corte.jpeg'
        ],
        [
            'title' => 'Corte de flequillo', 
            'text' => 'Un pequeño cambio que transforma el look.', 
            'info' => 'Diseño o mantenimiento del flequillo teniendo en cuenta tus facciones, nacimiento del cabello, textura y caída natural. Puede realizarse para crear un flequillo nuevo o simplemente devolverle forma al que ya tenés.<br><br>Tiempo aproximado: 15 a 20 min.', 
            'img' => 'img/servicios/flequillo.jpeg',
            'img_modal' => 'img/servicios/flequillo.jpeg'
        ],
        [
            'title' => 'Balayage', 
            'text' => 'Luz, dimensión y un degradado naturalmente integrado.', 
            'info' => 'Técnica de iluminación personalizada que crea una transición progresiva entre tonos más profundos y zonas de mayor luminosidad, logrando un degradado suave y armonioso, sin cortes marcados de color.<br><br>Cada diseño se adapta a la base, el largo y el movimiento del cabello. Antes de comenzar realizo un diagnóstico para definir la técnica, distribución, tonalidad y nivel de aclaración más adecuados para el resultado que buscás.<br><br>Tiempo aproximado: 2 a 4 hs, según largo, cantidad y trabajo a realizar.', 
            'img' => 'img/servicios/balayage.jpeg',
            'img_modal' => 'img/servicios/balayage.jpeg'
        ],
        [
            'title' => 'Mechas', 
            'text' => 'Luminosidad y dimensión creadas a medida.', 
            'info' => 'Servicio de iluminación diseñado de forma personalizada según tu base, corte y resultado deseado. La cantidad, distribución y grosor de las mechas se adaptan a cada cabello para conseguir desde efectos delicados y naturales hasta rubios con mayor presencia.<br><br>La tonalización se selecciona especialmente para armonizar el resultado final.<br><br>Tiempo aproximado: 2 a 3 hs.', 
            'img' => 'img/servicios/mechas balayage.jpeg',
            'img_modal' => 'img/servicios/mechas balayage completa.jpeg'
        ],
        [
            'title' => 'Color completo', 
            'text' => 'Color uniforme, brillo y una tonalidad pensada para vos.', 
            'info' => 'Servicio de coloración desde raíces hasta largos y puntas. La fórmula se personaliza teniendo en cuenta tu base, historial de color, porcentaje de canas, estado del cabello y resultado deseado.<br><br>Incluye diagnóstico y selección personalizada de la tonalidad.<br><br>Tiempo aproximado: 1 a 2 hs.', 
            'img' => 'img/servicios/color completo.jpeg',
            'img_modal' => 'img/servicios/color completo.jpeg'
        ],
        [
            'title' => 'Coloración de raíces', 
            'text' => 'Mantenimiento de tu color, cuidando cada detalle.', 
            'info' => 'Servicio pensado para mantener el crecimiento, cubrir canas o renovar el color de raíz sin intervenir innecesariamente sobre largos y puntas.<br><br>Según el diagnóstico, el objetivo y las características del cabello, puedo trabajar con coloración permanente, coloración sin amoníaco o tono sobre tono, seleccionando la alternativa y formulación más adecuada para cada caso.<br><br>Tiempo aproximado: 1 hs 30 min.', 
            'img' => 'img/servicios/coloracion de rices.jpeg',
            'img_modal' => 'img/servicios/coloracion de rices.jpeg'
        ],
        [
            'title' => 'Limpieza de color', 
            'text' => 'Corregir el color para volver a construirlo.', 
            'info' => 'Técnica destinada a remover o disminuir pigmentos artificiales cuando necesitamos modificar un color previo. Se realiza únicamente después de evaluar el historial y el estado del cabello, priorizando siempre la integridad de la fibra.<br><br>El procedimiento y el resultado posible se determinan de manera personalizada en cada caso.<br><br>Tiempo aproximado: 2 a 3 hs.', 
            'img' => 'img/servicios/barrido.jpeg',
            'img_modal' => 'img/servicios/barrido.jpeg'
        ],
        [
            'title' => 'Nutrición & Tratamientos', 
            'text' => 'Un tratamiento elegido especialmente para tu cabello.', 
            'info' => 'No todos los cabellos necesitan lo mismo. Por eso, antes de realizar el servicio evalúo personalmente el estado de la fibra para elegir el tratamiento más adecuado según sus necesidades: nutrición, hidratación, reparación, fortalecimiento o cuidado post coloración.<br><br>Trabajo con líneas profesionales como L’Oréal Professionnel, Olaplex y Moroccanoil.<br><br>Tiempo aproximado: 45 min a 1½ hs, según el tratamiento.', 
            'img' => 'img/servicios/tratamiento.jpeg',
            'img_modal' => 'img/servicios/tratamiento.jpeg'
        ],
        [
            'title' => 'Alisado', 
            'text' => 'Suavidad, brillo y un cabello más fácil de manejar.', 
            'info' => 'Trabajo con productos sin formol, buscando reducir el frizz, controlar el volumen y conseguir un cabello más lacio y disciplinado.<br><br>El producto y el procedimiento se eligen según el diagnóstico previo, teniendo en cuenta la textura, el estado del cabello y los procesos químicos realizados anteriormente.<br><br>Tiempo aproximado: 2 a 3 hs.', 
            'img' => 'img/servicios/alisado.jpeg',
            'img_modal' => 'img/servicios/alisado.jpeg'
        ],
        [
            'title' => 'Lavado', 
            'text' => 'Un momento de cuidado para tu cabello.', 
            'info' => 'Lavado realizado con productos profesionales seleccionados según las necesidades del cuero cabelludo y del cabello.<br><br>Incluye shampoo y acondicionador, complementando la rutina cuando corresponde con productos de terminación como leave-in, protector térmico o sellador de puntas, seleccionados según las características de cada cabello.<br><br>Tiempo aproximado: 20 a 30 min.', 
            'img' => 'img/servicios/lavado.jpeg',
            'img_modal' => 'img/servicios/lavado.jpeg'
        ],
        [
            'title' => 'Peinado', 
            'text' => 'El toque final para resaltar tu cabello.', 
            'info' => 'Peinado personalizado según tu estilo y la ocasión: brushing, ondas, movimiento o terminaciones más pulidas.<br><br>Siempre utilizando productos profesionales y protección térmica para cuidar la fibra durante el proceso.<br><br>Tiempo aproximado: 45 min a 1 h, según largo y cantidad.', 
            'img' => 'img/servicios/peinado.jpeg',
            'img_modal' => 'img/servicios/peinado.jpeg'
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
                        data-service-info="{!! $item['info'] !!}"
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
                info.innerHTML = this.dataset.serviceInfo;
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