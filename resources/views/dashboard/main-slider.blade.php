@extends('dashboard.layout')

@section('title', 'Слайдер')

@section('dashboardcontent')

<div class="dashboard-content">

  <a href="{{ route('main-slider-create') }}" class="btn btn-success mb-3">Добавить</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="number-column" scope="col">№</th>
        <th scope="col">Название</th>
        <th scope="col">Текст</th>
        <th class="button-column"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($sliders as $slide)
        <tr>
          <th scope="row">{{ $loop->index + 1 }}</th>
          <td>{{ $slide->title}}</td>
          <td>{{ $slide->text}}</td>
          <td class="table-button">
            <a href="{{ route('main-slider-show', $slide->id) }}" class="btn btn-success">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('main-slider-edit', $slide->id) }}" class="btn btn-primary">
              <i class="fas fa-pen"></i>
            </a>
            <form class="form" action="{{ route('main-slider-destroy', $slide->id) }}" method="get">
              @csrf
              <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>

<script>
  const menuItem = 0;
</script>

@endsection