<?php

/*
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\HTMLMin\Minifiers;

use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the blade minifier test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md> Apache 2.0
 */
class BladeMinifierTest extends AbstractTestCase
{
    public function testRenderEnabled()
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render('test    123');

        $this->assertSame('test 123', $return);

        $return = $blade->render('test    <div></div>');

        $this->assertSame('test <div></div>', $return);
    }

    public function tagProvider()
    {
        return [
            ['textarea'],
            ['pre'],
            ['code'],
        ];
    }

    /**
     * @dataProvider tagProvider
     */
    public function testRenderDisabled($tag)
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render("test    <$tag></$tag>");

        $this->assertSame("test    <$tag></$tag>", $return);
    }

    /**
     * @dataProvider tagProvider
     */
    public function testRenderForced($tag)
    {
        $blade = $this->getBladeMinifier(true);

        $return = $blade->render("test    <$tag></$tag>");

        $this->assertSame("test <$tag></$tag>", $return);
    }

    protected function getBladeMinifier($force = false)
    {
        return new BladeMinifier($force);
    }
}
