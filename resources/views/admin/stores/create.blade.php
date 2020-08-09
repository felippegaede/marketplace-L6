    @extends('layouts.app')
    @section('content')
    <h1>Cadastrar Loja</h1>
    <form action="{{route('admin.stores.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">Loja</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
            @error('name')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">
            @error('description')
            <small class="invalid-feedback">{{$message}}</small>
        @enderror
        </div>
        <div class="form-group">
            <label for="">Telefone</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}">
            @error('phone')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Celular</label>
            <input type="text" name="mobile_phone" class="form-control @error('mobile_phone') is-invalid @enderror" value="{{old('mobile_phone')}}">
            @error('mobile_phone')
            <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Logo da loja</label>
            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
            @error('logo')
                <small class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div>
        <button class="btn btn-lg btn-success" type="submit">Salvar</button>
        </div>
    </form>
    @endsection
