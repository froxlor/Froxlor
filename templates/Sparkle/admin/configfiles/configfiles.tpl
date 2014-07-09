$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{$configfiles[$distribution]['label']}&nbsp;&raquo;&nbsp;
				{$configfiles[$distribution]['services'][$service]['label']}&nbsp;&raquo;&nbsp;
				{$configfiles[$distribution]['services'][$service]['daemons'][$daemon]['label']}&nbsp;
[<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page, 'distribution' => $distribution, 'service' => $service))}">{$lng['panel']['back']}</a>]
			</h2>
		</header>

		<section>
			<table class="full">
				{$configpage}
				<if $restart != ''>
				<tr class="section">
					<th>{$lng['admin']['configfiles']['restart']}</th>
				<tr>
				<tr>
					<td>
					<textarea class="textarea_border" rows="" cols="70" readonly="readonly">$restart</textarea></td>
				</tr>
				</if>
		</table>
		<br />
		</section>
</article>
$footer
