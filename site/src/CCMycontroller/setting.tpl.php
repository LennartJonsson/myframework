<h1>Settings</h1>
<p>All settings that can be controlled.</p>

<?php if($settings != null):?>
  <?php foreach($settings as $setting):?>
    <h2><?=esc($setting['key'])?></h2>
    <p><?=filter_data($setting['value'], '')?></p><?php echo displaysettingvalue($setting['value'],$setting['type']); ?>
    <p class='smaller-text silent'><a href='<?=create_url("setting/edit/{$setting['key']}")?>'>edit</a></p>
  <?php endforeach; ?>
<?php else:?>
  <p>No settings exists.</p>
<?php endif;?>

