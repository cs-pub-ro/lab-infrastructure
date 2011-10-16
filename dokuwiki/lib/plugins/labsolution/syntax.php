<?php
/**
 * Wiki Lab Extension: Solution Plugin
 *
 * Syntax:     <solution> ... </solution>
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
class syntax_plugin_labsolution extends DokuWiki_Syntax_Plugin {

    /**
     * return some info
     */
    const SOLUTION_VISIBLE = 0;
    const SOLUTION_HIDDEN = 1;
    const SOLUTION_SHOW_EDITOR = 2;

    function getInfo(){
      return array(
        'author' => 'Mircea Bardac',
        'email'  => 'mircea@bardac.net',
        'date'   => '2009-09-12',
        'name'   => 'Wiki Lab Extension: Solution Plugin',
        'desc'   => 'Plugin for showing up solutions in lab.',
        'url'    => '',
      );
    }

    function is_solution_hidden(){
      $last_sol_lab = $this->getConf('last_sol_lab');
      $this_lab_no = 100;
      $r = $_SERVER['REQUEST_URI'];

      # TODO: make this pretty - have it as an option
      # URL format: http://something/path1/path2/.../laborator-XX
      #if (preg_match("/\/laborator\-\d\d$/",$r)) {
      #    $p = explode("/",$r);
      #    $p = $p[count($p)-1]; # we are only interested in the last element of the path
      #    $p = substr($p, -2); # take the last 2 characters of the last element
      #    $this_lab_no=(int)$p; # convert to int·
      #}

      # URL format: http://something/path1/path2/.../lab/XX/any_page
      if (preg_match("/\/lab\/\d\d\/[^\/]*/",$r)) {
          $p = explode("/",$r);
          $this_lab_no=(int)$p[count($p)-2]; # take the contents of the element before the last slash
      }
      global $INFO;
      $r = self::SOLUTION_VISIBLE;
      if ($this_lab_no > $last_sol_lab) {
    $r = self::SOLUTION_HIDDEN;
    if ($INFO['perm'] >= AUTH_EDIT ) { $r = self::SOLUTION_SHOW_EDITOR; }
      }
      return $r;
   }

    # http://www.dokuwiki.org/devel:syntax_plugins#syntax_types
    function getType(){ return 'protected'; }

    # http://www.dokuwiki.org/devel:syntax_plugins#syntax_types
    function getAllowedTypes() {
        # allow all types of syntax inside
        return array('container', 'baseonly', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs');
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
            $this->Lexer->addEntryPattern('<solution>(?=.*?</solution>)',$mode,'plugin_labsolution');
    }

    function postConnect() {
            $this->Lexer->addExitPattern('</solution>', 'plugin_labsolution');
            #$this->Lexer->addPattern('.*?', 'plugin_labsolution');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){

      $last_sol_lab = $this->getConf('last_sol_lab');
      $this_lab_no = 100;
      $r = $_SERVER['REQUEST_URI'];
      if (preg_match("/\/lab\/\d\d\/[^\/]*/",$r)) {
          $p = explode("/",$r);
          $this_lab_no=(int)$p[count($p)-2];
      }

       switch ($state) {
            case DOKU_LEXER_ENTER:
                #$handler->_addCall('nocache',array(),$pos);
                $data = array();
                return array('labsolution_open',array());
                return false;

            case DOKU_LEXER_MATCHED:
                return array('labsolution_data', $match);

            case DOKU_LEXER_UNMATCHED:
                 return array('labsolution_data', $match);
                 #$handler->_addCall('cdata',array($match), $pos);
                 #return false;

            case DOKU_LEXER_EXIT:
                return array('labsolution_close', '');

        }
        return false;
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $indata) {

      if (empty($indata)) return false;
      list($instr, $data) = $indata;

      $last_sol_lab = $this->getConf('last_sol_lab');
      $this_lab_no = 100;
      $r = $_SERVER['REQUEST_URI'];
      if (preg_match("/\/lab\/\d\d\/[^\/]*/",$r)) {
          $p = explode("/",$r);
          $this_lab_no=(int)$p[count($p)-2];
      }

      $hidden = $this->is_solution_hidden();

      if($mode == 'xhtml'){
      $renderer->info['cache'] = false;

      switch ($instr) {

          case 'labsolution_open' :
          if ($hidden == self::SOLUTION_HIDDEN) {
              $renderer->doc .= '%%%2121!!!+++CUTHERE+++!!!2121%%%';
              break;
          }
          if ($hidden == self::SOLUTION_SHOW_EDITOR) {
              $renderer->doc .= '<div class="solution solution_hidden"><div class="solution_title solution_title_hidden">Rezolvare ascunsă</div><div class="solution_contents">';
              break;
          }
          $renderer->doc .= '<div class="solution"><div class="solution_title">Rezolvare</div><div class="solution_contents">';
          break;

          case 'labsolution_data' :
            if ($hidden == self::SOLUTION_HIDDEN) break;
            $renderer->doc .= $renderer->_xmlEntities($data);
            break;

          case 'labsolution_close' :
        if ($hidden == self::SOLUTION_HIDDEN) {
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

//Setup VIM: ex: et ts=4 enc=utf-8 :
