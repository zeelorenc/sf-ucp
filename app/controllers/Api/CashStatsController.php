<?php namespace API;

use \Illuminate\Routing\Controller;
use \Dingo\Api\Routing\ControllerTrait;

class CashStatsController extends \Controller {

    use ControllerTrait;
    public function __construct() {
        // Constructor
    }

    public function totalcash()
    {
	 	$totalCash = \DB::table('STATS')->where('NAME', '=', 'totalcash')
	 								   ->select(
	 								   		\DB::raw('unix_timestamp(`CREATED_AT`) as date'),
	 								   		'INT_VAL as cash'
	 								   	)
	 								   	->orderBy('CREATED_AT', 'desc')->limit(30)->get();

        if(!$totalCash)
            return \App::abort('500');

	    return $totalCash;
    }

    public function create($apiKey)
    {
    	if($apiKey != \Config::get('irresistible.api_key')){
            return \App::abort('403');
    	}

        $totalCash = \Server::getTotalCash();

        if(is_null($totalCash))
        	return \App::abort('500');

        // make sure its not inserted again for a while
        if (\Session::get('inserted') > time())
            return ['message' => 'Must wait before inserting a new entry again.'];

        try
        {
	        $entry 			= new \Stats;
	        $entry->NAME 	= 'totalcash';
	        $entry->INT_VAL = $totalCash;
	 		$entry->save();

            \Session::put('inserted', time() + 60);
            return ["message" => "A new entry has been successfully implemented."];
        }
        catch(Exception $e)
        {
        	return $e;
        }
    }

    public function donorReset($apiKey)
    {
        if($apiKey != \Config::get('irresistible.api_key')){
            return \App::abort('403');
        }

        try
        {
            \DB::statement('TRUNCATE TABLE `TOP_DONOR`');
            return "Truncated donor statistics.";
        }
        catch(Exception $e)
        {
            return \App::abort('500');
        }
    }
}
