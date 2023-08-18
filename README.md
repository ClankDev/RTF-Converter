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

***Or, install using pip:***
<br>
pip install git+https://github.com/ClankDev/RTF-Converter.git
<br>
<br><br><br>

**Python - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:*
<br>
---------------------------------------------------------------------------------------
<pre><code>from rtf_converter import rtf_to_txt

# Sample RTF text
rtf_text = r"{\rtf1\ansi\ansicpg1252\deff0\deflang1033{\fonttbl{\f0\fswiss\fcharset0 Helvetica;}}{\colortbl ;\red255\green0\blue0;}\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\ql\qnatural\pardirnatural\f0\fs24 \cf0 Hello, World!}"

# Convert RTF to plain text
plain_text = rtf_to_txt(rtf_text)
print(plain_text)  # Output: Hello, World!</pre></code>
---------------------------------------------------------------------------------------

<br><br><br>

**Python - Example Usage #2**
<br><br>
*Convert an RTF File to Plain Text*
<br>
*Read file from the disk, convert its content to plain text using the rtf_to_txt function, and then save the result to a new text file:*
<br>
---------------------------------------------------------------------------------------
<pre><code>from rtf_converter import rtf_to_txt

# Read RTF file
with open('sample.rtf', 'r', encoding='utf-8') as file:
    rtf_content = file.read()

# Convert RTF content to plain text
plain_text = rtf_to_txt(rtf_content)

# Save plain text to a new file
with open('output.txt', 'w', encoding='utf-8') as file:
    file.write(plain_text)

print("RTF has been successfully converted to plain text and saved as output.txt.")</pre></code>
---------------------------------------------------------------------------------------

<br><br><br>

**Python - Handling RTF Conversion Errors**
<br><br>
*In case the RTF content is not formatted correctly, the rtf_to_txt function might raise an exception. Here is how you can handle such errors gracefully:*
<br>
---------------------------------------------------------------------------------------
<pre><code>from rtf_converter import rtf_to_txt

# Sample RTF text (potentially incorrect format)
rtf_text = r"{\rtf1\ansi\Hello, World!}"

# Attempt to convert RTF to plain text
try:
    plain_text = rtf_to_txt(rtf_text)
    print(plain_text)
except Exception as e:
    print("An error occurred during the conversion:", str(e))</pre></code>
---------------------------------------------------------------------------------------

<br><br><br>


**JavaScript - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>function rtfToTxt(rtf) {
    // (The entire JavaScript function implementation)
    ...
}

// Sample RTF text
var rtfText = "{\\rtf1\\ansi\\ansicpg1252\\deff0\\deflang1033{\\fonttbl{\\f0\\fswiss\\fcharset0 Helvetica;}}{\\colortbl ;\\red255\\green0\\blue0;}\\pard\\tx720\\tx1440\\tx2160\\tx2880\\tx3600\\tx4320\\tx5040\\tx5760\\tx6480\\tx7200\\tx7920\\tx8640\\ql\\qnatural\\pardirnatural\\f0\\fs24 \\cf0 Hello, World!}";

// Convert RTF to plain text
var plainText = rtfToTxt(rtfText);
console.log(plainText);  // Output: Hello, World!</pre></code>
---------------------------------------------------------------------------------------

<br><br><br>

**JavaScript - Example Usage #2 (With error handling)**
<br><br>
*Convert an RTF File to Plain Text* 
<br>
*Read file from the disk (or fetch from a server), convert its content to plain text using the rtfToTxt function, and then save the result to a new text file:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>function rtfToTxt(rtf) {
    // (The entire JavaScript function implementation)
    ...
}

// Fetch RTF content from a file (for example purposes, let's say from a server)
fetch('sample.rtf')
    .then(response => response.text())
    .then(rtfContent => {
        // Convert RTF content to plain text
        var plainText = rtfToTxt(rtfContent);

        // Save plain text to a new file
        // This part can vary based on where and how you want to save the file
        var blob = new Blob([plainText], { type: 'text/plain' });
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'output.txt';
        link.click();

        console.log("RTF has been successfully converted to plain text and saved as output.txt.");
    })
    .catch(error => {
        console.log("An error occurred during the conversion:", error);
    });</pre></code>
---------------------------------------------------------------------------------------

<br><br><br>


**PHP - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>&lt;?php
function rtfToTxt($rtf) {
    // (The entire PHP function implementation)
    ...
}

// Sample RTF text
$rtfText = "{\\rtf1\\ansi\\ansicpg1252\\deff0\\deflang1033{\\fonttbl{\\f0\\fswiss\\fcharset0 Helvetica;}}{\\colortbl ;\\red255\\green0\\blue0;}\\pard\\tx720\\tx1440\\tx2160\\tx2880\\tx3600\\tx4320\\tx5040\\tx5760\\tx6480\\tx7200\\tx7920\\tx8640\\ql\\qnatural\\pardirnatural\\f0\\fs24 \\cf0 Hello, World!}";

// Convert RTF to plain text
$plainText = rtfToTxt($rtfText);
echo $plainText;  // Output: Hello, World!
?&gt;</code></pre>
---------------------------------------------------------------------------------------

<br><br><br>

**PHP - Example Usage #2**
<br><br>
*Convert an RTF File to Plain Text* 
<br>
*Read file from the disk, convert its content to plain text using the rtfToTxt function, and then save the result to a new text file:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>&lt;?php
function rtfToTxt($rtf) {
    // (The entire PHP function implementation)
    ...
}

// Read RTF file
$rtfContent = file_get_contents('sample.rtf');

// Convert RTF content to plain text
$plainText = rtfToTxt($rtfContent);

// Save plain text to a new file
file_put_contents('output.txt', $plainText);

echo "RTF has been successfully converted to plain text and saved as output.txt.";
?&gt;</code></pre>
---------------------------------------------------------------------------------------

<br><br><br>

**PHP - Handling RTF Conversion Errors** 
<br><br>
*In case the RTF content is not formatted correctly, the rtfToTxt function might raise an exception. Here is how you can handle such errors gracefully:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>&lt;?php
function rtfToTxt($rtf) {
    // (The entire PHP function implementation)
    ...
}

// Sample RTF text (potentially incorrect format)
$rtfText = "{\\rtf1\\ansi\\Hello, World!}";

// Attempt to convert RTF to plain text
try {
    $plainText = rtfToTxt($rtfText);
    echo $plainText;
} catch (Exception $e) {
    echo "An error occurred during the conversion: " . $e->getMessage();
}
?&gt;</code></pre>
---------------------------------------------------------------------------------------

<br><br><br>

**C++ - Example Usage**
<br><br>
*Convert a simple RTF string to plain text:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>#include &lt;iostream&gt;
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
</code></pre>
---------------------------------------------------------------------------------------

<br><br><br>

**C++ - Example Usage #2**
<br><br>
*Convert an RTF File to Plain Text* 
<br>
*Read file from the disk, convert its content to plain text using the rtf_to_txt function, and then save the result to a new text file:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>#include &lt;iostream&gt;
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
</code></pre>
---------------------------------------------------------------------------------------

<br><br><br>

**C++ - Handling RTF Conversion Errors** 
<br><br>
*In case the RTF content is not formatted correctly, the rtf_to_txt function might throw an exception. Here is how you can handle such errors gracefully:* 
<br>
---------------------------------------------------------------------------------------
<pre><code>#include &lt;iostream&gt;
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
</code></pre>
---------------------------------------------------------------------------------------

<br><br><br>


**Contributing**
<br>
Contributions, issues, and feature requests are welcome!

<br><br>
**License**
<br>
This project is licensed under the MIT License - see the LICENSE file for details.
