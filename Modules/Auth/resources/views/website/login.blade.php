<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShopBook - Sign In</title>
  <link rel="stylesheet" href="{{ asset('modules/website/css/sign_in.css') }}">
</head>

<body>

  <div class="container">

    <div class="logo-box">
      <img src="{{ setting_get('logo') }}" alt="ShopBook" title="ShopBook">
    </div>

    <h2 class="title">Sign In to Your Account</h2>

    <form action="{{ route('login') }}" method="POST" class="form">
        @csrf
      <!-- Email -->
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
      </div>

      <!-- Password -->
      <div class="form-group password-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="********" required>
        <button type="button" class="toggle-btn" onclick="togglePassword('password')"></button>
      </div>

      <!-- Remember + Forgot -->
      <div class="options">
        <label class="remember">
          <input type="checkbox" name="remember">
          Remember Me
        </label>

        <a href="{{ route('password.email') }}" class="forgot">Forgot password?</a>
      </div>

      <!-- Submit -->
      <button type="submit" class="submit-btn">Sign In</button>

    </form>

    <p class="signup-text">
      Don't have an account?
      <a href="{{ route('register') }}">Sign up here</a>
    </p>

  </div>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      const btn = input.parentElement.querySelector(".toggle-btn");

      if (input.type === "password") {
        input.type = "text";
        btn.textContent = "Hide";
      } else {
        input.type = "password";
        btn.textContent = "Show";
      }
    }
  </script>

</body>
</html>
