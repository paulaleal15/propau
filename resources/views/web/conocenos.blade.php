@extends('web.app')

@section('contenido')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center mb-4">Conócenos</h1>

                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Nuestra Historia</h2>
                        <p class="card-text">
                            Aquí va la historia del hotel o del negocio. Se puede detallar cómo empezó, su evolución a lo largo del tiempo y los hitos más importantes que ha alcanzado.
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Misión y Visión</h2>
                        <p class="card-text">
                            <strong>Misión:</strong> Describe cuál es el propósito fundamental del hotel, a quién sirve y qué valor ofrece a sus clientes.
                        </p>
                        <p class="card-text">
                            <strong>Visión:</strong> Detalla hacia dónde se dirige el hotel a largo plazo y cuáles son sus aspiraciones.
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Nuestros Valores</h2>
                        <ul>
                            <li><strong>Calidad:</strong> Compromiso con la excelencia en cada detalle.</li>
                            <li><strong>Hospitalidad:</strong> Trato cálido y personalizado para que te sientas como en casa.</li>
                            <li><strong>Integridad:</strong> Actuamos con honestidad y transparencia.</li>
                            <li><strong>Innovación:</strong> Buscamos continuamente nuevas formas de mejorar tu experiencia.</li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">¿Qué nos diferencia?</h2>
                        <p class="card-text">
                            Explica aquí los aspectos únicos que distinguen al hotel de la competencia: puede ser la ubicación, un servicio exclusivo, el diseño, la gastronomía, etc.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Contacto</h2>
                        <ul class="list-unstyled">
                            <li><strong><i class="fas fa-phone"></i> Teléfono:</strong> +123 456 7890</li>
                            <li><strong><i class="fas fa-envelope"></i> Email:</strong> contacto@hotel.com</li>
                            <li><strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong> Calle Falsa 123, Ciudad, País</li>
                        </ul>
                        <h4 class="mt-3">Síguenos en Redes Sociales</h4>
                        <a href="#" class="btn btn-outline-primary"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-info"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-danger"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
