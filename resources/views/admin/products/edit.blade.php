    @extends('layouts.app')
    @section('content')
    <h1>Atualizar Produto</h1>
    <form action="{{route('admin.products.update', ['product' => $product->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Nome do Produto</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$product->name}}">
            @error('name')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"  value="{{$product->description}}">
            @error('description')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Conteúdo</label>
            <textarea name="body" id="" cols="30" rows="10"  class="form-control @error('body') is-invalid @enderror" >{{$product->body}}</textarea>
            @error('body')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Preço</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"  value="{{$product->price}}">
            @error('price')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Categorias</label>
            <select name="categories[]" id="" class="form-control" multiple>
                @foreach ($categories as $category)
                <option value="{{$category->id}}"
                    @if ($product->categories->contains($category))
                    selected
                @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Fotos do produto</label>
            <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple>
            @error('photos.*')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div>
            <button class="btn btn-lg btn-success" type="submit">Atualizar</button>
        </div>
    </form>
    <hr>
    <div class="row">
        @foreach ($product->photos as $photo)
            <div class="col-4 text-center">
            <img src="{{asset('storage/'. $photo->image)}}" alt="" class="img-fluid">
            <form action="{{route('admin.photo.remove')}}" method="POST">
                @csrf
            <input type="hidden" name="photoName" value="{{$photo->image}}">
                <button type="submit" class="btn btn-lg btn-danger">REMOVER</button>
            </form>
            </div>
        @endforeach
    </div>
    @endsection
