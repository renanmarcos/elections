@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique seu endereço de E-Mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um link de recuperação foi enviado para o seu E-Mail.') }}
                        </div>
                    @endif

                    {{ __('Por favor, verifique seu E-Mail para encontrar o link de recuperação.') }}
                    {{ __('Se você não recebeu o E-Mail') }}, <a href="{{ route('verification.resend') }}">{{ __('clique aqui para enviar outro.') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
