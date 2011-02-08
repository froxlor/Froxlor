$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/mysql_edit.png" alt="{$lng['mysql']['database_edit']}" />&nbsp;
			{$lng['mysql']['database_edit']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['mysql']['database_edit']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['mysql']['databasename']}:</td>
							<td>{$result['databasename']}</td>
						</tr>
						<tr>
							<td>{$lng['mysql']['databasedescription']}:</td>
							<td><input type="text" class="text" name="description" value="{$result['description']}" /></td>
						</tr>
						<if 1 < count($sql_root)>
						<tr>
							<td>{$lng['mysql']['mysql_server']}:</td>
							<td>{$sql_root[$result['dbserver']]['caption']}</td>
						</tr>
						</if>
						<tr>
							<td>{$lng['changepassword']['new_password_ifnotempty']}:</td>
							<td><input type="password" name="mysql_password" /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" value="{$lng['panel']['save']}" /></td>
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
