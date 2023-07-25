<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .top-nav {
            background-color: darkorange;
            padding: 2px 0;
            
        }
        .top-nav ul li {
            display: inline;

        }

        .top-nav ul li a{
            text-decoration: none;
            padding: 14px 28px 14px 28px;
            font-weight: bold;
            font-size: 1.5em;
            color: blue;
        }
        .top-nav ul li a:hover{
            opacity: 0.8;
        }
        
    </style>
</head>
<body>
    <div class="top-nav">
        <nav>
            <ul>
                <li> <a href="/"> Home </a> </li>
                <li> <a href="/dashboard"> Dashboard </a> </li>
                
                <li> <a href="/login"> Login </a> </li>
                <li> <a href="/signup"> Signup </a></li>
            </ul>
        </nav>
    </div>

    @yield('content')
</body>
</html>
