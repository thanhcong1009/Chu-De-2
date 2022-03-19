@extends('layouts.default')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col">
            <a href="{{ route('product-manager') }}" class="btn btn-primary"><i class="fas fa-angle-left"></i> Quản lý sản phẩm</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-4">
            <h3 class="text-center mb-4">Cập nhật sản phẩm</h3>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" id="input-name" class="form-control" name="name"
                        value="{{ $product->name }}" />
                    <label class="form-label" for="input-name">Tên sản phẩm</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="number" id="input-price" class="form-control" name="price"
                        value="{{ $product->price }}" />
                    <label class="form-label" for="input-price">Giá tiền gốc</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="number" id="input-price-sale" class="form-control" name="price_sale"
                        value="{{ $product->price_sale }}" />
                    <label class="form-label" for="input-price-sale">Giá sau khi giảm</label>
                </div>
                <div class="form-outline mb-2">
                    <textarea class="form-control" id="input-description" rows="4" style="resize: none;"
                        name="description" ">{{ $product->description }}</textarea>
                    <label class="form-label" for="input-description">Mô tả sản phẩm</label>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="customFile">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="customFile" name="image" value="{{ old('image') }}" />
                </div>
                <div class="mb-4 d-flex justify-content-center">
                    <img src="/{{ $product->image }}" alt="" class="w-50" id="previewImg">
                </div>

                <div class="mb-4">
                    <select class="form-select" id="input-producer" name="producer_code">
                        <option value="0">Chọn hãng</option>
                        @foreach ($producers as $producer)
                        <option
                            value="{{ $producer["code"] }}"
                            style="text-transform: uppercase;"
                            @if ($product->producer_code == $producer["code"])
                                selected
                            @endif
                        >
                            {{ $producer["name"] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <span class="msg-error">{{ $error }}</span>
                    @endforeach
                @elseif(session('success'))
                    <div class="msg-success mb-4">{{ session('success') }}</div>
                @endif

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('customFile').onchange = evt => {
        console.log(evt.target);
        const [file] = evt.target.files;
        if (file) {
            document.getElementById('previewImg').src = URL.createObjectURL(file);
        }
    }
</script>
@stop
