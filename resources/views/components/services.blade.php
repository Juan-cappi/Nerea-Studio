<section class="servicios">
    <h2>Nuestros Servicios</h2>
    <div class="services-grid">
        @php
            $items = [
                ['title' => 'Corte', 'text' => 'Diseñado a medida, respetando tu estilo y la forma de tu rostro.', 'img' => 'services/corte.jpg'],
                ['title' => 'Balayage', 'text' => 'Sutil, elegante, y de bajo mantenimiento', 'img' => 'services/balayage.jpg'],
                ['title' => 'Alisado', 'text' => 'Consigue un cabello liso y sedoso con nuestros tratamientos.', 'img' => 'services/alisado.jpg'],
                ['title' => 'Nutrición', 'text' => 'Consigue un cabello sano y brillante con nuestros tratamientos.', 'img' => 'services/nutricion.jpg'],
                ['title' => 'Lavado', 'text' => 'Lavado: un ritual pensado para relajar y cuidar tu experiencia en el salón.', 'img' => 'services/lavado.jpg'],
                ['title' => 'Peinado', 'text' => 'Peinados personalizados para cada ocasión.', 'img' => 'services/peinado.jpg'],
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
                    <a href="#" class="service-link">Ver mas</a>
                </div>
            </article>
        @endforeach
    </div>
</section>
