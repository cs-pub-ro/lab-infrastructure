    <?php
    /**
     * Secret Plugin: Hide wiki contents
     *
     * Based on the labsolution plugin by Mircea Bardac
     * 
     * Syntax:
     *   Make contents visible:
     *     ~~NOSECRET~~
     *     ~~SHOWSOLUTION~~
     *   Hide contents:
     *     <secret> ... </secret>
     *     <solution> ... </solution>
     * 
     * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
     * @author     Mircea Bardac <mircea@bardac.net>, Sergiu Costea <sergiu.costea@gmail.com>
     */
     
    if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
    if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
    require_once(DOKU_PLUGIN.'syntax.php');
     
    class syntax_plugin_secret extends DokuWiki_Syntax_Plugin {
     
        private $secret = true;
        private $render_buffer = '';

        function getInfo(){
            return array(
                'author' => 'Sergiu Costea',
                'email'  => 'sergiu.costea@gmail.com',
                'date'   => '2012-08-04',
                'name'   => 'Secret Plugin',
                'desc'   => 'Hide wiki contents',
                'url'    => '',
            );
        }
     
        function getType(){
            return 'disabled';
        }
     
        function getAllowedTypes() {
            return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs');
        }
     
        function getPType(){
            return 'block';
        }
     
        function getSort(){
            return 194;
        }
     
     
        function connectTo($mode) {
          $this->Lexer->addSpecialPattern('~~SHOWSOLUTION~~',$mode,'plugin_secret');
          $this->Lexer->addEntryPattern('<solution.*?>(?=.*?</solution>)',$mode,'plugin_secret');
          $this->Lexer->addSpecialPattern('~~NOSECRET~~',$mode,'plugin_secret');
          $this->Lexer->addEntryPattern('<secret.*?>(?=.*?</secret>)',$mode,'plugin_secret');
        }
     

        function postConnect() {
          $this->Lexer->addExitPattern('</solution>','plugin_secret');
          $this->Lexer->addExitPattern('</secret>','plugin_secret');
        }
     
     
        function handle($match, $state, $pos, &$handler){
            switch ($state) {
              case DOKU_LEXER_ENTER : 
                $return = array('state' => $state, 'match' => $match, 'lang' => 'ro', 'hidden' => false);

                if (preg_match("/-en/i", $match, $flag)) {
                    $return['lang'] = 'en'; 
                }

                if (preg_match("/-hidden/i", $match, $flag)) {
                    $return['hidden'] = true;
                }

                return $return;

              case DOKU_LEXER_SPECIAL :
                $this->secret = false;
                return array('state' => $state, 'match' => $match);

              case DOKU_LEXER_MATCHED :
              case DOKU_LEXER_UNMATCHED :
              case DOKU_LEXER_EXIT :
              default:
                return array('state' => $state, 'match' => $match);
            }
        }
     

        function render($mode, &$renderer, $data) {
            global $INFO;
            if($mode == 'xhtml'){
                //list($state, $match) = $data;
                $state = $data['state'];
                $match = $data['match'];
                $hidden = $data['hidden'];

                if ($data['lang'] == 'en') {
                    if ($hidden) {
                        $sol_text = "Show solution";
                        $show_text = "Show solution";
                        $hide_text = "Hide solution";
                    } else {
                        $sol_text = "Solution";
                    }
                } else {
                    if ($hidden) {
                        $sol_text = "Afișează rezolvarea";
                        $show_text = "Afișează rezolvarea";
                        $hide_text = "Ascunde rezolvarea";
                    } else {
                        $sol_text = "Rezolvare";
                    }
                }
                    
                switch ($state) {
                    case DOKU_LEXER_ENTER:
                        if ($this->secret == true && auth_quickaclcheck($INFO['id']) < AUTH_DELETE) {
                            $this->render_buffer = $renderer->doc;
                        } else {
                            $title_styles = "solution_title";
                            $content_styles = "solution_contents";

                            if ($hidden) {
                                $title_styles .= " hidden_solution_title";
                                $content_styles.= " hidden_solution_contents";
                            }

				            $renderer->doc .= '<div class="solution"><div class="'.$title_styles.'">';
                            if ($hidden) {
                                $renderer->doc .= '<img src="/courses/lib/tpl/arctic/images/tool-source.png"/>';
                            }
                            $renderer->doc .= '<span class="title_text">'.$sol_text.'</span></div>';
                            if ($hidden) {
                                $renderer->doc .= '<div class="hide_text">'.$hide_text.'</div>';
                                $renderer->doc .= '<div class="show_text">'.$show_text.'</div>';
                            }
                                
                            $renderer->doc .= '<div class="'.$content_styles.'">';
                        }
                        break;
                    case DOKU_LEXER_UNMATCHED:
                        if ($this->secret == true && auth_quickaclcheck($INFO['id']) < AUTH_DELETE) {

                        } else {
                            $renderer->doc .= $renderer->_xmlEntities($match);
                        }
                        break;
                    case DOKU_LEXER_EXIT:
                        if ($this->secret == true && auth_quickaclcheck($INFO['id']) < AUTH_DELETE) {
                            $renderer->doc = $this->render_buffer;
                        } else {
                       	    $renderer->doc .= "</div></div>\n"; 
                        }
                        break;
                }
                return true;
            }
            return false;
        }
    }
     
    //Setup VIM: ex: et ts=4 enc=utf-8 :
?>
