<div class="about">
  <section class="row dark">
    <div class="content">
      <h3>about me.</h3>
      <p>Hi, I'm Anne-Lise, a thirty something french girl who pretends to be british most of the time. My british partner and I came to live in the south of France six years ago. We have a beautiful little boy and a fat cat!</p>
    </div>
  </section>

  <section class="row">
    <div class="contentabout">
      <div class="contactme"
      <h3>contact me.</h3>
      <div id="form-main">
        <div id="form-div">
          <form class="form" id="form1">
            <p class="name">
              <input name="name" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Name" id="name" />
            </p>
            <p class="email">
              <input name="email" type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Email" />
            </p>
            <p class="text">
              <textarea name="comment" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="Message"></textarea>
            </p>
            <div name="barcode" value= "contact"></div>
            <div class="submit">
              <input type="submit" value="Envoyer" class="button-blue"/>
              <div class="ease"></div>
            </div>
            <div class="ok"></div>
          </form>
        </div>
      </div>
    <?php

    if (isset($_REQUEST["barcode"])
            && ($_REQUEST["barcode"] == "contact"))
    {
        require_once("private/control/treatment-form-contact.php");
    }

    ?>
    </div>
  </section>
  <?php
  require_once ("private/view/comments.php");
  ?>
</div>
