<?php

namespace App\Adapters;

/**
 * Convert route syntax from Viewi to CodeIgniter
 */
class RouteSyntaxConverter
{
    /**
     * Viewi routes: /, *, {userId}, {userId}, {name?}, {query<[A-Za-z]+>?}
     * Replaces route params `{name}` with placeholders:
     *      {name} {name?} -> (:segment)
     *      * -> (:any)
     *
     * @phpstan-return array{0: string, 1: list<string>} [route, param_names]
     */
    public function convert(string $url): array
    {
        $ciUrl      = '';
        $paramNames = [];

        $parts = explode(
            '/',
            str_replace('*', '(:any)', trim($url, '/'))
        );

        foreach ($parts as $segment) {
            if ($segment !== '' && $segment[0] === '{') {
                $strLen    = strlen($segment) - 1;
                $regOffset = -2;
                $regex     = null;

                if ($segment[$strLen - 1] === '?') { // {optional?}
                    $strLen--;
                    $regOffset = -3;
                }

                if ($segment[$strLen - 1] === '>') { // {<regex>}
                    $strLen--;
                    $regParts = explode('<', $segment);
                    $segment  = $regParts[0];
                    // {<regex>} -> ([a-z]+), (\d+)
                    $regex = substr($regParts[1], 0, $regOffset);
                    $regex = '(' . $regex . ')';
                }

                $paramName    = substr($segment, 1, $strLen - 1);
                $paramNames[] = $paramName;
                $segment      = $regex ?? '(:segment)';
            }

            $ciUrl .= '/' . $segment;
        }

        return [$ciUrl, $paramNames];
    }
}
