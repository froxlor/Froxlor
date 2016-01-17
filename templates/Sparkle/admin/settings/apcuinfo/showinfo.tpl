$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{$lng['admin']['apcuinfo']}
			</h2>
		</header>

		<section>
			<table class="full">
                            <tr class="section">
                                <th>{$lng['apcuinfo']['generaltitle']}</th>
                                <th class="right">
                                        <a href="{$linker->getLink(array('section' => 'apcuinfo', 'page' => 'showinfo', 'action' => 'delete'))}">{$lng['apcuinfo']['clearcache']}</a>
                                        &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['version']}</td>
                                <td>{$apcversion}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['phpversion']}</td>
                                <td>{$phpversion}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['sharedmem']}</td>
                                <td>{$sharedmem}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['start']}</td>
                                <td>{$starttime}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['uptime']}</td>
                                <td>{$uptime_duration}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['upload']}</td>
                                <td>{$cache['file_upload_progress']}</td>
                            </tr>
                            
                            
                            <tr class="section">
                                <th colspan="2">{$lng['apcuinfo']['cachetitle']}</th>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['cvar']}</td>
                                <td>{$number_vars} ({$size_vars})</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['hit']}</td>
                                <td>{$cache['num_hits']}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['miss']}</td>
                                <td>{$cache['num_misses']}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['reqrate']}</td>
                                <td>{$req_rate_user} {$lng['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['hitrate']}</td>
                                <td>{$hit_rate_user} {$lng['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['missrate']}</td>
                                <td>{$miss_rate_user} {$lng['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['insrate']}</td>
                                <td>{$insert_rate_user} {$lng['apcuinfo']['creqsec']}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['cachefull']}</td>
                                <td>{$cache['num_expunges']}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{$lng['apcuinfo']['memnote']}</th>
                            </tr>
                            {$img_src1}
                            <tr>
                                <td>{$lng['apcuinfo']['free']}</td>
                                <td>{$freemem}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['used']}</td>
                                <td>{$usedmem}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{$lng['apcuinfo']['hitmiss']}</th>
                            </tr>
                            {$img_src2}
                            <tr>
                                <td>{$lng['apcuinfo']['hit']}</td>
                                <td>{$hits}</td>
                            </tr>
                            <tr>
                                <td>{$lng['apcuinfo']['miss']}</td>
                                <td>{$misses}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{$lng['apcuinfo']['detailmem']}</th>
                            </tr>
                            {$img_src3}
                            <tr>
                                <td>{$lng['apcuinfo']['fragment']}</td>
                                <td>{$frag}</td>
                            </tr>
                            
                            <tr class="section">
                                <th colspan="2">{$lng['apcuinfo']['runtime']}</th>
                            </tr>
                            {$runtimelines}
			</table>
                            
		</section>
                            
                            
</article>
$footer
