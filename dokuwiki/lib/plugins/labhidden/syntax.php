<?php
/**
 * Wiki Lab Extension: Solution Plugin
 *
 * Syntax:     <hidden> ... </hidden>
 *
 * Acknowledgements:
 *  Derived from Box plugin (http://www.dokuwiki.org/plugin:box)
 *  Based on labsolution by Mircea Bardac.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Vlad Dogaru <ddvlad@rosedu.org>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_labhidden extends DokuWiki_Syntax_Plugin {

    function getInfo(){
      return array(
        'author' => 'Vlad Dogaru',
        'email'  => 'ddvlad@rosedu.org',
        'date'   => '2010-08-26',
        'name'   => 'Wiki Lab Extension: Hidden Plugin',
        'desc'   => 'Plugin for hiding content from all but admins',
        'url'    => '',
      );
    }

    function getType(){ return 'container'; }

    function getAllowedTypes() {
        return array('container','substition','protected','disabled','formatting','paragraphs');
    }
    function getPType(){ return 'block';}

    // must return a number lower than returned by native 'code' mode (200)
    function getSort(){ return 195; }

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
            $this->Lexer->addEntryPattern('<hidden>(?=.*?</hidden>)',$mode,'plugin_labhidden');
    }

    function postConnect() {
            $this->Lexer->addExitPattern('</hidden>', 'plugin_labhidden');
            #$this->Lexer->addPattern('.*?', 'plugin_labsolution');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){

       switch ($state) {
            case DOKU_LEXER_ENTER:
                #$handler->_addCall('nocache',array(),$pos);
                $data = array();
                return array('labhidden_open',array());
                return false;

            case DOKU_LEXER_MATCHED:
                return array('labhidden_data', $match);

            case DOKU_LEXER_UNMATCHED:
                 return array('labhidden_data', $match);
                 #$handler->_addCall('cdata',array($match), $pos);
                 #return false;

            case DOKU_LEXER_EXIT:
                return array('labhidden_close', '');

        }
        return false;
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $indata) {

        if (empty($indata)) return false;
        list($instr, $data) = $indata;

        global $INFO;
        $hidden = $INFO['perm'] < AUTH_EDIT;

        if($mode == 'xhtml'){
            $renderer->info['cache'] = false;

            switch ($instr) {

            case 'labhidden_open' :
                if ($hidden) {
                    $renderer->doc .= '%%%2121!!!+++CUTHERE+++!!!2121%%%';
                } else {
                    $renderer->doc .= '<div class="usohidden usohidden_hidden"><div class="usohidden_title usohidden_title_hidden">Indicații pentru asistenți</div><div class="usohidden_contents">';
                }
                break;

            case 'labhidden_data' :
                if ($hidden)
                    break;
                $renderer->doc .= $renderer->_xmlEntities($data);
                break;

            case 'labhidden_close' :
                if ($hidden) {
                    $parts = preg_split("/%%%2121!!!\+\+\+CUTHERE\+\+\+!!!2121%%%/", $renderer->doc);
                    $renderer->doc = $parts[0];
                    break;
                }
                $renderer->doc .= "</div></div>\n";
                break;
            }

            return true;
        }
        return false;
    }

}

//Setup VIM: ex: et sts=4 sw=4 enc=utf-8 :
