<?php 
	session_start();
	require_once 'google-api-php-client/vendor/autoload.php';
?>
<?php 
    //CÒn giữ lại cái option đã chọn 
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google_Service_Bigquery::BIGQUERY);
    $bigquery = new Google_Service_Bigquery($client);
    $projectId = 'cloudcomputing0403';
    
    $request = new Google_Service_Bigquery_QueryRequest();
    
    $str = '';


    //Get the current page and calculating offset
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1; //Chú ý chỗ này
    };
    $numberPages = 10;
    $starting_limit = ($page - 1) * $numberPages;


    //User summits filter selection and search input 
    if(isset($_POST['submit'])){
        $list = [];

        //Filter by country
        if (strcmp(($_POST['country']),"ALL") !== 0){
            $country_filter = "Country='{$_POST['country']}'";
            array_push($list, $country_filter);
        }
    
       //Fillter by capacity
        if(strcmp(($_POST['capacity']),"ALL") !== 0){
            switch ($_POST['capacity']) {
                case 1  :  $capacity_filter = " Capacity__MW_ BETWEEN 0 AND 10 ";  break; 
                case 2  :  $capacity_filter = " Capacity__MW_ BETWEEN 10 AND 20 ";  break;  
                case 3  :  $capacity_filter = " Capacity__MW_ BETWEEN 20 AND 50";  break;   
                case 4  :  $capacity_filter = " Capacity__MW_ > 50";  break;   
            }
            array_push($list, $capacity_filter);
        }
    
        //Search 
        if(!empty($_POST['search'])){
            $search_str = " (Project_Name LIKE '%{$_POST['search']}%' OR Province_State LIKE '%{$_POST['search']}%' OR DISTRICT LIKE '%{$_POST['search']}%')";
            array_push($list, $search_str);
        }
    
        
        $_SESSION['filter'] = $list;
        // Connect all the condition
        foreach($list as $key => $value){
            if(!empty($value)){
                $query .= $value;
                if (count($list) > 1 && (count($list) - 1 > $key)) { // more than one search filter, and not the last
                    $query .= " AND";
                }
            }
        }
       
        //Query based on condition
        if(count($query) !== 0){
            $request->setQuery("SELECT Project_Name,Subtype,Current_Status, Capacity__MW_, Year_of_Completion, Country_list_of_Sponsor_Developer, Sponsor_Developer_Company, Country_list_of_Lender_Financier, Lender_Financier_Company, Country_list_of_Construction_EPC, Construction_Company_EPC_Participant, Country, Province_State, District 
                                FROM [asm1.project]
                                WHERE {$query}   
                                LIMIT {$numberPages} OFFSET {$starting_limit}    
                                 ");
        }else{
            $request->setQuery("SELECT Project_Name,Subtype,Current_Status, Capacity__MW_, Year_of_Completion, Country_list_of_Sponsor_Developer, Sponsor_Developer_Company, Country_list_of_Lender_Financier, Lender_Financier_Company, Country_list_of_Construction_EPC, Construction_Company_EPC_Participant, Country, Province_State, District 
                                FROM [asm1.project]
                                LIMIT {$numberPages} OFFSET {$starting_limit}
                        ");
        }

    }else{
        $request->setQuery("SELECT Project_Name,Subtype,Current_Status, Capacity__MW_, Year_of_Completion, Country_list_of_Sponsor_Developer, Sponsor_Developer_Company, Country_list_of_Lender_Financier, Lender_Financier_Company, Country_list_of_Construction_EPC, Construction_Company_EPC_Participant, Country, Province_State, District 
                            FROM [asm1.project]
                            LIMIT {$numberPages} OFFSET {$starting_limit}
                        ");
    }
    
    
    
    $response = $bigquery->jobs->query($projectId, $request);
    $rows = $response->getRows();
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>  
    <div class="mt-3">
        <form method="post">
            <ul class="nav justify-content-around w-100 col-10 d-flex align-content-center flex-wrap mt-3">
                <li class="nav-item">
                    <div class="form-group">
                        <label for='country'>Filter by Country</label>
                        <select name="country" id="country" class="form-control">
                            <option value="ALL" selected="selected">ALL</option>
                        <?php 
                            $request = new Google_Service_Bigquery_QueryRequest();
                    
                            $str = '';
                            
                            $request->setQuery("SELECT Country
                                                FROM [asm1.project]
                                                GROUP BY Country
                                            ");
                            
                            $countries_list = $bigquery->jobs->query($projectId, $request);
                            $country_id = $countries_list->getRows();
            
                            print_r($country_id);
            
                            foreach($country_id as $row ){  
                                foreach ($row['f'] as $key => $field){
                                        echo '<option value="'.$field["v"].'"  >'.$field["v"].'</option>';
                                        
                                };         
                            }
                        ?>
                        </select>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="form-group">
                        <label for='capacity'>Filter by Capacity</label>
                        <select name='capacity' id='capacity' class="form-control">
                            <option value="ALL" selected="selected">ALL</option>
                            <option value="1" <?php if(isset($_POST['capacity']) && $_POST['capacity']=="1") {echo'selected';} ?>>0-10 MW</option>
                            <option value="2" <?php if(isset($_POST['capacity']) && $_POST['capacity']=="2") {echo'selected';} ?>>10-20 MW</option>
                            <option value="3" <?php if(isset($_POST['capacity']) && $_POST['capacity']=="3") {echo'selected';} ?>>20-50 MW</option>
                            <option value="4" <?php if(isset($_POST['capacity']) && $_POST['capacity']=="4") {echo'selected';} ?>> >50 MW</option>
                        </select>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="form-group">
                        <label for='search'>Search</label>
                        <input type="text" name="search" class="form-control" id="search" Placeholder="Search bar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
                    </div>
                </li>
                <li class="nav-item">
                    <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
                </li>
            </ul>
        </form>
    </div>
	<div class='content'>
        <div class="pagination">
            <?php 
            // ----------Pagination-----------------
            //Get number of records in dataset
                $request = new Google_Service_Bigquery_QueryRequest();
                        
                $str = '';

                
                
                if(count($query) == 0){
                $request->setQuery("SELECT COUNT(Project_Name)
                                    FROM [asm1.project]
                                ");
                }else{
                    $request->setQuery("SELECT COUNT(Project_Name)
                                        FROM [asm1.project]
                                        WHERE {$query}
                                        ");    
                }

                $row_nums = $bigquery->jobs->query($projectId, $request);
                $row_num = $row_nums->getRows();

                foreach($row_num as $row ){  
                    foreach ($row['f'] as $key => $field){
                            $num =  $field["v"];
                    };         
                }

                echo $num;
                //Calculate total pages are needed
                $page_size = 10;
                $total_page = ceil($num/$page_size);

                $start_loop = ($page*10)/$page_size;
                $last_val=($total_page-1);
                $start_SH=$start_loop + 9;

                if ($total_page-1 <= $start_SH) 
                {
                    $end_loop = $total_page;
                }else{
                    $end_loop = $start_SH;
                }

                
                //Button
                echo "<div class='d-flex flex-row'>";
                    if ((($page*10)) > 10) 
                    {
                        echo "<button class='btn btn-dark mx-1 my-3'><a class='text-light' href='bigqueryDisplay?page=1'>First</a></button>";
                    }
                    if($page > 1){
                        echo "<button class='btn btn-dark mx-1 my-3'><a class='text-light' href='bigqueryDisplay?page=".(($page)-1)."'>Previous</a></button>";
                    }
                    for($btn = $start_loop; $btn <= $end_loop; $btn++){
                        echo '<button class="btn btn-dark mx-1 my-3"><a class="text-light" href="bigqueryDisplay?page='.$btn.'">'.$btn.'</a></button>';
                    }
                    if($page < $total_page){
                        echo "<button class='btn btn-dark mx-1 my-3'><a class='text-light' href='bigqueryDisplay?page=".(($page)+1)."'>Next</a></button>";
                    }
                    if ($total_page-1 != $start_loop) 
                    {
                        
                        echo "<button class='btn btn-dark mx-1 my-3'><a class='text-light' href='bigqueryDisplay?page=".$last_val."'>Last</a></button>";
                    }
                echo "</div>";

            ?>
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
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach($rows as $row ){
                echo "<tr>";
                foreach ($row['f'] as $field){
                    // echo '<th>'. $field['v'] .' </th>'; 
                    if(is_null($field['v']) or ctype_space($field['v'])){
                        echo '<th> NaN </th>'; 
                    }else{
                        echo '<th>'. $field['v'] .' </th>'; 
                    };
                };
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
	</div>
</body>
</html>
