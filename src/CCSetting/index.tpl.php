<h1>Settings</h1>
<p>View and edit settings.</p>

<h2>All settings</h2>
<?php if($settings != null):?>
  <ul>
  <?php foreach($settings as $setting):?>
    <li><?=$setting['key']?> = <?=$setting['value']?> <a href='<?=create_url("setting/edit/{$setting['key']}")?>'>edit</a> <?php echo displaysettingvalue($setting['value'],$setting['type']); ?>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No setting exists.</p>
<?php endif;?>

