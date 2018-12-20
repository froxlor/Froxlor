<?php
namespace Froxlor\Validate\Form;

class String
{

	public static function validateFormFieldString($fieldname, $fielddata, $newfieldvalue)
	{
		if (isset($fielddata['string_delimiter']) && $fielddata['string_delimiter'] != '') {
			$newfieldvalues = array_map('trim', explode($fielddata['string_delimiter'], $newfieldvalue));
			unset($fielddata['string_delimiter']);

			$returnvalue = true;
			foreach ($newfieldvalues as $single_newfieldvalue) {
				/**
				 * don't use tabs in value-fields, #81
				 */
				$single_newfieldvalue = str_replace("\t", " ", $single_newfieldvalue);
				$single_returnvalue = self::validateFormFieldString($fieldname, $fielddata, $single_newfieldvalue);
				if ($single_returnvalue !== true) {
					$returnvalue = $single_returnvalue;
					break;
				}
			}
		} else {
			$returnvalue = false;

			/**
			 * don't use tabs in value-fields, #81
			 */
			$newfieldvalue = str_replace("\t", " ", $newfieldvalue);

			if (isset($fielddata['string_type']) && $fielddata['string_type'] == 'mail') {
				$returnvalue = (filter_var($newfieldvalue, FILTER_VALIDATE_EMAIL) == $newfieldvalue);
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'url') {
				$returnvalue = self::validateUrl($newfieldvalue);
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'dir') {
				// check for empty value (it might be allowed)
				if (trim($newfieldvalue) == '') {
					$newfieldvalue = '';
					$returnvalue = 'stringmustntbeempty';
				} else {
					// add trailing slash to validate path if needed
					// refs #331
					if (substr($newfieldvalue, - 1) != '/') {
						$newfieldvalue .= '/';
					}
					$returnvalue = ($newfieldvalue == \Froxlor\FileDir::makeCorrectDir($newfieldvalue));
				}
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'confdir') {
				// check for empty value (it might be allowed)
				if (trim($newfieldvalue) == '') {
					$newfieldvalue = '';
					$returnvalue = 'stringmustntbeempty';
				} else {
					// add trailing slash to validate path if needed
					// refs #331
					if (substr($newfieldvalue, - 1) != '/') {
						$newfieldvalue .= '/';
					}
					// if this is a configuration directory, check for stupidity of admins :p
					if (\Froxlor\FileDir::checkDisallowedPaths($newfieldvalue) !== true) {
						$newfieldvalue = '';
						$returnvalue = 'givendirnotallowed';
					} else {
						$returnvalue = ($newfieldvalue == \Froxlor\FileDir::makeCorrectDir($newfieldvalue));
					}
				}
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'file') {
				// check for empty value (it might be allowed)
				if (trim($newfieldvalue) == '') {
					$newfieldvalue = '';
					$returnvalue = 'stringmustntbeempty';
				} else {
					$returnvalue = ($newfieldvalue == \Froxlor\FileDir::makeCorrectFile($newfieldvalue));
				}
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'filedir') {
				// check for empty value (it might be allowed)
				if (trim($newfieldvalue) == '') {
					$newfieldvalue = '';
					$returnvalue = 'stringmustntbeempty';
				} else {
					$returnvalue = (($newfieldvalue == \Froxlor\FileDir::makeCorrectDir($newfieldvalue)) || ($newfieldvalue == \Froxlor\FileDir::makeCorrectFile($newfieldvalue)));
				}
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'validate_ip') {
				// check for empty value (it might be allowed)
				if (trim($newfieldvalue) == '') {
					$newfieldvalue = '';
					$returnvalue = 'stringmustntbeempty';
				} else {
					$newfieldvalue = \Froxlor\Validate\Validate::validate_ip2($newfieldvalue, true);
					$returnvalue = ($newfieldvalue !== false ? true : 'invalidip');
				}
			} elseif (isset($fielddata['string_type']) && $fielddata['string_type'] == 'validate_ip_incl_private') {
				// check for empty value (it might be allowed)
				if (trim($newfieldvalue) == '') {
					$newfieldvalue = '';
					$returnvalue = 'stringmustntbeempty';
				} else {
					$newfieldvalue = \Froxlor\Validate\Validate::validate_ip2($newfieldvalue, true, 'invalidip', true, true, true);
					$returnvalue = ($newfieldvalue !== false ? true : 'invalidip');
				}
			} elseif (preg_match('/^[^\r\n\t\f\0]*$/D', $newfieldvalue)) {
				$returnvalue = true;
			}

			if (isset($fielddata['string_regexp']) && $fielddata['string_regexp'] != '') {
				if (preg_match($fielddata['string_regexp'], $newfieldvalue)) {
					$returnvalue = true;
				} else {
					$returnvalue = false;
				}
			}

			if (isset($fielddata['string_emptyallowed']) && $fielddata['string_emptyallowed'] === true && $newfieldvalue === '') {
				$returnvalue = true;
			} elseif (isset($fielddata['string_emptyallowed']) && $fielddata['string_emptyallowed'] === false && $newfieldvalue === '') {
				$returnvalue = 'stringmustntbeempty';
			}
		}

		if ($returnvalue === true) {
			return true;
		} elseif ($returnvalue === false) {
			return 'stringformaterror';
		} else {
			return $returnvalue;
		}
	}

	/**
	 * Returns whether a URL is in a correct format or not
	 *
	 * @param string $url
	 *        	URL to be tested
	 * @return bool
	 * @author Christian Hoffmann
	 * @author Froxlor team <team@froxlor.org> (2010-)
	 *        
	 */
	public static function validateUrl($url)
	{
		if (strtolower(substr($url, 0, 7)) != "http://" && strtolower(substr($url, 0, 8)) != "https://") {
			$url = 'http://' . $url;
		}

		// needs converting
		try {
			$idna_convert = new \Froxlor\Idna\IdnaWrapper();
			$url = $idna_convert->encode($url);
		} catch (\Exception $e) {
			return false;
		}

		$pattern = "/^https?:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,4}(\:[0-9]+)?\/?(.+)?$/i";
		if (preg_match($pattern, $url)) {
			return true;
		}

		// not an fqdn
		if (strtolower(substr($url, 0, 7)) == "http://" || strtolower(substr($url, 0, 8)) == "https://") {
			if (strtolower(substr($url, 0, 7)) == "http://") {
				$ip = strtolower(substr($url, 7));
			}

			if (strtolower(substr($url, 0, 8)) == "https://") {
				$ip = strtolower(substr($url, 8));
			}

			$ip = substr($ip, 0, strpos($ip, '/'));
			// possible : in IP (when a port is given), #1173
			// but only if there actually IS ONE
			if (strpos($ip, ':') !== false) {
				$ip = substr($ip, 0, strpos($ip, ':'));
			}

			if (validate_ip($ip, true) !== false) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}