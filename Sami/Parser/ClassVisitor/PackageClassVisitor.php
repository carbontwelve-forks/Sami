<?php

/*
 * This file is part of the Sami utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sami\Parser\ClassVisitor;

use Sami\Parser\ClassVisitorInterface;
use Sami\Parser\ParserContext;
use Sami\Reflection\ClassReflection;
use Sami\Reflection\PropertyReflection;

/**
 * Class PackageClassVisitor
 *
 * If enabled this overwrites Namespace with Package name.
 *
 * @package Sami\Parser\ClassVisitor
 */
class PackageClassVisitor implements ClassVisitorInterface
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * PackageClassVisitor constructor.
     * @param bool $enabled
     */
    public function __construct(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Modify the namespace of the ClassReflection to
     * equal the package name only if enabled.
     *
     * @param ClassReflection $class
     * @return bool
     */
    public function visit(ClassReflection $class): bool
    {
        if (!$this->enabled){
            return false;
        }

        $modified = false;

        if (strlen($class->getPackage()) > 0) {
            $class->setNamespace($class->getPackage());
            $modified = true;
        }

        return $modified;
    }
}
