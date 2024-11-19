<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up - Nafast Media</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('registerform/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('registerform/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/extra-component-sweetalert.css') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app-dark.css') }}">
</head>

<body>
    <img class="wave" src="{{ asset('registerform/images/wave.png') }}" />
    <div class="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="{{ route('register.store') }}" method="POST" class="register-form"
                            id="register-form">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"
                                    value="{{ old('name') }}" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"
                                    value="{{ old('email') }}" />
                            </div>

                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Your Username"
                                    value="{{ old('username') }}" />
                            </div>

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_confirmation" id="re_pass"
                                    placeholder="Repeat your password" />
                            </div>

                            <div class="input-div one">
                                <div class="i">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="div">
                                    <h5>Jabatan</h5>
                                    <select style="border-radius: 10px; padding: 5px;" name="jabatan_id" class="input"
                                        required>
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}"
                                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                                {{ $jabatan->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit"
                                    value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img style="width: 65%;" src="{{ asset('registerform/images/signupimage.jpg') }}"
                                alt="sing up image">
                        </figure>
                        <a href="{{ route('login') }}" class="signup-image-link">I am
                            already have
                            account</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script src="{{ asset('registerform/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('registerform/js/main.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/sweetalert2.js') }}"></script>

    <script>
        @if ($errors->any())
            let errorMessages = '';

            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}\n';
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessages,
            });
        @endif

        @if (session('error'))
            console.log('Session error:', '{{ session('error') }}');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            })
        @endif
    </script>
</body>

</html>
