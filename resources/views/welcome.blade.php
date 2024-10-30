<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asset Managment System</title>

  <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Nunito', sans-serif;
      margin: 0;
      background-color: #f3f4f6;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #1f2937;
      padding: 1rem;
    }

    .navbar a {
      color: #ffffff;
      margin: 0 1rem;
      text-decoration: none;
      font-weight: 600;
    }

    .navbar a:hover {
      color: #9ca3af;
    }

    .content {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80vh;
      text-align: center;
    }

    .content h1 {
      font-size: 2.5rem;
      color: #374151;
    }

    .button {
      display: inline-block;
      padding: 0.5rem 1rem;
      margin-top: 1rem;
      background-color: #3b82f6;
      color: #fff;
      border-radius: 0.375rem;
      text-decoration: none;
      font-weight: 600;
    }

    .button:hover {
      background-color: #2563eb;
    }

    .logout-button {
    color: #fff;
    background-color: #1f2937; 
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    border: none;
    font-weight: 500;
    transition: background-color 0.3s;
    }

    .logout-button:hover {
    background-color: #0056b3; /* Darker blue on hover */
    color: #000;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>
      <a href="{{ url('/') }}">Home</a>
      @auth
        <a href="{{ url('/dashboard') }}">Dashboard</a>
      @else
        <a href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
          <a href="{{ route('register') }}">Register</a>
        @endif
      @endauth
    </div>
    @auth
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">  <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link active nav-hover logout-button">
              Logout
            </button>
          </form>
        </li>
      </ul>
    @endauth
  </div>

  <div class="content">
    <div>
      <h1>Welcome to Asset Managment System</h1>
      <p>Keep Track All Asset in PNHB.</p>
      @auth
        <a href="{{ url('/dashboard') }}" class="button">Go to Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="button">Get Started</a>
      @endauth
    </div>
  </div>



</body>
</html>