<?php 
    session_start();
    $s = file_get_contents('gs://cloud-asm-1/project.csv');
    $file_content_separated_by_spaces = explode(PHP_EOL, $s);
    // print_r ($file_content_separated_by_spaces); //Nhớ cái này omg
    $_SESSION['info'] = $file_content_separated_by_spaces; //array
    
    unset($file_content_separated_by_spaces[0]);
?>
<?php 
    function checkNull($var) {
       if(empty($var) or ctype_space($var)){
        echo '<th>NaN</th>';
       }else{
        echo '<th>'. $var .' </th>';
       }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class='container'>
        <div class="d-flex align-items-center justify-content-between w-100">
      		<div class="row">
                <div class="col-md-12 bg-light text-left">
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 bg-light text-right">
                    <button class="btn btn-primary"><a href="/addProject" class="text-light">Add</a></button>
                </div>
            </div>
        </div>
    </div>
        <table class='table table-striped'>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Project Name</th>
                    <th scope="col">Subtype</th>
                    <th scope="col">Current_Status</th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Year of Completion</th>
                    <th scope="col">List of Sponser</th>
                    <th scope="col">Sponser Company</th>
                    <th scope="col">List of lender</th>
                    <th scope="col">Lender Company</th>
                    <th scope="col">List of EPC</th>
                    <th scope="col">EPC Participant</th>
                    <th scope="col">Country</th>
                    <th scope="col">Province/State</th>
                    <th scope="col">District</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            foreach($file_content_separated_by_spaces as $key => $value){
                list($name, $sub, $status, $capacity, $YoC, $list_sponsor, $spon_company, $list_lender, $lend_comp,$epc,$epc_participant,$country, $province, $district) = explode(",", $value);
                    echo' <div>';
                        echo '<tr>';
                            checkNull($name);
                            checkNull($sub);
                            checkNull($status);
                            checkNull($capacity);
                            checkNull($YoC);
                            checkNull($list_sponsor);
                            checkNull($spon_company);
                            checkNull($list_lender);
                            checkNull($lend_comp);
                            checkNull($epc);
                            checkNull($epc_participant);
                            checkNull($country);
                            checkNull($province);
                            checkNull($district);
                            echo '
                                <th>
                                    <button class="btn btn-primary"><a href="update.php?updateid='.$key.'" class="text-light">Update</a></button>
                                    <button class="btn btn-danger mt-4" data-toggle="modal" data-target="#exampleModal">Delete</button>
                                </th>
                            ' ;
                        echo '</tr';
                    echo '</div>';
         }
          ?>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Do you want to delete this project ?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary"><a href="delete.php?deleteid=<?php echo $key;?>" class="text-light">Delete</a></button>
        </div>
        </div>
    </div>
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>