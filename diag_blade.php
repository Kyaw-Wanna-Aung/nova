<?php
$projectRoot = "/home/userkyaw_wanna/projects/nova";
require $projectRoot . "/vendor/autoload.php";
$app = require_once $projectRoot . "/bootstrap/app.php";
$app->make("Illuminate\\Contracts\\Console\\Kernel")->bootstrap();
$content = file_get_contents($projectRoot . "/resources/views/user/our-routes.blade.php");
try {
    $compiled = Illuminate\Support\Facades\Blade::compileString($content);
    $tmp = tempnam(sys_get_temp_dir(), "blade_");
    file_put_contents($tmp, "<?php \n" . $compiled);
    exec("php -l " . escapeshellarg($tmp), $lintOut, $lintCode);
    echo "=== LINT RESULT ===\n";
    echo implode("\n", $lintOut) . "\n(exit $lintCode)\n\n";
    echo "=== COMPILED: LINES CONTAINING foreach/endforeach/forelse/endfor/endif ===\n";
    $lines = explode("\n", $compiled);
    foreach ($lines as $i => $line) {
        $n = $i + 1;
        if (preg_match("/(foreach|endforeach|forelse|endfor|endif|endwhile)/i", $line)) {
            echo "$n: $line\n";
        }
    }
    echo "\n=== COMPILED: FULL DUMP (all lines) ===\n";
    foreach ($lines as $i => $line) {
        $n = $i + 1;
        echo "$n: $line\n";
    }
    unlink($tmp);
} catch (Throwable $e) {
    echo "EXCEPTION: " . get_class($e) . "\n" . $e->getMessage() . "\nLine: " . $e->getLine() . "\n";
}