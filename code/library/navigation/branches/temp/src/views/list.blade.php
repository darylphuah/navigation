<ul{{{ $id or ' id="'.$id.'"'}}}>

<?php
	$x = 1;
	$total = count($nodes);
	if ( $total ):
	foreach ( $nodes AS $node ):
		$class  = $node['class'];
		$class .= ( $x == 1 )           ? ' first'    : '';
		$class .= ( $x == $total )      ? ' last'     : '';
		$class .= ( $node['active'] )   ? ' active'   : '';


?>
	<li<?php echo ( !empty($class) ) ? ' class="'.$class.'"' : ''; ?>>
		<?php if ( !empty($node['html']) ): ?>
		<?php echo $node['html']; ?>
		<?php elseif ( !empty($node['image']) ): ?>
		<a href="<?php echo $node['location']; ?>"<?php echo ( $node['external'] ) ? ' class="external"': ''; ?>>
			<img src="<?php echo $node['image']; ?>" alt="<?php echo $node['title']; ?>" />
		</a>
		<?php else: ?>
		<a href="<?php echo $node['location']; ?>"<?php echo ( $node['external'] ) ? ' class="external"': ''; ?>>
			<span><?php echo $node['title']; ?></span>
		</a>
		<?php endif; ?>

		<?php
		if ( !empty($node['children']) )
		{
			foreach ( $node['children'] as $child )
			{
				$child->output($template);
			}
		}
		?>
	</li>
<?php
	$x++;
	endforeach;
	endif;
?>
</ul>
