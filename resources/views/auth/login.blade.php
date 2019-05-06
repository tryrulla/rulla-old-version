@extends('layouts.app')

@section('title', 'Log in')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>
                {{ trans('auth.forms.login.title') }}
            </h1>
        </div>

        <form class="p-4" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="md:flex flex-wrap">
                <div class="md:w-1/2 max-md:py-2 md:pr-4">
                    <label for="identity" class="form-label block">
                        {{ trans('auth.forms.login.fields.identity.title') }}
                    </label>

                    <input class="input-text w-full{{ ($errors->has('identity') || $errors->has('username') || $errors->has('email')) ? ' invalid' : '' }}" id="identity" name="identity" autofocus
                           required type="text" placeholder="{{ trans('auth.forms.login.fields.identity.placeholder') }}" value="{{ old('identity') }}">

                    @if ($errors->has('identity'))
                        <span class="form-error" role="alert">
                            <strong>{{ $errors->first('identity') }}</strong>
                        </span>
                    @elseif ($errors->has('username'))
                        <span class="form-error" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @elseif ($errors->has('email'))
                        <span class="form-error" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="md:w-1/2 max-md:py-2 md:pl-4">
                    <label for="password" class="form-label block">
                        {{ trans('auth.forms.login.fields.password.title') }}
                    </label>

                    <input class="input-text w-full{{ $errors->has('password') ? ' invalid' : '' }}" id="password"
                           name="password" type="password" placeholder="{{ trans('auth.forms.login.fields.password.placeholder') }}" value="{{ old('password') }}">

                    @if ($errors->has('password'))
                        <span class="form-error" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-2 mb-4">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label for="remember" class="ml-2 text-gray-800 inline-block">
                    {{ trans('auth.forms.login.fields.remember') }}
                </label>
            </div>

            <div class="md:flex items-center justify-between">
                <button class="mb-2 button-white" type="submit">
                    {{ trans('auth.forms.login.button') }}
                </button>

                <div>
                    @if (Route::has('password.request'))
                        <a class="nice-link px-2" href="{{ route('password.request') }}">{{ trans('auth.forms.login.forgot') }}</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
