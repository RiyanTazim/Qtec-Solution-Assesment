<!DOCTYPE html>
<html lang="en">
<style>
    .error-message {
        font-size: 0.9em;
        margin-top: 4px;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/style.css">
</head>

<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="{{ route('register.store') }}" method="post" class="register-form"
                            id="register-form">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" required id="name" placeholder="Your Name" />
                                @error('name')
                                    <div>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"  required/>
                                @error('email')
                                    <div>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password" required/>
                                @error('password')
                                    <div>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password_confirmation" id="re_pass"
                                    placeholder="Repeat your password" required/>
                            </div>
                            {{-- <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all
                                    statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div> --}}
                            <div class="form-group form-button">
                                <input type="submit" id="signup" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('/') }}assets/images/signup-image.jpg" alt="sing up image">
                        </figure>
                        <a href="{{ route('login') }}" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="{{ asset('/') }}assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const email = document.getElementById('email');
            const password = document.getElementById('pass');
            const rePassword = document.getElementById('re_pass');
            const checkbox = document.getElementById('agree-term');
            const form = document.getElementById('register-form');
    
            // Helper to show error message
            function showError(element, message) {
                clearError(element);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.style.color = 'red';
                errorDiv.textContent = message;
                element.parentElement.appendChild(errorDiv);
            }
    
            // Helper to clear error
            function clearError(element) {
                const existing = element.parentElement.querySelector('.error-message');
                if (existing) {
                    existing.remove();
                }
            }
    
            // Email validation
            email.addEventListener('blur', function () {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regex.test(email.value)) {
                    showError(email, 'Enter a valid email address.');
                } else {
                    clearError(email);
                }
            });
    
            // Password length validation
            password.addEventListener('blur', function () {
                if (password.value.length < 8) {
                    showError(password, 'Password must be at least 8 characters.');
                } else {
                    clearError(password);
                }
            });
    
            // Confirm password match
            rePassword.addEventListener('blur', function () {
                if (rePassword.value !== password.value) {
                    showError(rePassword, 'Passwords do not match.');
                } else {
                    clearError(rePassword);
                }
            });
    
            // Checkbox validation on blur (clicking away)
            checkbox.addEventListener('blur', function () {
                if (!checkbox.checked) {
                    showError(checkbox, 'You must agree to the Terms of Service.');
                } else {
                    clearError(checkbox);
                }
            });
    
            // Prevent form submit if any errors exist
            form.addEventListener('submit', function (e) {
                // Trigger all validations
                email.dispatchEvent(new Event('blur'));
                password.dispatchEvent(new Event('blur'));
                rePassword.dispatchEvent(new Event('blur'));
                checkbox.dispatchEvent(new Event('blur'));
    
                const errors = form.querySelectorAll('.error-message');
                if (errors.length > 0) {
                    e.preventDefault();
                }
            });

            
        });
    </script>
    
    
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
