<?php if($content['id']):?>
  <h1><?=esc($content['title'])?></h1>
  <p><?=$content->GetFilteredData()?></p>
<?php if($controller=='blog'):?>
  <p class='smaller-text silent'><a href='<?=create_url("blog/edit/{$content['id']}")?>'>edit</a></p>
<?php else:?>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a></p>
<?php endif;?>
<?php else:?>
  <p>404: No such page exists.</p>
<?php endif;?>
