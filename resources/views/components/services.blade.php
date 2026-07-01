<section class="servicios">
    <h2>Nuestros Servicios</h2>
    <div class="services-grid">
        @php
            $items = [
                ['title' => 'Corte', 'text' => 'Diseñado a medida, respetando tu estilo y la forma de tu rostro.', 'info' => 'Incluye diagnóstico de rostro y tipo de cabello, corte preciso y asesoramiento para mantenerlo perfecto en casa.', 'img' => 'services/corte.jpg'],
                ['title' => 'Balayage', 'text' => 'Sutil, elegante, y de bajo mantenimiento', 'info' => 'Técnica de coloración artesanal que aporta luz natural, volumen y un efecto suavemente degradado.', 'img' => 'services/balayage.jpg'],
                ['title' => 'Alisado', 'text' => 'Consigue un cabello liso y sedoso con nuestros tratamientos.', 'info' => 'Ideal para controlar el frizz y lograr un acabado brillante, con productos pensados para cuidar la fibra.', 'img' => 'services/alisado.jpg'],
                ['title' => 'Nutrición', 'text' => 'Consigue un cabello sano y brillante con nuestros tratamientos.', 'info' => 'Tratamiento profundo de hidratación y reparación para restaurar la elasticidad y el brillo.', 'img' => 'services/nutricion.jpg'],
                ['title' => 'Lavado', 'text' => 'Lavado: un ritual pensado para relajar y cuidar tu experiencia en el salón.', 'info' => 'Incluye masaje capilar, elección del producto ideal y secado con atención a tu tipo de cabello.', 'img' => 'services/lavado.jpg'],
                ['title' => 'Peinado', 'text' => 'Peinados personalizados para cada ocasión.', 'info' => 'Perfecto para eventos, fotos o días especiales, con opciones que se adaptan a tu estilo.', 'img' => 'services/peinado.jpg'],
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
