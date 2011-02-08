$header
<article>
	<header>
		<h2>
			<img src="images/Froxlor/icons/add_mysql.png" alt="{$lng['mysql']['database_create']}" />&nbsp;
			{$lng['mysql']['database_create']}
		</h2>
	</header>
	
	<section class="fullform bradiusodd">

			<form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<legend>Froxlor&nbsp;-&nbsp;{$lng['mysql']['database_create']}</legend>

					<table class="formtable">
						<tr>
							<td>{$lng['mysql']['databasedescription']}:</td>
							<td><input type="text" class="text" name="description" /></td>
						</tr>
						<if 1 < count($sql_root)>
						<tr>
							<td>{$lng['mysql']['mysql_server']}:</td>
							<td><select name="mysql_server">$mysql_servers</select></td>
						</tr>
						</if>
						<tr>
							<td>{$lng['login']['password']}:</td>
							<td><input type="password" name="mysql_password" maxlength="50" /></td>
						</tr>
						<tr>
							<td>{$lng['customer']['sendinfomail']}:</td>
							<td>{$sendinfomail}</td>
						</tr>
						<tr>
							<td colspan="2"><input type="hidden" name="send" value="send" /><input type="submit" class="bottom" value="{$lng['mysql']['database_create']}" /></td>
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
