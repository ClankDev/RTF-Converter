#include <iostream>
#include <string>
#include <regex>
#include <stack>
#include <unordered_set>
#include <unordered_map>

std::string rtf_to_txt(const std::string& rtf) {
    // Define the regular expression pattern
    std::regex pattern(R"(\\([a-z]{1,32})(-?\d{1,10})?[ ]?|\\'([0-9a-f]{2})|\\([^a-z])|([{}])|[\r\n]+|(.)", std::regex_constants::icase);
    
    // Control words which specify a "destination"
    std::unordered_set<std::string> destinations = {
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
    };
    
    // Translation of some special characters
    std::unordered_map<std::string, std::string> specialchars = {
        {"par", "\n"},
        {"sect", "\n\n"},
        {"page", "\n\n"},
        {"line", "\n"},
        {"tab", "\t"},
        {"emdash", "\u2014"},
        {"endash", "\u2013"},
        {"emspace", "\u2003"},
        {"enspace", "\u2002"},
        {"qmspace", "\u2005"},
        {"bullet", "\u2022"},
        {"lquote", "\u2018"},
        {"rquote", "\u2019"},
        {"ldblquote", "\u201C"},
        {"rdblquote", "\u201D"},
    };
    
    std::stack<std::pair<int, bool>> stack;
    bool ignorable = false;
    int ucskip = 1;
    int curskip = 0;
    std::string out;

    for (std::sregex_iterator i = std::sregex_iterator(rtf.begin(), rtf.end(), pattern); i != std::sregex_iterator(); ++i) {
        std::smatch match = *i;
        std::string word = match[1];
        std::string arg = match[2];
        std::string hex = match[3];
        std::string char_ = match[4];
        std::string brace = match[5];
        std::string tchar = match[6];
        
        if (!brace.empty()) {
            curskip = 0;
            if (brace == "{") {
                stack.push({ucskip, ignorable});
            }
            else if (brace == "}") {
                ucskip = stack.top().first;
                ignorable = stack.top().second;
                stack.pop();
            }
        }
        else if (!char_.empty()) {
            curskip = 0;
            if (char_ == "~" && !ignorable) {
                out.append("\xA0"); // NBSP
            }
            else if (char_ == "{" || char_ == "}" || char_ == "\\") {
                if (!ignorable) {
                    out.append(char_);
                }
            }
            else if (char_ == "*") {
                ignorable = true;
            }
        }
        else if (!word.empty()) {
            curskip = 0;
            if (destinations.find(word) != destinations.end()) {
                ignorable = true;
            }
            else if (ignorable) {
                // Skip this control word and its argument
            }
            else if (specialchars.find(word) != specialchars.end()) {
                out.append(specialchars[word]);
            }
            else if (word == "uc") {
                ucskip = std::stoi(arg);
            }
            else if (word == "u") {
                int c = std::stoi(arg);
                if (c < 0) c += 0x10000;
                if (c > 127) out.append(1, (char)c);
                else out.append(1, (char)c);
                curskip = ucskip;
            }
        }
        else if (!hex.empty()) {
            if (curskip > 0) {
                curskip -= 1;
            }
            else if (!ignorable) {
                int c = std::stoi(hex, nullptr, 16);
                if (c > 127) out.append(1, (char)c);
                else out.append(1, (char)c);
            }
        }
        else if (!tchar.empty()) {
            if (curskip > 0) {
                curskip -= 1;
            }
            else if (!ignorable) {
                out.append(tchar);
            }
        }
    }
    return out;
}

int main() {
    std::string rtf = "{\\rtf1\\ansi\\ansicpg1252\\cocoartf1671\\cocoasubrtf200\n{\\fonttbl\\f0\\fswiss\\fcharset0 Helvetica;}\n{\\colortbl;\\red255\\green255\\blue255;}\n{\\*\\expandedcolortbl;;}\n\\paperw11900\\paperh16840\\margl1440\\margr1440\\vieww10800\\viewh8400\\viewkind0\n\\pard\\tx566\\tx1133\\tx1700\\tx2267\\tx2834\\tx3401\\tx3968\\tx4535\\tx5102\\tx5669\\tx6236\\tx6803\\pardirnatural\\partightenfactor0\n\n\\f0\\fs24 \\cf0 Hello, world!}\n";
    std::cout << rtf_to_txt(rtf) << std::endl;
    return 0;
}
