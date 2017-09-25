<?php

namespace Cncal\Getui\Sdk\Protobuf\Type;

use Cncal\Getui\Sdk\Protobuf\PBMessage;
/**
 * @author Nikolai Kordulla
 */
class PBScalar extends PBMessage
{
	/**
	 * Set scalar value
	 */
	public function set_value($value)
	{	
		$this->value = $value;	
	}

	/**
	 * Get the scalar value
	 */
	public function get_value()
	{
		return $this->value;
	}
}
?>
