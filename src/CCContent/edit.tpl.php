<?php if($content['created']): ?>
  <h1>Edit Content</h1>
  <p>You can edit and save this content.</p>
<?php else: ?>
  <h1>Create Content</h1>
  <p>Create new content.</p>
<?php endif; ?>

<?=$form->GetHTML(array('class'=>'content-edit'))?>

<p class='smaller-text'><em>
<?php if($content['created']): ?>
  This content was created by <?=$content['owner']?> <?=time_diff($content['created'])?> ago.
<?php else: ?>
  Content not yet created.
<?php endif; ?>

<?php if(isset($content['updated'])):?>
  Last updated <?=time_diff($content['updated'])?> ago.
<?php endif; ?>
</em></p>

<p>
<?php if ( $content['created'] ): ?>
<?php if ( $controller == 'blog' ): ?>
<a href='<?=create_url('blog', 'create')?>'>Create new blog</a>
<a href='<?=create_url('blog', 'view', $content['id'])?>'>View</a>
<?php else: ?>
<?php if ( $content['key'] != 'about' ): ?>
<a href='<?=create_url('content', 'create')?>'>Create new content</a>
<?php endif; ?>
<a href='<?=create_url('page', 'view', $content['id'])?>'>View</a>
<?php endif; ?>
<?php endif; ?>
</p>

