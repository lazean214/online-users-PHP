<?php

    public function onlineUsers(){

        $timeout = 300; // 5 minutes
        $time = time();
        $ip = $_SERVER["REMOTE_ADDR"];
        $file = public_path() ."/users.txt";
        $arr = file($file);

        $users = 0;
        // Check the timestamp if it is more than five(5) minutes idle
        for ($i = 0; $i < count($arr); $i++){
            if ($time - intval(substr($arr[$i], strpos($arr[$i], "    ") + 4)) > $timeout){
                //Remove from the lists
                unset($arr[$i]);
                //Update lists
                $arr = array_values($arr);
                file_put_contents($file, implode($arr)); // 'Glue' array elements into string
            }
            $users++;
        }
        echo $users;
        // Only add entry if user isn't already there, otherwise just edit timestamp
        for ($i = 0; $i < count($arr); $i++){

            // Validates
            if (substr($arr[$i], 0, strlen($ip)) == $ip){
                $arr[$i] = substr($arr[$i], 0, strlen($ip))."    ".$time."\n";
                // Update lists
                $arr = array_values($arr);
                file_put_contents($file, implode($arr)); // 'Glue' array elements into string
                exit;
            }
        }
        file_put_contents($file, $ip."    ".$time."\n", FILE_APPEND);
    }

?>


