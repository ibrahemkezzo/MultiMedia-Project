<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopBook - Sign Up</title>
    <link rel="stylesheet" href="{{ asset('modules/website/css/sign_up.css') }}">
</head>

<body>

    <div class="container">

        <!-- Logo -->
        <div class="logo-box">
            <img src="{{ setting_get('logo') }}" alt="ShopBook" title="ShopBook">
        </div>

        <h2 class="title">Create Your Account</h2>

        <form action="{{ route('register') }}" method="POST" class="form">
            @csrf
            <!-- Name -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="John Doe" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            </div>

            <!-- Password -->
            <div class="form-group password-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required>
                <button type="button" class="toggle-btn" id="togglePasswordBtn1"
                        onclick="togglePassword('password', 'togglePasswordBtn1')"></button>
            </div>

            <!-- Confirm Password -->
            <div class="form-group password-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********" required>
                {{-- <button type="button" class="toggle-btn" id="togglePasswordBtn2"
                        onclick="togglePassword('password_confirmation', 'togglePasswordBtn2')"></button> --}}
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-btn">Sign Up</button>

        </form>

        <p class="signup-text">
            Already have an account?
            <a href="{{ route('login') }}">Sign in here</a>
        </p>

    </div>

    <script>
        function togglePassword(inputId, btnId) {
            const input = document.getElementById(inputId);
            const btn = document.getElementById(btnId);

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
