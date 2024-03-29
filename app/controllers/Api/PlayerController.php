<?php namespace API;

use \Illuminate\Routing\Controller;
use \Dingo\Api\Routing\ControllerTrait;

class PlayerController extends \Controller {

    use ControllerTrait;

    public function __construct() {
    	// Constructor
    }

    public function record($apiKey)
    {
        if($apiKey != \Config::get('irresistible.api_key')){
            return \App::abort('403');
    	}

        try
        {
        	\DB::statement('UPDATE `USERS` SET `WEEKEND_UPTIME` = `UPTIME`');

        	return "Users' weekly time has been updated.";
        }
        catch(Exception $e)
        {
        	return \App::abort('500');
        }
    }

    public function article($id)
    {
        if(ctype_digit($id) == false)
            return \App::abort(403);

        $contentData = \DB::table('HELP')->find($id);

        if(is_null($contentData))
            return \App::abort(404);

        $content = str_replace("<li>", "<li>* ", $contentData->CONTENT);

        return "{FFFFFF}" . html_entity_decode(strip_tags($content), ENT_QUOTES, 'UTF-8');
    }

    public function data($id, $name)
    {
        if (!ctype_digit($id) && !ctype_alnum($name)) {
            return $this->response->error('The specified user has not been found.', 404);
        }

        $userData = \User::where('ID', '=', $id)->where('NAME', '=', $name)->first();

        if (is_null($userData)) {
            return $this->response->error('The specified user has not been found.', 404);
        }

        return [
            'username' => (string)$userData->NAME,
            'kills' => (int)$userData->KILLS,
            'deaths' => (int)$userData->DEATHS,
            'ratio' => (float)sprintf("%4.2f",$userData->KILLS/$userData->DEATHS),
            'admin' => (int)$userData->ADMINLEVEL,
            'vip' => (string)\Gliee\Irresistible\Utils::vipToString($userData->VIP_PACKAGE),
            'score' => (int)$userData->SCORE,
            'last_logged' => (string)\Carbon\Carbon::createFromTimeStamp($userData->LASTLOGGED)->diffForHumans(),
            'robberies' => (int)$userData->ROBBERIES,
            'arrests' => (int)$userData->ARRESTS
        ];
    }

    public function feedbackDestroy($id)
    {
        $currentUser = \User::find(\Session::get('UUID'));

        if(!$currentUser) {
            return App::abort('404');
        }

        if($currentUser->ADMINLEVEL < 6) {
            return $this->response->error('Unauthorized Access', 403);
        }

        $feedback = \Feedback::find($id);

        if (is_null($feedback)) {
            return $this->response->error('The feedback has not been found.', 404);
        }

        if ($feedback->delete()) {
            return ['id' => $id, 'status' => 'deleted'];
        } else {
            return ['id' => $id, 'status' => 'undeleted'];
        }
    }

    public function totalPlayers()
    {
        $totalPlayers = \User::where('ONLINE', '>=', 1)->count('ONLINE');
        return ['players' => $totalPlayers];
    }

    public function validate($name)
    {
        $user = \User::where('NAME', '=', $name)->select('NAME')->first();

        if ( ! is_null($user)) {
            return ['name' => $user->NAME];
        } else {
            return $this->response->error("User could not be found", 404);
        }
    }

    public function topDonors()
    {
        $topDonor = \DB::table('TOP_DONOR')->orderBy('AMOUNT', 'desc')->remember(30)->first();
        $topDonorUsername = "<i>Anonymous</i>";

        if ( ! is_null($topDonor) && ! $topDonor->HIDE )
        {
            $topDonorUser = \User::remember(30)->find($topDonor->USER_ID);
            $topDonorUsername = $topDonorUser->NAME;
        }

        $donors = \DB::table('REDEEMED')->orderBy('TIME', 'desc')->distinct()->remember(30)->lists('REDEEMER');

        return [
            'top_donor' => $topDonorUsername,
            'donors' => $donors
        ];

    }
}
