<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers Certificates
 */
class CertificatesTest extends TestCase
{

	public function testAdminCertificatesAdd()
	{
		global $admin_userdata;
		
		$certdata = $this->generateKey();
		$json_result = Certificates::getLocal($admin_userdata, array(
			'domainname' => 'test2.local',
			'ssl_cert_file' => $certdata['cert'],
			'ssl_key_file' => $certdata['key']
		))->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['domainid']);
	}

	public function testResellerCertificatesAddAgain()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		
		$certdata = $this->generateKey();
		$this->expectExceptionCode(406);
		$this->expectExceptionMessage("Domain 'test2.local' already has a certificate. Did you mean to call update?");
		$json_result = Certificates::getLocal($reseller_userdata, array(
			'domainname' => 'test2.local',
			'ssl_cert_file' => $certdata['cert'],
			'ssl_key_file' => $certdata['key']
		))->add();
	}

	public function testCustomerCertificatesAdd()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$certdata = $this->generateKey();
		$json_result = Certificates::getLocal($customer_userdata, array(
			'domainname' => 'mysub2.test2.local',
			'ssl_cert_file' => $certdata['cert'],
			'ssl_key_file' => $certdata['key']
		))->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(5, $result['domainid']);
	}

	public function testAdminCertificatesList()
	{
		global $admin_userdata;
		
		$json_result = Certificates::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
	}

	public function testResellerCertificatesList()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		
		$json_result = Certificates::getLocal($reseller_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
	}

	public function testCustomerCertificatesList()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$json_result = Certificates::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
	}

	public function testAdminCertificatesUpdate()
	{
		global $admin_userdata;
		
		$certdata = $this->generateKey();
		$json_result = Certificates::getLocal($admin_userdata, array(
			'domainname' => 'test2.local',
			'ssl_cert_file' => $certdata['cert'],
			'ssl_key_file' => $certdata['key']
		))->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['domainid']);
		$this->assertEquals(str_replace("\n", "", $certdata['cert']), str_replace("\n", "", $result['ssl_cert_file']));
	}

	public function testCustomerCertificatesUpdate()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$certdata = $this->generateKey();
		$json_result = Certificates::getLocal($customer_userdata, array(
			'domainname' => 'mysub2.test2.local',
			'ssl_cert_file' => $certdata['cert'],
			'ssl_key_file' => $certdata['key']
		))->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(5, $result['domainid']);
		$this->assertEquals(str_replace("\n", "", $certdata['cert']), str_replace("\n", "", $result['ssl_cert_file']));
	}

	/**
	 * @depends testAdminCertificatesUpdate
	 */
	public function testCustomerCertificatesDelete()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$json_result = Certificates::getLocal($customer_userdata, array(
			'id' => 1
		))->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['domainid']);
	}

	private function generateKey()
	{
		$dn = array(
			"countryName" => "DE",
			"stateOrProvinceName" => "Hessen",
			"localityName" => "Frankfurt",
			"organizationName" => "Froxlor",
			"organizationalUnitName" => "Testing",
			"commonName" => "test2.local",
			"emailAddress" => "team@froxlor.org"
		);
		
		// generate key pair
		$privkey = openssl_pkey_new(array(
			"private_key_bits" => 2048,
			"private_key_type" => OPENSSL_KEYTYPE_RSA
		));
		
		// generate csr
		$csr = openssl_csr_new($dn, $privkey, array(
			'digest_alg' => 'sha256'
		));
		
		// generate self-signed certificate
		$sscert = openssl_csr_sign($csr, null, $privkey, 365, array(
			'digest_alg' => 'sha256'
		));
		
		// export
		openssl_csr_export($csr, $csrout);
		openssl_x509_export($sscert, $certout);
		openssl_pkey_export($privkey, $pkeyout, null);
		
		return array(
			'cert' => $certout,
			'key' => $pkeyout
		);
	}
}
