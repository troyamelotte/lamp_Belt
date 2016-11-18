<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a href="/users/logout">Logout</a>
    <h3>Welcome <?php echo $user['name']; ?>!</h3>
    <h4> <?php echo count($poked_you); ?> people poked you!</h4>
    <?php foreach ($poked_you as $poker) {?>

      <p>
        <?php echo $poker['alias'];?> poked you <?php echo $poker['pokes'];?> times.
      </p>
    <?php } ?>
    <h3>People you may want to poke:</h3>
    <table>
      <tr>
        <th>
          Name:
        </th>
        <th>
          Alias:
        </th>
        <th>
          Email Address:
        </th>
        <th>
          Poke History:
        </th>
        <th>
          Action:
        </th>
      </tr>
      <?php foreach ($all_users as $user) {?>
        <tr>
          <td>
            <?php echo $user["name"]; ?>
          </td>
          <td>
            <?php echo $user['alias']; ?>
          </td>
          <td>
            <?php echo $user['email']; ?>
          </td>
          <td>
            <?php echo $user['poke_count']; ?>
          </td>
          <td>
            <a href="/users/poke/<?php echo $user['id']; ?>">Poke!</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </body>
</html>
