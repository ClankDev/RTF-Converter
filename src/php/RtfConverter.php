<?php
namespace RtfConverter;

class RtfConverter {
    public static function rtfToTxt($rtf) {
        $out = '';
        $len = strlen($rtf);
        $ignorable = false;
        $inColorTable = false;

        for ($i = 0; $i < $len; $i++) {
            $c = $rtf[$i];
            switch ($c) {
                case '{':
                    if (!$inColorTable) {
                        $ignorable = true;
                    }
                    break;
                case '}':
                    $ignorable = false;
                    break;
                case '\\':
                    if ($ignorable) {
                        // Skip if inside ignored block
                        if ($i + 1 < $len && ctype_alpha($rtf[$i + 1])) {
                            $i++; // Skip the control word
                        }
                        if ($i + 1 < $len && $rtf[$i + 1] == '\'') {
                            // Skip hex code
                            $i += 2; // Skip the \'
                        }
                        continue 2; // Use "continue 2" to skip the current loop iteration
                    }

                    $word = '';
                    $i++;

                    while ($i < $len && ctype_alpha($rtf[$i])) {
                        $word .= $rtf[$i];
                        $i++;
                    }

                    if ($word === 'colortbl') {
                        $inColorTable = true;
                        // Skip color table content until semicolon is encountered
                        while ($i < $len && $rtf[$i] !== ';') {
                            $i++;
                        }
                        $inColorTable = false;
                    } elseif ($word === 'u') {
                        // Handle Unicode character
                        $param = '';
                        while ($i < $len && ctype_digit($rtf[$i])) {
                            $param .= $rtf[$i];
                            $i++;
                        }
                        $out .= mb_convert_encoding("&#" . intval($param) . ";", 'UTF-8', 'HTML-ENTITIES');
                        if ($i < $len && $rtf[$i] == '?') $i++;
                    }
                    break;
                default:
                    if (!$ignorable && !$inColorTable) {
                        $out .= $c;
                    }
                    break;
            }
        }
        return $out;
    }
}

?>
