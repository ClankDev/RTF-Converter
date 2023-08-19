<?php

namespace RtfConverter;

class RtfConverter
{
    public static function rtfToTxt($rtf) {
        $pattern = '/\\\\([a-z]{1,32})(-?\\d{1,10})?[ ]?|\\\'([0-9a-f]{2})|\\\\([^a-z])|([{])|[\r\n]+|(.*?)/i';
            $destinations = array(
                'aftncn','aftnsep','aftnsepc','annotation','atnauthor','atndate','atnicn','atnid',
                'atnparent','atnref','atntime','atrfend','atrfstart','author','background',
                'bkmkend','bkmkstart','blipuid','buptim','category','colorschememapping',
                'colortbl','comment','company','creatim','datafield','datastore','defchp','defpap',
                'do','doccomm','docvar','dptxbxtext','ebcend','ebcstart','factoidname','falt',
                'fchars','ffdeftext','ffentrymcr','ffexitmcr','ffformat','ffhelptext','ffl',
                'ffname','ffstattext','field','file','filetbl','fldinst','fldrslt','fldtype',
                'fname','fontemb','fontfile','fonttbl','footer','footerf','footerl',
                'footerr','footnote','formfield','ftncn','ftnsep','ftnsepc','g','generator',
                'gridtbl','header','headerf','headerl','headerr','hl','hlfr','hlinkbase',
                'hlloc','hlsrc','hsv','htmltag','info','keycode','keywords','latentstyles',
                'lchars','levelnumbers','leveltext','lfolevel','linkval','list','listlevel',
                'listname','listoverride','listoverridetable','listpicture','liststylename',
                'listtable','listtext','lsdlockedexcept','macc','maccPr','mailmerge','maln',
                'malnScr','manager','margPr','mbar','mbarPr','mbaseJc','mbegChr','mborderBox',
                'mborderBoxPr','mbox','mboxPr','mchr','mcount','mctrlPr','md','mdeg','mdegHide',
                'mden','mdiff','mdPr','me','mendChr','meqArr','meqArrPr','mf','mfName','mfPr',
                'mfunc','mfuncPr','mgroupChr','mgroupChrPr','mgrow','mhideBot','mhideLeft',
                'mhideRight','mhideTop','mhtmltag','mlim','mlimloc','mlimlow','mlimlowPr',
                'mlimupp','mlimuppPr','mm','mmaddfieldname','mmath','mmathPict','mmathPr',
                'mmaxdist','mmc','mmcJc','mmconnectstr','mmconnectstrdata','mmcPr','mmcs',
                'mmdatasource','mmheadersource','mmmailsubject','mmodso','mmodsofilter',
                'mmodsofldmpdata','mmodsomappedname','mmodsoname','mmodsorecipdata','mmodsosort',
                'mmodsosrc','mmodsotable','mmodsoudl','mmodsoudldata','mmodsouniquetag',
                'mmPr','mmquery','mmr','mnary','mnaryPr','mnoBreak','mnum','mobjDist','moMath',
                'moMathPara','moMathParaPr','mopEmu','mphant','mphantPr','mplcHide','mpos',
                'mr','mrad','mradPr','mrPr','msepChr','mshow','mshp','msPre','msPrePr','msSub',
                'msSubPr','msSubSup','msSubSupPr','msSup','msSupPr','mstrikeBLTR','mstrikeH',
                'mstrikeTLBR','mstrikeV','msub','msubHide','msup','msupHide','mtransp','mtype',
                'mvertJc','mvfmf','mvfml','mvtof','mvtol','mzeroAsc','mzeroDesc','mzeroWid',
                'nesttableprops','nextfile','nonesttables','objalias','objclass','objdata',
                'object','objname','objsect','objtime','oldcprops','oldpprops','oldsprops',
                'oldtprops','oleclsid','operator','panose','password','passwordhash','pgp',
                'pgptbl','picprop','pict','pn','pnseclvl','pntext','pntxta','pntxtb','printim',
                'private','propname','protend','protstart','protusertbl','pxe','result',
                'revtbl','revtim','rsidtbl','rxe','shp','shpgrp','shpinst',
                'shppict','shprslt','shptxt','sn','sp','staticval','stylesheet','subject','sv',
                'svb','tc','template','themedata','title','txe','ud','upr','userprops',
                'wgrffmtfilter','windowcaption','writereservation','writereservhash','xe','xform',
                'xmlattrname','xmlattrvalue','xmlclose','xmlname','xmlnstbl','xmlopen'
            );
        
        $specialchars = array(
            'par' => "\n",
            'sect' => "\n\n",
            'page' => "\n\n",
            'line' => "\n",
            'tab' => "\t",
            'emdash' => "\u2014",
            'endash' => "\u2013",
            'emspace' => "\u2003",
            'enspace' => "\u2002",
            'qmspace' => "\u2005",
            'bullet' => "\u2022",
            'lquote' => "\u2018",
            'rquote' => "\u2019",
            'ldblquote' => "\u201C",
            'rdblquote' => "\u201D",
        );
        
        $stack = array();
        $ignorable = false;
        $ucskip = 1;
        $curskip = 0;
        $out = array();
        
        if (preg_match_all($pattern, $rtf, $matches)) {
            foreach ($matches[0] as $index => $match) {
                $word = $matches[1][$index];
                $arg = $matches[2][$index];
                $hex = $matches[3][$index];
                $char = $matches[4][$index];
                $brace = $matches[5][$index];
                $tchar = $matches[6][$index];
                
                if ($brace) {
                    $curskip = 0;
                    if ($brace == '{') {
                        $stack[] = array($ucskip, $ignorable);
                    } elseif ($brace == '}') {
                        list($ucskip, $ignorable) = array_pop($stack);
                    }
                } elseif ($char) {
                    $curskip = 0;
                    if ($char == '~' && !$ignorable) {
                        $out[] = "\xA0";
                    } elseif ($char == '{' || $char == '}' || $char == '\\') {
                        if (!$ignorable) {
                            $out[] = $char;
                        }
                    } elseif ($char == '*') {
                        $ignorable = true;
                    }
                } elseif ($word) {
                    $curskip = 0;
                    if (in_array($word, $destinations)) {
                        $ignorable = true;
                    } elseif ($ignorable) {
                        // No action needed
                    } elseif (array_key_exists($word, $specialchars)) {
                        $out[] = $specialchars[$word];
                    } elseif ($word == 'uc') {
                        $ucskip = intval($arg);
                    } elseif ($word == 'u') {
                        $c = intval($arg);
                        $c = ($c < 0) ? $c + 0x10000 : $c;
                        $out[] = $c > 127 ? chr($c) : $c;
                        $curskip = $ucskip;
                    }
                } elseif ($hex) {
                    if ($curskip > 0) {
                        $curskip -= 1;
                    } elseif (!$ignorable) {
                        $c = hexdec($hex);
                        $out[] = $c > 127 ? chr($c) : $c;
                    }
                } elseif ($tchar) {
                    if ($curskip > 0) {
                        $curskip -= 1;
                    } elseif (!$ignorable) {
                        $out[] = $tchar;
                    }
                }
            }
        }
        
        return implode("", $out);
    }
}

// Example Usage
//$rtfText = "{\\rtf1\\ansi\\Hello, World!}";
//$plainText = RtfConverter::rtfToTxt($rtfText);
//echo $plainText;

?>
