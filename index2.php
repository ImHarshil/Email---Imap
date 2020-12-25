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
<?php
$filePath="dataobject.txt";
if (file_exists($filePath)){
    $objData = file_get_contents($filePath);
    $dataemails = unserialize($objData);  
}
 else {
    echo "data object not loaded";
}
$var = trim(file_get_contents("emailid.txt"));
$emails = explode("\n", $var);

$spamcount=0;
$inboxcount=0;

for ($i=0 ; $i<count($dataemails); $i++){
    $spamcount+= (int) $dataemails[$i][5];
    $inboxcount+= (int) $dataemails[$i][0];
}
//print_r($dataemails);
?>
    <body>   
        <div class="container" >
                        <center><h1 class="display-4" style="border-bottom: 2px solid green;"> NOT SPAM COUNT </h1></center>
        <table class="table table-hover table-dark table-bordered table-striped">
            <thead style="position: sticky;top: 0;">
                <tr>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">S. No</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Email Id</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Inbox</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">All mails</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Drafts</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Important</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Sent</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Spam</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Starred</th>
                    <th class="lead" scope="col" style="position: sticky;top: 0; background-color:black;">Trash</th>
                </tr>
            </thead>
            <tbody>
                   <?php for ($i = 0; $i < count($dataemails)-1; $i++) { ?>
                            <tr>
                                <th scope="row" class="lead"><?php echo $i +1 ?></th>
                                <td class="lead" ><?php echo $emails[$i] ?></td>
                                    <?php foreach ($dataemails[$i] as $value1) {?>
                                    <td class="lead"><?php echo $value1 ?></td>
                                    
                                    <?php } ?>
                            </tr>
                    <?php  }     ?>
            </tbody>
        </table>
        </div>
        <div class="container lead">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                <b><th class="bg-success text-white lead"> Total inbox count </td></b>
                    <th class="bg-danger text-white lead"> Total spam count </td>
                </tr>
                </thead>
                <tr>
                    <td class="bg-success text-white lead"><?php echo $inboxcount ?></td>
                    <td class="bg-danger text-white lead"><?php echo $spamcount ?></td>
                </tr>
            </table>
        </div>
    </body>
