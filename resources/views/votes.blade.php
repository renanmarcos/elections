@extends('layouts.app')

@section('content')

<h1>Votos</h1>
    @if(count($candidates) > 0)
    @foreach($candidates as $candidate)
    <ul class="list-group">
        <li class="list-group-item">Nome: {{$candidate->name}}</li>
        <li class="list-group-item">Número do candidato: {{$candidate->number}}</li>
        <li class="list-group-item">Quantidade de votos: {{$candidate->votes}}</li>
    </ul>
    <br>
    @endforeach
    @endif
    @if (Auth::check())
    <h2>Digite o número do candidato que voce deseja votar:</h2>
    {!! Form::open(['url' => 'votos/mandar']) !!}
    {{Form::text('number', '', ['class' => 'form-control', 'placeholder' => 'Digite o número'])}}
    {{Form::submit('Mandar', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    @endif

@endsection