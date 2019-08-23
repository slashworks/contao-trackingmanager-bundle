<?php

/*
 * This file is part of Contao Simple SVG Icons Bundle.
 *
 * (c) slashworks
 *
 * @license LGPL-3.0-or-later
 */

namespace Slashworks\ContaoTrackingManagerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Slashworks\ContaoSimpleSvgIconsBundle\ContaoSimpleSvgIconsBundle;

class ContaoTrackingManagerBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoTrackingManagerBundle();

        $this->assertInstanceOf('Slashworks\ContaoTrackingManagerBundle\ContaoTrackingManagerBundle', $bundle);
    }
}
