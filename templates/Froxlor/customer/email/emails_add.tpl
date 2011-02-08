$header
<article>
	<if $domains == ''>
			<div class="messagewrapperfull">
				<div class="warningcontainer bradius">
					<div class="warningtitle">{$lng['admin']['warning']}</div>
					<div class="warning"><br /><strong>{$lng['emails']['noemaildomainaddedyet']}</strong></div>
				</div>
			</div>
	</if>
	<else>
	<header>
		<h2>
			<img src="images/Froxlor/icons/email_add.png" alt="{$lng['emails']['emails_add']}" />&nbsp;
			{$lng['emails']['emails_add']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['emails']['emails_add']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['emails']['emailaddress']}:</td>
							<td><input type="text" name="email_part" value="" size="15" /> @ <select name="domain">$domains</select></td>
						</tr>
						<tr>
							<td>{$lng['emails']['iscatchall']}</td>
							<td>$iscatchall</td>
						</tr>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['emails']['emails_add']}" /></td>
						</tr>
					</table>

					<p style="display: none;">
						<input type="hidden" name="s" value="$s" />
						<input type="hidden" name="page" value="$page" />
						<input type="hidden" name="action" value="$action" />
						<input type="hidden" name="send" value="send" />
					</p>
				</fieldset>
			</form>
	</section>
</article>
$footer
