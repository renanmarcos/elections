@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Candidatos</div>

                <div class="card-body">
                    @if (!empty(session('error')))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (!empty(session('success')))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(count($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <ul class="list-group">
                                <li class="list-group-item">Nome: {{$candidate->name}}</li>
                                <li class="list-group-item">Número do candidato: {{$candidate->candidate_number}}</li>
                                <li class="list-group-item">Quantidade de votos: {{$candidate->votes}}</li>
                            </ul>
                            <br>
                        @endforeach
                    @endif
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Criar um novo candidato</div>

                <div class="card-body">
                    @if (Auth::check())
                        {!! Form::open(['url' => 'candidates']) !!}
                        {{Form::text('name', '', [
                            'class' => 'form-control',
                            'placeholder' => 'Digite o nome',
                            'minlength' => '4',
                            'maxlength' => '255',
                            'required'
                            ])}}<br>
                        {{Form::text('candidate_number', '', [
                            'class' => 'form-control',
                            'placeholder' => 'Digite o número',
                            'minlength' => '4',
                            'maxlength' => '4',
                            'required'
                            ])}}<br>
                        {{Form::submit('Criar', ['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
