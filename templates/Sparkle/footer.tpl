<if isset($userinfo['loginname'])>
	</div>
	<div class="clear"></div> 
	</div>
</if>
<footer>
	<span><img src="templates/{$theme}/assets/img/logo_grey.png" alt="Froxlor" />
		<if (\Froxlor\Settings::Get('admin.show_version_login') == '1' && $filename == 'index.php') || ($filename != 'index.php' && \Froxlor\Settings::Get('admin.show_version_footer') == '1')>
			{$version}{$branding}
		</if>
		&copy; 2009-{$current_year} by <a href="http://www.froxlor.org/" rel="external">the Froxlor Team</a><br />
		<if (\Froxlor\Settings::Get('panel.imprint_url')) != ''><a href="{$panel_imprint_url}" target="_blank" class="footer-link">{$lng['imprint']}</a></if>
		<if (\Froxlor\Settings::Get('panel.terms_url')) != ''><a href="{$panel_terms_url}" target="_blank" class="footer-link">{$lng['terms']}</a></if>
		<if (\Froxlor\Settings::Get('panel.privacy_url')) != ''><a href="{$panel_privacy_url}" target="_blank" class="footer-link">{$lng['privacy']}</a></if>
	</span>
	<if $lng['translator'] != ''>
		<br /><span>{$lng['panel']['translator']}: {$lng['translator']}
	</if>
</footer>
<a href="#" class="scrollup">Scroll</a>
</body>
</html>
