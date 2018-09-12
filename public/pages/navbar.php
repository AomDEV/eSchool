<?php require("public/core/settings.php"); ?>
<div id="navbar_web" style="margin-bottom: -10px;">

<div style="background-color: #2ecc71;">
  <img style="max-width: 100%;" src="https://satit.msu.ac.th/blog/data/blog/df.png" />
</div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./#"><i class="icon home"></i> <?=$_CONFIG["short_web_name"]?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li><a href="./?page=about"><i class="icon info circle"></i> <span tkey="menu-about"></span></a></li>
        <li><a href="./?page=contact"><i class="icon address book"></i> <span tkey="menu-contract"></span></a></li>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

</div>