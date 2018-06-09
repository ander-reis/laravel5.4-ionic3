@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de perfis PayPal</h3>
            {!! Button::primary('Novo perfil PayPal')->asLinkTo(route('admin.web_profiles.create')) !!}
        </div>
        <div class="row">
            {!!
                    Table::withContents($webProfiles->items())->striped()->bordered()
                        ->callback('Ações', function ($field, $webProfile){
                          $linkEdit = route('admin.web_profiles.edit',['user' => $webProfile->id]);
                          $linkShow = route('admin.web_profiles.show',['user' => $webProfile->id]);
                          return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit).'|'.
                                 Button::link(Icon::create('remove'))->asLinkTo($linkShow);
                    })
            !!}
        </div>
        {!! $webProfiles->Links() !!}
    </div>
@endsection