<x-guest-layout>
 
    <style>
        /* Animated gradient background */
        .animated-gradient {
            background: linear-gradient(-45deg, #0ea5e9, #22d3ee, #0284c7, #0369a1);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            min-height: 100vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Container for the split design */
        .register-container {
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
        .register-button {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #0ea5e9, #22d3ee);
            color: white;
            font-weight: bold;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .register-button:hover {
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
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            text-align: center;
        }
        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }
    </style>

    <div class="animated-gradient">
        <div class="register-container">
            <!-- Left Section (Form) -->
            <div class="form-section">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Input -->
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="name" id="name" class="custom-input" placeholder="Enter your name" required>
                    </div>
                    @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Email Input -->
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="custom-input" placeholder="Enter your email" required>
                    </div>
                    @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Department Input -->
                    <div class="input-group">
                        <select name="department_id" id="department_id" class="custom-input">
                            <option value="">Select Department (or select any department first and press this to add new below)</option>
                            @foreach ($department as $departments)
                                <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- New Department Input Field -->
                    <div class="input-group" id="new-department-wrapper" style="display: none;">
                        <input type="text" name="new_department" id="new_department" class="custom-input" placeholder="Enter new department name">
                    </div>
                    

                    <!-- Password Input -->
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="custom-input" placeholder="Create password" required>
                    </div>
                    @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Confirm Password -->
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="custom-input" placeholder="Confirm password" required>
                    </div>
                    @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" class="register-button">Create Account</button>

                    <!-- Back Link -->
                    <div class="back-link">
                        <a href="{{ url('/') }}">Back to Login Page</a>
                    </div>
                </form>
            </div>

            <!-- Right Section (Logo and Title) -->
            <div class="image-section">
                <img src="{{ asset('images/Puncak_Niaga_Holdings_Logo.png') }}" alt="Logo">
                <h2>Join Our Platform</h2>
                <p>Register now and start managing your assets effortlessly.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const departmentSelect = document.getElementById('department_id');
    const newDepartmentWrapper = document.getElementById('new-department-wrapper');

    // Show or hide the new department input
    departmentSelect.addEventListener('change', () => {
        if (departmentSelect.value === '') {
            newDepartmentWrapper.style.display = 'block';
        } else {
            newDepartmentWrapper.style.display = 'none';
            const newDepartmentInput = document.getElementById('new_department');
            newDepartmentInput.value = ''; // Clear the input if hidden
        }
    });
});

    </script>
</x-guest-layout>
