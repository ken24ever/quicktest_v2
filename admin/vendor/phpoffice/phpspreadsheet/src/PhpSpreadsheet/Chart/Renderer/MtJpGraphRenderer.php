<?php

namespace PhpOffice\PhpSpreadsheet\Chart\Renderer;

/**
<<<<<<< HEAD
 * Jpgraph is not officially maintained by Composer at packagist.org.
=======
 * Jpgraph is not oficially maintained in Composer.
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
 *
 * This renderer implementation uses package
 * https://packagist.org/packages/mitoteam/jpgraph
 *
<<<<<<< HEAD
 * This package is up to date for June 2023 and has PHP 8.2 support.
=======
 * This package is up to date for August 2022 and has PHP 8.1 support.
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
 */
class MtJpGraphRenderer extends JpGraphRendererBase
{
    protected static function init(): void
    {
        static $loaded = false;
        if ($loaded) {
            return;
        }

        \mitoteam\jpgraph\MtJpGraph::load([
            'bar',
            'contour',
            'line',
            'pie',
            'pie3d',
            'radar',
            'regstat',
            'scatter',
            'stock',
<<<<<<< HEAD
        ], true); // enable Extended mode
=======
        ]);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

        $loaded = true;
    }
}
