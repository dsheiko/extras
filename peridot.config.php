<?php
use Evenement\EventEmitterInterface;
use Peridot\Reporter\CodeCoverage\CodeCoverageReporter;
use Peridot\Reporter\CodeCoverageReporters;

require_once __DIR__ . "/tests/bootstrap.php";

return function (EventEmitterInterface $emitter) {
    $coverage = new CodeCoverageReporters($emitter);
    $coverage->register();

    $emitter->on('code-coverage.start', function (CodeCoverageReporter $reporter) {
        $reporter->addDirectoryToWhitelist(__DIR__ . '/src');
    });
};