<div class="row">
    <div class="col-12 col-lg-12 col-xs-8 mt-5 pt-3 pb-3 bg-white form-wrapper">
        <div class="container">
            <h3>Tasks for today</h3>
            <?php if (session()->get('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->get('success') ?>
                </div>
            <?php endif; ?>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="col-6" scope="col">Description</th>
                        <th class="col-3" scope="col">Status</th>
                        <th class="col-3" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): ?>
                        <tr>
                            <td class="col-6"><?= $task['description'] ?></td>
                            <td class="col-3"><?= $task['status'] ?></td>
                            <td class="col-3">
                                <div class="row">
                                    <?php if ($task['status'] !== 'Not Started'): ?>
                                        <div class="col-md-4 col-sm-12 py-1">
                                            <form action="/tasks/<?= $task['id'] ?>/progress" method="POST">
                                                <input type="hidden" name="_method" value="PUT" />
                                                <button type="submit" class="btn btn-dark btn-sm px-3">
                                                    <i class="fa fa-pause"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($task['status'] !== 'Complete'): ?>
                                        <div class="col-md-4 col-sm-12 py-1">
                                            <form action="/tasks/<?= $task['id'] ?>/complete" method="POST">
                                                <input type="hidden" name="_method" value="PUT" />
                                                <button type="submit" class="btn btn-success btn-sm px-3">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($task['status'] !== 'Cancelled'): ?>
                                        <div class="col-md-4 col-sm-12 py-1">
                                            <form action="/tasks/<?= $task['id'] ?>" method="POST">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <button type="submit" class="btn btn-danger btn-sm px-3">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
