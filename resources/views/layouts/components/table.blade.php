<table class="table table-hover">
    <thead class="text-md-center">
        <tr>
            @foreach ($header as $item)
                <th>{{ $item }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($content[0] as $i => $id)
            <tr class="text-md-center">
                @foreach ($content as $column)
                    <td class="py-4">{{ $column[$i] }}</td>
                @endforeach
                <td class="py-4">
                    @foreach ($acoes as $acao)
                        @include('layouts.components.action-button', ['link' => route($acao['link'], [$acao['param'] => $id]), 'img' => $acao['img']])
                    @endforeach
                    
                    {{-- <a type="button" data-bs-toggle="modal" data-bs-target="#myModal" data-param1="{{ '$patrimonio' }}"
                        data-param2="{{ '$patrimonio->classificacao' }}" class="me-1"><img
                            src="{{ asset('/images/info.png') }}" width="24px" alt="Icon de edição">
                    </a> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>