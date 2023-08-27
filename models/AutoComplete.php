<?php

namespace app\models;

use Yii;

// This calculates the similarity between two strings as described in Programming Classics: Implementing the World's Best Algorithms by Oliver (ISBN 0-131-00413-1). Note that this implementation does not use a stack as in Oliver's pseudo code, but recursive calls which may or may not speed up the whole process. Note also that the complexity of this algorithm is O(N**3) where N is the length of the longest string.
class AutoComplete
{
	public $baseString, $set, $output;
	public $returnCount = 7;
	public function __construct($baseString, $set)
	{
		$this->baseString = $baseString;
		$this->set = $set;
	}

	public function calculate()
	{
		$this->output = $this->set;
		// return;
		// foreach ($this->set as $key => $value) {
		// 	$r = similar_text($this->baseString, $value, $p);
		// 	$this->output[] = [
		// 		'string'=>$value,
		// 		'result'=>$r,
		// 		'similarity'=>$p
		// 	];
		// }

		// usort($this->output, function($a, $b) {
		//     return $a['similarity'] - $b['similarity'];
		// });

		// $this->output = array_reverse($this->output);
		// $this->output = array_slice($this->output, 0, $this->returnCount, true);
	}

}