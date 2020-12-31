<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Api\Commands\Domains;
use Froxlor\Bulk\DomainBulkAction;

/**
 *
 * @covers \Froxlor\Bulk\BulkAction
 * @covers \Froxlor\Bulk\DomainBulkAction
 */
class DomainBulkTest extends TestCase
{
	public function testNoImportFile()
	{
		global $admin_userdata;
		$this->expectExceptionMessage("No file was given for import");
		$bulk = new DomainBulkAction(null, $admin_userdata);
		$bulk->doImport(";", 0);
	}

	public function testImportFileDoesNotExist()
	{
		global $admin_userdata;
		$this->expectExceptionMessage("The file '/tmp/nonexisting.csv' could not be found");
		$bulk = new DomainBulkAction("/tmp/nonexisting.csv", $admin_userdata);
		$bulk->doImport(";", 0);
	}

	public function testImportDomains()
	{
		global $admin_userdata;

		$content = <<<EOC
domain;loginname;
imported-a.com;test1;
imported-b.com;test1;
imported-c.com;test2;
EOC;
		file_put_contents('/tmp/import-test.csv', $content);
		$bulk = new DomainBulkAction("/tmp/import-test.csv", $admin_userdata);
		$result = $bulk->doImport(";", 0);

		$this->assertEquals(3, $result['all']);
		$this->assertEquals(2, $result['imported']);
		$this->assertEquals("Customer with loginname 'test2' could not be found", $bulk->getErrors()[0]);

		// now check whether the domain really exists for test1 user
		$data = [
			'domain' => 'imported-a.com'
		];
		$json_result = Domains::getLocal($admin_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('imported-a.com', $result['domain']);
		$this->assertEquals(1, $result['customerid']);
	}

	public function testImportDomainsMaxAlloc()
	{
		global $admin_userdata;

		// fake allocation restriction
		$admin_userdata['domains'] = 1;

		$content = <<<EOC
domain;loginname;
imported-a.com;test1;
imported-b.com;test1;
imported-c.com;test2;
EOC;
		file_put_contents('/tmp/import-test.csv', $content);
		$bulk = new DomainBulkAction("/tmp/import-test.csv", $admin_userdata);
		$result = $bulk->doImport(";", 0);

		$this->assertEquals(3, $result['all']);
		$this->assertEquals(0, $result['imported']);
		$this->assertEquals("You have reached your maximum allocation of domains (" . $admin_userdata['domains'] . ")", $result['notes']);
	}
}
