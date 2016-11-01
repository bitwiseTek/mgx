@if ($paginator->getLastPage() > 1)
<?php $previousPage = ($paginator->getCurrentPage() > 1) ? $paginator->getCurrentPage() - 1 : 1; ?>  
<ul class="pager">  
  <li class="previous {{ ($paginator->getCurrentPage() == 1) ? ' hidden_info' : '' }}"><a href="{{ $paginator->getUrl($previousPage) }}">&laquo; Prev</a></li>
  <li class="next {{($paginator->getCurrentPage() == $paginator->getLastPage()) ? ' hidden_info' : '' }}"><a href="{{$paginator->getUrl($paginator->getCurrentPage()+1) }}">Next &raquo;</a></li>
</ul>  
@endif
