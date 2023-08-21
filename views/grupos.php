<div class="container-fluid bg-light w-100 p-5 page">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="d-flex justify-content-between align-items-center my-4 group-create">
                <div class="d-flex alig-items-center align-content-start flex-row gap-2">
                    <h2>Gerenciar grupos</h2>
                </div>
                <div class="group-buttons d-flex flex-row align-items-start gap-2">
                    <button class="btn btn-primary" onClick="window.location.reload();">Voltar</button>
                    <a id="create_grupo" href="#" class="btn btn-outline-primary">Adicionar novo</span></a>
                </div>
            </div>
        </div>
        <?php if(!empty($grupos)) :?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Quantidade de patrocinadores nesse grupo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach ($grupos as $value) : ?>
                    <tr>
                        <td><?= $value->grupo; ?></td>
                        <td><?= $value->qtd; ?></td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm delete_grupo" data-id="<?= $value->id; ?>" data-qtd="<?= $value->qtd; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    Nenhum grupo cadastrado ainda.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>