<style>
    
    .services-grid {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important; 
        gap: 50px !important; /* Más espacio y aire entre tarjetas */
    }

    
    @media (max-width: 1024px) {
        .services-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 35px !important;
        }
    }
    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr !important;
            gap: 25px !important;
        }
    }

    
    .service-card {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
    }

   
    .service-media {
        width: 100% !important;
        height: 280px !important; 
        overflow: hidden !important;
    }
    .service-media img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important; 
        object-position: center !important; 
        display: block !important;
    }

   
    .service-body {
        flex-grow: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
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
                    'img' => 'img/servicios/corte.jpeg'
                ],
                [
                    'title' => 'Balayage', 
                    'text' => 'Sutil, elegante, y de bajo mantenimiento.', 
                    'info' => 'Técnica de coloración artesanal que aporta luz natural, volumen y un efecto suavemente degradado.', 
                    'img' => 'img/servicios/balayage.jpeg'
                ],
                [
                    'title' => 'Alisado', 
                    'text' => 'Consigue un cabello liso y sedoso con nuestros tratamientos.', 
                    'info' => 'Ideal para controlar el frizz y lograr un acabado brillante, con productos pensados para cuidar la fibra.', 
                    'img' => 'img/servicios/alisado.jpeg'
                ],
                [
                    'title' => 'Nutrición / Tratamiento', 
                    'text' => 'Consigue un cabello sano y brillante con nuestros tratamientos.', 
                    'info' => 'Tratamiento profundo de hidratación y reparación intensa para restaurar la elasticidad y el brillo natural.', 
                    'img' => 'img/servicios/tratamiento.jpeg'
                ],
                [
                    'title' => 'Lavado', 
                    'text' => 'Un ritual pensado para relajar y cuidar tu experiencia en el salón.', 
                    'info' => 'Incluye masaje capilar neurosedante, elección del shampoo ideal según tu cuero cabelludo y secado.', 
                    'img' => 'img/servicios/lavado.jpeg'
                ],
                [
                    'title' => 'Peinado', 
                    'text' => 'Peinados personalizados para cada ocasión.', 
                    'info' => 'Perfecto para eventos, fiestas o días especiales, con opciones de recogidos u ondas que se adaptan a tu outfit.', 
                    'img' => 'img/servicios/peinado.jpeg'
                ],
                [
                    'title' => 'Barrido', 
                    'text' => 'Decoloración suave para limpiar tonos viejos o aclarar tu base.', 
                    'info' => 'Elimina pigmentos acumulados de tinturas anteriores para preparar el cabello hacia un nuevo color reflejo.', 
                    'img' => 'img/servicios/barrido.jpeg'
                ],
                [
                    'title' => 'Color Completo', 
                    'text' => 'Renovación total de tu color de raíz a puntas.', 
                    'info' => 'Aplicación global de tinturas premium con alta protección para lograr un color uniforme, vibrante y duradero.', 
                    'img' => 'img/servicios/color completo.jpeg'
                ],
                [
                    'title' => 'Coloración de Raíces', 
                    'text' => 'Mantenimiento preciso para cubrir canas o crecimiento.', 
                    'info' => 'Retoque localizado en el crecimiento de la raíz para emparejar tu color global y asegurar una cobertura del 100%.', 
                    'img' => 'img/servicios/coloracion de rices.jpeg'
                ],
                [
                    'title' => 'Mechas Balayage', 
                    'text' => 'Contraste y definición de luz para tu melena.', 
                    'info' => 'Combinación avanzada de iluminación localizada que genera un contraste armónico y tridimensional.', 
                    'img' => 'img/servicios/mechas balayage.jpeg'
                ],
                [
                    'title' => 'Mechas Tradicionales', 
                    'text' => 'Reflejos definidos desde la raíz para un rubio impactante.', 
                    'info' => 'Técnica clásica con papel aluminio para conseguir una distribución uniforme de reflejos claros y luminososos.', 
                    'img' => 'img/servicios/mechas.jpeg'
                ],
                [
                    'title' => 'Corte de Flequillo', 
                    'text' => 'Un cambio rápido para enmarcar tu mirada.', 
                    'info' => 'Diseño y texturización de flequillo (recto, cortina o desmechado) para renovar tu look sin tocar el largo general.', 
                    'img' => 'img/servicios/flequillo.jpeg'
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
                    <button type="button" class="service-link" data-service-title="{{ $item['title'] }}" data-service-info="{{ $item['info'] }}">Ver más</button>
                </div>
            </article>
        @endforeach
    </div>
</section>


<div id="service-modal" class="service-modal" aria-hidden="true">
    <div class="service-modal__content">
        <button type="button" class="service-modal__close" id="service-modal-close" aria-label="Cerrar">×</button>
        <h3 id="service-modal-title"></h3>
        <p id="service-modal-info"></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('service-modal');
        const title = document.getElementById('service-modal-title');
        const info = document.getElementById('service-modal-info');
        const closeBtn = document.getElementById('service-modal-close');

        document.querySelectorAll('.service-link').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                title.textContent = this.dataset.serviceTitle;
                info.textContent = this.dataset.serviceInfo;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        const closeModal = () => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        };

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>