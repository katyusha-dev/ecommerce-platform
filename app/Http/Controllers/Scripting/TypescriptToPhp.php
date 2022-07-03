<?php

namespace App\Http\Controllers\Scripting;

use Platform\Tidy\TidyEntity;
use function explode;
use function base_path;
use function str_replace;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypescriptToPhp extends Controller {
    public function index(Request $request) {
        if ($ts = $request->get('ts')) {
            $this->convert($ts);
        }

        return view('scripts/ts-to-php');
    }

    public function convert(string $ts) {
        $writeTo    = base_path('platform/Entities');
        $namespace  = 'Platform\\Entities';
        $properties = [];
        $class      = null;

        foreach (explode("\n", $ts) as $line) {
            if (!Str::contains($line, ':')) {
                if (Str::contains($line, 'class')) {
                    $class = str_replace(['export', 'class', '{', ' '], ['', '', '', ''], $line);

                    if (Str::contains($class, 'extends')) {
                        $class = Str::replace('extends', ' ', $class);
                        $boom  = explode(' ', $class);
                        $class = $boom[0];
                    }

                    $class = trim($class);
                }
                continue;
            }

            $line     = trim($line);
            $boom     = explode(':', $line);
            $property = str_replace(';', '', trim($boom[0]));
            $type     = str_replace(';', '', trim($boom[1]));

            if ($type === 'boolean') {
                $type = 'bool';
            }

            if ($type === 'number') {
                $type = 'int';
            }

            if (Str::contains($property, '?')) {
                $property = str_replace('?', '', $property);
                $type     = '?'.$type;
            }

            $properties[$property] = $type;
        }

        $propertiesString = '';
        foreach ($properties as $property => $type) {
            $phpDoc = '';

            if (Str::contains($type, '[]')) {
                $array  = Str::replace('[]', '', $type);
                $doc    = '/** @var '.Str::replace('?', '', $type).' */';
                $phpDoc = "\n".$doc;
                $type   = 'array';
            }

            $propertiesString .= $phpDoc."\npublic ${type} \$${property};";
        }

        $php = <<<EOB
            <?php
            namespace ${namespace};

            use Platform\PlatformEntity;

            class ${class} extends PlatformEntity {
                ${propertiesString};
            }
            EOB;

        $file = $writeTo.'/'.$class.'.php';
        file_put_contents($file, str_replace(';;', ';', $php));
    }
}
