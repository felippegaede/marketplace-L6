    @extends('layouts.app')
    @section('content')
    <h1>Cadastrar Produto</h1>
    <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">Nome do Produto</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
            @error('name')
                <small class='invalid-feedback'>{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">
            @error('description')
                <small class='invalid-feedback'>{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Conteúdo</label>
            <textarea name="body" id="" cols="30" rows="10"  class="form-control @error('body') is-invalid @enderror" value="{{old('body')}}"></textarea>
            @error('body')
            <small class='invalid-feedback'>{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Preço</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}">
            @error('price')
                <small class='invalid-feedback'>{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Categorias</label>
            <select name="categories[]" id="" class="form-control" multiple>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Fotos do produto</label>
            <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple>
            @error('photos.*')
                <small class="invalid-feeedback">{{$message}}</small>
            @enderror
        </div>

        <div>
        <button class="btn btn-lg btn-success" type="submit">Salvar</button>
        </div>
    </form>
    @endsection
