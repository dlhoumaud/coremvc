<?php
/**
 * @ Author: david Lhoumaud
 * @ Create Time: 2025-03-12 16:39:36
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-12 18:13:33
 * @ Description:
 */

namespace Tests;

use App\Core\TestCase;

class ExampleTest extends TestCase
{
    public function testAssertEquals()
    {
        self::assertEquals('John', 'John');
    }

    public function testAssertNotEquals()
    {
        self::assertNotEquals('John', 'Jane');
    }

    public function testAssertTrue()
    {
        self::assertTrue(true);
    }
    public function testAssertFalse()
    {
        self::assertFalse(false);
    }
    public function testAssertNull()
    {
        self::assertNull(null);
    }
    public function testAssertNotNull()
    {
        self::assertNotNull('John');
    }

    // Ajoute d'autres méthodes de test selon les besoins
}
