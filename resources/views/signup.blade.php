<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <h1> Sign up here</h1> 
        <div>
            <form action="/api/signup" method="POST">
                @csrf

                <div>
                    <input type="text" name="username" placeholder="please enter your username">
                </div>
                <div>
                    <input type="email" name="email" placeholder="please enter your email">
                </div>
                <div>
                    <input type="password" name="password" placeholder="please enter your password">
                </div>
                <div>
                    <input type="submit" name="signup" value="signup">
                </div>
            </form>

            <p> already have an account? <a href="/login"> login</a></p>
        </div>
    @endsection
</body>
</html>


