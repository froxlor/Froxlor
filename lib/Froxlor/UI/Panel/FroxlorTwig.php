<?php

declare(strict_types=1);

namespace Froxlor\UI\Panel;

class FroxlorTwig extends \Twig\Extension\AbstractExtension
{

	public function getFilters()
	{
		return array(
			new \Twig\TwigFilter('formatBytes', array(
				$this,
				'formatBytesFilter'
			)),
			new \Twig\TwigFilter('formatIP', array(
				$this,
				'formatIPFilter'
			)),
			new \Twig\TwigFilter('idnDecode', array(
				$this,
				'idnDecodeFilter'
			))
		);
	}

	public function getTests()
	{
		return array(
			new \Twig\TwigTest('numeric', function ($value) {
				return is_numeric($value);
			})
		);
	}

	public function getFunctions()
	{
		return array(
			new \Twig\TwigFunction('get_setting', [
				$this,
				'getSetting'
			]),
			new \Twig\TwigFunction('lng', [
				$this,
				'getLang'
			])
		);
	}

	public function formatBytesFilter($size, $suffix = "B", $factor = 1)
	{
		$size = $size * $factor;
		$units = array(
			'',
			'K',
			'M',
			'G',
			'T',
			'P',
			'E',
			'Z',
			'Y'
		);
		$power = $size > 0 ? floor(log($size, 1024)) : 0;
		if ($power < 0) {
			$size = 0.00;
			$power = 0;
		}
		return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power] . $suffix;
	}

	public function formatIPFilter($addr)
	{
		return inet_ntop(inet_pton($addr));
	}

	public function idnDecodeFilter($entity)
	{
		$idna_convert = new \Froxlor\Idna\IdnaWrapper();
		return $idna_convert->decode($entity);
	}

	public function getSetting($setting = null)
	{
		return \Froxlor\Settings::Get($setting);
	}

	public function getLang($identifier = null)
	{
		return \Froxlor\UI\Panel\UI::getLng($identifier);
	}

	/**
	 *
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'froxlortwig';
	}
}
