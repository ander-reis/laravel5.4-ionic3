@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Vídeos</h3>
            <?php $iconEdit = Icon::create('pencil');?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.videos.edit', ['videos' => $video->id])) !!}
            <?php $iconDestroy = Icon::create('remove');?>
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.videos.destroy',['video' => $video->id]))
                ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit();"])
            !!}
            <?php $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.videos.destroy','video' => $video->id],
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
                            <img src="{{$video->thumb_asset}}" width="512" height="360">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Video</th>
                        <td>
                            <a href="{{$video->file_asset}}" target="_blank">Download</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">#</th>
                        <td>{{$video->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Título</th>
                        <td>{{$video->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Descrição</th>
                        <td>{{$video->description}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection