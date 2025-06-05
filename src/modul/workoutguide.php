<?php
  if(isset($_POST["insertdata-workoutguide"])){
    if(InsertWorkoutGuide($_POST) > 0 ){
      ?>
          <script>
              alert("Success: Berhasil menyimpan data workout guide!");
          </script>
      <?php
    }
    else {
      ?>
          <script>
              alert("Error: Gagal menyimpan data workout guide!");
          </script>
      <?php
    }
  }
  elseif (isset($_POST["deletedata-workoutguide"])) {
    if(DeleteWorkoutGuide($_POST) > 0 ){
      ?>
          <script>
              alert("Success: Berhasil menghapus data workout guide!");
          </script>
      <?php
    }
    else {
      ?>
          <script>
              alert("Error: Gagal menghapus data workout guide!");
          </script>
      <?php
    }
  }
?>


<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#entryasset-workout">Add Workout</button>
<div class="modal fade" id="entryasset-workout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <form action="" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Entry Data Workout</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                          <th scope="col">Type Workout</th>
                          <th scope="col">Body Part</th>
                          <th scope="col">Workout Name</th>
                          <th scope="col">Value MET</th>
                          <th><button type="button" name="add_asset_workout" class="btn btn-success btn-xs add_asset_workout">+</button></th>
                        </tr>
                    </thead>
                    <tbody id="table-assets-workout">
                   </tbody>
                </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="insertdata-workoutguide" class="btn btn-outline-dark">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="table-responsive mt-4">
  <form action="" method="post">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Type Workout</th>
                <th>Body Part</th>
                <th>Workout Name</th>
                <th>Met</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
          <?php
              $no = 1;
              $result = "SELECT A.*, B.*, C.* FROM tbl_exercise AS A 
              INNER JOIN tbl_type_workout AS B ON A.id_type_workout = B.id_type_workout
              INNER JOIN tbl_bodypart AS C ON A.id_bodypart = C.id_bodypart";
              $query = mysqli_query($conn, $result);
              while ($data = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data["name_type_workout"];?></td>
                <td><?= $data["name_bodypart"];?></td>
                <td><?= $data["name_workout"];?></td>
                <td><?= $data["met_exercise"];?></td>
                <td class="icheck1">
                    <input type="checkbox" name="checkidworkout[]" id="checkidworkout" class="checkidworkout" value="<?= $data['id_exercise']; ?>">
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal fade text-left" id="delete-workout" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete data type workout</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-row" id="dltworkout-check">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="deletedata-workoutguide" class="btn btn-outline-dark">Delete</button>
            </div>
        </div>
        </div>
    </div>
  </form>
  <button type="button" class="btn btn-dark float-end" onclick="return validateForm();">Delete Workout</button>
</div>

<script>
    
$(document).ready(function(){

    var count = 0;

    $(document).on('click', '.add_asset_workout', function(){
        count++;
        var html = '';
        html += '<tr>';
        html += '<td><select type="text" name="type_wokout[]" class="form-select type_wokout" required><option value="" selected disabled>Please Select</option><?= fillSeletTypeWorkout(); ?></select></td>';
        html += '<td><select type="text" name="bodypart_wokout[]" class="form-select bodypart_wokout" required><option value="" selected disabled>Please Select</option><?= fillSeletBodypart(); ?></select></td>';
        html += '<td><textarea type="text" name="name_workout[]" class="form-control name_workout" placeholder="Entry workout name" required></textarea></td>';
        html += '<td><input type="text" name="met_workout[]" class="form-control met_workout" placeholder="Entry value MET" required/></td>';
        html += '<td><button type="button" name="remove_asset_workout" class="btn btn-danger btn-xs remove_asset_workout">-</button></td>';
        $('#table-assets-workout').append(html);
    });

    $(document).on('click', '.remove_asset_workout', function(){
        $(this).closest('tr').remove();
    });
});

function validateForm() {
  var count_checked = $('input[name="checkidworkout[]"]:checked').length;
  if (count_checked == 0) {
      alert("Please check at least one checkbox");
      return false;
  } else {
      $('#dltworkout-check').html("Are you sure to delete data?");
      $('#delete-workout').modal('show');
      return true;
  }
}

</script>
