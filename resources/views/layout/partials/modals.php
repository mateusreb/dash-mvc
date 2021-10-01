<div id="<?php echo $data['modal']['id']; ?>" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo $data['modal']['action']; ?>" method="post">
                    <div class="text-center">
                        <span class="text-<?php echo $data['modal']['type']; ?> icon icon-<?php echo $data['modal']['icon']; ?> icon-5x"></span>
                        <h3 class="text-warning"><?php echo $data['modal']['title']; ?></h3>
                        <p><?php echo $data['modal']['text']; ?></p>
                        <div class="m-t-lg">
                        <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>">
                            <?php foreach ($data['modal']['param'] as $param) { ?>
                                <input type="hidden" id="<?php echo $param; ?>" name="<?php echo $param; ?>">
                            <?php } ?>
                            <button type="submit" class="btn btn-<?php echo $data['modal']['type']; ?>">Continue</button>
                            <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>