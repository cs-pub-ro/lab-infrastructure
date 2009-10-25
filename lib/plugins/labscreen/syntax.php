<?php
/**
 * Wiki Lab Extension: Screen Plugin
 *
 * Syntax:     <screen> ... </screen>
 *
 * Acknowledgements:
 *  Derived from Box plugin (http://www.dokuwiki.org/plugin:box)
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Mircea Bardac <mircea@bardac.net>  
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_labscreen extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    function getInfo(){
      return array(
        'author' => 'Mircea Bardac',
        'email'  => 'mircea@bardac.net',
        'date'   => '2009-09-12',
        'name'   => 'Wiki Lab Extension: Screen Plugin',
        'desc'   => 'Plugin for showing up screen outputs in lab.',
        'url'    => '',
      );
    }

    function getType(){ return 'protected';}
    function getAllowedTypes() {
            return array();
    }
    function getPType(){ return 'block';}

    // must return a number lower than returned by native 'code' mode (200)
    function getSort(){ return 190; } # must be higher than labsolution (195)

    // override default accepts() method to allow nesting 
    // - ie, to get the plugin accepts its own entry syntax
    //function accepts($mode) {
    //    if ($mode == substr(get_class($this), 7)) return true;
    //    return parent::accepts($mode);
    //}

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {       
            $this->Lexer->addEntryPattern('<screen>(?=.*?</screen>)',$mode,'plugin_labscreen');
    }

    function postConnect() {
            $this->Lexer->addExitPattern('</screen>', 'plugin_labscreen');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){

       switch ($state) {
            case DOKU_LEXER_ENTER:
                $data = array();
                return array('labscreen_open',array());
                return false;

            case DOKU_LEXER_MATCHED:
                return array('labscreen_data', $match);

            case DOKU_LEXER_UNMATCHED:                
                 return array('labscreen_data', $match);

            case DOKU_LEXER_EXIT:
                return array('labscreen_close', '');

        }       
        return false;
    }

   // taken from http://php.net/manual/en/function.wordwrap.php
   function utf8_wordwrap($str, $width = 80, $break = "\n") // wordwrap() with utf-8 support
    {
        $str = preg_split('#[\s\n\r]+#', $str);
        $len = 0;
        foreach ($str as $val)
        {
            $val .= ' ';
            $tmp = mb_strlen($val, 'utf-8');
            $len += $tmp;
            if ($len >= $width)
            {
                $return .= $break . $val;
                $len = $tmp;
            }
            else
                $return .= $val;
        }
        return $return;
    }

   function utf8_linewrap($str)
    {
        $str = preg_split('#\n#', $str);
        $r = '';
        foreach ($str as $val)
        {
            $r .= $this->utf8_wordwrap($val)."\n";
        }
        return $r;
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $indata) {

      if (empty($indata)) return false;
      list($instr, $data) = $indata;

      if($mode == 'xhtml'){
          switch ($instr) {

          case 'labscreen_open' :
            $renderer->doc .= '<div class="screen">';
            break;

          case 'labscreen_data' :
	    // convert tabs to spaces
	    $data = str_replace("\t", '    ', $data);
	    // line wrapping at 80 characters
	    //$data = $this->utf8_linewrap($data);
	    // convert HTML entities
	    $data = htmlspecialchars($data, ENT_QUOTES);
	    // convert spaces to non-breakable spaces
	    $data = str_replace(" ", '&nbsp;', $data);
	    // replace new lines with <br />
	    $data = nl2br($data);

	    $renderer->doc .= $data;
	    // $renderer->doc .= $renderer->_xmlEntities($data); // needed when allowing other syntax types
            break;

          case 'labscreen_close' :
            $new_doc = str_replace('<div class="screen"><br />', '<div class="screen">', $renderer->doc);
            $renderer->doc = $new_doc."</div>\n";
            break;
        }

        return true;
      }
      return false;
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :
