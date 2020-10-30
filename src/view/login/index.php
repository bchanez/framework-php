<div>

  <h1>Connexion</h1>

  <div>

    <div>
      <form action="?r=login/login" method="post">

        <label for="email">Email</label>
        <input type="email" name="email" maxlength="255" required />

        <label for="password">Mot de passe</label>
        <input type="password" name="password" maxlength="255" required />

        <?php if (isset($data['errors']['wrongIdentifiers'])) : ?>
          <div><?php echo $data['errors']['wrongIdentifiers'] ?></div>
        <?php endif; ?>

        <div>
          <input type="submit" name="connection" value="Se connecter" />
        </div>

      </form>
    </div>

    <div>
      <small><a href="?r=registration">S'inscrire</a></small>
    </div>

  </div>
</div>
