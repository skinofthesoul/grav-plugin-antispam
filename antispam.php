<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Grav;
use Grav\Common\Language\Language;
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
        if ($this->config->get('plugins.antispam.change_on_output')) {
          $this->enable([
              'onOutputGenerated' => ['onOutputGenerated', 0]
          ]);
        } else {
          $this->enable([
              'onPageContentProcessed' => ['onPageContentProcessed', 0]
          ]);
        }
    }

    public function onPageContentProcessed(Event $event)
    {
        $page = $event['page'];
        $header = $page->header();

        if (isset($header->antispam) && $header->antispam == false) {
          // don't munge the email form or whatever
        } else {
          $content = $page->content();

          // find mailto links and turn them into plain text email addresses
          // (problem occurs with the flex-directory plugin)
          // also taking care of linked images
          //$r = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
          $r = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
          $content = preg_replace_callback($r, array(get_class($this), 'munge'), $content);

          // find plain text email addresses and replace them with munge() results, excluding responsive images and anything wrapped in a mailto link (or rather, only get matches preceded by whitespace or >)
          $r2 = '/(?<=[\s|\>])([a-zA-Z0-9._%+-]+@(?!(\d)x\.)[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/';
          $content = preg_replace_callback($r2, array(get_class($this), 'munge'), $content);

          $page->setRawContent($content);
        }
    }

    public function onOutputGenerated()
    {
        $header = $this->grav['page']->header();

        if (isset($header->antispam) && $header->antispam == false) {
          // don't munge the email form or whatever
        } else {
          $content = $this->grav->output;

          // find mailto links and turn them into plain text email addresses
          // (problem occurs with the flex-directory plugin)
          // also taking care of linked images
          //$r = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
          $r = '`\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>`ism';
          $content = preg_replace_callback($r, array(get_class($this), 'munge'), $content);

          // find plain text email addresses and replace them with munge() results, excluding responsive images and anything wrapped in a mailto link (or rather, only get matches preceded by whitespace or >)
          $r2 = '/(?<=[\s|\>])([a-zA-Z0-9._%+-]+@(?!(\d)x\.)[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/';
          $content = preg_replace_callback($r2, array(get_class($this), 'munge'), $content);

          $this->grav->output = $content;
        }
    }

    // taken from http://www.celticproductions.net/articles/10/email/php-email-obfuscator.html
    // with minor changes (while instead of for)
    // (preg_replace_callback returns an array)
    private function munge($array, $string = "link")
    {
      if (count($array) < 4) {
        $address = strtolower($array[1]);
      } else {
        $address = strtolower($array[2]);
      }
      $coded = "";
      $unmixedkey = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@-_";
      $inprogresskey = $unmixedkey;
      $mixedkey = "";
      $unshuffled = strlen($unmixedkey);
      while ($unshuffled > 0)
      {
          $ranpos = mt_rand(0, $unshuffled-1);
          $nextchar = $inprogresskey[$ranpos];
          $mixedkey .= $nextchar;
          $before = substr($inprogresskey,0,$ranpos);
          $after = substr($inprogresskey,$ranpos+1,$unshuffled-($ranpos+1));
          $inprogresskey = $before.''.$after;
          $unshuffled -= 1;
      }
      $cipher = $mixedkey;

      $shift = strlen($address);

      $txt = "<script type=\"text/javascript\" language=\"javascript\">\n" .
      "// Email obfuscator script 2.1 by Tim Williams, University of Arizona\n".
      "// Random encryption key feature by Andrew Moulden, Site Engineering Ltd\n".
      "// PHP version coded by Ross Killen, Celtic Productions Ltd\n".
      "// This code is freeware provided these six comment lines remain intact\n".
      "// A wizard to generate this code is at http://www.jottings.com/obfuscator/\n".
      "// The PHP code may be obtained from http://www.celticproductions.net/\n\n";

      for ($j=0; $j<strlen($address); $j++)
      {
          if (strpos($cipher,$address[$j]) == -1 )
          {
              $chr = $address[$j];
              $coded .= $address[$j];
          }
          else
          {
              $chr = (strpos($cipher,$address[$j]) + $shift) % strlen($cipher);
              $coded .= $cipher[$chr];
          }
      }

      if (array_key_exists(4, $array) && (strpos($array[4], '<img') === 0 || $array[4] != $array[2])) {
        $string = "'".$array[4]."'";
      }

      if (array_key_exists(3, $array) && trim($array[3]) != "") {
        $title = "'".$array[3]."'";
        $title = str_replace('"', '\"', $title);
      } else {
        $title = "";
      }

      // check plugin settings
      $config = $this->config();
      $target = "";
      if ($config['target']) {
        $target = " target='_blank'";
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
      "document.write(\"<a href='mailto:\"+link+\"'$target $title>\"+".$string."+\"</a>\")\n" .
      "\n".
      "<" . "/script><noscript>".$this->grav['language']->translate(['PLUGIN_ANTISPAM.NOSCRIPT'])."<"."/noscript>";
      return $txt;
    }
}
