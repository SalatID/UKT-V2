<?php
namespace App\Logging;
// use Illuminate\Log\Logger;
use DB;
use Illuminate\Support\Facades\Auth;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
class MySQLLoggingHandler extends AbstractProcessingHandler{
/**
 *
 * Reference:
 * https://github.com/markhilton/monolog-mysql/blob/master/src/Logger/Monolog/Handler/MysqlHandler.php
 */
    public function __construct($level = Logger::DEBUG, $bubble = true) {
        $this->table = 'log_program';
        parent::__construct($level, $bubble);
    }
    protected function write(array $record):void
    {
    //    dd($record['context']['exception']->getFile());   
       $data = array(
           'file'          =>array_key_exists('exception',$record['context'])?$record['context']['exception']->getFile():'not file',
           'line'          =>array_key_exists('exception',$record['context'])?$record['context']['exception']->getLine():0,
           'message'       => $record['message'],
           'trace'         =>array_key_exists('exception',$record['context'])?$record['context']['exception']->getTraceAsString():'not trace',
           'ip_address'    =>$_SERVER['REMOTE_ADDR']??'0.0.0.0',
           'context'       => json_encode(array_key_exists('exception',$record['context'])?$record['context']:'{}'),
           'level'         => $record['level'],
           'level_name'    => $record['level_name'],
           'channel'       => $record['channel'],
           'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
           'extra'         => json_encode($record['extra']),
           'formatted'     => $record['formatted'],
           'created_at'    => date("Y-m-d H:i:s"),
       );
       DB::connection()->table($this->table)->insert($data);     
    }
}