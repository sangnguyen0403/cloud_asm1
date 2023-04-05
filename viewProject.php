<?php 
    session_start();

    $columns = array('Project Name: ','Subtype: ','Current_Status: ','Capacity:','Year of Completion: ','List of Sponser: ','Sponser Company: ','List of lender: ','Lender Company: ','List of EPC: ','EPC Participant: ','Country: ','Province/State: ','District: ');
    if(isset($_GET['viewid'])){
        $id = $_GET['viewid'];
        foreach($_SESSION['info'] as $key => $value){
            list($name, $sub, $status, $capacity, $YoC, $list_sponsor, $spon_company, $list_lender, $lend_comp,$epc,$epc_participant,$country, $province, $district) = explode(",", $value);
            if($key == $id){
                $data = array($name, $sub, $status, $capacity, $YoC, $list_sponsor, $spon_company, $list_lender, $lend_comp,$epc,$epc_participant,$country, $province, $district);
            }
        }
    };

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class='heading'>
            <h2>Details</h2>
        </div>
        <ul class="list-group mt-5">
            <?php 
                foreach($data as $key => $value){
                    echo "<li class='list-group-item d-flex justify-content-between'>";
                        echo "<div><b>".$columns[$key]."</b></div>";
                        echo '<div>'. $value .' </div>';
                        
                    echo"</li>";
    
                }
            ?>
            
        </ul>
    </div>
</body>
</html>