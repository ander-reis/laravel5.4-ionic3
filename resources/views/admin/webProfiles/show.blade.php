@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Ver perfil PayPal</h3>
            <?php $iconDestroy = Icon::create('remove'); ?>
            {!! Button::danger($iconDestroy)
            ->asLinkTo(route('admin.web_profiles.destroy',['web_profile' => $web_profile->id]))
            ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit()"])
            !!}
            <?php
            $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.web_profiles.destroy', 'web_profile' => $web_profile->id],
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
                    <td>{{$web_profile->id}}</td>
                </tr>
                <tr>
                    <th scope="row">Nome</th>
                    <td>{{$web_profile->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Logo Url</th>
                    <td>{!! \BootstrapImage::thumbnail($web_profile->logo_url, 'thumbnail') !!}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection