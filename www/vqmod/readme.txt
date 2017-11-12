----------------------------------------
vQmod� - Virtual File Modification System
----------------------------------------

ABOUT:
=========
 * @author Qphoria <qphoria@gmail.com> & JayGilford <jay@jaygilford.com>
 * @copyright (c) 2010-2011
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @site: http://code.google.com/p/vqmod

"vQmod"(TM) (aka Virtual Quick Mod) is a new innovation in php modification override methods.
Instead of modifying actual files to add custom modifications, source files are parsed "on-the-fly" before the php include() or require() is called.
The source is cloned to a temp file and modifications are made to that temp file, then substituted for the real file in the include path.

=====================================
See website for additional information, usage, and syntax:
http://code.google.com/p/vqmod
=====================================