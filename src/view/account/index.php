<?php include_once 'src/view/page-header.php' ?>

<div>
  <h2><?php echo $data['user']->getFirstName() . ' ' . $data['user']->getLastName(); ?></h2>
  <strong>Email :</strong>&nbsp<?php echo $data['user']->getEmail(); ?>
  <strong>Date de naissance :</strong>&nbsp<?php echo dateFormat($data['user']->getBirthDate()); ?>

  <a href="?r=account/edit&userId=<?= $data['user']->getId(); ?>">Modifier mes informations</a>
</div>
