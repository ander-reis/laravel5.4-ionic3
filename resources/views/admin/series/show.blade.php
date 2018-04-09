@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Séries</h3>
            <?php $iconEdit = Icon::create('pencil');?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.series.edit', ['serie' => $serie->id])) !!}
            <?php $iconDestroy = Icon::create('remove');?>
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.series.destroy',['serie' => $serie->id]))
                ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit();"])
            !!}
            <?php $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.series.destroy','serie' => $serie->id],
                'method' => 'DELETE',
                'style'=> 'display:none'
            ])?>

            {!! form($formDelete ) !!}
            <br/><br/>
            <div class="row">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">Thumb</th>
                        <td>
                            <img src="{{$serie->thumb_asset}}" width="512" height="360">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">#</th>
                        <td>{{$serie->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Título</th>
                        <td>{{$serie->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Descrição</th>
                        <td>{{$serie->description}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection