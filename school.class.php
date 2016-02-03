<?php 

class school {
	
	private $pdo;
	private $popularAuthor;
	
	public function __construct () {
		global $param;

		$dsn = "mysql:host=".$param['host']."; dbname=" . $param['db'] . "; SET NAMES cp1251";

		try {
			$this->pdo = new PDO($dsn, $param['user'], $param['pass']);
		} catch (PDOException $e) {
			die ('�� ������� ������������ � ���� ������: ' . $e->getMessage());
		}
	}

	// �������� ����� �� ��������
	public function addBook ($name) {
		try {
			$db = $this->pdo;
			$query = "INSERT INTO books (name) VALUES ('" . $name . "');";
			$db->query($query);
		} catch (PDOException $e) {
			echo '����� �� ���� ���������! ' . $e;
		}
	}

	// �������� ������ �����
	public function addAuthor ($name) {
		try {
			$db = $this->pdo;
			$query = "INSERT INTO autors (name) VALUES ('" . $name . "');";
			$db->query($query);
		} catch (PDOException $e) {
			echo '����� �� ��� ��������! ' . $e;
		}
	}

	// �������� ��������
	public function addStudent ($name) {
		try {
			$db = $this->pdo;
			$query = "INSERT INTO students (name) VALUES ('" . $name . "');";
			$db->query($query);
		} catch (PDOException $e) {
			echo '������� �� ��� ��������! ' . $e;
		}
	}

	// ������� ���� �����
	public function studentGiveBook ($id_student, $id_book) {
		try {
			$db = $this->pdo;
			$query = "INSERT INTO books_students (id_books, id_students) VALUES ('" . $id_book. "', '" . $id_student . "');";
			$db->query($query);
		} catch (PDOException $e) {
			echo '������� �� ���� ����� �����! ' . $e;
		}
	}

	// ������ ����� ����� ������ � �������
	public function setBookOfAuthor ($id_book, $id_author) {
		try {
			$db = $this->pdo;
			$query = "INSERT INTO autors_books (id_autors, id_books) VALUES ('" . $id_author . "', '" . $id_book . "');";
			$db->query($query);
		} catch (PDOException $e) {
			echo '����� ����� ������ � ������� �� ���� �����������! ' . $e;
		}
	}

	// �������� ������ ��������� ������
	public function getMostPopularAuthor () {
		try {
			$db = $this->pdo;
			$query = "SELECT a.name, count(bs.id_books) AS qut_id_book FROM autors AS a ";
			$query .= " INNER JOIN autors_books AS ab ON ab.id_autors = a.id ";
			$query .= " LEFT JOIN books_students AS bs ON bs.id_books = ab.id_books ";
			$query .= " GROUP BY a.name ";
			$query .= " ORDER BY qut_id_book desc LIMIT 1; ";
//echo $query;
			$result = $db->query($query);
			while($row = $result->fetch()){
				$this->popularAuthor = iconv 	('utf-8', 'windows-1251', $row['name']) . " (" . $row['qut_id_book'] . ")";
			}
		} catch (PDOException $e) {
			echo $e;
		}
		$this->render('���������� ����� ����� ���������', '���������� �����: ' . $this->popularAuthor);
	}

	private function getFromPDO ($db_name, $field) {

		try {
			$db = $this->pdo;
			$arr = array();

			$query = "SELECT `" . $field . "` FROM `" . $db_name . "` ORDER BY " . $field;

			$result = $db->query($query);

			while($row = $result->fetch()) {
				$arr[] = $row[$field];
			}
		} catch (PDOException $e) {
			return "��������� ������: " . $e;
		}

		return $arr;
	}


	private function preparation ($arr, $header) {
		$begin = "<ol>"; $end = "</ol>";
		$render = "<h4>" . $header . ": (" . count($arr) . ")</h4>";
		$render .= $begin;

		foreach ($arr as $ar) {
			$render .= "<li>" . iconv('utf-8', 'windows-1251', $ar) . "</li>";
		}
		$render .= $end;
		
		return $render;
	}


	public function getBooks () {

		/* ������ ���� */
		$books = $this->getFromPDO('books', 'name');
		/* ������ ������� */
		$autors = $this->getFromPDO('autors', 'name');
		/* ������ ��������� */
		$students = $this->getFromPDO('students', 'name');

		/* ��������� ������ ���� */
		$this->render("����� ����������", $this->preparation($books, '�������� ���� ����'));

		/* ��������� ������ ������� */
		$this->render("", $this->preparation($autors, '�������� ���� �������'));

		/* ��������� ������ ��������� */
		$this->render("", $this->preparation($students, '�������� ���� ���������'));

	}

	private function render ($header, $data) {
		echo "<h2>" . $header . "</h2>";
		echo "<div>" . $data . "</div>";
	}

}






