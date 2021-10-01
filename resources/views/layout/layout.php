        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php require_once __DIR__ . '/partials/head.php'; ?>
        </head>

        <body class="layout layout-header-fixed">
            <div class="layout-header">
                <?php require_once 'partials/header.php'; ?>
            </div>
            <div class="layout-main">
                <div class="layout-sidebar">
                    <div class="layout-sidebar-backdrop"></div>
                    <div class="layout-sidebar-body">
                        <div class="custom-scrollbar">
                            <nav id="sidenav" class="sidenav-collapse collapse">
                                <?php require_once 'partials/sidenav.php'; ?>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="layout-content">
                    <div class="layout-content-body">
                        <div class="title-bar">
                            <h1 class="title-bar-title">
                                <span class="d-ib">
                                    <?php echo $data['pagetitle']; ?>
                                </span>
                            </h1>
                            <p class="title-bar-description">
                                <small><?php echo $data['description']; ?></small>
                            </p>
                        </div>
                        <?php self::content($data); ?>
                    </div>
                </div>
                <?php 
                    require_once __DIR__ . '/partials/footer.php';                     
                    if (array_key_exists('modal',$data))
                        require_once  'partials/modals.php'; 
                ?>
            </div>
            <?php require_once  'partials/scripts.php'; ?>
        </body>
        </html>