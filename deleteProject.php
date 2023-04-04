<?php 
    session_start();

    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];
        $file = fopen('gs://cloud-asm-1/project.csv','w');
        foreach($_SESSION['info'] as $key => $value){
            list($name, $sub, $status, $capacity, $YoC, $list_sponsor, $spon_company, $list_lender, $lend_comp,$epc,$epc_participant,$country, $province, $district) = explode(",", $value);
            if(strcmp($key, $id) == 0){
                array_splice($_SESSION['info'], $key, 1);
            };
        };
        $info = implode($_SESSION['info'], PHP_EOL);
        fwrite($file, $info); //Bi cai write (Phai chuyen ve dang nhu truoc luc doc thi moi write vao dc)
        fclose($file);
        header("Location: /home");
        };
?>