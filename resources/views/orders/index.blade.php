@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Pedidos Recebidos</h2>
        <hr>
    </div>
    <div class="col-12">
        <div class="accordion" id="accordionExample">
            @forelse ($orders as $key => $order)
            <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                      Pedido n°: {{$order->reference}}
                    </button>
                  </h2>
                </div>
                <div id="collapse{{$key}}" class="collapse @if ($key == 0) show @endif " aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <h6>Informações do cliente</h6>
                    <p>Nome: {{$order->user->name}}</p>
                    <p>Email: {{$order->user->email}}</p>
                    <hr>
                    <h6>Dados do pedido</h6>
                    <p>Status: {{$order->pagseguro_status}}</p>
                    @php
                        $items = unserialize($order->items);
                        $total = 0;
                        foreach ($items as $item) {
                            $total = $total + ($item['price'] * $item['amount']);
                        }
                    @endphp
                    @foreach (filterItemsByStoreId($items, auth()->user()->store->id) as $item)
                    <ul>
                        <li>Item: {{$item['name']}}</li>
                        <li>Valor: R${{number_format($item['price'],2,",",".")}}</li>
                        <li>Quantidade: {{$item['amount']}}</li>
                    </ul>
                    @endforeach
                    <p>Valor total do pedido: R${{number_format($total,2,",",".")}}</p>
                  </div>
                </div>
              </div>
            @empty
                <div class="alert alert-warning">Não há pedidos recebidos</div>
            @endforelse
          </div>
          {{$orders->links()}}
    </div>
</div>

@endsection
