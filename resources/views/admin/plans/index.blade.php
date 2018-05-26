@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de planos</h3>
            {!! Button::primary('Novo plano')->asLinkTo(route('admin.plans.create')) !!}
        </div>
        <div class="row">
            {!!
               Table::withContents($plans->items())->striped()->callback('Ações', function ($field, $plans){
                  $linkEdit = route('admin.plans.edit',['plan' => $plans->id]);
                  $linkShow = route('admin.plans.show',['plan' => $plans->id]);
                  return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit).'|'.
                              Button::link(Icon::create('remove'))->asLinkTo($linkShow);
               })
            !!}
        </div>
        {!! $plans->Links() !!}
    </div>
@endsection