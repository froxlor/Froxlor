				</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td width="100%" class="footer">
					<br />SysCP
					<if ($settings['admin']['show_version_login'] == '1' && $filename == 'index.php') || ($filename != 'index.php' && $settings['admin']['show_version_footer'] == '1')>
						 {$version} ({$dbversion})
					</if>
					<a style="text-decoration:none;" href="index.php?page=easter&amp;action=egg">&copy;</a> 2003-2009 by <a href="http://www.syscp.org/" target="_blank">the SysCP Team</a>
					<br />Theme: Luca Piona and Luca Longinotti
					<if $lng['translator'] != ''>
					<br />{$lng['panel']['translator']}: {$lng['translator']}
					</if>
					<br />&nbsp;
				</td>
			</tr>
		</table>
	</body>
</html>
