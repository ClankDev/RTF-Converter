<p align="center">
    Python, Javascript, PHP and C-Sharp RTF-Converter<br>
    RTF-Converter is a function that allows users to convert Rich Text Format (RTF) files into plain text using regular expressions.
<br><br>
  <img width="75%" src="/sample-rtf.PNG">
</p>   
<br><br><br>
<br><br>
Features:
<br><br>
Lightweight
<br>
Fast and efficient
<br>
Pure code, no external dependencies
<br>
<br><br><br>

**Installation**
<br><br>
***Clone the repository:***
<br>
git clone https://github.com/ClankDev/RTF-Converter.git
<br>
cd RTF-Converter

***Install using pip:***
<br>
pip install rtf-converter

***Install using npm:***
<br>
npm i rtf-converter

***Install using composer:***
<br>
composer require clank-ai/rtf-converter
<br>
<br><br><br>

**Python - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:*
<br>
---------------------------------------------------------------------------------------
```
from rtf_converter import rtf_to_txt

# Sample RTF text
rtf_text = r"{\rtf1\ansi\ansicpg1252\deff0\deflang1033{\fonttbl{\f0\fswiss\fcharset0 Helvetica;}}{\colortbl ;\red255\green0\blue0;}\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\ql\qnatural\pardirnatural\f0\fs24 \cf0 Hello, World!}"

# Convert RTF to plain text
plain_text = rtf_to_txt(rtf_text)
print(plain_text)  # Output: Hello, World!
````
---------------------------------------------------------------------------------------

<br><br><br>

**Python - Example Usage #2**
<br><br>
*Convert an RTF File to Plain Text*
<br>
*Read file from the disk, convert its content to plain text using the rtf_to_txt function, and then save the result to a new text file:*
<br>
---------------------------------------------------------------------------------------
```
from rtf_converter import rtf_to_txt

# Read RTF file
with open('sample.rtf', 'r', encoding='utf-8') as file:
    rtf_content = file.read()

# Convert RTF content to plain text
plain_text = rtf_to_txt(rtf_content)

# Save plain text to a new file
with open('output.txt', 'w', encoding='utf-8') as file:
    file.write(plain_text)

print("RTF has been successfully converted to plain text and saved as output.txt.")
```
---------------------------------------------------------------------------------------

<br><br><br>

**Python - Handling RTF Conversion Errors**
<br><br>
*In case the RTF content is not formatted correctly, the rtf_to_txt function might raise an exception. Here is how you can handle such errors gracefully:*
<br>
---------------------------------------------------------------------------------------
```
from rtf_converter import rtf_to_txt

# Sample RTF text (potentially incorrect format)
rtf_text = r"{\rtf1\ansi\Hello, World!}"

# Attempt to convert RTF to plain text
try:
    plain_text = rtf_to_txt(rtf_text)
    print(plain_text)
except Exception as e:
    print("An error occurred during the conversion:", str(e))
```
---------------------------------------------------------------------------------------

<br><br><br>


**JavaScript - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:* 
<br>
---------------------------------------------------------------------------------------
```
// Import the rtfToTxt function from the rtf-converter npm package
import { rtfToTxt } from './node_modules/rtf-converter/rtf_converter.js';
    
// Sample RTF text
var rtfText = "{\\rtf1\\ansi\\ansicpg1252\\deff0\\deflang1033{\\fonttbl{\\f0\\fswiss\\fcharset0 Helvetica;}}{\\colortbl ;\\red255\\green0\\blue0;}\\pard\\tx720\\tx1440\\tx2160\\tx2880\\tx3600\\tx4320\\tx5040\\tx5760\\tx6480\\tx7200\\tx7920\\tx8640\\ql\\qnatural\\pardirnatural\\f0\\fs24 \\cf0 Hello, World!}";

