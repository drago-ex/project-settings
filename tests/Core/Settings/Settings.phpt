<?php

/**
 * Test: App\Core\Settings\Settings
 */

declare(strict_types=1);

use App\Core\Settings\Settings;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test('Settings expose values through methods and magic properties', function () {
	$settings = new Settings([
		'website' => 'Drago',
		'description' => 'A sample site',
	]);

	Assert::same('Drago', $settings->get('website'));
	Assert::true($settings->has('website'));
	Assert::false($settings->has('missing'));
	Assert::same('Drago', $settings->website);
	Assert::true(isset($settings->website));
	Assert::false(isset($settings->missing));
	Assert::same([
		'website' => 'Drago',
		'description' => 'A sample site',
	], $settings->all());
});


test('Reading a missing setting throws a descriptive exception', function () {
	$settings = new Settings([]);

	Assert::exception(
		fn() => $settings->get('missing'),
		RuntimeException::class,
		'Missing setting "missing".',
	);
});

