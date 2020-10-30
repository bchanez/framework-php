<?php include_once 'src/view/page-header.php' ?>

<div>

  <h1>Mon compte</h1>

  <div>
    <form action="?r=account/update&userId=<?= $_SESSION['userId'] ?>" method="post">

      <label for="firstName">Prénom</label>
      <input name="firstName" type="text" id="firstName" value="<?php echo $data['user']->getFirstName() ?>" placeholder="" maxlength="100" required />

      <label for="lastName">Nom</label>
      <input name="lastName" id="lastName" type="text" value="<?php echo $data['user']->getLastName() ?>" placeholder="" maxlength="100" required />

      <label for="email">Email</label>
      <input name="email" id="email" type="email" value="<?php echo $data['user']->getEmail() ?>" placeholder="" maxlength="255" required />
      <?php if (isset($data['errors']['email'])) : ?>
        <div><?php echo $data['errors']['email'] ?></div>
      <?php endif; ?>

      <div>
        <input name="updateButton" type="submit" value="Mettre à jour" />
      </div>

    </form>
  </div>

</div>
