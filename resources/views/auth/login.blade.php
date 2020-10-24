<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/genetic.light.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font/iconsmind/style.css') }}">
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}">

    <title>Iniciar Sesión</title>
</head>
<body>

        <div class="fixed-background"></div>
        <main id="app-vue">
            <div class="container-fluid">
                <div class="row h-100 p-0 m-0">
                    <div class="col-4 col-md-4 mx-auto my-auto">
                        <div class="card auth-card">
                            <div class="form-side">
                                <a href="#">
                                    <span class="logo-single"></span>
                                </a>
                                <h6 class="mb-4">Inicio de Sesión GeneticApp</h6>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                            <label for="usuario" class="has-float-label mb-4">
                                                <span>Nombre de Usuario</span>
                                            </label>
                                            <input id="usuario" type="text" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('usuario') }}"  autofocus>

                                            @if ($errors->has('usuario'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('usuario') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                                <label for="password" class="has-float-label mb-4">
                                                    <span>Contraseña</span>
                                                </label>
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}"  autofocus>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="#">Recuperar contraseña?</a>
                                        <button class="btn btn-primary btn-md btn-shadow" type="submit">INICIAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <script src="{{ asset('js/app.js')}}"></script>
        <script src="{{ asset('js/genetic.script.js')}}"></script>
        <script src="{{ asset('js/script.js')}}"></script>

</body>
</html>
