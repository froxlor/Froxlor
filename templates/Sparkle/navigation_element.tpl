<div class="menuelement">
	<h4>
		<if $navurl != '#'>
			<a href="{$navurl}" {$target} class="menu">{$navlabel}</a>
		<else>
			{$navlabel}
		</if>
	</h4>
	<ul>
		{$navigation_links}
	</ul>
</div>
