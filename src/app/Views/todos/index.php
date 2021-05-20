<div class="row">
    <div class="col-12 col-lg-12 col-xs-8 mt-5 pt-3 pb-3 bg-white form-wrapper">
        <div class="container">
            <h3>Add New Todo</h3>
            <?php if (session()->get('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->get('success') ?>
                </div>
            <?php endif; ?>
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
                                <?php foreach ($interval_options as $option): ?>
                                    <option><?= $option ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-4">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    <?php if (isset($validation)): ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">Description</th>
                        <th scope="col">Interval</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($todos as $todo): ?>
                        <tr>
                            <td><?= $todo['description'] ?></td>
                            <td><?= $todo['interval'] ?></td>
                            <td><?= $todo['status'] ?></td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <a href="/todos/<?= $todo['id'] ?>" type="button" class="btn btn-dark btn-sm px-3">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <form action="/todos/<?= $todo['id'] ?>" method="POST">
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit" class="btn btn-danger btn-sm px-3">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
