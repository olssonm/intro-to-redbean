<?php
	require_once('vendor/autoload.php');
	use RedBean_Facade as R;

	date_default_timezone_set('Europe/Stockholm');

	R::setup('mysql:host=localhost;dbname=' . DB_NAME, DB_USER, DB_PASSWORD);

	R::nuke();

	class Model_class extends RedBean_SimpleModel {
		public function update() {
			$this->created_at = date("Y-m-d H:i:s");
		}
	}

	$school = R::dispense('school');
	$school->name = 'Jedi Academy';
	$school->city = 'Coruscant';
	R::store($school);

	list($s1, $s2) = R::dispense('student', 2);
	$s1->name = 'Anakin Solo';
	$s1->age = 11;
	$s2->name = 'Ben Skywalker';
	$s2->age = 11;
	R::store($s1);
	R::store($s2);

	$class = R::dispense('class');
	$class->name = '4B';

	$class->ownStudent[] = $s1;
	$class->ownStudent[] = $s2;
	
	R::store($class);

	$teacher = R::dispense('teacher');
	$teacher->name = 'Luke Skywalker';
	R::store($teacher);

	$class = R::load('class', 1);
	$class->sharedTeacher[] = $teacher;
	R::store($class);

	$teacher = R::load('teacher', 1);
	$classes = $teacher->sharedClass;
	foreach($classes as $class) {
		echo $class->name;
	}

	$class = R::find('class', 'name = ?', array(
		'4B'
	));

	$name = '4B';
	$limit = 1;

	$class = R::find('class', 'name = ? ORDER BY name ASC LIMIT ?', array(
		$name,
		$limit
	));

	// $number = R::dispense('number');
	// $number->value = 199.99;
	// R::store($number);

	// $number = R::dispense('number');
	// $number->value = 'hej';
	// R::store($number);