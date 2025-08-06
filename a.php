<select id="farmer_name" name="farmer_name">
    <?php
      $sql = "SELECT 'name' FROM farmerreg";
      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['farmer_name'] . "'>" . $row['farmer_name'] . "</option>";
      }

    ?>
  </select><br><br>