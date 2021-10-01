<ul class="sidenav">
    <li class="sidenav-search hidden-md hidden-lg">
        <form class="sidenav-form" action="/">
            <div class="form-group form-group-sm">
                <div class="input-with-icon">
                    <input class="form-control" type="text" placeholder="Search…">
                    <span class="icon icon-search input-icon"></span>
                </div>
            </div>
        </form>
    </li>
    <li class="sidenav-heading">Navigation</li>
    <?php foreach ($config['menu'] as $items) 
    {
        if($items['admin'] && !$data['is-admin'])
        { 
            continue;
        }          
    ?>
        <li aria-expanded="true" class="sidenav-item has-subnav <?php foreach ($items['items'] as $subitem) {  if ($subitem['text'] == $data['pagetitle']) echo 'active open'; } ?>">
            <a href="" aria-haspopup="true">
                <span class="sidenav-icon icon <?php echo $items['icon']; ?>"></span>
                <span class="sidenav-label"><?php echo $items['text']; ?></span>
            </a>
            <ul class="sidenav-subnav collapse" aria-expanded="true">
                <?php foreach ($items['items'] as $subitem) 
                      { 
                ?>
                    <li class="<?php if ($subitem['text'] == $data['pagetitle']) echo 'active'; ?>"><a href="<?php echo $subitem['url']; ?>"><?php echo $subitem['text']; ?></a></li>
                <?php 
                      } 
                ?>
            </ul>
        </li>
    <?php } ?>
</ul>