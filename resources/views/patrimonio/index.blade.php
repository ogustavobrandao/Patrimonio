@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Patrimônio',
        'addButton' => route('patrimonio.create'),
        'searchForm' => route('patrimonio.busca.get'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Prédio', 'Sala', 'Ações'],
            'content' => [$patrimonios->pluck('id'), $patrimonios->pluck('nome'), $patrimonios->pluck('sala.predio.nome'), $patrimonios->pluck('sala.nome')],
            'acoes' => [
                ['link' => 'patrimonio.edit', 'param' => 'patrimonio_id', 'img' => asset('/images/pencil.png') , 'type' =>'editLink' ],
                ['link' => 'patrimonio.delete', 'param' => 'patrimonio_id', 'img' => asset('/images/delete.png'), 'type' =>'delete']
            ]
        ])

        <div class="d-flex justify-content-center">
            {{ $patrimonios->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detalhes do Patrimônio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nome do Patrimônio:</strong> <span id="patrimonio_nome"></span></p>
                    <p><strong>Classificação:</strong> <span id="classificacao"></span></p>
                    <p><strong>Valor Residual:</strong> <span id="valor_residual"></span></p>
                    <p><strong>Vida Útil:</strong> <span id="vida_util"></span> meses</p>
                    <hr>
                    <p><strong>Meses de Depreciação:</strong> <span id="meses"></span></p>
                    <p><strong>Valor Inicial do Item:</strong> R$ <span id="valor_inicial"></span></p>
                    <p><strong>Depreciação Atual do Item:</strong> R$ <span id="depreciacao_atual"></span></p>
                    <p><strong>Valor Atual do Item:</strong> R$ <span id="valor_atual"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function exibirModal() {
            $('#myModal').modal('show');
        }

        $(document).ready(function() {
            $('#myModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var patrimonio = button.data('param1')
                var classificacao = button.data('param2')

                var modal = $(this)

                var depreciacaoMensal = ((patrimonio.valor - classificacao.residual) / classificacao
                    .vida_util).toFixed(2);

                console.log(classificacao)

                var data = new Date(patrimonio.data_compra);
                var dataAtual = new Date();

                var anoData = data.getFullYear();
                var mesData = data.getMonth();
                var anoAtual = dataAtual.getFullYear();
                var mesAtual = dataAtual.getMonth();

                var diferencaMeses = (anoAtual - anoData) * 12 + (mesAtual - mesData);

                var depreciacaoAtual = (diferencaMeses * depreciacaoMensal).toFixed(2)
                var valorAtual = (patrimonio.valor - (diferencaMeses * depreciacaoMensal)).toFixed(2)


                modal.find('#myModalLabel').text(`Depreciação: ${patrimonio.nome}`)

                modal.find('#classificacao').text(`${classificacao.nome}`)
                modal.find('#vida_util').text(`${classificacao.vida_util} meses`)
                modal.find('#valor_residual').text(`R$ ${classificacao.residual}`)

                modal.find('#meses').text(`${diferencaMeses} meses`)
                modal.find('#valor_inicial').text(`R$ ${Number(patrimonio.valor).toFixed(2)}`)
                modal.find('#depreciacao_atual').text(`R$ ${depreciacaoAtual}`)

                Number(valorAtual) > Number(classificacao.residual) ?
                    modal.find('#valor_atual').text(`R$ ${valorAtual}`) :
                    modal.find('#valor_atual').text(`R$ ${classificacao.residual} (Valor residual)`)

            })
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#patrimonio_table').DataTable({
                searching: true,
                "language": {
                    "search": "Pesquisar: ",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Exibindo página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "zeroRecords": "Nenhum registro disponível",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Próximo"
                    }
                },
                "columnDefs": [{
                    "targets": [4],
                    "orderable": false
                }]
            });
        });
    </script>
@endpush
