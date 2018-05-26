@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Ver planos</h3>
            <?php $iconEdit = Icon::create('pencil'); ?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.plans.edit',['plan' => $plan->id])) !!}
            <?php $iconDestroy = Icon::create('remove'); ?>
            {!! Button::danger($iconDestroy)
            ->asLinkTo(route('admin.plans.destroy',['plan' => $plan->id]))
            ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit()"])
            !!}
            <?php
            $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.plans.destroy', 'plan' => $plan->id],
                'method' => 'DELETE',
                'style' => 'display:none'
            ])
            ?>
            {!! form($formDelete) !!}
            <br><br>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="row">#</th>
                    <td>{{$plan->id}}</td>
                </tr>
                <tr>
                    <th scope="row">Nome</th>
                    <td>{{$plan->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Descrição</th>
                    <td>{{$plan->description}}</td>
                </tr>
                <tr>
                    <th scope="row">Duração</th>
                    <td>{{$plan->duration}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection