<!DOCTYPE html>
<html>

<head>
    <title>Nafast Media</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('loginform/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/extra-component-sweetalert.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <img class="wave" src="{{ asset('loginform/img/wave.png') }}" />
    <div class="container">
        <div class="img">
            <img src="{{ asset('loginform/img/bg.svg') }}" />
        </div>
        <div class="login-content">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <img src="{{ asset('loginform/img/avatar.svg') }}" />
                <h2 class="title">Welcome</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="username" required autocomplete="off">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" name="password" class="input" required>
                    </div>
                </div>
                <button type="submit" class="btn">Login</button>
                <a href="{{ route('register') }}">Create an account</a>
            </form>


        </div>
    </div>
    <script type="text/javascript" src="{{ asset('loginform/js/main.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/sweetalert2.js') }}"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            })
        @endif

        @if (session('error'))
            console.log('Session error:', '{{ session('error') }}');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
</body>

</html>
