<?php

echo $before_widget;

$available_icons = array(
	'phone' => 'phone',
	'cellphone' => 'cellphone',
	'mail' => 'mail',
	'home' => 'home',
	'name' => 'user',
	'address' => 'map',
	'city' => 'address',
	'zip' => 'contacts',
);

if ($title)
	echo $before_title . $title . $after_title;
?>

<div class="contact_info_wrap">
	<ul class="clearfix">
	<?php foreach($this->fields as $name=>$field): ?>
		<?php if(!empty($field['value']) && $name != 'title'): ?>
			<li>
				<?php if(in_array($name, array_keys($available_icons))): ?>
					<?php if($name == 'mail'): ?>
						<?php $field['value'] = '<a href="mailto:' . $field['value'] . '">' . $field['value'] . '</a>'; ?>
					<?php endif; ?>
					<?php echo do_shortcode('[icon style="'.$available_icons[$name].'" color="'.$color.'"]'.$field['value'].'[/icon]')?>
				<?php else: ?>
					<?php echo do_shortcode('[icon]'.$field['value'].'[/icon]')?>
				<?php endif ?>
			</li>
		<?php endif ?>
	<?php endforeach ?>
	</ul>
</div>
<?php
echo $after_widget;