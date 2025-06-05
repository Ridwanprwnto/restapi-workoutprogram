<?php
  if(isset($_POST["insertdata-bodypart"])){
    if(InsertBodypart($_POST) > 0 ){
      ?>
          <script>
              alert("Success: Berhasil menyimpan data bodypart!");
          </script>
      <?php
    }
    else {
      ?>
          <script>
              alert("Error: Gagal menyimpan data bodypart!");
          </script>
      <?php
    }
  }
  elseif (isset($_POST["deletedata-bodypart"])) {
    if(DeleteBodypart($_POST) > 0 ){
      ?>
          <script>
              alert("Success: Berhasil menghapus data bodypart!");
          </script>
      <?php
    }
    else {
      ?>
          <script>
              alert("Error: Gagal menghapus data bodypart!");
          </script>
      <?php
    }
  }
?>

<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#entrybody-workout">Add Bodypart</button>

<div class="modal fade" id="entrybody-workout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Entry Data Bodypart</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <table class="table table-striped text-center">
                <thead>
                  <tr>
                    <th scope="col">Bodypart</th>
                    <th><button type="button" name="add_bodypart" id="add_bodypart" class="btn btn-success btn-xs add_bodypart">+</button></th>
                  </tr>
                </thead>
                <tbody id="table-bodypart">
                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="insertdata-bodypart" class="btn btn-outline-dark">Save</button>
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
                <th>Body Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
          <?php
              $no = 1;
              $result = "SELECT * FROM tbl_bodypart";
              $query = mysqli_query($conn, $result);
              while ($data = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data["name_bodypart"];?></td>
                <td class="icheck1">
                    <input type="checkbox" name="checkidbody[]" id="checkidbody" class="checkidbody" value="<?= $data['id_bodypart']; ?>">
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal fade text-left" id="deletebody-workout" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete data bodypart</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-row" id="dltbody-check">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="deletedata-bodypart" class="btn btn-outline-dark">Delete</button>
            </div>
        </div>
        </div>
    </div>
  </form>
  <button type="button" class="btn btn-dark float-end" onclick="return validateForm();">Delete Bodypart</button>
</div>


<script>
      
  $(document).ready(function(){
      var count = 0;
      $(document).on('click', '.add_bodypart', function(){
          count++;
          var html = '';
          html += '<tr>';
          html += '<td><input type="text" name="name_bodypart[]" class="form-control name_bodypart" placeholder="Entry bodypart name" required/></td>';
          html += '<td><button type="button" name="remove_bodypart" class="btn btn-danger btn-xs remove_bodypart">-</button></td>';
          $('#table-bodypart').append(html);
      });

      $(document).on('click', '.remove_bodypart', function(){
          $(this).closest('tr').remove();
      });
  });

  function validateForm() {
    var count_checked = $('input[name="checkidbody[]"]:checked').length;
    if (count_checked == 0) {
        alert("Please check at least one checkbox");
        return false;
    } else {
        $('#dltbody-check').html("Are you sure to delete data?");
        $('#deletebody-workout').modal('show');
        return true;
    }
  }

</script>

<?php
    include ("src/components/alert.php");
?>
