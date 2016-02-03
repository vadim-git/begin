<!doctype html>
<html>
<head>
<title>Begin page</title>
</head>
<body>

<?php

abstract class transport {

	protected $command = '';

	abstract public function start ();

	abstract public function go ();

	public function show () {

		print $this->command . "<br />";

	}

}


class car extends transport {

	public function start (){

		$this->command = 'start';

		$this->show();

		return $this;

	}


	public function go() {

		$this->command = 'go';

		$this->show();

		return $this;
	}

}


$car = new car();
$car->start()->go();


include_once "config.php";
include_once "school.class.php";

//echo "<pre>";print_r($array);echo "</pre>";

$school = new school();
/*Добавить книгу*/
//$school->addBook('Первое чудо');
/*Добавить автора*/
//$school->addAuthor('Герман');
/*Добавить студента*/
//$school->addStudent('Генадий');

/*Установить связь книги с автором*/
//$school->setBookOfAuthor(7,1);
/*книги 1-7, Авторы 1-5*/

// Студент взял книгу ID Студента и ID книги
// Студенты 1-6, Книги 1-7
//$school->studentGiveBook(5,4);

$school->getMostPopularAuthor();
$school->getBooks();
/*echo "<pre>";
var_dump($school);
$a = array (1, 2, array ("a", "b", "c")); 
var_dump($a); 

$b = 3.1;
$c = true;
var_dump($b, $c);
echo "</pre>";*/



?>
</body>
</html>