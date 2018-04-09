@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Categoria</h3>
            <?php $iconEdit = Icon::create('pencil');?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.categories.edit', ['category' => $category->id])) !!}
            <?php $iconDestroy = Icon::create('remove');?>
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.categories.destroy',['category' => $category->id]))
                ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit();"])
            !!}
            <?php $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.categories.destroy','category' => $category->id],
                'method' => 'DELETE',
                'style'=> 'display:none'
            ])?>

            {!! form($formDelete ) !!}
            <br/><br/>
            <div class="row">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">#</th>
                        <td>{{$category->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Categoria</th>
                        <td>{{$category->category}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection