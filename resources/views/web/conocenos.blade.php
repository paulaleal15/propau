@extends('web.app')
@section('contenido')

<style>
    .service-card {
        transition: transform 0.3s ease-in-out;
    }
    .service-card:hover {
        transform: translateY(-10px);
    }
</style>

<section class="py-5 bg-light">
    <div class="container px-5">
        <div class="row gx-5">
            <div class="col-xl-8">
                <h1 class="fw-bolder fs-2 mb-4">Nosotros</h1>
                <p class="lead fw-normal text-muted mb-4">Descubre la historia, misión y los servicios excepcionales que hacen de nuestro hotel tu mejor opción para una estancia inolvidable.</p>
            </div>
        </div>
    </div>
</section>

<!-- About section one-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="{{ asset('img/image.png') }}" alt="Nuestra Historia" /></div>
            <div class="col-lg-6">
                <h2 class="fw-bolder">Nuestra Historia</h2>
                <p class="lead fw-normal text-muted mb-0">Imperial Suites fue creado con el objetivo de ofrecer comodidad, buen servicio y una experiencia agradable a sus huéspedes. Desde sus inicios, se ha enfocado en la atención personalizada y en el uso de la tecnología para mejorar la gestión hotelera y la satisfacción del cliente.</p>
            </div>
        </div>
    </div>
</section>

<!-- About section two-->
<section class="py-5 bg-light">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6 order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0" src="{{ asset('img/image2.jpeg') }}" alt="Misión y Visión" /></div>
            <div class="col-lg-6">
                <h2 class="fw-bolder">Misión y Visión</h2>
                <p class="lead fw-normal text-muted mb-0">Imperial Suites tiene como misión brindar un servicio de alojamiento de calidad, con atención personalizada y comodidad para sus huéspedes, apoyándose en el uso de la tecnología; y como visión, consolidarse como un hotel reconocido por su buen servicio, innovación y compromiso con la satisfacción del cliente en el sector hotelero.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services section-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bolder">Nuestros Servicios</h2>
            <p class="lead fw-normal text-muted mb-0">Ofrecemos una amplia gama de servicios para asegurar que tu estancia sea cómoda y placentera.</p>
        </div>
        <div class="row gx-5">
            <div class="col-lg-4 mb-5">
                <div class="text-center service-card">
                    <i class="bi bi-wifi fs-1 text-primary"></i>
                    <h3 class="fw-bolder">Wi-Fi de Alta Velocidad</h3>
                    <p class="text-muted">Conéctate sin problemas en todas nuestras instalaciones.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="text-center service-card">
                    <i class="bi bi-cup-straw fs-1 text-primary"></i>
                    <h3 class="fw-bolder">Restaurante y Bar</h3>
                    <p class="text-muted">Disfruta de una exquisita gastronomía y cócteles de autor.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="text-center service-card">
                    <i class="bi bi-building fs-1 text-primary"></i>
                    <h3 class="fw-bolder">Salas de Conferencias</h3>
                    <p class="text-muted">Espacios equipados para tus eventos y reuniones de negocios.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
