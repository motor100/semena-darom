@extends('dashboard.layout')

@section('title', $page->title)

@section('dashboardcontent')

<div class="dashboard-content">

  <form class="form" action="{{ url()->current() }}/update" method="post">

  <div class="form-group mb-3">
    <label for="text" class="form-check-label mb-1">Описание</label>
    <textarea name="text" id="text">{{ $page->text }}</textarea>
  </div>

  @csrf
  <button type="submit" class="btn btn-primary">Обновить</button>

  </form>

</div>

<script>
  const menuItem = 4;
</script>

@endsection

@section('script')
  <script src="https://cdn.tiny.cloud/1/5bpy3e636t6os710b6abr6w7zmyr1d77c4px4vl6qi628r67/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="{{ asset('/adminpanel/js/tiny-file-upload.js') }}"></script>
@endsection