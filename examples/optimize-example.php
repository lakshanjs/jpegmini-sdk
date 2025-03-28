<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LakshanJS\Jpegmini\JpegminiSDK;

try {
    $jpegmini = new JpegminiSDK('/usr/local/bin/jpegmini');

    $result = $jpegmini->optimize('/path/to/input.jpg', [
        'output' => '/path/to/output.jpg',
        'resize' => '60',
        'quality_mode' => 1,
        'remove_metadata' => true,
        'skip_high_compression' => false,
        'logfile' => '/tmp/jpegmini.log',
        'log_level' => 2
    ]);

    echo "✅ Optimization successful!\n";
    echo "Command: " . $result['command'] . "\n";
    echo "Output:\n" . implode("\n", $result['output']) . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

