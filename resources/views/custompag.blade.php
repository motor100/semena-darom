@if ($paginator->lastPage() > 1)
  @if ($paginator->currentPage() > $paginator->lastPage())
    <div class="not-found">Не найдено</div>
  @endif
  <ul class="pagination">
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
      <li class="link{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
      </li>
    @endfor
  </ul>
@endif