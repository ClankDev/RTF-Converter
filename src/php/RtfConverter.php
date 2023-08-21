<?php
namespace RtfConverter;

class RtfConverter {
    public static function rtfToTxt($rtf) {
        if ($rtf === null) {
            return '';
        }
        
        // Directly remove patterns like 'listtemplateid' before processing
        $rtf = preg_replace('/\\\\listtemplateid[^\s}]+/', '', $rtf);
        
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
                        if ($i + 1 < $len && ctype_alpha($rtf[$i + 1])) {
                            $i++; // Skip the control word
                        }
                        if ($i + 1 < $len && $rtf[$i + 1] == '\'') {
                            // Skip hex code
                            $i += 2; // Skip the \'
                        }
                        continue 2; 
                    }

                    $word = '';
                    $i++;

                    while ($i < $len && (ctype_alpha($rtf[$i]) || ctype_digit($rtf[$i]) || $rtf[$i] === '-')) {
                        $word .= $rtf[$i];
                        $i++;
                    }

                    if ($word === 'colortbl') {
                        $inColorTable = true;
                        while ($i < $len && $rtf[$i] !== ';') {
                            $i++;
                        }
                        $inColorTable = false;
                    } elseif ($word === 'u8364') {  // Directly check for the Euro Unicode character
                        $out .= '€';
                        if ($i < $len && $rtf[$i] == '?') $i++;
                    } elseif ($word[0] === 'u' && is_numeric(substr($word, 1))) {
                        $out .= mb_convert_encoding("&#" . intval(substr($word, 1)) . ";", 'UTF-8', 'HTML-ENTITIES');
                        if ($i < $len && $rtf[$i] == '?') $i++;
                    } elseif (in_array($word, ['b', 'i', 'list', 'listlevel', 'listhybrid'])) {
                        continue 2;
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
