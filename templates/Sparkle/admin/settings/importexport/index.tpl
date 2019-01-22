$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/settings_big.png" alt="" />&nbsp;
				{$lng['admin']['configfiles']['importexport']}
			</h2>
		</header>
		
		<section>
			<a href="{$linker->getLink(array('section' => 'settings', 'page' => $page, 'action' => 'export'))}">
				<input class="yesbutton" type="button" value="Download/Export {$lng['admin']['serversettings']}" />
			</a>
		</section>
		<br><br>
		<section>
			<form action="{$linker->getLink(array('section' => 'settings', 'page' => $page, 'action' => 'import'))}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="send" value="send" />

				<input type="file" name="import_file" id="import_file" placeholder="Choose file for import" />
				<input type="submit" value="Import">
			</form>
		</section>
</article>
$footer
