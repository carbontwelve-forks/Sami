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

class PackageClassVisitorTest extends TestCase
{
    public function testMutatesNamespaceWithPackage()
    {
        $class = $this->getMockBuilder('Sami\Reflection\ClassReflection')
            ->setMethods(array('getTags'))
            ->setConstructorArgs(array('Mock', 1))
            ->getMock();
        $package = array(
            "Hello\\World"
        );
        $class->expects($this->any())
            ->method('getTags')
            ->with($this->equalTo('package'))
            ->will($this->returnValue($package));

        $visitor = new PackageClassVisitor(true);
        $visitor->visit($class);

        $this->assertEquals('Hello\\World', $class->getNamespace());
    }

    // @todo test that namespace doens't get overwritten by package tag
}
