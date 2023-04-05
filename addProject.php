<?php 
    session_start();
    if(isset($_POST['submit'])){
        $file = fopen('gs://cloud-asm-1/project.csv','w');
        $projectName = $_POST['projectName'];
        $subtype = $_POST['subtype'];
        $status = $_POST['status'];
        $capacity = $_POST['capacity'];
        $yoc = $_POST['yoc'];
        $list_sponser = $_POST['list_sponser'];
        $sponser_comp = $_POST['sponser_comp'];
        $list_lender = $_POST['list_lender'];
        $lend_comp = $_POST['lend_comp'];
        $epc = $_POST['epc'];
        $epc_participant = $_POST['epc_participant'];
        $country = $_POST['country'];
        $province = $_POST['province'];
        $district = $_POST['district'];
        $form_info = array($projectName,$subtype,$status ,$capacity,$yoc,$list_sponser,$sponser_comp,$list_lender,$lend_comp,$epc,$epc_participant,$country,$province,$district);
        $project_info = implode($form_info, ','); 
        $_SESSION['info'][] = $project_info; 
        $info = implode($_SESSION['info'], PHP_EOL); 
        fwrite($file, $info); 
        fclose($file);
        header("Location: /home");
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</head>
<body>
    <div class="mx-auto col-10 col-md-8 col-lg-6">
        <form method='post' class='mt-4'>
            <div class="form-group mt-3">
                <label for="projectName">Project Name</label>
                <input type="text" class="form-control" id="projectName" name='projectName' placeholder="Enter Project Name" required>
            </div>
            <div class="form-group mt-3">
                <label for="subtype">Subtype</label>
                <input type="text" class="form-control" id="subtype" name='subtype' placeholder="Enter Subtype">
            </div>
            <div class="form-group mt-3">
                <label for="status">Current Status</label>
                <input type="text" class="form-control" id="status" name='status' placeholder="Enter Current Status">
            </div>
            <div class="form-group mt-3">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" id="capacity" name='capacity' placeholder="Enter Capacity">
            </div>
            <div class="form-group mt-3">
                <label for="yoc">Year of Complete</label>
                <input type="text" class="form-control" id="yoc" name='yoc' placeholder="Enter YoC">
            </div>
            <div class="form-group mt-3">
                <label for="list_sponser">Country List of Sponser</label>
                <input type="text" class="form-control" id="list_sponser" name='list_sponser' placeholder="Enter Country list of sponser seperated by ';'">
            </div>
            <div class="form-group mt-3">
                <label for="sponser_comp">Sponser/Developer company</label>
                <input type="text" class="form-control" id="sponser_comp" name='sponser_comp' placeholder="Enter Sponser/Developer company">
            </div>
            <div class="form-group mt-3">
                <label for="list_lender">Country list of lender/ Financer</label>
                <input type="text" class="form-control" id="list_lender" name='list_lender' placeholder="Enter Country list of lender seperated by ';'">
            </div>
            <div class="form-group mt-3">
                <label for="lend_comp">Lender/ Financer</label>
                <input type="text" class="form-control" id="lend_comp" name='lend_comp' placeholder="Enter Country list of lender seperated by ';'">
            </div>
            <div class="form-group mt-3">
                <label for="epc">Country List of Construction</label>
                <input type="text" class="form-control" id="epc" name='epc' placeholder="Enter Country list of construction seperated by ';'">
            </div>
            <div class="form-group mt-3">
                <label for="epc_participant">EPC participant</label>
                <input type="text" class="form-control" id="epc_participant" name='epc_participant' placeholder="Enter EPC participant seperated by ';'">
            </div>
            <div class="form-group mt-3">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name='country' placeholder="Enter country">
            </div>
            <div class="form-group mt-3">
                <label for="province">Province/State</label>
                <input type="text" class="form-control" id="province" name='province' placeholder="Enter Province/State">
            </div>
            <div class="form-group mt-3">
                <label for="district">District</label>
                <input type="text" class="form-control" id="district" name='district' placeholder="Enter Province/State">
            </div>
            <button type="submit" class="btn btn-primary mt-3" name='submit'>Submit</button>
        </form>
    </div>
</body>
</html>