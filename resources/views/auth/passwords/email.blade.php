@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{ trans('auth.forms.request-reset.title') }}
            </h1>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label block">
                    {{ trans('auth.forms.request-reset.fields.email.title') }}
                </label>

                <input class="input-text w-full{{ $errors->has('email') ? ' invalid' : '' }}" id="email" name="email" autofocus
                       required type="email" placeholder="{{ trans('auth.forms.request-reset.fields.email.placeholder') }}" value="{{ old('email') }}">

                @if ($errors->has('email'))
                    <span class="form-error" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="md:flex items-center justify-between">
                <button class="mb-2 button-white" type="submit">
                    {{ trans('auth.forms.request-reset.button') }}
                </button>

                <div>
                    @if (Route::has('login'))
                        <a class="nice-link px-2" href="{{ route('login') }}">{{ trans('auth.forms.request-reset.login') }}</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
