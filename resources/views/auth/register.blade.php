@extends('layouts.master')

@section('title', 'Đăng Ký - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6 mb-5">
        <div class="bg-dark-custom p-5 rounded shadow border-bottom border-danger">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus text-laravel" style="font-size: 3rem;"></i>
                <h3 class="text-white fw-bold mt-2">Đăng Ký Tài Khoản</h3>
                <p class="text-white">Tham gia cùng cộng đồng <span class="text-laravel">ElectroGear</span></p>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="full_name" class="form-label text-white">Họ và tên</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-person"></i></span>
                        <input type="text" name="full_name" class="form-control bg-dark text-white @error('full_name') border-danger @else border-secondary @enderror" id="full_name" placeholder="Nguyễn Văn A" value="{{ old('full_name') }}" required autofocus autocomplete="name">
                    </div>
                    @error('full_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control bg-dark text-white @error('email') border-danger @else border-secondary @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label text-white">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-telephone"></i></span>
                        <input type="tel" name="phone_number" class="form-control bg-dark text-white @error('phone_number') border-danger @else border-secondary @enderror" id="phone_number" placeholder="0909123456" value="{{ old('phone_number') }}" required>
                    </div>
                    @error('phone_number')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-white">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control bg-dark text-white @error('password') border-danger @else border-secondary @enderror" id="password" placeholder="••••••••" required autocomplete="new-password">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-white small mt-1">Mật khẩu phải chứa ít nhất 8 ký tự.</div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label text-white">Xác nhận mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-shield-check"></i></span>
                        <input type="password" name="password_confirmation" class="form-control bg-dark text-white @error('password_confirmation') border-danger @else border-secondary @enderror" id="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input bg-dark border-secondary custom-checkbox" id="terms" required>
                    <label class="form-check-label text-white small" for="terms">
                        Tôi đồng ý với các <a href="#" class="text-laravel hover-light">Điều khoản dịch vụ</a> và <a href="#" class="text-laravel hover-light">Chính sách bảo mật</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-laravel w-100 btn-lg shadow mb-3">Tạo Tài Khoản</button>

                <div class="text-center mt-3 text-white small">
                    Đã có tài khoản? <a href="{{ route('login') }}" class="text-laravel fw-bold text-decoration-none hover-light">Đăng Nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-check-input:focus {
        border-color: var(--laravel-red) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25) !important;
    }
    .custom-checkbox:checked {
        background-color: var(--laravel-red);
        border-color: var(--laravel-red);
    }
    .hover-light:hover {
        color: white !important;
        transition: color 0.2s;
    }
</style>
@endsection
