<?php
	/**
	* 
	*/
	class ChangeString
	{
		private $alphabet;

		function __construct($alphabet)
		{
			$this->alphabet = $alphabet;
		}

		function build($input)
		{
			for ($i=0; $i<strlen($input); ++$i) {
				$input[$i] = $this->buildCharacter($input[$i]);
			}

			return $input;
		}

		function buildCharacter($c)
		{
			$isUpper = ($c == strtoupper($c));

			$pos = array_search(strtolower($c), $this->alphabet);

			if ($pos === false)
				return $c;

			if ($pos == count($this->alphabet)-1)
				$pos = 0;
			else
				$pos = $pos+1;

			if ($isUpper)
				return strtoupper($this->alphabet[$pos]);
			return $this->alphabet[$pos];
		}
	}

	$changeString = new ChangeString([ 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r',
								's', 't', 'u', 'v', 'w', 'x', 'y', 'z' ]);
	echo $changeString->build("123 abcd*3");
	echo '<br>';
	echo $changeString->build("**Casa 52");
	echo '<br>';
	echo $changeString->build("**Casa 52Z");
