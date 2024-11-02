@extends('dashboard.layout')

@section('title', 'Отзывы')

@section('dashboardcontent')

<div class="dashboard-home">

  <div class="content">
    <div class="container-fluid">
      <div class="testimonials-wrapper">
        @if(count($testimonials) > 0)
          @foreach($testimonials as $ts)
            <div class="item">
              <form class="form" action="/admin/testimonials-update" method="post">
                <div class="form-group mb-3">
                  <label for="inputName" class="form-check-label">Имя</label>
                  <input type="text" name="name" id="inputName" class="form-control" value="{{ $ts->name }}" required>
                </div>
                <div class="form-group mb-3">
                  <label for="inputText" class="form-check-label">Отзыв</label>
                  <textarea name="text" id="inputText" class="form-control" required>{{ $ts->text }}</textarea>
                </div>
                <input type="hidden" name="id" value="{{ $ts->id }}">
                @csrf
                <button type="submit" class="publicate-btn btn btn-primary">опубликовать</button>
              </form>
              <form class="form rm-testimonial-form" action="/admin/testimonials-destroy" method="post">
                <input type="hidden" name="id" value="{{ $ts->id }}">
                @csrf
                <button type="submit" class="rm-btn btn btn-secondary">удалить</button>
              </form>
            </div>
          @endforeach
        @endif
      </div>

      <div class="archive">
        @if(isset($publicated_reviews) && count($publicated_reviews) > 0)
          <h3 class="h4 mb-4">Архив отзывов</h3>
          @foreach($publicated_reviews as $p_rws)
            <div class="item d-flex justify-content-between mb-3">
              <div class="title-wrapper">
                <span class="title">{{ $p_rws->name }}</span>
                <span class="date">{{ $p_rws->publicated_at }}</span>
                @if($p_rws->product > 0)
                  <a href="/product/{{ $p_rws->slug }}" class="product" target="_blank">Товар</a>
                @endif
                <span class="excerpt">{{ $p_rws->short_text }}</span>
              </div>
              <div class="btns">
                <a class="list-btn edit-btn" href="/dashboard/reviews/edit/{{$p_rws->id}}">
                  <i class="far fas fa-pen"></i>
                </a>
                <a class="list-btn delete-btn" href="/dashboard/reviews/del/{{$p_rws->id}}">
                  <i class="far fa-times-circle"></i>
                </a>
              </div>
            </div>
          @endforeach
        @endif
      </div>

    </div>
  </div> 

</div>

<script>
  const menuItem = 5;
</script>
@endsection