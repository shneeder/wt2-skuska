<?php

namespace WT2projekt\Http\Controllers;

use Illuminate\Http\Request;
use Mysqli;

class AdminController extends Controller
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

        $sql = "SELECT name, email, first_name, last_name, street, postal_code, town, school_name  FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($newsResult, [
                    "name" => $row['name'],
                    "email" => $row['email'],
                    "first_name" => $row['first_name'],
                    "last_name" => $row['last_name'],
                    "street" => $row['street'],
                    "postal_code" => $row['postal_code'],
                    "town" => $row['town'],
                    "school_name" => $row['school_name']
                ]);
            }
        } else {
            echo "0 results";
        }


        return view('admin', ["users" => $newsResult]);
       // return view('admin' );
    }
}
