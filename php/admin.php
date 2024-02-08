<?php

require "resources/connect.php";

include "resources/header.php";

if (!$IsLogIn) {
  echo "Please Log in to access the Admin panel.";
}
if ($IsLogIn) {


  //get all login data
  $permission = $_SESSION['userlvl'];


  if ($permission == 1) {
    echo '<h1>You are unauthorized to access this panel.</h1>';

  }
  if ($permission == 2) {
    // Fetch Agent's FirstName based on the agentID
    $sql = "SELECT FirstName FROM agents WHERE LoginID = :loginID";
    $query = $db->prepare($sql);
    $query->execute(["loginID" => $_SESSION['user_id']]);
    $agent_data = $query->fetch();

    echo '<h1>Welcome to the Agent Panel, ' . $agent_data['FirstName'] . '!</h1>';
    //fetch Agent ID
    $sql = "SELECT AgentID FROM agents WHERE LoginID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $_SESSION['user_id']]);
    $data = $query->fetch();
    $agentID = $data['AgentID'];

    //fetch all agent listings
    $sql = "SELECT * FROM properties WHERE AgentID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id" => $agentID]);

    ?>
    <section class="services">
      <h1 class="heading">Properties</h1>
      <a href="add.php">Add a Property listing</a>
      <section class="box-container">

        <?php while ($data = $query->fetch()): ?>
          <div class="box">
            <p>Property Number:
              <?= $data['PropertyID']; ?>
            </p>
            <p>Address:
              <?= $data['StreetNum']; ?>,
              <?= $data['StreetName']; ?>,
              <?= $data['Postal']; ?>
            </p>
            <p>Price:
              <?= $data['Price']; ?>
            </p>
            <a href="add.php?item=<?= $data['PropertyID']; ?>">Edit</a>
            <a href="delete.php?item=<?= $data['PropertyID']; ?>">Delete</a>
          </div>
        <?php endwhile; ?>

      </section>
      <h1 class="heading">Offers</h1>
      <section class="box-container">
        <?php
        //fetch all offers
        $sql = "SELECT o.*, p.AgentID FROM `propertyoffers` o JOIN `properties` p ON o.PropertyID = p.PropertyID WHERE AgentID = :id";
        $query = $db->prepare($sql);
        $query->execute(["id" => $agentID]);

        while ($data = $query->fetch()): ?>
          <div class="box">
            <p>Offer for Property Number:
              <?= $data['PropertyID']; ?>
            </p>
            <p>Amount:
              <?= $data['OfferAmount']; ?>
            </p>
            <p>Status:
              <?= $data['OfferStatus']; ?>
            </p>
            <a href="modifyOffer.php?item=<?= $data['OfferID']; ?>&set=App">Approve</a>
            <a href="modifyOffer.php?item=<?= $data['OfferID']; ?>&set=Rej">Reject</a>
            <a href="modifyOffer.php?item=<?= $data['OfferID']; ?>&set=Del">Delete</a>
          </div>
        <?php endwhile; ?>
      </section>

    </section>
    <?php
  } else if ($permission == 3) {
    $sql = "SELECT AdminID FROM admins WHERE LoginID = :id";
    $query = $db->prepare($sql);
    $query->execute(["id"=> $_SESSION['user_id']]);
    $data = $query->fetch();

    $adminID = $data['AdminID'];

    // Fetch the admin's first name based on the adminID
    $sql = "SELECT FirstName FROM admins WHERE LoginID = :adminID";
    $query = $db->prepare($sql);
    $query->execute(["adminID" => $adminID]);
    $admin_data = $query->fetch();

    echo '<h1>Welcome to the Admin Panel, ' . $admin_data['FirstName'] . '!</h1>';

    //fetch all  listings
    $sql = "SELECT * FROM properties";
    $query = $db->prepare($sql);
    $query->execute();



    ?>
      <section class="services">
        <h1 class="heading">Properties</h1>
        <button class="btn" type="submit" style="display: block; margin: 0 auto; width: 30rem;"
          onclick="location.href='add.php'">Add a Property listing</button>
        <section class="box-container">
        <?php while ($data = $query->fetch()): ?>
            <div class="box">
              <p>Property Number:
              <?= $data['PropertyID']; ?>
              </p>
              <p>Address:
              <?= $data['StreetNum']; ?>,
              <?= $data['StreetName']; ?>,
              <?= $data['Postal']; ?>
              </p>
              <p>Price:
              <?= $data['Price']; ?>
              </p>
              <a href="add.php?item=<?= $data['PropertyID']; ?>">Edit</a>
              <a href="delete.php?item=<?= $data['PropertyID']; ?>">Delete</a>
            </div>
        <?php endwhile; ?>
        </section>
        <h1 class="heading">Offers</h1>
        <section class="box-container">
          <?php
          //fetch all offers
          $sql = "SELECT * FROM propertyoffers";
          $query = $db->prepare($sql);
          $query->execute();

          while ($data = $query->fetch()): ?>
            <div class="box">
              <p>Offer for Property Number:
              <?= $data['PropertyID']; ?>
              </p>
              <p>Amount:
              <?= $data['OfferAmount']; ?>
              </p>
              <p>Status:
              <?= $data['OfferStatus']; ?>
              </p>
              <a href="modifyOffer.php?item=<?= $data['OfferID']; ?>&set=App">Approve</a>
              <a href="modifyOffer.php?item=<?= $data['OfferID']; ?>&set=Rej">Reject</a>
              <a href="modifyOffer.php?item=<?= $data['OfferID']; ?>&set=Del">Delete</a>
            </div>
        <?php endwhile; ?>
        </section>
        <h1 class="heading">Users</h1>
        <!-- <button class="btn" type="submit" style="display: block; margin: 0 auto; width: 30rem;" onclick="location.href='add1.php'">Add User</button> -->
        <section class="box-container">
          <?php
          //fetch all users
          $sql = "SELECT * FROM users";
          $query = $db->prepare($sql);
          $query->execute();

          while ($data = $query->fetch()): ?>
            <div class="box">
              <p>User:
              <?= $data['FirstName']; ?>
              <?= $data['LastName']; ?>
              </p>
              <p>Email:
              <?= $data['Email']; ?>
              </p>
              <p>Phone:
              <?= $data['Phone']; ?> 
              </p>
              <p>City:
              <?= $data['City']; ?> 
              </p>
              <br>
              <a href="admin_user_edit.php?user=<?= $data['UserID']; ?>">Edit</a>
              <a href="deleteUser.php?user=<?= $data['UserID']; ?>">Delete</a>
            </div>

        <?php endwhile; ?>

        </section>
        <h1 class="heading">Agents</h1>
        <button class="btn" type="submit" style="display: block; margin: 0 auto; width: 30rem;"
          onclick="location.href='addAgent.php'">Add Agent</button>

        <section class="box-container">
          <?php
          // Fetch all agents from the "agents" table
          $sql = "SELECT * FROM agents";
          $query = $db->prepare($sql);
          $query->execute();

          while ($data = $query->fetch()): ?>
            <div class="box">
              <p>Agent:
              <?= $data['FirstName']; ?>
              <?= $data['LastName']; ?>
              </p>
              <p>Email:
              <?= $data['Email']; ?>
              </p>
              <p>Phone:
              <?= $data['Phone']; ?>
              </p>
              <a href="editAgent.php?agent=<?= $data['AgentID']; ?>">Edit</a>
              <a href="deleteAgent.php?agent=<?= $data['AgentID']; ?>">Delete</a>
            </div>
        <?php endwhile; ?>
        </section>

      <?php
  }
}

include "resources/footer.php";

?>