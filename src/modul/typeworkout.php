<?php
  if(isset($_POST["insertdata-typeworkout"])){
    if(InsertTypeWorkout($_POST) > 0 ){
      ?>
          <script>
              alert("Success: Berhasil menyimpan data type workout!");
          </script>
      <?php
    }
    else {
      ?>
          <script>
              alert("Error: Gagal menyimpan data type workout!");
          </script>
      <?php
    }
  }
  elseif (isset($_POST["deletedata-typeworkout"])) {
    if(DeleteTypeWorkout($_POST) > 0 ){
      ?>
          <script>
              alert("Success: Berhasil menghapus data type workout!");
          </script>
      <?php
    }
    else {
      ?>
          <script>
              alert("Error: Gagal menghapus data type workout!");
          </script>
      <?php
    }
  }
?>

<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#entrytype-workout">Add Type Workout</button>

<div class="modal fade" id="entrytype-workout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Entry Data Type Workout</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <table class="table table-striped text-center">
                <thead>
                  <tr>
                    <th scope="col">Workout Type</th>
                    <th scope="col">Workout Description</th>
                    <th><button type="button" name="add_type_workout" id="add_type_workout" class="btn btn-success btn-xs add_type_workout">+</button></th>
                  </tr>
                </thead>
                <tbody id="table-type-workout">
                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="insertdata-typeworkout" class="btn btn-outline-dark">Save</button>
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
                <th>Desc Workout</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
          <?php
              $no = 1;
              $result = "SELECT * FROM tbl_type_workout";
              $query = mysqli_query($conn, $result);
              while ($data = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data["name_type_workout"];?></td>
                <td><?= $data["desc_type_workout"];?></td>
                <td class="icheck1">
                    <input type="checkbox" name="checkidtype[]" id="checkidtype" class="checkidtype" value="<?= $data['id_type_workout']; ?>">
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal fade text-left" id="deletetype-workout" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete data type workout</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-row" id="dlttype-check">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="deletedata-typeworkout" class="btn btn-outline-dark">Delete</button>
            </div>
        </div>
        </div>
    </div>
  </form>
  <button type="button" class="btn btn-dark float-end" onclick="return validateForm();">Delete Type Workout</button>
</div>

<script>
      
  $(document).ready(function(){
      var count = 0;
      $(document).on('click', '.add_type_workout', function(){
          count++;
          var html = '';
          html += '<tr>';
          html += '<td><input type="text" name="name_workout[]" class="form-control name_workout" placeholder="Entry workout type name" required/></td>';
          html += '<td><textarea type="text" name="desc_workout[]" class="form-control desc_workout" placeholder="Entry workout desc" required></textarea></td>';
          html += '<td><button type="button" name="remove_type_workout" class="btn btn-danger btn-xs remove_type_workout">-</button></td>';
          $('#table-type-workout').append(html);
      });

      $(document).on('click', '.remove_type_workout', function(){
          $(this).closest('tr').remove();
      });
  });

  function validateForm() {
    var count_checked = $('input[name="checkidtype[]"]:checked').length;
    if (count_checked == 0) {
        alert("Please check at least one checkbox");
        return false;
    } else {
        $('#dlttype-check').html("Are you sure to delete data?");
        $('#deletetype-workout').modal('show');
        return true;
    }
  }

</script>

<?php
    include ("src/components/alert.php");
?>
