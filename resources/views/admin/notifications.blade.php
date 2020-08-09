@extends('layouts.app')
@section('content')
<a href="{{route('admin.notifications.read.all')}}" class="btn btn-lg btn-success">Marcar todas como lidas</a>
@if ($unreadNotifications->count())
<table class="table table-striped" style="margin-top: 25px">
    <thead>
        <tr>
            <th>Notificação</th>
            <th>Criado em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($unreadNotifications as $n)
        <tr>
            <td>{{$n->data['message']}}</td>
            <td>{{$n->created_at->locale('pt')->diffForhumans()}}</td>
            <td>
                <div class="btn-group">
                    <a href="{{route('admin.notifications.read', ['notification' => $n->id])}}" class="btn btn-sm btn-info">Marcar como lida</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<hr>
<div class="alert alert-warning">Não há novas notificações.</div>
@endif

@endsection
