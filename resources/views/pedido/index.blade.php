@extends('plantilla.app')
@section('contenido')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Reservas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            <form action="{{route('productos.index')}}" method="get">
                                <div class="input-group">
                                    <input name="texto" type="text" class="form-control" value="{{$texto}}"
                                        placeholder="Ingrese texto a buscar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i>
                                            Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(Session::has('mensaje'))
                        <div class="alert alert-info alert-dismissible fade show mt-2">
                            {{Session::get('mensaje')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                        </div>
                        @endif
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Reserva</th>
                                        <th>Habitación</th>
                                        <th>Usuario</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Huéspedes</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($registros->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No hay reservas que coincidan con la búsqueda.</td>
                                        </tr>
                                    @else
                                        @foreach($registros as $reserva)
                                            <tr class="align-middle">
                                                <td>{{ $reserva->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('uploads/productos/' . $reserva->producto->imagen) }}" class="img-fluid rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $reserva->producto->nombre }}">
                                                        <span>{{ $reserva->producto->nombre }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $reserva->pedido->user->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}</td>
                                                <td>{{ $reserva->huespedes }}</td>
                                                <td>
                                                    @php
                                                        $status = $reserva->estadia_status;
                                                        $colores = [
                                                            'Próxima' => 'bg-info',
                                                            'En curso' => 'bg-success',
                                                            'Finalizada' => 'bg-secondary',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $colores[$status] ?? 'bg-dark' }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{$registros->appends(["texto"=>$texto])}}
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@endsection
@push('scripts')
<script>
document.getElementById('mnuPedidos').classList.add('active');
</script>
@endpush