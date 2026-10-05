<?php

use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

if (! function_exists('pr')) {
    /**
     * Log a readable value to laravel.log with its runtime type and call site, then return it unchanged.
     *
     * @template T
     *
     * @param  T  $value
     * @return T
     */
    function pr(mixed $value, ?string $t = null): mixed {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $title = $t ?? 'Debug value';
        $type = get_debug_type($value);
        $source = ($caller['file'] ?? 'unknown') . ':' . ($caller['line'] ?? '?');

        $dumper = new CliDumper;
        $dumper->setColors(false);
        $output = $dumper->dump((new VarCloner)->cloneVar($value), true);
        $divider = str_repeat('─', 60);

        Log::channel('single')->info(sprintf(
            "\n%s\n[pr] %s\n%s\nType:   %s\nSource: %s\n\nValue:\n%s\n%s",
            $divider,
            $title,
            $divider,
            $type,
            $source,
            '    ' . str_replace("\n", "\n    ", rtrim($output ?? '', "\r\n")),
            $divider,
        ));

        return $value;
    }
}

if (! function_exists('prd')) {
    /**
     * Dump a readable value to the console with its runtime type and call site, then return it unchanged.
     *
     * @template T
     *
     * @param  T  $value
     * @return T
     */
    function prd(mixed $value, ?string $t = null): mixed {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];

        (new CliDumper)->dump((new VarCloner)->cloneVar([
            'Label' => $t ?? 'Debug value',
            'Type' => get_debug_type($value),
            'Source' => ($caller['file'] ?? 'unknown') . ':' . ($caller['line'] ?? '?'),
            'Value' => $value,
        ]));

        return $value;
    }
}
