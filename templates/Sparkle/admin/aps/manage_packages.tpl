<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/aps.png" alt="" />&nbsp;
			{$lng['aps']['specialoptions']}
		</h2>
	</header>

	<section class="midform midformaps_2 bradiusodd">
	
		<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
			<p style="margin-left:10px;">
				<strong>{$lng['admin']['phpsettings']['actions']}</strong>
			</p>
			<p style="margin-left:10px;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="downloadallpackages" value="{$lng['aps']['downloadallpackages']}" />
			</p>
		</form>

		<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
			<p style="margin-left:10px;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="updateallpackages" value="{$lng['aps']['updateallpackages']}" />
			</p>
		</form>

		<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
			<p style="margin-left:10px;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="enablenewest" value="{$lng['aps']['enablenewest']}" />
			</p>
		</form>

		<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
			<p style="margin-left:10px;">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="save" value="save" />
				<input type="submit" name="removeunused" value="{$lng['aps']['removeunused']}" />
			</p>
		</form>

	</section>
	<br />
	<section class="midform bradiusodd">
		<p style="margin-left:10px;"><strong>{$lng['aps']['statistics']}</strong></p>
		<p style="margin-left:10px;">{$Statistics}</p>
	</section>
</article>
<br />
<article>
	<header>
		<h2>
			<img src="templates/{$theme}/assets/img/icons/aps.png" alt="" />&nbsp;
			{$lng['aps']['managepackages']}
		</h2>
	</header>

	<section>
	
		<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">

			<table class="bradiusodd aps">
			<thead>
				<tr>
					<th style="width:30%;">{$lng['aps']['packagenameandversion']}</th>
					<th>{$lng['ticket']['status']}</th>
					<th>{$lng['aps']['installations']}</th>
					<th style="width:7%;">{$lng['aps']['lock']}</th>
					<th style="width:7%;">{$lng['aps']['unlock']}</th>
					<th style="width:7%;">{$lng['aps']['remove']}</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3" style="border-top:1px solid #666;"><strong>{$lng['aps']['allpackages']}</strong></td>
					<td style="width:7%;text-align:center;border-top:1px solid #666;"><input type="radio" name="all" value="lock"/></td>
					<td style="width:7%;text-align:center;border-top:1px solid #666;"><input type="radio" name="all" value="unlock"/></td>
					<td style="width:7%;text-align:center;border-top:1px solid #666;"><input type="radio" name="all" value="remove"/></td>
				</tr>
			</tfoot>
			<tbody>
				{$Packages}
			</tbody>
			</table>

			<p class="submit">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="page" value="$page" />
				<input type="reset" value="{$lng['panel']['reset']}"/>&nbsp;
				<input type="submit" name="save" value="{$lng['panel']['save']}"/>
			</p>

		</form>
	</section>

</article>

