<?php

namespace Froxlor\Dkim;

class Rspamd extends DkimHelperBase
{
	public function getRecordName($domain)
	{
		return 'dkim._domainkey';
	}
}