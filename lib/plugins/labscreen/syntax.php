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
            return array('container','substition','protected','disabled','formatting','paragraphs');
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
            $renderer->doc .= $renderer->_xmlEntities($data); 
            break;

          case 'labscreen_close' :
            $renderer->doc .= "</div>\n";
            break;
        }

        return true;
      }
      return false;
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :
