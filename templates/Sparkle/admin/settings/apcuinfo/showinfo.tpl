$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['apcuinfo']}
			</h2>
		</header>

		<section>
			<table class="full">
                            <tr class="section">
                                <th>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['generaltitle']}</th>
                                <th class="right">
                                        <a href="{$linker->getLink(array('section' => 'apcuinfo', 'page' => 'showinfo', 'action' => 'delete'))}">{\Froxlor\I18N\Lang::getAll()['apcuinfo']['clearcache']}</a>
                                        &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['version']}</td>
                                <td>{$apcversion}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['phpversion']}</td>
                                <td>{$phpversion}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['sharedmem']}</td>
                                <td>{$sharedmem}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['start']}</td>
                                <td>{$starttime}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['uptime']}</td>
                                <td>{$uptime_duration}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['upload']}</td>
                                <td>{$cache['file_upload_progress']}</td>
                            </tr>
                            
                            
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['apcuinfo']['cachetitle']}</th>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['cvar']}</td>
                                <td>{$number_vars} ({$size_vars})</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['hit']}</td>
                                <td>{$cache['num_hits']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['miss']}</td>
                                <td>{$cache['num_misses']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['reqrate']}</td>
                                <td>{$req_rate_user} {\Froxlor\I18N\Lang::getAll()['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['hitrate']}</td>
                                <td>{$hit_rate_user} {\Froxlor\I18N\Lang::getAll()['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['missrate']}</td>
                                <td>{$miss_rate_user} {\Froxlor\I18N\Lang::getAll()['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['insrate']}</td>
                                <td>{$insert_rate_user} {\Froxlor\I18N\Lang::getAll()['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['cachefull']}</td>
                                <td>{$cache['num_expunges']}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['apcuinfo']['memnote']}</th>
                            </tr>
                            {$img_src1}
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['free']}</td>
                                <td>{$freemem}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['used']}</td>
                                <td>{$usedmem}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['apcuinfo']['hitmiss']}</th>
                            </tr>
                            {$img_src2}
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['hit']}</td>
                                <td>{$hits}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['miss']}</td>
                                <td>{$misses}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['apcuinfo']['detailmem']}</th>
                            </tr>
                            {$img_src3}
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['apcuinfo']['fragment']}</td>
                                <td>{$frag}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['apcuinfo']['runtime']}</th>
                            </tr>
                            {$runtimelines}
			</table>
                            
		</section>
                            
                            
</article>
$footer
