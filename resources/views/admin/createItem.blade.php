@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Tambah data</p>
        <form action="{{route('postItem')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="item" class="form-label">Nama Barang</label>
            <input type="text" class="form-control mb-2" name="item_name" value="{{old('item_name')}}" id="item">
            @error('item_name')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="category" class="form-label">Kategori</label>
            <select class="form-control mb-2" name="category_id" id="category">
                <option value="" disabled selected>Pilih Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" style="height: 100px;" class="form-control mb-2" name="description"
                value="{{old('description')}}" id="deskripsi">
            @error('description')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="price" class="form-label">Harga Satuan</label>
            <input type="number" class="form-control mb-2" name="unit_price" value="{{old('unit_price')}}" id="price">
            @error('unit_price')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" name="image" id="gambar" class="form-control" accept="image/*"
                    onchange="previewImage(event)">
                @error('image')
                <div>
                    <small class="text-danger">{{$message}}</small>
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <img id="image_preview" src="#" alt="Image Preview" style="display: none; max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-success mt-3">Tambah Data</button>
            <a href="{{ route('itemAdmin') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>