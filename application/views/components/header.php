<div id="page-header" class="bg-gradient-9">
    <div id="mobile-navigation">
        <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button>
        <a href="<?= base_url() ?>" class="logo-content-small" title="FACTEEZO"></a>
    </div>
    <div id="header-logo" class="logo-bg">
        <a href="<?= base_url() ?>" class="logo-content-big" title="Facteezo">
            Monarch <i>UI</i>
            <span>The perfect solution for user interfaces</span>
        </a>
        <a href="<?= base_url() ?>" class="logo-content-small" title="Facteezo">
            Monarch <i>UI</i>
            <span>The perfect solution for user interfaces</span>
        </a>
        <a id="close-sidebar" href="#" title="Close sidebar">
            <i class="glyph-icon icon-angle-left"></i>
        </a>
    </div>
    <div id="header-nav-left">
        <div class="user-account-btn dropdown">
            <a href="<?= base_url() ?>" title="My Account" class="user-profile clearfix" data-toggle="dropdown">
                <img width="28" src="<?= base_url() ?>assets/image-resources/gravatar.jpg" alt="Profile image">
                <span><?= $this->session->userdata("name") ?></span>
                <i class="glyph-icon icon-angle-down"></i>
            </a>
            <div class="dropdown-menu float-left">
                <div class="box-sm">
                    <div class="login-box clearfix">
                        <div class="user-img">
                            <img src="<?= base_url() ?>assets/image-resources/gravatar.jpg" alt="">
                        </div>
                        <div class="user-info">
                            <span>
                                <?= $this->session->userdata("name") ?>
                            </span>
                        </div>
                    </div>
                    <div class="pad5A button-pane button-pane-alt text-center">
                        <a href="<?= base_url() ?>login/logout" class="btn display-block font-normal btn-danger">
                            <i class="glyph-icon icon-power-off"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #header-nav-left -->

    <div id="header-nav-right">
        <!-- <a href="#" class="hdr-btn popover-button" title="Search" data-placement="bottom" data-id="#popover-search">
            <i class="glyph-icon icon-search"></i>
        </a> -->
        <div class="hide" id="popover-search">
            <div class="pad5A">
                <div class="input-group">
                    <!-- <input type="text" class="form-control" placeholder="Search terms here ...">
                    <span class="input-group-btn">
                        <a class="btn btn-primary" href="#">Search</a>
                    </span> -->
                </div>
            </div>
        </div>
        <a href="#" class="hdr-btn" id="fullscreen-btn" title="Fullscreen">
            <i class="glyph-icon icon-arrows-alt"></i>
        </a>
        <a class="header-btn" id="logout-btn" href="<?= base_url() ?>login/logout" title="Logout">
            <i class="glyph-icon icon-linecons-lock"></i>
        </a>

    </div><!-- #header-nav-right -->

</div>