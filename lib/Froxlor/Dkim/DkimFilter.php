<?php

namespace Froxlor\Dkim;

class DkimFilter extends DkimHelperBase
{

	public function getRecordName($domain)
	{
		return 'dkim' . $domain['dkim_id'] . '._domainkey';
	}
}