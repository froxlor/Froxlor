$header
<article>
		<header>
			<h2>
				<img src="images/Froxlor/icons/settings.png" alt="" />&nbsp;
				{$configfiles[$distribution]['label']}&nbsp;&raquo;&nbsp;
				{$configfiles[$distribution]['services'][$service]['label']}&nbsp;&raquo;&nbsp;
				{$configfiles[$distribution]['services'][$service]['daemons'][$daemon]['label']}&nbsp;
[<a href="$filename?s=$s&amp;page=$page&amp;distribution=$distribution&amp;service=$service">{$lng['panel']['back']}</a>]
			</h2>
		</header>
		
		<section class="fullform bradiusodd">
        	<table class="formtable">
				{$configpage}
				<if $restart != ''>
				<tr>
					<td>{$lng['admin']['configfiles']['restart']}<br /><br />
					<textarea class="textarea_border" rows="3" cols="70" readonly="readonly">$restart</textarea></td>
				</tr>
		</table>
		<br /><br />
		</section>
</article>
$footer
