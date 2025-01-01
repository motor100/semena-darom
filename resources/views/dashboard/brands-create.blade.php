@extends('dashboard.layout')

@section('title', 'Добавить производителя')

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

  <form class="form" action="{{ route('admin.brands-store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
      <label for="title">Название</label>
      <input type="text" class="form-control" name="title" id="title" minlength="3" maxlength="50" required value="{{ old('title') }}">
    </div>

    @csrf
    <button type="submit" class="btn btn-primary">Добавить</button>
  </form>

</div>

<script>
  const menuItem = 1;
</script>

@endsection