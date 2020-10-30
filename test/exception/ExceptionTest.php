<?php

use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
  /**
   * @test
   * @covers BDDException
  */
  public function BDDExceptionTest()
  {
    $this->expectException(BDDException::class);
    throw new BDDException('test', 42);
  }
}
