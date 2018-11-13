@ECHO off

::verify compiler present
IF NOT EXIST ~compiler.jar GOTO missingcompiler

::check needed files exist
IF NOT EXIST ~header.js GOTO missingfile
IF NOT EXIST ~footer.js GOTO missingfile
IF NOT EXIST ~wrapperStart.js GOTO missingfile
IF NOT EXIST ~wrapperEnd.js GOTO missingfile
IF NOT EXIST chartist.min.js GOTO missingfile

::compile all needed files
CALL digibyte_digibyte\~build.bat Y
CALL mctrivia_digiQR\~build.bat Y
CALL mctrivia_xmr\~build.bat Y
CALL iancoleman_bip39\~build.bat Y

::verify files exist
IF NOT EXIST digibyte.min.js GOTO missingfile
IF NOT EXIST xmr.min.js GOTO missingfile
IF NOT EXIST digiQR.min.js GOTO missingfile
IF NOT EXIST bip39.min.js GOTO missingfile

::compile files to 1 file
IF EXIST ~~temp.js DEL ~~temp.js
::                                                                                                     
java -jar ~compiler.jar --js bip39.min.js --js digibyte.min.js --js xmr.min.js --js digiQR.min.js --js chartist.min.js --js_output_file ~~temp.js --compilation_level WHITESPACE_ONLY
IF NOT EXIST ~~temp.js GOTO failed
IF EXIST ..\libraries.min.js DEL ..\libraries.min.js
COPY /b ~header.js + ~~temp.js + ~footer.js ..\libraries.min.js 1>NUL
DEL ~~temp.js
IF NOT EXIST ..\libraries.min.js GOTO failed
DEL digibyte.min.js
DEL xmr.min.js
DEL digiQR.min.js
DEL bip39.min.js
ECHO Success
PAUSE
GOTO endBuild


::Compiler Missing
:missingcompiler
ECHO Failed: Google Closure Compiler missing.
PAUSE
GOTO endBuild

::Show generic error message
:missingfile
ECHO Failed: Needed file was missing
PAUSE
GOTO endBuild

::Expected output file missing
:failed
ECHO Failed: Couldn't create digiQR.min.js
PAUSE

:endBuild