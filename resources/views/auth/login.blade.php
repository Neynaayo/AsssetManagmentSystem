<x-guest-layout>
    <style>
        /* Animated gradient background */
        .animated-gradient {
            background: linear-gradient(-45deg, #0ea5e9, #22d3ee, #0284c7, #0369a1);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Container for the split design */
        .login-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Left Section (Form) */
        .form-section {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
        }

        .form-section form {
            max-width: 400px;
            margin: auto;
        }

        /* Right Section (Logo and Title) */
        .image-section {
            flex: 1;
            background: url('{{ asset('images/glowingChipBG.jpg') }}') no-repeat center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 2rem;
        }

        .image-section img {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }

        .image-section h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .image-section p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Input Field Styles */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .custom-input {
            width: 100%;
            padding: 0.75rem 2.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            color: #000000;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 8px rgba(14, 165, 233, 0.5);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            pointer-events: none;
        }

        /* Button Styles */
        .login-button {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #0ea5e9, #22d3ee);
            color: white;
            font-weight: bold;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background: linear-gradient(to left, #0ea5e9, #22d3ee);
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.5);
        }

        /* Additional Styles */
        .back-link {
            margin-top: 1rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }

        .back-link:hover {
            color: white;
            text-decoration: underline;
        }
    </style>

    <div class="animated-gradient">
        <div class="login-container">
            <!-- Left Section (Form) -->
            <div class="form-section">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Email Input -->
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="custom-input" placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="custom-input" placeholder="Enter your password" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between text-white/70 mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm hover:text-white">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="login-button">Sign In</button>

                    <!-- Back to Register -->
                    <div class="back-link mt-4">
                        <p class="text-sm">
                            Don't have an account? <a href="{{ route('register') }}">Register here</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Right Section (Logo and Title) -->
            <div class="image-section">
                <img src="{{ asset('images/Puncak_Niaga_Holdings_Logo.png') }}" alt="Logo">
                <h2>Welcome Back!</h2>
                <p>Log in to manage your assets efficiently.</p>
            </div>
        </div>
    </div>
</x-guest-layout>
