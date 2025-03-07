<!-- navbar.php -->
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-content">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><strong>Chick Deco & Cadeaux</strong></a>
        </div>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?route=home">Home</a></li>
                <!-- <li><a href="login.php">Login</a></li> -->
                <li><a href="?route=register">Signup</a></li>
                <li><a href="?route=about">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><strong>Logout</strong></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
