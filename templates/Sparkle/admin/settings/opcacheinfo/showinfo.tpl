$header
<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/res_recalculate_big.png" alt="" />&nbsp;
				{\Froxlor\I18N\Lang::getAll()['admin']['opcacheinfo']}
			</h2>
		</header>

		<section>
                        <div>
                            
                            <if ($totalmem) >
                                <div class="canvasbox">
					<input type="hidden" id="usedmem" class="circular" data-used="{$usedmem}" data-available="{$totalmem}">
					<canvas id="usedmem-canvas" width="120" height="76"></canvas><br />
                                        {\Froxlor\I18N\Lang::getAll()['opcacheinfo']['memusage']}<br />
                                        <small>
                                            {\Froxlor\I18N\Lang::getAll()['opcacheinfo']['used']}: {$usedmemstr} <br />
                                            {\Froxlor\I18N\Lang::getAll()['opcacheinfo']['free']}: {$freememstr}
                                        </small>
				</div>                  
                                <div class="canvasbox">
					<input type="hidden" id="wastedmem" class="circular" data-used="{$wastedmem}" data-available="{$totalmem}">
					<canvas id="wastedmem-canvas" width="120" height="76"></canvas><br />
					{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['wastedmem']}<br />
                                        <small>
                                            {$wastedmemstr}
                                        </small>
				</div>                  
                            </if>
                            <if (isset($stringbuffer)) >
                                <div class="canvasbox">
					<input type="hidden" id="stringused" class="circular" data-used="{$usedstring}" data-available="{$totalstring}">
					<canvas id="stringused-canvas" width="120" height="76"></canvas><br />
					{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['strinterning']}<br />
                                        <small>
                                            {\Froxlor\I18N\Lang::getAll()['opcacheinfo']['used']}: {$usedstringstr} <br />
                                            {\Froxlor\I18N\Lang::getAll()['opcacheinfo']['free']}: {$freestringstr}
                                        </small>
				</div>                  
                            </if>
                            <if ($totalkey) >
                                <div class="canvasbox">
					<input type="hidden" id="usedkeystat" class="circular" data-used="{$usedkey}" data-available="{$totalkey}">
					<canvas id="usedkeystat-canvas" width="120" height="76"></canvas><br />
					{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['usedkey']}<br />
                                        <small>
                                            {$usedkeystr}
                                        </small>
				</div>                  
                            </if>
                            <if ($cachetotal) >
                                <div class="canvasbox">
					<input type="hidden" id="cachehit" class="circular" data-used="{$cachehits}" data-available="{$cachetotal}">
					<canvas id="cachehit-canvas" width="120" height="76"></canvas><br />
					{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['hitsc']}
				</div>                  
                            </if>
                                
                        </div>
                    
			<table class="full">
                            <tr class="section">
                                <th>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['generaltitle']}</th>
                                <th class="right">
                                        <a href="{$linker->getLink(array('section' => 'opcacheinfo', 'page' => 'showinfo', 'action' => 'reset'))}">{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['resetcache']}</a>
                                        &nbsp;
                                </th>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['version']}</td>
                                <td>{$general['version']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['phpversion']}</td>
                                <td>{$general['phpversion']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['start']}</td>
                                <td>{$general['start_time']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['lastreset']}</td>
                                <td>{$general['last_restart_time']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['oomrestarts']}</td>
                                <td>{$general['oom_restarts']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['hashrestarts']}</td>
                                <td>{$general['hash_restarts']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['manualrestarts']}</td>
                                <td>{$general['manual_restarts']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['status']}</td>
                                <td>{$general['status']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['cachedscripts']}</td>
                                <td>{$general['cachedscripts']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['hitsc']}</td>
                                <td>{$general['cachehits']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['missc']}</td>
                                <td>{$general['cachemiss']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['blmissc']}</td>
                                <td>{$general['blacklistmiss']}</td>
                            </tr>

                            <if ($totalmem) >
                            <tr>
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['memusage']}</th>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['totalmem']}</td>
                                <td>{$memory['total']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['usedmem']}</td>
                                <td>{$memory['used']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['freemem']}</td>
                                <td>{$memory['free']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['wastedmem']}</td>
                                <td>{$memory['wasted']}</td>
                            </tr>
                            </if>
                            
                            <if (isset($stringbuffer)) >
                            <tr>
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['strinterning']}</th>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['totalmem']}</td>
                                <td>{$stringbuffer['total']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['usedmem']}</td>
                                <td>{$stringbuffer['used']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['freemem']}</td>
                                <td>{$stringbuffer['free']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['strcount']}</td>
                                <td>{$stringbuffer['strcount']}</td>
                            </tr>
                            </if>
                            
                            <if (isset($keystat)) >
                            <tr>
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['keystat']}</th>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['maxkey']}</td>
                                <td>{$keystat['total']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['usedkey']}</td>
                                <td>{$keystat['used']}</td>
                            </tr>
                            <tr>
                                <td>{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['wastedkey']}</td>
                                <td>{$keystat['wasted']}</td>
                            </tr>
                            </if>

                            <if $runtimelines >
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['runtimeconf']}</th>
                            </tr>
                            {$runtimelines}
                            </if>
                            
                            <if $blacklistlines >
                            <tr class="section">
                                <th colspan="2">{\Froxlor\I18N\Lang::getAll()['opcacheinfo']['blacklist']}</th>
                            </tr>
                            {$blacklistlines}
                            </if>
                            
			</table>
                            
		</section>
                            
</article>
$footer
