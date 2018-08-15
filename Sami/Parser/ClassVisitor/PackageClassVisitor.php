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
 * Looks for package tags and sets the class namespace to them.
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

    public function visit(ClassReflection $class): bool
    {
        if (!$this->enabled){
            return false;
        }

        $modified = false;
        $properties = $class->getTags('package');
        if (!empty($properties)) {
            if ($this->injectProperty($class, reset($properties))) {
                $modified = true;
            }
        }

        return $modified;
    }

    /**
     * Mutate the class namespace based upon package tag.
     *
     * @param ClassReflection $class      Class reflection
     * @param string          $packageTag Package tag contents
     *
     * @return bool
     */
    protected function injectProperty(ClassReflection $class, string $packageTag): bool
    {
        if (strlen($packageTag) > 0 && is_null($class->getNamespace())) {
            $class->setNamespace($packageTag);
        }

        return false;
    }
}
