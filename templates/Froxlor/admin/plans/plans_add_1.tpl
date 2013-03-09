$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/domain_add.png" alt="" />&nbsp;
				{$lng['admin']['plans']['plan_add']}
			</h2>
		</header>

		<section class="tinyform bradiusodd">
			<form method="post" action="{$linker->getLink(array('section' => 'plans'))}" enctype="application/x-www-form-urlencoded">
				<fieldset>
				<legend>Froxlor&nbsp;-&nbsp;{$lng['admin']['plans']['plan']}</legend>
				<p>
					<label for="plan_type">{$lng['admin']['plans']['plan_group']}:</label>&nbsp;
					<select id="plan_type" name="plan_type">$plan_options</select>
				</p>
				<p class="submit">
					<input type="hidden" name="s" value="$s" />
					<input type="hidden" name="page" value="$page" />
					<input type="hidden" name="action" value="$action" />
					<input type="hidden" name="prepare" value="prepare" />
					<input type="submit" value="{$lng['panel']['next']}" />
				</p>
				</fieldset>
			</form>
		</section>
	</article>
$footer

