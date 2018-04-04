<div class="nav2">
  <div class="container">
    @foreach($nav2 as $item)
      <?php (isset($item['activo']))? $activo=' class="active"':$activo=''; ?>
    @if(isset($item['modal']))
      <a href="" data-toggle="modal" data-target="{!!$item['modal']!!}">
        <?php echo html_entity_decode($item['nombre']) ?>
      </a>
     
    <?php $linku = $item['link']; ?>

   @else
      <div<?php echo $activo;?>> 
      	<a href="{{ isset($item['href'])?$item['href']:'' }}" id="{{ isset($item['id'])?$item['id']:'' }}">
        	{{ $item['nombre'] }}
        </a>
      </div>
    @endif
    @endforeach
  </div>
</div>
