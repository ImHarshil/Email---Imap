<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE); 

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css" />

        <script type="text/javascript" src="static/js/jquery.js"></script>

        <script type="text/javascript" src="static/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="static/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css/"/>

        <script type="text/javascript" src="DataTables/datatables.min.js"></script>

        <title>Index</title>

    </head>
    <body>
        <?php
        if (!function_exists('imap_open')) {
            echo "IMAP is not configured.";
            exit();
        } else {
            
                $mailboxPath2 = "{imap.gmail.com:993/imap/ssl}";

                $var = trim(file_get_contents("emailid.txt"));
                $emails = explode("\n", $var);
                /*foreach ($emails as $email) {
                    //  echo $email;
                } */
                $var = trim(file_get_contents("password.txt"));
                $passwords = explode("\n", $var);
                /*foreach ($passwords as $password) {
                    //   echo $password;
                } */
                $dataemails = array();

                $val1 = count($emails);
                //echo $val . "\n\n";
//$i=0;         
                
                for ($i = 0; $i < $val1; $i++) {
                    //try{
                        $dataemails[$i] = array();
                    if ($imap = imap_open($mailboxPath2, $emails[$i], $passwords[$i])) {
                        array_push($dataemails, $emails[$i]);

                        $list = imap_list($imap, "{imap.gmail.com}", "*");

                        if (is_array($list)) {
                            
                            foreach ($list as $val) {

                                $strval = imap_utf7_decode($val);
                                $strval = str_replace("com", "com:993/imap/ssl", $strval);
                                //echo $strval;
                                //echo " =  ";
                                $imaplist = imap_open($strval, $emails[$i], $passwords[$i]);
                                //echo imap_num_msg($imaplist);
                                //echo "\n";
                                array_push($dataemails[$i], imap_num_msg($imaplist));
                                imap_close($imaplist);
                            }

                            echo "\n\n";

                            //continue;
                        } else {
                            echo "imap_list failed: " . imap_last_error() . "\n";
                        }
                        imap_close($imap);
                    } else {
                        echo imap_last_error() . "\n";
                        //      exit;
                    }
                    
                    }
                    /*
                    catch(Exception $e){
                        $dataemails[i]=null;
                    }
                   // print_r($dataemails);
                }
                */
                $dataobject = serialize($dataemails);
                $fp = fopen("dataobject.txt", "w") or die("unable to open a file !");
                fwrite($fp, $dataobject);
                fclose($fp);

                $spamcount=0;
                $inboxcount=0;
                $myfile = fopen("dataemails.txt", "w") or die("Unable to open file!");
                fwrite($myfile, "emailid                  inbox   Allmails  Drafts  imp     sent  spam  starred   trash \n");
                for ($i = 0; $i < count($dataemails)-1; $i++) {
                    fwrite($myfile, str_pad($emails[$i] . " =    ", 10, " ", STR_PAD_RIGHT));
                    fwrite($myfile, str_pad($dataemails[$i][0], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][1], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][2], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][3], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][4], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][5], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][6], 8) . "\n");
                    fwrite($myfile, str_pad($dataemails[$i][7], 8) . "\n");
                    fwrite($myfile, "\n\n\n");
                   // echo"\n";
                    $spamcount+=(int)$dataemails[$i][5];
                    $inboxcount+= (int)$dataemails[$i][0];
                }
                fclose($myfile);

               /* $myfile = fopen("dataemails.txt", "r") or die("Unable to open file!");
                while (!feof($myfile)) {
                    echo fgets($myfile);
                }

                fclose($myfile);  */
            }
            ?>
                    <div class="container" >
                        <center><h1 class="display-4" style="border-bottom: 2px solid green;"> NOT SPAM COUNT </h1></center>
        <table class="table table-hover table-dark table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">S. No</th>
                    <th scope="col">Email Id</th>
                    <th scope="col">Inbox</th>
                    <th scope="col">All mails</th>
                    <th scope="col">Drafts</th>
                    <th scope="col">Important</th>
                    <th scope="col">Sent</th>
                    <th scope="col">Spam</th>
                    <th scope="col">Starred</th>
                    <th scope="col">Trash</th>
                </tr>
            </thead>
            <tbody>
                   <?php for ($i = 0; $i < count($dataemails)-1; $i++) { ?>
                            <tr>
                                <th scope="row" class="lead"><?php echo $i +1 ?></th>
                                <td><?php echo $emails[$i] ?></td>
                                    <?php foreach ($dataemails[$i] as $value1) {?>
                                    <td><?php echo $value1 ?></td>
                                    <?php } ?>
                            </tr>
                    <?php  }     ?>
            </tbody>
        </table>
        </div>
        <div class="container">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th class="bg-success text-white"> Total inbox count </td>
                    <th class="bg-danger text-white"> Total spam count </td>
                </tr>
                </thead>
                <tr>
                    <td class="bg-success text-white"><?php echo $inboxcount ?></td>
                    <td class="bg-danger text-white"> <?php echo $spamcount ?></td>
                </tr>
            </table>
        </div>
    </body>
</html>
