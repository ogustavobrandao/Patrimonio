@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Cargos',
        'addButtonModal' => 'cadastrarCargoModal',
        'searchForm' => route('cargo.buscar'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Ações'],
            'content' => [
                $cargos->pluck('id'),
                $cargos->pluck('nome'),
            ],
            'acoes' => [
                [
                    'link' => 'cargo.edit',
                    'param' => 'cargo_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                ['link' => 'cargo.delete', 'param' => 'cargo_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $cargos->links('pagination::bootstrap-4') }}
        </div>
    </div>


    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarCargoModal',
        'modalTitle' => 'Cadastrar Cargo',
        'formAction' => route('cargo.store'),
        'type' => ('create'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'editarCargoModal',
        'modalTitle' => 'Editar Cargo',
        'formAction' => route('cargo.update', ['cargo_id' => 'cargo_id']),
        'type' => ('edit'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Cargo?',
        'route' => route('cargo.delete', ['cargo_id' => 'id']), 
    ])

@endsection

@push('scripts')
    <script>
        const editModal = $('#editarCargoModal');
        const updateRoute = "{{ route('cargo.update', ['cargo_id' => 'cargo_id']) }}";
        var cargoId = 0;
        const cargos = {!! json_encode($cargos->pluck('nome', 'id')) !!}
        $(document).ready(function() {
            editModal.on('show.bs.modal', function(event) {
                var formAction = updateRoute.replace('cargo_id', cargoId);
                editModal.find('form').attr('action', formAction);
                $('#nome-edit').val(cargos[cargoId]);

            });
        });
  
        function openEditModal(id) {
            cargoId = id;
            editModal.modal('show');
        }

    const cargoDeleteRoute = "http://127.0.0.1:8000/cargo/id/delete";
        
        function openDeleteModal(id) {
            cargoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = cargoDeleteRoute.replace('id', cargoId);
                $(this).find('form').attr('action', formAction);
            });
        });

    </script>
@endpush
