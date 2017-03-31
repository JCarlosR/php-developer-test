<?php

	class CompleteRange
	{
		
		static function build($list)
		{
			$size = count($list);
			if ($size == 0)
				return [];

			$start = $list[0];
			$end = $list[$size-1];
			return range($start, $end);
		}
		
	}

	$result = CompleteRange::build([1,2,4,5]);
	var_dump($result);
	
	$result = CompleteRange::build([2,4,9]);
	var_dump($result);

	$result = CompleteRange::build([55,58,60]);
	var_dump($result);
