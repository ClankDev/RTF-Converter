function rtfToTxt(rtf) {
    var pattern = /\\([a-z]{1,32})(-?\d{1,10})?[ ]?|\\'([0-9a-f]{2})|\\([^a-z])|([{}])|[\r\n]+|(.)|[\u2022]/gi;
var destinations = new Set([
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
    'xmlattrname','xmlattrvalue','xmlclose','xmlname','xmlnstbl',
    'xmlopen',
]);
    var specialchars = {
        'par': '\n',
        'sect': '\n\n',
        'page': '\n\n',
        'line': '\n',
        'tab': '\t',
        'emdash': '\u2014',
        'endash': '\u2013',
        'emspace': '\u2003',
        'enspace': '\u2002',
        'qmspace': '\u2005',
        'bullet': '\u2022',
        'lquote': '\u2018',
        'rquote': '\u2019',
        'ldblquote': '\u201C',
        'rdblquote': '\u201D',
    };
    var stack = [];
    var ignorable = false;
    var ucskip = 1;
    var curskip = 0;
    var out = [];
    var match, word, arg, hex, char, brace, tchar;
    while ((match = pattern.exec(rtf))) {
        [word, arg, hex, char, brace, tchar] = match.slice(1);
        if (brace) {
            curskip = 0;
            if (brace === '{') {
                // Push state
                stack.push([ucskip, ignorable]);
            }
            else if (brace === '}') {
                // Pop state
                [ucskip, ignorable] = stack.pop();
            }
        }
        else if (char) {
            curskip = 0;
            if (char === '~' && !ignorable) {
                out.push('\xA0'); // NBSP
            }
            else if ('{}\\'.indexOf(char) !== -1 && !ignorable) {
                out.push(char);
            }
            else if (char === '*') {
                ignorable = true;
            }
        }
        else if (word) {
            curskip = 0;
            if (destinations.has(word)) {
                ignorable = true;
            }
            else if (ignorable) {
                // Null
            }
            else if (word in specialchars) {
                out.push(specialchars[word]);
            }
            else if (word === 'uc') {
                ucskip = parseInt(arg);
            }
            else if (word === 'u') {
                var c = parseInt(arg);
                if (c < 0) c += 0x10000;
                if (c > 127) out.push(String.fromCharCode(c));
                else out.push(String.fromCharCode(c));
                curskip = ucskip;
            }
        }
        else if (hex) {
            if (curskip > 0) {
                curskip -= 1;
            }
            else if (!ignorable) {
                var c = parseInt(hex, 16);
                if (c > 127) out.push(String.fromCharCode(c));
                else out.push(String.fromCharCode(c));
            }
        }
        else if (tchar) {
            if (curskip > 0) {
                curskip -= 1;
            }
            else if (!ignorable) {
                out.push(tchar);
            }
        }
    }
    return out.join('');
}

// Example
//var rtfText = "{\\rtf1\\ansi Hello, {\\b World!}}";
//console.log(rtfToTxt(rtfText)); // Output: " Hello, World!"
