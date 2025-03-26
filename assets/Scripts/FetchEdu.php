<?php
  $eduQuery = "SELECT Eduid, Eduname FROM educations";
  $eduResult = $conn->query($eduQuery);
  
  if ($eduResult->num_rows > 0) {
      while($row = $eduResult->fetch_assoc()) {
          echo '<input type="checkbox" id="edu_'.$row['Eduid'].'" name="education[]" value="'.$row['Eduid'].'">';
          echo '<label for="edu_'.$row['Eduid'].'">'.$row['Eduname'].'</label>';
      }
  } else {
      echo '<p>No education levels found</p>';
  }
?>