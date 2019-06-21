@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Votos</div>

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
                    @if (Auth::check())
                        <p>Digite o número do candidato que voce deseja votar:</p>
                        {!! Form::open(['onsubmit' => 'computeVoteUri(this);', 'name' => 'compute-vote-form']) !!}
                        {{Form::text('candidate-number', '', ['class' => 'form-control', 'placeholder' => 'Digite o número', 'id' => 'candidate-number'])}}
                        <br>
                        {{Form::submit('Computar voto', ['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function computeVoteUri(form) {
        form.action = "candidates/" + document.getElementById("candidate-number").value;
    }
</script>

@endsection
