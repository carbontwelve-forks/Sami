<?php

/*
 * This file is part of the Sami library.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sami\Tests\Parser\ClassVisitor;

use PHPUnit\Framework\TestCase;
use Sami\Parser\ClassVisitor\PackageClassVisitor;
use Sami\Reflection\ClassReflection;

class PackageClassVisitorTest extends TestCase
{
    public function testMutatesNamespaceWithPackage()
    {
        /** @var ClassReflection $class */
        $class = $this->getMockBuilder('Sami\Reflection\ClassReflection')
            ->setMethods(['getTags', 'getPackage'])
            ->setConstructorArgs(['Mock', 1])
            ->getMock();

        $class->expects($this->any())
            ->method('getPackage')
            ->will($this->returnValue("Hello\\World"));


        $visitor = new PackageClassVisitor(true);
        $this->assertTrue($visitor->visit($class));
        $this->assertEquals('Hello\\World', $class->getPackage());
    }
}
