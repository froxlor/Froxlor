<?php

	function generateDkim( $vars ) {

		if ( Settings::Get( 'dkim.use_dkim' ) !== '1'
			|| !isset( $vars['dkim_pubkey'] )
			|| $vars['dkim_pubkey'] == '' ) {
				return false;
		}
		
		$selector = "custom";
		
		// start
		$dkim_txt = 'v=DKIM1;';

		// algorithm
		$algorithm = explode( ',', Settings::Get( 'dkim.dkim_algorithm' ) );
		$alg = '';

		foreach ( $algorithm as $a ) {
			if ( $a == 'all' ) {
				break;
			} else {
				$alg .= $a . ':';
			}
		}

		if ( $alg != '' ) {
			$alg = substr( $alg, 0, -1 );
			$dkim_txt .= 'h=' . $alg . ';';
		}

		// notes
		if ( trim( Settings::Get( 'dkim.dkim_notes' ) != '' ) ) {
			$dkim_txt .= 'n=' . trim( Settings::Get( 'dkim.dkim_notes' ) ) . ';';
		}

		// key
		$dkim_txt .= 'k=rsa;p=' . trim( preg_replace( '/-----BEGIN PUBLIC KEY-----(.+)-----END PUBLIC KEY-----/s', '$1', str_replace( "\n", '', $vars['dkim_pubkey'] ) ) ) . ';';

		// service-type
		if ( Settings::Get( 'dkim.dkim_servicetype' ) == '1' ) {
			$dkim_txt .= 's=email;';
		}

		// end-part
		$dkim_txt .= 't=s';

		// split if necessary
		$dkim_record = '';
		$lbr = 50;
		for ( $pos = 0; $pos <= strlen( $dkim_txt ) -1; $pos += $lbr ) {
			$dkim_record .= ( ( $pos == 0 ) ? '( "' : "\t\t\t\t\t \"" ) . substr( $dkim_txt, $pos, $lbr ) . ( ( $pos >= strlen( $dkim_txt ) - $lbr ) ? '" )' : '"' );
		}

		// Host entry
		if ( !empty( $selector ) ) {
			$dkim_host .= $selector . '._domainkey';
		}
		else if ( !empty( $vars['dkim_key'] ) ) {
			$dkim_host .= 'dkim_' . $vars['dkim_id'] . '._domainkey';
		}
		else {
			$dkim_host .= 'default._domainkey';
		}

		// adsp-entry
		if ( Settings::Get( 'dkim.dkim_add_adsp' ) == "1" ) {

			$adsp_host .= '_adsp._domainkey';
			$adsp_record = '"dkim=';
			switch ( (int)Settings::Get( 'dkim.dkim_add_adsppolicy' ) ) {
				case 0:
					$adsp_record .= 'unknown"' . "\n";
					break;
				case 1:
					$adsp_record .= 'all"' . "\n";
					break;
				case 2:
					$adsp_record .= 'discardable"' . "\n";
					break;
			}
		}

		$return = array();
		$return['dkim_host'] = $dkim_host;
		$return['dkim_record'] = $dkim_record;
		if ( isset( $adsp_host ) && isset( $adsp_record ) ) {
			$return['adsp_host'] = $adsp_host;
			$return['adsp_record'] = $adsp_record;
		}

		return $return;
	}

