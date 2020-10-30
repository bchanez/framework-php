<div>

  <div>
    <a href="?r=login">Se connecter</a>
  </div>

  <h1>Inscription</h1>

  <div>
    <form action="?r=registration/register" method="post">

      <label for="firstName">Prénom</label>
      <input name="firstName" type="text" id="firstName" value="<?php if (isset($data['values']['firstName'])) {
  echo $data['values']['firstName'];
} ?>" maxlength="100" required />
      <?php if (isset($data['errors']['firstName'])) : ?>
        <div><?php echo $data['errors']['firstName'] ?></div>
      <?php endif; ?>

      <label for="lastName">Nom</label>
      <input name="lastName" id="lastName" type="text" value="<?php if (isset($data['values']['lastName'])) {
  echo $data['values']['lastName'];
} ?>" maxlength="100" required />
      <?php if (isset($data['errors']['lastName'])) : ?>
        <div><?php echo $data['errors']['lastName'] ?></div>
      <?php endif; ?>

      <label for="birthDate">Date de naissance</label>
      <input name="birthDate" id="birthDate" type="date" value="<?php if (isset($data['values']['birthDate'])) {
  echo $data['values']['birthDate'];
} ?>" maxlength="10" placeholder="jj/mm/aaaa" required />
      <?php if (isset($data['errors']['birthDate'])) : ?>
        <div><?php echo $data['errors']['birthDate'] ?></div>
      <?php endif; ?>

      <label for="email">Email</label>
      <input name="email" id="email" type="email" value="<?php if (isset($data['values']['email'])) {
  echo $data['values']['email'];
} ?>" maxlength="255" required />
      <?php if (isset($data['errors']['email'])) : ?>
        <div><?php echo $data['errors']['email'] ?></div>
      <?php endif; ?>

      <label for="password">Mot de passe</label>
      <input name="password" id="password" type="password" maxlength="255" required />
      <?php if (isset($data['errors']['password'])) : ?>
        <div><?php echo $data['errors']['password'] ?></div>
      <?php endif; ?>


      <div>
        <input name="registerButton" type="submit" value="S'inscrire" />
      </div>

    </form>
  </div>

</div>
