<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Cron\TaskId;

/**
 *
 * @covers \Froxlor\Cron\TaskId
 */
class TaskIDTest extends TestCase
{
	private $fixedids = array(
		'REBUILD_VHOST' => 1,

		'CREATE_HOME' => 2,

		'REBUILD_DNS' => 4,

		'CREATE_FTP' => 5,

		'DELETE_CUSTOMER_FILES' => 6,

		'DELETE_EMAIL_DATA' => 7,

		'DELETE_FTP_DATA' => 8,

		'CREATE_QUOTA' => 10,

		'DELETE_DOMAIN_PDNS' => 11,

		'DELETE_DOMAIN_SSL' => 12,

		'CREATE_CUSTOMER_BACKUP' => 20,

		'REBUILD_CRON' => 99,
	);

	public function testValidTaskId()
	{

		$isId99Valid = TaskId::isValid(99);
		$this->assertTrue($isId99Valid, "Task id 99 must be valid");

		$isIdStringValid = TaskId::isValid('99');
		$this->assertTrue($isIdStringValid, "String task ids should be valid");

		$isNegativeValid = TaskId::isValid(-1);
		$this->assertFalse($isNegativeValid, "Negative task should be invalid");
	}

	public function testIdMappingCorrect() {
		foreach($this->fixedids as $name => $expected) {
			$result = constant("\Froxlor\Cron\TaskId::$name");
			$this->assertEquals( $expected, $result, "Task $name has bad mapping");
		}
	}

	public function testConvertToConstant() {
		foreach($this->fixedids as $name => $taskid) {
			$result = TaskId::convertToConstant($taskid);
			$this->assertEquals( $name, $result, "Task $name has bad mapping from id to name");
		}

		$unknownIDResult = TaskId::isValid(10101010);
		$this->assertFalse($unknownIDResult);
	}
}
