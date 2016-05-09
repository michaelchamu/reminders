<?php
/*This script goes through the text file generated with all emails and timestamps
*It gets each row, checks if date is within the week
*if the date is within the week, it creates a new file called daily.csv
*if the date is not within the week, it creates another file called weekly.csv
*the file then deletes the origial emails file*/

//check for the existance of the csv file with the emails
//if file exists, send email to each user every day with option to delete their account
include_once 'emailClass.php';
//read csv file and obtain the date';
$emailer = new EmailClass();
if(file_exists('/tmp/week_emails.csv'))
{
    $file = fopen('/tmp/week_emails.csv','r');

    while(!feof($file))
    {   
        $data = fgetcsv($file,1024);
        //check if file has records
        if(0 != filesize('/tmp/week_emails.csv'))
        {
        //send email
        $email = $data[0];
        $id = $data[1];
        $pw = $data[2];
        
        $hash = strtolower($email);
        $hash .= $pw;
        $hash = md5($hash);
        //echo $email;
       echo $emailer->sendEmail($hash,$id,$email);
        }
        else
        {
        //if file is empty or doesnt exist, the log and exit
        echo "Empty file";
        }
    }
}
else
{
//log file doesnt exist
}

?>