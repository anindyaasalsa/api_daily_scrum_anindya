<?php

namespace App\Http\Controllers;
use App\DailyScrum;
use App\User;
use DB;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class DailyScrumController extends Controller
{
    
    public function index($id)
    {
    	try{
           $dataUser = User::where('id', $id)->first();
           if($dataUser != NULL){
            $data["count"] = DailyScrum::count();
            $daily_scrum = array();
            $dataDaily = DB::table('daily_scrums')->join('users','users.id','=','daily_scrums.id_users')
                                                  ->select('daily_scrums.id','users.firstname','users.lastname','daily_scrums.team','daily_scrums.activity_yesterday','daily_scrums.activity_today','daily_scrums.problem_yesterday','daily_scrums.solution')
                                                  ->where('daily_scrums.id_users','=', $id)
                                                  ->get();

	        foreach ($dataDaily as $p) {
	            $item = [
	                "id"                        => $p->id,
                    "firstname"                 => $p->firstname,
                    "lastname"                  => $p->lastname,
                    "team"                      => $p->team,
                    "activity_yesterday"        => $p->activity_yesterday,
                    "activity_today"            => $p->activity_today,
                    "problem_yesterday"         => $p->problem_yesterday,
                    "solution"                  => $p->solution
	            ];

	            array_push($daily_scrum, $item);
	        }
	        $data["daily_scrum"] = $daily_scrum;
	        $data["status"] = 1;
	        return response($data);
        } else {
            return response ([
                'status'    => 0,
                'message'   => 'Data user tidak ditemukan'
            ]);
        }

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function getAll($limit = 10, $offset = 0)
    {
    	try{
	        $data["count"] = DailyScrum::count();
            $daily_scrum = array();
            $dataDaily = DB::table('daily_scrums')->join('users','users.id','=','daily_scrums.id_users')
                                                  ->select('daily_scrums.id','users.firstname','users.lastname','daily_scrums.team','daily_scrums.activity_yesterday','daily_scrums.activity_today','daily_scrums.problem_yesterday','daily_scrums.solution')
                                                  ->get();
	        foreach ($dataDaily as $p) {
	            $item = [
                    "id"                        => $p->id,
                    "firstname"                 => $p->firstname,
                    "lastname"                  => $p->lastname,
                    "team"                      => $p->team,
                    "activity_yesterday"        => $p->activity_yesterday,
                    "activity_today"            => $p->activity_today,
                    "problem_yesterday"         => $p->problem_yesterday,
                    "solution"                  => $p->solution
	            ];

	            array_push($daily_scrum, $item);
	        } 
	        $data["daily_scrum"] = $daily_scrum;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function store(Request $request)
    {
      try{
    		$validator = Validator::make($request->all(), [
                'id_users'              => 'required|integer|max:11',
				'team'			        => 'required|string',
				'activity_yesterday'    => 'required|string|max:255',
				'activity_today'		=> 'required|string|max:255',
				'problem_yesterday' 	=> 'required|string|max:255',
				'solution' 			    => 'required|string|max:255',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new DailyScrum();
	        $data->id_users = $request->input('id_users');
	        $data->team = $request->input('team');
	        $data->activity_yesterday = $request->input('activity_yesterday');
	        $data->activity_today = $request->input('activity_today');
			$data->problem_yesterday = $request->input('problem_yesterday');
			$data->solution = $request->input('solution');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data daily scrum ditambahkan!'
    		], 201);

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
  	}

    public function delete($id)
    {
        try{

            $delete = DailyScrum::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Data Daily Scrum berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data Daily Scrum gagal dihapus."
              ]);
            }
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
