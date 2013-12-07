<?php

require 'phcurry.php';

class PHCurryTest extends PHPUnit_Framework_TestCase
{
    public function testWillExecuteImmediatelyWithAllArguments()
    {
    	$this->assertEquals(
    		phcurry(
    			function($a, $b, $c) {
		    		return $a * $b * $c;
    			},
    			1, 2, 3
    		),
    		6
    	);
    }
    
    public function testWillWaitForAllArguments()
    {
    	$volumeCalculator = function($w, $h, $l) {
			return $w * $h * $l;
		};
		$iKnowTheWidth = phcurry($volumeCalculator, 3);
		$iKnowTheWidthAndHeight = $iKnowTheWidth(2);
    	$this->assertEquals(
    		$iKnowTheWidthAndHeight(4),
    		24
    	);
    }
    
    public function testExecuteNoArgumentVersionStraightAway()
    {
    	$returnOne = function() {
			return 1;
		};
    	$this->assertEquals(
    		phcurry($returnOne),
    		1
    	);
    }
    
    public function testCanSeeExtraArgs()
    {
    	$seeExtraArgs = function() {
			$args = func_get_args();
			$r = 0;
			for ($i=0; $i<sizeof($args); $i++) {
				$r = $r + $args[$i];
			}
			return $r;
		};
    	$this->assertEquals(
    		phcurry($seeExtraArgs, 1, 2, 3),
    		6
    	);
    }
    
}
?>
