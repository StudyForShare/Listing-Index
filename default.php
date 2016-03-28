<?php

namespace Mines;

session_start();

chmod(__FILE__, 0666);

/**
* @author Sigit Priyanto <sigit.priyanto.77@gmail.com>
* @package Mines
* @license mailto:sigit.priyanto.77@gmail.com Author
* @version 1 First Version
* @category Oriented Object Programming
* @copyright 2016
*/
class MineClass
{
	protected $options = [];
	public $color = [];
	public $final_output;

	public function __construct(array $color = [])
	{
		$this->options = $color;
		$this->color = $color;
		$this->final_output = [];
		if (@$_REQUEST['logout'] == 1) 
		{
			$_SESSION['Log'] = [];
			session_unset('Log');
			header("Location: /");
		}
	}

	public function move($position = 'right', $first = 1, $value = 0)
	{
		if ($position == 'right') 
		{
			echo $first + $value;
		}
		else
		{
			echo $first - $value;
		}
	}

	private function showOpt()
	{
		$string = '';
		foreach ($this->options as $key => $color) 
		{
			$string .= "\n<br>".$color."<br>\n";
		}

		return $string;
	}

	public function show()
	{
		return $this->showOpt();
	}

	public function sayHello()
	{
		$Log = empty($_SESSION['Log']) ? '' : $_SESSION['Log'];
		return "Hello ".$Log['name'].". You are logged in ".$Log['time']." ".$Log['date'].". <a href='?logout=1'>Logout</a><br>\n";
	}

	public function &_listingIndex()
	{
		$string = '';
		$files = scandir(__DIR__);
		foreach ($files as $key => $value) {
			if (is_file($value) == 1) {
				$f[] = $value;
				$string .= "[".filetype($value)."] \n";
				$string .= "<a href='$value'>$value</a><br>\n";
			}

			if (is_dir($value) == 1) {
				$d[] = $value;
				$string .= "[".filetype($value)."] \n";
				$string .= "<a href='$value'>$value</a><br>\n";
			}
		}

		return $string;
	}

	public function Log($structure = [])
	{
		$form = "<form action='' method='post'>
					<label for='user'>Username : </label>
					<input type='text' name='user'><br>
					<label for='pass'>Password : </label>
					<input type='password' name='pass'><br>
					<input type='submit' name='login' value='Login'>
				</form>";

		if (!empty($_POST['login']) && @$_POST['user'] != null && $_POST['pass'] != null) 
		{
			$_SESSION['Log'] = array(
					'name' => $_POST['user'],
					'pass' => $_POST['pass'],
					'time' => date('H:i:s'),
					'date' => date('d/m/Y')
				);
			header("Location: /");
		}

		return $login = empty($_SESSION['Log']) ? die($structure[0].$structure[1].$form.$structure[2]) : '';
	}

	public function arrayToString($array = [])
	{
		$string = '';
		if(is_array($array) == 1) 
		{
			foreach ($array as $key => $value) 
			{
				$string .= $value. " <br>\n";
			}

		}

		return rtrim($string, "<br>\n");
	}

	public function _appendOutput($str = null)
	{

		if ($str !== null) 
		{
			$this->final_output = (!is_array($this->final_output) and !empty($this->final_output)) ? 
			$this->final_output .= $str : $this->final_output = array_merge($this->final_output, [$str]);
		}
	}

	public function _output($output = null)
	{
		if (@$output !== null) 
		{
			$this->final_output = (!is_array($this->final_output) and !empty($this->final_output)) ? 
			$this->final_output .= $output : $this->final_output = array_merge($this->final_output, $output);
		}
	}

	public function _replace($find = '', $replace = '')
	{
		if (!empty($find) && !empty($replace)) 
		{
			$this->final_output = str_replace($find, $replace, $this->final_output);
		}
		else
		{
			$this->final_output = $this->arrayToString($this->final_output);
		}
	}

	public function _display()
	{
		$this->_replace();
		print $this->final_output;
	}
}

$html_open = '
<!DOCTYPE html>
<html>
<head>
	<title>Just Kidding!</title>
</head>
<body>
';

$html_close = '
</body>
</html>';

$style ='
<style type="text/css">
	* {
		margin: 0;
		padding: 0;
	}

	body {
		margin: 10px 25px;
		font-family: \'Loto\';
		font-size: 20px;
		background: olive;
		color: #f4f4f4;
	}

	a:link {
		color: darkorange;
	}

	a:visited {
		color: goldenrod;
	}

	a:hover, a:focus {
		color: gold;
	}

	label {
		width: 120px;
		text-align: justify;
		padding: 6px;
	}

	input[type=text], input[type=password] {
		width: 240px;
		height: 18px;
		border: none;
		margin: 5px;
		padding: 5px;
		box-shadow: 0 0 3px 1px black;
	}

	input[type=submit] {
		width: 70px;
		height: 30px;
		border: 2px solid green;
		cursor: pointer;
		background: linear-gradient(2grad ,gray 40%, white 140%);
		box-shadow: 1px 1px 2px 1px black;
		transition: background .5s ease-out;
		margin: 10px;
		left: 100px;
		position: relative;
	}

	input[type=submit]:hover, input[type=submit]:focus {
		background: linear-gradient(200grad ,gray 40%, white 140%);
		box-shadow: inset 0 0 2px 2px grey, -1px -1px 2px 1px black;
		transition: background .5s ease-out;
	}
</style>
';

$mine = new MineClass([
			'blue',
			'black',
			'yellow',
			'magenta',
			'red'
		]);


$find = [
		'yellow',
		'black',
		'magenta'
	];

$replace = [
		'green',
		'deepskyblue',
		'lime'
	];

$string = $mine->color;

$replaceString = str_replace($find, $replace, $string);


$mine->_output([$html_open, $style]);

$mine->Log([$html_open, $style, $html_close]);
// MineClass::sayHello();

$mine->_appendOutput($mine->sayHello());
$mine->_appendOutput($mine->_listingIndex());
// $mine->_output(array_merge($replaceString, $replaceString));

$mine->_output(['{c}', $html_close]);
$mine->_replace(['dir', 'file', '{c}', '{a}'], ['<a href="?">dir</a>', '<a href="?">file</a>',
		 'Copyright &copy; '.date('Y').'. Allright Reserved. Design By {a}.', 'Sigit Priyanto']);
$mine->_display();