// Convert RTF to plain text
var plainText = rtfToTxt(rtfText);
console.log(plainText);  // Output: Hello, World!
```
---------------------------------------------------------------------------------------

<br><br><br>

**JavaScript - Example Usage #2 (With error handling)**
<br><br>
*Convert an RTF File to Plain Text* 
<br>
*Read file from the disk (or fetch from a server), convert its content to plain text using the rtfToTxt function, and then save the result to a new text file:* 
<br>
---------------------------------------------------------------------------------------
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTF Converter</title>

</head>
<body>
    <h1>RTF Converter</h1>
    <input type="file" id="rtfFile" accept=".rtf" />
    <button onclick="convertRTF()">Convert RTF to Text</button>
    <script type="module">
    // Import the rtfToTxt function from the rtf-converter package
    import { rtfToTxt } from './node_modules/rtf-converter/rtf_converter.js';

    // Function to handle the conversion process
    function convertRTF() {
        var fileInput = document.getElementById('rtfFile');
        var file = fileInput.files[0];
        if (!file) {
        alert('Please select an RTF file to convert.');
        return;
        }

        // Read the RTF content from the uploaded file
        var reader = new FileReader();
        reader.onload = function(event) {
        var rtfContent = event.target.result;

        // Convert RTF content to plain text using the rtfToTxt function
        var plainText = rtfToTxt(rtfContent);

        // Save plain text to a new file
        var blob = new Blob([plainText], { type: 'text/plain' });
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'output.txt';
        link.click();

        console.log("RTF has been successfully converted to plain text and saved as output.txt.");
        };
        reader.readAsText(file);
    }

    // Make the convertRTF function globally accessible so that it can be called from the HTML file
    window.convertRTF = convertRTF;
    </script>
</body>
</html>
```
---------------------------------------------------------------------------------------

<br><br><br>


**PHP - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:* 
<br>
---------------------------------------------------------------------------------------
```
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use RtfConverter\RtfConverter;

$rtfText = "{\\rtf1\\ansi\\ansicpg1252\\deff0\\deflang1033
    {\\fonttbl{\\f0\\fswiss\\fcharset0 Helvetica;}{\\f1\\fswiss\\fcharset0 Arial;}}
    {\\colortbl ;\\red255\\green0\\blue0;\\red0\\green0\\blue255;}
    Hello, {\\f1\\b World}! This is {\\i italic} text. The — dash and the – dash are different.
    ‘ Quotes ’ are special too. Unicode: \\u8364 is the Euro symbol.
    Nested {\\b\\i bold and italic} text. Here's a list:
    \\list\\listtemplateid1\\listhybrid
    {\\listlevel\\levelnfc0\\leveljc0\\levelfollow0\\levelstartat1\\levelspace0\\levelindent0
    {\\*\\levelmarker\\fi-360\\li720\\jclisttab\\tx720 }{\\leveltext\\leveltemplateid1'\\uc0\\u8226 ;}
    {\\levelnumbers\\leveltemplateid2'\\u-3999 \\u8197 ;}}Hello from nested list!
    }";
    


echo "Before conversion\n";
$plainText = RtfConverter::rtfToTxt($rtfText);
echo "After conversion:\n";
echo $plainText . "\n";
echo "Type of output: " . gettype($plainText) . "\n";
echo "Length of output: " . strlen($plainText) . "\n";
?>
```
---------------------------------------------------------------------------------------

<br><br><br>

**PHP - Example Usage #2**
<br><br>
*Convert an RTF File to Plain Text* 
<br>
*Read file from the disk, convert its content to plain text using the rtfToTxt function, and then save the result to a new text file:* 
<br>
---------------------------------------------------------------------------------------
```
<?php
// Include the RtfConverter class
require_once 'vendor/autoload.php';

use RtfConverter\RtfConverter;

// Read RTF file
$rtfContent = file_get_contents('sample.rtf');

// Convert RTF content to plain text
$plainText = RtfConverter::rtfToTxt($rtfContent);

// Save plain text to a new file
file_put_contents('output.txt', $plainText);

echo "RTF has been successfully converted to plain text and saved as output.txt.";
?>
```
---------------------------------------------------------------------------------------

<br><br><br>

