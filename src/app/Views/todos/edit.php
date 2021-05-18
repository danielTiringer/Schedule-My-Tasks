<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
        <div class="container">
            <? if (session()->get('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->get('success') ?>
                </div>
            <? endif; ?>
            <form class="" action="/todos/<?= $todo['id'] ?>" method="POST">
                <input type="hidden" name="_method" value="PUT" />
                <div class="row">
                    <div class="col-8 col-sm-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" value="<?= set_value('description', $todo['description']) ?>">
                        </div>
                    </div>
                    <div class="col-2 col-sm-6">
                        <div class="form-group">
                            <label for="interval">Interval</label>
                            <select class="form-control" name="interval" id="interval">
                                <? foreach ($interval_options as $option): ?>
                                    <option <? if($todo['interval'] == $option): ?> selected="selected"<? endif ?>><?= $option ?></option>
                                <? endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-sm-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" name="status" id="status" value="<?= set_value('status', $todo['status']) ?>">
                        </div>
                    </div>
                    <? if (isset($validation)): ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    <? endif; ?>
                </div>
                <div class="col-12 row">
                    <div class="col-6 col-sm-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <div class="col-6 col-sm-4">
                        <a href="/todos" type="button" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
