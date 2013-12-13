<?php

/**
 * PHCurry - An implementatin of Curry similar to what is found in functional programming languages.
 */

/**
 * PHCurry - An implementatin of Curry similar to what is found in functional programming languages.
 * 
 * Currying is a concept from functional programming where you allow you a
 * function that would normally need `n` arguments to be called with fewer 
 * arguments. When you do this it will return a function with you current
 * arguments stored, but waiting for the extra arguments. When all arguments are
 * finally stored/passed the function will be invoked.
 * 
 * An Example:
 *
 * <code>
 * $volumeCalculator = function($w, $h, $l) {
 *   return $w * $h * $l;
 * };
 * $iKnowTheWidth = PHCurry($volumeCalculator, 3);
 * $iKnowTheWidthAndHeight = $iKnowTheWidth(2);
 * echo "The volume is " . $iKnowTheWidthAndHeight(4);
 * 
 * </code>
 *
 * @param Function $func The function to use.
 * @return mixed Result of $func or a function when not enough arguments be supplied.
 */
function PHCurry($func) { 
	$phcurry = function($func) use (&$phcurry) {
		
		$requiredArgumentCount = call_user_func(function($f) {
			$rf = new ReflectionFunction($f);
			return $rf->getNumberOfParameters();
		},$func);
		
		$arguments = func_get_args();
		
		if (sizeof($arguments) > $requiredArgumentCount) {
			return call_user_func_array($func, array_slice($arguments, 1));
		}
		
		return function() use (&$phcurry, &$func, $arguments) {
			$combinedArguments = array_merge($arguments, func_get_args());
			return call_user_func_array($phcurry, $combinedArguments);
		};
		
	};
	
	return call_user_func_array($phcurry, func_get_args());
};
