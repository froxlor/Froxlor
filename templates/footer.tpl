				</td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td width="100%" class="footer">
					<br />Froxlor
					<if ($settings['admin']['show_version_login'] == '1' && $filename == 'index.php') || ($filename != 'index.php' && $settings['admin']['show_version_footer'] == '1')>
						 {$version}
					</if>
					&copy; 2009-2010 by <a href="http://www.froxlor.org/" target="_blank">the Froxlor Team</a>
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
