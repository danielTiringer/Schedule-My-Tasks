<div class="row">
    <div class="col-12 col-lg-12 col-xs-8 mt-5 pt-3 pb-3 bg-white form-wrapper">
        <div class="container">
            <h3>Add New Todo</h3>
            <hr>
            <? if (session()->get('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->get('success') ?>
                </div>
            <? endif; ?>
            <form class="" action="/todos" method="POST">
                <div class="row">
                    <div class="col-12 col-md-8 col-sm-7">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" value="">
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-sm-3">
                        <div class="form-group">
                            <label for="interval">Interval</label>
                            <select class="form-control" name="interval" id="interval">
                                <? foreach ($interval_options as $option): ?>
                                    <option><?= $option ?></option>
                                <? endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-4">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    <? if (isset($validation)): ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    <? endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
