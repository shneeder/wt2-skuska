<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;
use Mysqli;


class NewsletterController extends Controller
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

    public function index()
    {
        $conn = $this->connect_to_db(env('DB_HOST', '127.0.0.1'), env('DB_USERNAME', 'root'),
            env('DB_PASSWORD', ''), env('DB_DATABASE', 'forge'));

        $newsResult = array();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT title, content FROM news";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($newsResult, ["title" => $row['title'], "content" => $row['content']]);
            }
        } else {
            echo "0 results";
        }

        return view('newsletter', ["news" => $newsResult]);
    }

    public function store(Request $request)
    {
        if (!Newsletter::isSubscribed($request->user_email) ) {
            Newsletter::subscribe($request->user_email);
            return redirect('newsletter')->with('status', 'Boli Ste pridaný na odber aktualít.');
        }
        return redirect('newsletter')->with('status', 'Ste už prihlásený na odber aktualít!');
    }

    public function unstore(Request $request)
    {
        if (Newsletter::isSubscribed($request->user_email) ) {
            Newsletter::unsubscribe($request->user_email);
            return redirect('newsletter')->with('status', 'Boli Ste odhlásený z odberu aktualít!');
        }
        return redirect('newsletter')->with('status', 'Na odber aktualít NIE STE prihlásený!');
    }
}
