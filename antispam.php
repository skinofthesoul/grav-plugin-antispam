<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class AntispamPlugin
 * @package Grav\Plugin
 */
class AntispamPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
            'onOutputGenerated' => ['onOutputGenerated', 0]
        ]);
    }

    public function onOutputGenerated()
    {
        $content = $this->grav->output;

        // find plain text email addresses and replace them with munge() results
        $content = preg_replace_callback('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', array(get_class($this), 'munge'), $content);

        $this->grav->output = $content;
    }

    // taken from http://www.celticproductions.net/articles/10/email/php-email-obfuscator.html
    // with minor changes (while instead of for)
    // (preg_replace_callback returns an array)
    function munge($array)
    {
      $address = strtolower($array[0]);
      $coded = "";
      $unmixedkey = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@";
      $inprogresskey = $unmixedkey;
      $mixedkey = "";
      $unshuffled = strlen($unmixedkey);
      while ($unshuffled > 0)
      {
          $ranpos = mt_rand(0, $unshuffled-1);
          $nextchar = $inprogresskey{$ranpos};
          $mixedkey .= $nextchar;
          $before = substr($inprogresskey,0,$ranpos);
          $after = substr($inprogresskey,$ranpos+1,$unshuffled-($ranpos+1));
          $inprogresskey = $before.''.$after;
          $unshuffled -= 1;
      }
      $cipher = $mixedkey;

      $shift = strlen($address);

      $txt = "<script type=\"text/javascript\" language=\"javascript\">\n" .
      "<!-"."-\n" .
      "// Email obfuscator script 2.1 by Tim Williams, University of Arizona\n".
      "// Random encryption key feature by Andrew Moulden, Site Engineering Ltd\n".
      "// PHP version coded by Ross Killen, Celtic Productions Ltd\n".
      "// This code is freeware provided these six comment lines remain intact\n".
      "// A wizard to generate this code is at http://www.jottings.com/obfuscator/\n".
      "// The PHP code may be obtained from http://www.celticproductions.net/\n\n";

      for ($j=0; $j<strlen($address); $j++)
      {
          if (strpos($cipher,$address{$j}) == -1 )
          {
              $chr = $address{$j};
              $coded .= $address{$j};
          }
          else
          {
              $chr = (strpos($cipher,$address{$j}) + $shift) % strlen($cipher);
              $coded .= $cipher{$chr};
          }
      }


      $txt .= "\ncoded = \"" . $coded . "\"\n" .
      " key = \"".$cipher."\"\n".
      " shift=coded.length\n".
      " link=\"\"\n".
      " for (i=0; i<coded.length; i++) {\n" .
      " if (key.indexOf(coded.charAt(i))==-1) {\n" .
      " ltr = coded.charAt(i)\n" .
      " link += (ltr)\n" .
      " }\n" .
      " else { \n".
      " ltr = (key.indexOf(coded.charAt(i))-
      shift+key.length) % key.length\n".
      " link += (key.charAt(ltr))\n".
      " }\n".
      " }\n".
      "document.write(\"<a href='mailto:\"+link+\"'>\"+link+\"</a>\")\n" .
      "\n".
      "//-"."->\n" .
      "<" . "/script><noscript>N/A" .
      "<"."/noscript>";
      return $txt;
    }
}
