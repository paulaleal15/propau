@extends('web.app')
@section('contenido')

<section class="py-5 bg-light">
    <div class="container px-5">
        <div class="row gx-5">
            <div class="col-xl-8">
                <h1 class="fw-bolder fs-2 mb-4">Conócenos</h1>
                <p class="lead fw-normal text-muted mb-4">Descubre la historia, misión y los servicios excepcionales que hacen de nuestro hotel tu mejor opción para una estancia inolvidable.</p>
            </div>
        </div>
    </div>
</section>

<!-- About section one-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="https://dummyimage.com/600x400/343a40/6c757d" alt="Nuestra Historia" /></div>
            <div class="col-lg-6">
                <h2 class="fw-bolder">Nuestra Historia</h2>
                <p class="lead fw-normal text-muted mb-0">Fundado en [Año], nuestro hotel ha crecido desde un modesto comienzo hasta convertirse en un referente de hospitalidad y lujo. Cada rincón de nuestro hotel cuenta una historia de dedicación y pasión por el servicio.</p>
            </div>
        </div>
    </div>
</section>

<!-- About section two-->
<section class="py-5 bg-light">
    <div class="container px-5 my-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6 order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0" src="https://dummyimage.com/600x400/343a40/6c757d" alt="Misión y Visión" /></div>
            <div class="col-lg-6">
                <h2 class="fw-bolder">Misión y Visión</h2>
                <p class="lead fw-normal text-muted mb-0">Nuestra misión es ofrecer experiencias memorables a través de un servicio personalizado y de alta calidad. Aspiramos a ser reconocidos como el hotel líder en nuestra categoría, innovando constantemente para superar las expectativas de nuestros huéspedes.</p>
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
                <div class="text-center">
                    <i class="bi bi-wifi fs-1 text-primary"></i>
                    <h3 class="fw-bolder">Wi-Fi de Alta Velocidad</h3>
                    <p class="text-muted">Conéctate sin problemas en todas nuestras instalaciones.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="text-center">
                    <i class="bi bi-cup-straw fs-1 text-primary"></i>
                    <h3 class="fw-bolder">Restaurante y Bar</h3>
                    <p class="text-muted">Disfruta de una exquisita gastronomía y cócteles de autor.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="text-center">
                    <i class="bi bi-person-workspace fs-1 text-primary"></i>
                    <h3 class="fw-bolder">Salas de Conferencias</h3>
                    <p class="text-muted">Espacios equipados para tus eventos y reuniones de negocios.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
