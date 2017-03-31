<?php
	// Estado CERO: Esperamos un ( -> UNO
	// Estado UNO: Esperamos un ) -> CERO y considerar "()"

	class ClearPar
	{
		private $state;

		static function build($input)
		{
			$state = 0;
			$output = '';

			for ($i=0; $i<strlen($input); ++$i) {
				if ($state == 0 && $input[$i]=='(') {
					$state = 1;
				} else if ($state == 1 && $input[$i]==')') {
					$output .= '()';
					$state = 0;
				}
			}

			return $output;
		}
	}

	echo ClearPar::build("()())()"); // salida : "()()()"

	echo '<br>';

	echo ClearPar::build("()(()"); // salida : "()()"

	echo '<br>';

	echo ClearPar::build(")("); // salida : ""

	echo '<br>';

	echo ClearPar::build("((()"); // salida : "()"
