@if ($type == 'delete')
    <form action="{{ $link }}" method="POST">
        @csrf
        @method('delete')
        <button class="btn me-1 p-0" ><img src="{{ $img }}" alt="Ícone de Ação"></button>
    </form>
@elseif ($type == 'edit')
    <button class="btn me-1 p-0" onclick="openEditModal({{ $id }})">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação">
    </button>
@elseif ($type == 'editLink')
    <a href="{{ $link }}" class="me-1"><img src="{{ $img }}" width="24px"
        alt="Icon de edição">
    </a>
@endif
