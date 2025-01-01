@extends('dashboard.layout')

@section('title', 'Редактировать товар')

@section('dashboardcontent')

<div class="dashboard-content">
    
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="form" id="save-data-form" action="{{ route('products-update', $product->id) }}" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
      <label for="title" class="label-text">Название</label>
      <input type="text" class="form-control" name="title" id="title" maxlength="200" required value="{{ $product->title }}">
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Описание</div>
      @if(isset($to_editorjs))
        <div id="to-editorjs" style="display: none;">{{ $to_editorjs }}</div>
      @endif
      <div id="editorjs"></div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text">Категория</div>
      <select name="category" id="category" class="form-select mt-1">
        @foreach($category as $ct)
          @if($ct->id == $current_category->id)
            <option value="{{ $ct->id }}" selected>{{ $ct->title }}</option>
          @else
            <option value="{{ $ct->id }}">{{ $ct->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      @if($product->image)
        <div class="image-preview">
          <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
        </div>
      @endif
    </div>
    <div class="form-group mb-3">
      <div class="label-text">Изображение</div>
      <input type="file" name="input-main-file" id="input-main-file" class="inputfile" accept="image/jpeg,image/png">
      <label for="input-main-file" class="custom-inputfile-label">Выберите файл</label>
      <span class="namefile main-file-text">Файл не выбран</span>
    </div>
    <div class="form-group">
      <div class="image-preview gallery-image-preview">
        @if($product->galleries->count() > 0)
          @foreach($product->galleries as $gl)
            <img src="{{ asset('storage/uploads/products/' . $gl->image) }}" alt="">
          @endforeach
          <div class="gallery-delete">Удалить галерею</div>
        @endif
      </div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text">Галерея</div>
      <input type="file" name="input-gallery-file[]" id="input-gallery-file" class="inputfile" accept="image/jpeg,image/png" multiple value="">
      <label for="input-gallery-file" class="custom-inputfile-label">Выберите файлы</label>
      <span class="namefile gallery-file-text">Файлы не выбраны</span>
    </div>
    <div class="form-group mb-3">
      <label for="barcode" class="label-text">Штрихкод</label>
      <input type="number" class="form-control input-barcode input-number" name="barcode" id="barcode" min="0" step="1" required value="{{ $product->barcode }}">
    </div>
    <div class="form-group mb-3">
      <label for="stock" class="label-text">Количество</label>
      <input type="number" class="form-control input-stock input-number" name="stock" id="stock" min="0" step="1" value="{{ $product->stock }}">
    </div>
    <div class="form-group mb-3">
      <label for="buying-price" class="label-text">Закупочная цена</label>
      <input type="number" class="form-control input-buying-price input-number" name="buying_price" id="buying-price" min="0" step="0.5" value="{{ $product->buying_price }}">
    </div>
    <div class="form-group mb-3">
      <label for="wholesale-price" class="label-text">Оптовая цена</label>
      <input type="wholesale-price" class="form-control input-wholesale-price input-number" name="wholesale_price" id="wholesale-price" min="0" step="0.5" required value="{{ $product->wholesale_price }}">
    </div>
    <div class="form-group mb-3">
      <label for="retail-price" class="label-text">Розничная цена</label>
      <input type="number" class="form-control input-retail-price input-number" name="retail_price" id="retail-price" min="0" step="0.5" required value="{{ $product->retail_price }}">
    </div>
    <div class="form-group mb-3">
      <label for="promo-price" class="label-text">Акционная цена</label>
      <input type="number" class="form-control input-promo-price input-number" name="promo_price" id="promo-price" min="0" step="0.5" value="{{ $product->promo_price }}">
    </div>
    <div class="form-group mb-3">
      <label for="weight" class="label-text">Вес, гр.</label>
      <input type="number" class="form-control input-weight input-number" name="weight" id="weight" min="0" step="1" value="{{ $product->weight }}" required>
    </div>
    <div class="form-group mb-3">
      <div class="label-text">Производитель</div>
      @if($product->brand)
        <select name="brand" id="brand" class="form-select mt-1">
          <option value=""></option>
          @foreach($brands as $brand)
            @if($brand->id == $product->brand->id)
              <option value="{{ $brand->id }}" selected>{{ $brand->title }}</option>
            @else
              <option value="{{ $brand->id }}">{{ $brand->title }}</option>
            @endif
          @endforeach
        </select>
      @else
        <select name="brand" id="brand" class="form-select mt-1">
          <option value="" selected="selected"></option>
          @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
          @endforeach
        </select>
      @endif
    </div>
    <div class="form-group mb-3">
      <div class="label-text" class="label-text">Свойство</div>
      <select name="property" id="property" class="form-select mt-1">
        <option value="{{ $product->property }}" selected>{{ $product->property }}</option>
        <option value=""></option>
        <option value="Хит">Хит</option>
      </select>
    </div>
    <div class="form-group mb-5">
      <label for="position" class="label-text">Позиция на складе</label>
      <input type="number" class="form-control input-position input-number" name="position" id="position" max="1000000" value="{{ $product->position }}" required>
    </div>
    <input type="hidden" name="id" value="{{ $product->id }}">
    <input type="hidden" name="delete_gallery" value="">
    <input type="hidden" name="text_json" id="save-data-input" value="">

    @csrf
    <button type="submit" class="btn btn-primary">Обновить</button>
  </form>

</div>

<script>
  const menuItem = 0;
</script>

<script>

  // Выбор файлов Галерея
  let inputGalleryFile = document.querySelector('#input-gallery-file'),
      galleryFileText = document.querySelector('.gallery-file-text');

  inputGalleryFile.onchange = function() {
    let filesName = '';
    for (let i = 0; i < this.files.length; i++) {
      filesName += this.files[i].name + ' ';
    }
    galleryFileText.innerHTML = filesName;
  }

  // Удаление всех файлов из галереи
  const galleryDelete = document.querySelector('.gallery-delete');
  const galleryImagePreview = document.querySelector('.gallery-image-preview');
  const inputDeleteGallery = document.querySelector('[name="delete_gallery"]');

  if (galleryDelete) {
    galleryDelete.onclick = function() {
      galleryDelete.classList.add('hidden');
      galleryImagePreview.innerHTML = '';
      inputDeleteGallery.value = 1;
    }
  }
</script>

@endsection