**PHP - Handling RTF Conversion Errors** 
<br><br>
*In case the RTF content is not formatted correctly, the rtfToTxt function might raise an exception. Here is how you can handle such errors gracefully:* 
<br>
---------------------------------------------------------------------------------------
```
<?php
// Include the RtfConverter class
require_once 'vendor/autoload.php';

use RtfConverter\RtfConverter;

// Sample RTF text (potentially incorrect format)
$rtfText = "{\\rtf1\\ansi\\Hello, World!}";

try {
    // Attempt to convert RTF to plain text
    $plainText = RtfConverter::rtfToTxt($rtfText);
    echo $plainText;
} catch (Exception $e) {
    echo "An error occurred during the conversion: " . $e->getMessage();
}
?>
```
---------------------------------------------------------------------------------------

<br><br><br>

**C++ - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:* 
<br>
---------------------------------------------------------------------------------------
```
#include &lt;iostream&gt;
#include &lt;string&gt;
#include "rtf_converter.cpp" // Assume this header contains the declaration of rtf_to_txt function

int main() {
    // Sample RTF text
    std::string rtfText = "{\\rtf1\\ansi\\ansicpg1252\\deff0\\deflang1033{\\fonttbl{\\f0\\fswiss\\fcharset0 Helvetica;}}{\\colortbl ;\\red255\\green0\\blue0;}\\pard\\tx720\\tx1440\\tx2160\\tx2880\\tx3600\\tx4320\\tx5040\\tx5760\\tx6480\\tx7200\\tx7920\\tx8640\\ql\\qnatural\\pardirnatural\\f0\\fs24 \\cf0 Hello, World!}";

    // Convert RTF to plain text
    std::string plainText = rtf_to_txt(rtfText);
    
    std::cout &lt;&lt; plainText;  // Output: Hello, World!
    
    return 0;
}
```
---------------------------------------------------------------------------------------

<br><br><br>

**C++ - Example Usage #2**
<br><br>
*Convert an RTF File to Plain Text* 
<br>
*Read file from the disk, convert its content to plain text using the rtf_to_txt function, and then save the result to a new text file:* 
<br>
---------------------------------------------------------------------------------------
```
#include &lt;iostream&gt;
#include &lt;fstream&gt;
#include &lt;string&gt;
#include "rtf_converter.cpp" // Assume this header contains the declaration of rtf_to_txt function

int main() {
    // Read RTF file
    std::ifstream rtfFile("sample.rtf");
    std::string rtfContent((std::istreambuf_iterator&lt;char&gt;(rtfFile)), std::istreambuf_iterator&lt;char&gt;());
    
    // Convert RTF content to plain text
    std::string plainText = rtf_to_txt(rtfContent);
    
    // Save plain text to a new file
    std::ofstream outFile("output.txt");
    outFile &lt;&lt; plainText;
    
    std::cout &lt;&lt; "RTF has been successfully converted to plain text and saved as output.txt." &lt;&lt; std::endl;

    return 0;
}
```
---------------------------------------------------------------------------------------

<br><br><br>

**C++ - Handling RTF Conversion Errors** 
<br><br>
*In case the RTF content is not formatted correctly, the rtf_to_txt function might throw an exception. Here is how you can handle such errors gracefully:* 
<br>
---------------------------------------------------------------------------------------
```
#include &lt;iostream&gt;
#include &lt;string&gt;
#include &lt;exception&gt;
#include "rtf_converter.cpp" // Assume this header contains the declaration of rtf_to_txt function

int main() {
    // Sample RTF text (potentially incorrect format)
    std::string rtfText = "{\\rtf1\\ansi\\Hello, World!}";

    // Attempt to convert RTF to plain text
    try {
        std::string plainText = rtf_to_txt(rtfText);
        std::cout &lt;&lt; plainText;
    } catch (const std::exception&amp; e) {
        std::cout &lt;&lt; "An error occurred during the conversion: " &lt;&lt; e.what() &lt;&lt; std::endl;
    }
    
    return 0;
}
```
---------------------------------------------------------------------------------------

<br><br><br>


**Contributing**
<br>
Contributions, issues, and feature requests are welcome!

<br><br>
**License**
<br>
This project is licensed under the MIT License - see the LICENSE file for details.
