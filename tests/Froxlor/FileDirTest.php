<?php

use Froxlor\FileDir;
use PHPUnit\Framework\TestCase;

/**
 * 
 * @covers \Froxlor\FileDir
 */
class FileDirTest extends TestCase
{

	protected $tmpfile = '/tmp/Froxlor-FileDirTest.Shie7tieni5EeRi4.tmp';

	protected $testdata = 'Froxlor-FileDirTest Testdata';
	protected $testdata2 = 'Froxlor-FileDirTest Data 2';

	public function testWriteFile()
	{
		@unlink($this->tmpfile);
		$result = FileDir::writeFile($this->tmpfile, $this->testdata, 0644);
		$this->assertTrue($result);
		$this->assertFileExists($this->tmpfile, "File should be written");
		$this->assertStringEqualsFile($this->tmpfile, $this->testdata);

		$resultRewrite = FileDir::writeFile($this->tmpfile, $this->testdata2, 0640);
		$this->assertTrue($resultRewrite);
		$this->assertStringEqualsFile($this->tmpfile, $this->testdata2, "File content not written correctly");

		clearstatcache();

		$perms = fileperms($this->tmpfile) & 0777;
		$this->assertEquals(0640, $perms, "File permission not set correctly");

		$resultPermissionChange = FileDir::writeFile($this->tmpfile, $this->testdata2, 0600);
		
		clearstatcache();
		
		$perms = fileperms($this->tmpfile) & 0777;
		$this->assertEquals(0600, $perms, "File permission not update if file content is same");

		@unlink($this->tmpfile);
	}

	public function testWriteFilePermission()
	{
		$this->expectExceptionMessage("permissions");
		$result = FileDir::writeFile($this->tmpfile, $this->testdata, 0777+1);
	}


	public function testWriteFileOwner()
	{
		@unlink($this->tmpfile);

		$posixusername = posix_getpwuid(posix_getuid());
		$posixgroup = posix_getgrgid(posix_getgid());

		$groupname = 'users';
		$testgrpinfo = posix_getgrnam($groupname);

		$this->assertNotFalse($testgrpinfo, "Posix group {$groupname} should exists for test");
		if ($testgrpinfo === false) {
			throw new \Exception("Can't get group info");
		}
		$posixusername = get_current_user();
		$result = FileDir::writeFile($this->tmpfile, $this->testdata, 0644, $posixusername, $groupname);

		clearstatcache();
		
		$this->assertEquals($testgrpinfo['gid'], filegroup($this->tmpfile), "File group should be set");
		
		@unlink($this->tmpfile);
	}
}
