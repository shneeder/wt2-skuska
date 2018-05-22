<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;
use Mysqli;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function connect_to_db($db_host, $db_user, $db_pass, $db_name)
    {
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno) {
            echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
        }
        $conn->set_charset("utf8");
        return $conn;
    }

    public function index($userID)
    {
        $conn = $this->connect_to_db(env('DB_HOST', '127.0.0.1'), env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge'));

        $newsResult = array();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT t.already_run_km, t.datum, t.exact_time, t.finish_time, 
            r.startLat , r.startLng , r.finistLat , r.finistLng, t.evaluation, t.note FROM training t
                JOIN route r ON t.route_id = r.id
                WHERE t.user_id = ".$userID;
        $result = $conn->query($sql);
        $acc = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Average speed calculation
                $finish = explode(':', $row['finish_time']);
                $start = explode(':', $row['exact_time']);
                if (count($finish) > 1 && count($start) > 1) {
                    $hrs = intval($finish[0]) - intval($start[0]);
                    $mns = intval($finish[1]) - intval($start[1]);
                    $time_hrs = $hrs + ($mns / 60);
                    $speed = $row['already_run_km'] / $time_hrs;
                } else {
                    $speed = 0;
                }
                $acc += $row['already_run_km'];
                array_push($newsResult, [
                        "km" => $row['already_run_km'],
                        "datum" => $row['datum'],
                        "start_time" => $row['exact_time'],
                        "finish_time" => $row['finish_time'],
                        "start_lat" => $row['startLat'],
                        "start_lng" => $row['startLng'],
                        "finish_lat" => $row['finistLat'],
                        "finish_lng" => $row['finistLng'],
                        "evaluation" => $row['evaluation'],
                        "note" => $row['note'],
                        "av_speed" => $speed
                ]);
            }
        } else {
            echo "0 results";
        }
        if($result->num_rows > 0)
            $avg_km = $acc / $result->num_rows;
        else
            $avg_km = 0;
        return view('training', ["data" => $newsResult, "avg_km" => $avg_km]);
    }

}
