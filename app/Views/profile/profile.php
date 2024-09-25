<div class="container">
  <div class="col-md-12">
    <div class="profile-card">
      <div class="text-center">
        <div class="current-profile-picture">
          <img src="uploads/UserImg/<?=$_SESSION['idUser']?>/default.png" alt="profile picture" class="profile-image">
        </div>

        <div class="change-profile-picture" data-url="<?php echo Helpers\generateUrl("User","User","updatePhoto",[],"ajax")?>">
          <label for="fileInput" class="btn btn-primary change-picture-label">Cambiar imagen</label>
          <input type="file" id="fileInput" name="photo" style="display: none;">
        </div>

        <div class="profile-name"><?= $_SESSION['nameUser']?></div>
        <div class="profile-name"><?= $_SESSION['LastNameUser']?></div>
        <div class="profile-title"><?= $_SESSION['RolName']?></div>
      </div>
      <div class="profile-info">
        <div class="row">
          <div class="col-md-6">
            <div class="profile-label">Email</div>
            <div class="profile-value"><label for=""><?php echo $_SESSION['EmailUser']?></label> </div>
            <div class="profile-label">Phone</div>
            <div class="profile-value"><label for=""><?= $_SESSION['PhoneUser']?></label></div>
            <div class="profile-label">Location</div>
            <div class="profile-value"><label for=""><?= $_SESSION['CountryUser']?>, <?= $_SESSION['CityUser']?></label></div>
          </div>
          <!-- <div class="col-md-12 text-center">
            <button id="saveChangesBtn" type="button" class="btn btn-outline-primary">Guardar cambios</button>
          </div> -->
        </div>
      </div>
    </div>
  </div>
  <form id="upload-form" method="post" enctype="multipart/form-data" action="<?php echo Helpers\generateUrl("User","User","updatePhoto") ?>" style="display:none;">
    <input type="file" name="photo" id="file">
    <button type="submit" id="submitFormBtn"></button>
  </form>
</div>
