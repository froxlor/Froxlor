$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/view.png" alt="" />&nbsp;
				{$lng['panel']['viewlogs']}&nbsp;(<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains', 'action' => 'edit', 'id' => $domain_id))}">{$domain['domain']}</a>)&nbsp;[<a href="{$linker->getLink(array('section' => 'domains', 'page' => 'domains'))}">{$lng['menue']['domains']['domains']}</a>]
			</h2>
		</header>

		<section>
			<h3>Error-Log</h3>
			<textarea rows="20" class="logcontent" readonly>{$error_log_content}</textarea>
			<h3>Access-Log</h3>
			<textarea rows="20" class="logcontent" readonly>{$access_log_content}</textarea>
		</section>

	</article>

$footer
