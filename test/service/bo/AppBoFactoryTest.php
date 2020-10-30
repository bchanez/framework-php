<?php

use PHPUnit\Framework\TestCase;

class AppBoFactoryTest extends TestCase
{
  /** @before */
  public function setUp(): void
  {
    parent::setUp();
    App_BoFactory::setFactory(null);
  }

  /**
   * @test
   * @covers App_BoFactory
   */
  public function factoryTest(): void
  {
    $factory = App_BoFactory::getFactory();
    $this->assertNotNull($factory);
    $this->assertInstanceOf(App_BoFactory::class, $factory);

    $appBoFactoryMock = $this->createPartialMock(App_BoFactory::class, []);
    App_BoFactory::setFactory($appBoFactoryMock);
    $this->assertNotNull(App_BoFactory::getFactory());
    $this->assertSame($appBoFactoryMock, App_BoFactory::getFactory());
  }

  /**
   * @test
   * @covers App_BoFactory
   */
  public function getUserBoTest(): void
  {
    $this->assertInstanceOf(UserBoImpl::class, App_BoFactory::getFactory()->getUserBo());
  }
}
