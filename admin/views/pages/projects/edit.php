<?php
require_once 'models/projectclass.php';
require_once 'models/userclass.php';
require_once 'models/projectcatagoryclass.php';
require_once 'models/clintclass.php';



$msg = "";


$p_catagory = ProjectCategory::readALL();
// echo "<pre>";
// print_r($p_catagory);
// echo "</pre>";


$clints = Clint::readALL();
// echo "<pre>";
// print_r($clints);
// echo "</pre>";

$users = User::readALL();
// echo "<pre>";
// print_r($users);
// echo "</pre>";

$row = null;
if(isset($_GET['id'])){
    $row = Project::readById($_GET['id']);
    // echo "<pre>";
    // print_r($row);
    // echo "</pre>";
}



function getHtmlDateValue($datetimeString) {
    // Converts the datetime string into the YYYY-MM-DD format required by HTML
    return date('Y-m-d', strtotime($datetimeString));
}


if (isset($_POST['btn_submit'])) {
  $tittle = $_POST['tittle'];
  $clint_id = $_POST['clint_id'];
  $project_category_id = $_POST['project_category_id'];
  $user_id = $_POST['user_id'];
  $exstartingtime = !empty($_POST['exstartingtime']) ? $_POST['exstartingtime'] : '1000-01-01';
  $exendingtime   = !empty($_POST['exendingtime'])   ? $_POST['exendingtime']   : '1000-01-01';
  $acstartingtime = !empty($_POST['acstartingtime']) ? $_POST['acstartingtime'] : '1000-01-01';
  $acendingtime   = !empty($_POST['acendingtime'])   ? $_POST['acendingtime']   : '1000-01-01';


  $actualcost = $_POST['actualcost'];
  $budgetcost = $_POST['budgetcost'];

  // echo $exstartingtime . "<br>". $exendingtime;
 


  $project = new project($_GET['id'], $tittle, $clint_id, $project_category_id, $user_id, $exstartingtime, $exendingtime, $acstartingtime, $acendingtime, $actualcost, $budgetcost);

  $projects = $project->update();

}





?>


<div class="content-wrapper">
  <div class="card card-primary card-outline mb-4">
    <div class="card-header">
      <div class="card-title">Edit Project</div> <br> <br>

      <a href="manage_project" class="btn btn-sm btn-dark">Back</a>
    </div>
    <h4><?= $msg ?? "" ?></h4>

    <form action="" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group">
          <label>tittle</label>
          <input type="text" class="form-control" name="tittle" placeholder="Enter name" value="<?= $row['title'] ?>">
        </div>
        
        <div class="form-group">
          <label>clint</label>
          <select class="form-control" name="clint_id">

            <?php foreach ($clints as $items):
               $selected = $items['id'] == $row['client_id'] ? 'selected' : '';?>
              ?>
              
              <option value="<?= $items['id']; ?>" <?=  $selected ?>><?= $items['name']; ?></option>
            <?php endforeach; ?>

          </select>
        </div>
        <div class="form-group">
          <label>project category</label>
          <select class="form-control" name="project_category_id">
            <?php foreach ($p_catagory as $items): 
              $selected = $items['id'] == $row['project_category_id'] ? 'selected' : '';?>
              ?>
              <option value="<?= $items['id']; ?>" <?=  $selected ?>  ><?= $items['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>user</label>
          <select class="form-control" name="user_id">
            <?php foreach ($users as $items):
              $selected = $items['id'] == $row['user_id'] ? 'selected' : '';?>
              ?>
              <option value="<?= $items['id']; ?>" <?=  $selected ?>  ><?= $items['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>expected_starting_time</label>
          <input type="date" class="form-control" name="exstartingtime" value="<?= getHtmlDateValue($row['expected_starting_time'])  ?>" >
        </div>
        <div class="form-group">
          <label>expected_ending_time</label>
          <input type="date" class="form-control" name="exendingtime" value="<?= getHtmlDateValue($row['expected_ending_time']) ?>">
        </div>
        <div class="form-group">
          <label>actual_starting_time</label>
          <input type="date" class="form-control" name="acstartingtime" value="<?= getHtmlDateValue($row['actual_starting_time']) ?>">
        </div>
        <div class="form-group">
          <label>actual_ending_time</label>
          <input type="date" class="form-control" name="acendingtime" value="<?= getHtmlDateValue($row['actual_ending_time']) ?>">
        </div>
        <div class="form-group">
          <label>actual_cost</label>
          <input type="number" class="form-control" name="actualcost" value="<?= $row['actual_cost'] ?>">
        </div>

        <div class="form-group">
          <label>budget_cost</label>
          <input type="number" class="form-control" name="budgetcost" value="<?= $row['budget_cost'] ?>">
        </div>
      </div>
      <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" name="btn_submit" class="btn btn-primary">Update</button>
    </div>
    </form>


   




    <h3><?= $msg; ?></h3>
  </div>


</div>