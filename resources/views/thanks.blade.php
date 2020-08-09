@extends('layouts.front')

@section('content')

<h2 class="alert alert-success">Muito obrigado!</h2>
<h3>Seu pedido foi recebido. Código do pedido: {{request()->get('order')}}</h3>

@endsection
