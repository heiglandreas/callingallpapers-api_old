<?php
/**
 * Copyright (c) 2016-2016} Andreas Heigl<andreas@heigl.org>
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright 2016-2016 Andreas Heigl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     16.01.2016
 * @link      http://github.com/heiglandreas/callingallpapers
 */

namespace Callingallpapers\Api\Entity;

class CfpListMapper
{
    public function map(CfpList $list)
    {
        $cfps = [];

        /** @var Cfp $cfp */
        foreach ($list as $cfp) {
            $item = [
                'name'           => $cfp->getName(),
                'uri'            => $cfp->getUri(),
                'dateCfpStart'   => $cfp->getDateCfpStart()->format('c'),
                'dateCfpEnd'     => $cfp->getDateCfpEnd()->format('c'),
                'location'       => $cfp->getLocation(),
                'latitude'       => $cfp->getLatitude(),
                'longitude'      => $cfp->getLongitude(),
                'description'    => $cfp->getDescription(),
                'dateEventStart' => $cfp->getDateEventStart()->format('c'),
                'dateEventEnd'   => $cfp->getDateEventEnd()->format('c'),
                'iconUri'        => $cfp->getIconUri(),
                'eventUri'       => $cfp->getEventUri(),
                'timezone'       => $cfp->getTimezone()->getName(),
                'tags'           => $cfp->getTags(),
                'lastChange'     => $cfp->getLastUdated()->format('c'),
                '_rel'            => [
                    'cfp_uri'    => 'v1/cfp/' . $cfp->getHash(),
                ]
            ];

            $cfps[] = $item;
        }

        return [
            'cfps' => $cfps,
            'meta' => [
                'count' => $list->count(),
            ]
        ];
    }
}
