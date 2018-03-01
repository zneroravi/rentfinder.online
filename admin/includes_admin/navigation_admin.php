<nav class="navbar navbar-inverse navbar-fixed-top round_edges">
        <div class="container-fluid">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">RentFinder.online </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>

            <?php session_start();?>

            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-left">
                     <li role="presentation"><a href="../admin/admin_property_view.php">Properties </a></li>
                    <li role="presentation"><a href="../admin/admin_landlord_view.php">Landlords </a></li>
                    <li role="presentation"><a href="../admin/admin_tenant_view.php">Tenants </a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Welcome &nbsp&nbsp<i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['name'];?> <span class="caret"></span></a>
                        <ul class="dropdown-menu blk-clr" role="menu">
                            <li role="presentation"><a href="../admin/admin.php?userid=<?php echo $_SESSION['_id'];?>">Dashboard</a></li>
                            <li role="presentation"><a href="#">Profile</a></li>
                            <li class="divider" role="presentation"></li>
                            <li role="presentation"><a href="../includes/logout.php">Logout <i class="glyphicon glyphicon-off"></i> </a></li>
                        </ul>
                    </li>
                </ul>
              
            </div>
        </div>
    </nav>