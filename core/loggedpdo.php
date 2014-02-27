<?php
/*******************************************************************************
@INFORMACOES BASICAS
--------------------------------------------------------------------------------
@CRIACAO.....: 15/04/2013
@AUTOR.......: Adriel Vieira <ahdriel@gmail.com>
@AUTOR.......: Márcio David <marcio.h.david@gmail.com>
@LINGUAGEM...: PHP
@VERSAO......: 1.0
@NOME FISICO.: jz_date.php
@NOME CODIGO.: Obelisc
@UTILIDADE...: Classe Extensão da Classe PDO, gera logs de todas as querys executadas.
@INTRODUCAO..: JAZZMVC Revision SVN 19
@STATUS......: [X] Construção, [] Operação, [] Manutenção, [] Fora de uso
*******************************************************************************/

class LoggedPDO extends PDO
{
    public static $log = array();
    
    public function __construct($dsn, $username = null, $password = null) {
        parent::__construct($dsn, $username, $password);
    }
    
    /**
     * Print out the log when we're destructed. I'm assuming this will
     * be at the end of the page. If not you might want to remove this
     * destructor and manually call LoggedPDO::printLog();
     */
    public function __destruct()
    {
        LoggedPDO::printLog();
    }
    
    public function query($query) {
        $start = microtime(true);
        $result = parent::query($query);
        $time = microtime(true) - $start;
        LoggedPDO::$log[] = array('query' => $query,
                                  'time' => round($time * 1000, 3));
        return $result;
    }

    /**
     * @return LoggedPDOStatement
     */
    public function prepare($query, $opts = NULL) {
        return new LoggedPDOStatement(parent::prepare($query));
    }
    
    public static function printLog() {
        $date=  new jz_date();
        $totalTime = 0;
        $mlog=fopen (ROOT_DIR.DS.'core'.DS.'log'.DS.'jazzmvc.log','a');
             
        foreach(self::$log as $entry) {
            $totalTime += $entry['time'];
            $write = '['.$date->now_hms().']['. $entry['time'].']['.$entry['query']."]\n";
            fwrite($mlog,$write);
            fwrite($mlog,"\r\n");
        
        }
        $write = count(self::$log) . ' -- ' . $totalTime . "\n";
        fclose ($mlog);
    }
}

/**
* PDOStatement decorator that logs when a PDOStatement is
* executed, and the time it took to run
* @see LoggedPDO
*/
class LoggedPDOStatement {
    /**
     * The PDOStatement we decorate
     */
    private $statement;
    protected $_debugValues = null;

    public function __construct(PDOStatement $statement) {
        $this->statement = $statement;
    }

    /**
    * When execute is called record the time it takes and
    * then log the query
    * @return PDO result set
    */
    public function execute($values=array()) {
        $this->_debugValues = $values;
        $start = microtime(true);
        $result = $this->statement->execute($values);
        $time = microtime(true) - $start;
        LoggedPDO::$log[] = array('query' => '[PS] ' . $this->_debugQuery(),
                                  'time' => round($time * 1000, 3));
        return $result;
    }
    /**
    * Other than execute pass all other calls to the PDOStatement object
    * @param string $function_name
    * @param array $parameters arguments
    */
    
    public function __call($function_name, $parameters) {
        return call_user_func_array(array($this->statement, $function_name), $parameters);
    }

      public function _debugQuery()
      {
        $q = $this->statement->queryString;

        $re1='.*?'; # Non-greedy match on filler
        $re2='(\\?)'; # Any Single Character 1
/*
        if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
        {
            $c1=$matches[1][0];
            print "($c1) \n";
        }*/

        return preg_replace_callback("/".$re1.$re2."/is", array($this, '_debugReplace'), $q);
      }

      public function _debugReplace($matches)
      {
        $i = 0;
        foreach ($matches as $mat) {
            return str_replace('?', $this->_debugValues[$i], $mat);
            $i++;
        }
      }
}