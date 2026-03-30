@extends('layouts.master')

@section('title', 'Cập Nhật Sản Phẩm - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card bg-dark-custom border-danger text-light shadow-lg">
            <div class="card-header bg-laravel text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Cập Nhật Sản Phẩm: {{ $product->name }}</h5>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-light text-laravel fw-bold">
                    <i class="bi bi-list-ul me-1"></i> Danh sách
                </a>
            </div>
            
            <div class="card-body p-4 bg-dark-custom">
                @if ($errors->any())
                    <div class="alert alert-danger border-danger bg-dark-custom text-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-laravel fw-bold">
                                Tên Sản Phẩm <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control bg-dark text-light border-secondary @error('name') is-invalid border-danger @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   placeholder="Nhập tên sản phẩm..." 
                                   required>
                            @error('name')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label text-laravel fw-bold">
                                Danh Mục <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" id="category_id" 
                                    class="form-select bg-dark text-light border-secondary @error('category_id') is-invalid border-danger @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php
                        $firstVariant = $product->variants->first();
                        $basePrice = $firstVariant ? $firstVariant->price : 0;
                        $baseStock = $firstVariant ? $firstVariant->stock_quantity : 0;
                        $hasMultipleVariants = $product->variants->count() > 1;
                    @endphp

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label text-laravel fw-bold">
                                Giá Sản Phẩm / Giá Tham Khảo (VNĐ) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control bg-dark text-light border-secondary @error('price') is-invalid border-danger @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $basePrice) }}" 
                                   placeholder="Nhập giá..." 
                                   min="0" required>
                            @error('price')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="stock" class="form-label text-laravel fw-bold">
                                Số Lượng Tồn Kho (Mặc định) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control bg-dark text-light border-secondary @error('stock') is-invalid border-danger @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $baseStock) }}" 
                                   placeholder="Nhập số lượng..." 
                                   min="0" required>
                            @error('stock')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if($hasMultipleVariants)
                        <!-- Variants Table -->
                        <div id="variants-table-container" class="mb-4">
                            <h6 class="text-laravel fw-bold"><i class="bi bi-list-nested me-1"></i> Cập Nhật Biến Thể Sản Phẩm</h6>
                            <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                                <i class="bi bi-info-circle me-1"></i> Bạn chỉ có thể cập nhật Giá và Tồn Kho cho các biến thể hiện tại.
                            </div>
                            <div class="table-responsive">
                                <table class="table table-dark table-bordered border-secondary align-middle">
                                    <thead class="table-active text-center">
                                        <tr>
                                            <th>Loại Biến Thể</th>
                                            <th>Mã SKU</th>
                                            <th>Giá (VNĐ)</th>
                                            <th>Số Lượng Tồn</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variants-tbody">
                                        @foreach($product->variants as $variant)
                                            <tr>
                                                <td class="align-middle fw-bold text-info" style="font-size: 0.9rem;">
                                                    @if($variant->attributeValues->count() > 0)
                                                        {{ $variant->attributeValues->map(function($av) { return $av->value; })->implode(' - ') }}
                                                    @else
                                                        Mặc định
                                                    @endif
                                                </td>
                                                <td class="text-center text-secondary">{{ $variant->sku }}</td>
                                                <td>
                                                    <input type="number" name="variants[{{ $variant->variant_id }}][price]" 
                                                           class="form-control form-control-sm bg-dark text-light border-secondary" 
                                                           value="{{ $variant->price }}" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="variants[{{ $variant->variant_id }}][stock]" 
                                                           class="form-control form-control-sm bg-dark text-light border-secondary" 
                                                           value="{{ $variant->stock_quantity }}" min="0" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <!-- Nếu chỉ có 1 variant mặc định, ẩn phần biến thể hoặc ko cần table này -->
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label text-laravel fw-bold">
                            Hình Ảnh Sản Phẩm (Bỏ trống nếu không thay đổi)
                        </label>
                        <input type="file" 
                               class="form-control bg-dark text-light border-secondary @error('image') is-invalid border-danger @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        <div class="form-text text-secondary mt-1">Định dạng: jpeg, png, jpg, gif, dung lượng tối đa 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                        @enderror

                        @php
                            $currentImage = $product->images->first();
                        @endphp
                        
                        <div class="d-flex align-items-center mt-3 gap-3">
                            @if($currentImage)
                                <div>
                                    <span class="d-block text-secondary mb-1" style="font-size: 0.85rem">Ảnh hiện tại:</span>
                                    <img src="{{ Storage::url($currentImage->image_url) }}" class="img-thumbnail bg-dark border-secondary" style="max-height: 150px; border-radius: 8px;" alt="Current Image">
                                </div>
                            @endif
                            <div id="imagePreviewContainer" style="display: none;">
                                <span class="d-block text-info mb-1" style="font-size: 0.85rem">Ảnh mới (Xem trước):</span>
                                <img id="imagePreview" src="" class="img-thumbnail bg-dark border-info" style="max-height: 150px; border-radius: 8px;" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label text-laravel fw-bold">
                            Mô Tả Sản Phẩm <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control bg-dark text-light border-secondary @error('description') is-invalid border-danger @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Nhập mô tả sản phẩm..." required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-laravel px-4">
                            <i class="bi bi-save me-1"></i> Lưu Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Custom styling matching the dark-tech theme */
    .form-control:focus, .form-select:focus {
        background-color: #1f2937;
        color: #f3f4f6;
        border-color: var(--laravel-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25);
    }
    .form-control::placeholder {
        color: #6b7280;
    }
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .alert-danger {
        border-radius: 8px;
    }
    .form-select {
        background-color: var(--bs-dark);
        color: var(--bs-light);
        border: 1px solid var(--bs-secondary);
    }
    .form-select:focus {
        background-color: #1f2937;
        color: #f3f4f6;
    }
</style>
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        }
    });
</script>
@endsection
