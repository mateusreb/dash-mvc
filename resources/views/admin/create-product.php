<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="demo-form-wrapper">
            <form id="demo-form-wizard-1" method="post" action="/manage-products/create">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="row gutter-xs">
                            <?php
                            if (array_key_exists('alert', $data))
                                echo $data['alert'];
                            ?>
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>">
                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-xs-4 col-xs-offset-0">
                                <div class="form-group">
                                    <label for="version" class="control-label">Version</label>
                                    <input id="version" class="form-control" type="text" name="version">
                                </div>
                            </div>
                            <div class="col-xs-6 col-xs-offset-0">
                                <div class="form-group">
                                    <label for="status" class="control-label">Status</label>
                                    <select id="status" class="custom-select" name="status" data-rule-required="true" data-msg-required="Please select your credit card type.">
                                        <option value="" selected="selected">Select a status</option>
                                        <option value="Online">Online</option>
                                        <option value="Offline">Offline</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-5 col-xs-offset-1">
                                <div class="form-group">
                                    <label for="update-date" class="control-label">Update Date</label>
                                    <div class="input-with-icon">
                                        <input id="update-date" class="form-control" type="text" data-provide="datepicker" data-date-today-highlight="true" name="update-date">
                                        <span class="icon icon-calendar input-icon"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="hash" class="control-label">Hash</label>
                                <input id="hash" class="form-control" type="text" name="hash">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <input id="description" class="form-control" type="text" name="description">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-block" type="submit">Save</button>
                        </div>
                        <div class="text-center">
                            <a class="label label-primary label-pill" href="/manage-licenses">
                                <span>← Go Back </span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>