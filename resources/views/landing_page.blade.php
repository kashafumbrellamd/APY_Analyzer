<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <style>
        #login img {
            margin: 10px 0;
        }

        #login .center {
            text-align: center;
        }

        #login .login {
            max-width: 300px;
            margin: 35px auto;
        }

        #login .login-form {
            padding: 0px 25px;
        }
    </style>
</head>

<body>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <div id="login" class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="login well well-small">
                    <div class="center">
                        <img src="http://placehold.it/250x100&text=Logo" alt="logo">
                    </div>
                    <form action="{{ route('bank_login') }}" class="login-form" id="UserLoginForm" method="post">
                        @csrf
                        <div class="control-group">
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-user"></i></span>
                                <input name="email" placeholder="Email" type="email" id="email"
                                    class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="control-group">
                            <input class="btn btn-primary btn-large btn-block" type="submit" value="Sign in">
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}"> Go To Admin Login </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
