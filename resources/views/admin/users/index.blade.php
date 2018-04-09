@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de Usuários</h3>
            {!! Button::primary('Novo Usuário')->asLinkTo(route('admin.users.create')) !!}
        </div>

        <div class="row">
            {{--renderiza a tabela com facade bootstrapper--}}
           {!! Table::withContents($users->items())->striped()
           ->callback('Ações', function ($field, $user){
            $linkEdit = route('admin.users.edit', ['user' => $user->id]);
            $linkShow = route('admin.users.show', ['user' => $user->id]);
            return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit) . '|' .
                    Button::link(Icon::create('remove'))->asLinkTo($linkShow);
           })
            !!}
        </div>
        {{--links da paginação--}}
        {!! $users->links() !!}
    </div>
@endsection
