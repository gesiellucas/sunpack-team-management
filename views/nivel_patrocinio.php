<div class="container-fluid bg-light w-100 p-5 page">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="d-flex justify-content-between align-items-center my-4 group-create">
                <div class="d-flex alig-items-center align-content-start flex-row gap-2">
                    <h2>Gerenciar nível de patrocínio</h2>
                </div>
                <div class="group-buttons d-flex flex-row align-items-start gap-2">
                    <button class="btn btn-primary" onClick="window.location.reload();">Voltar</button>
                    <a id="create_nivel_patrocinio" href="#" class="btn btn-outline-primary">Adicionar novo</span></a>
                </div>
            </div>
        </div>
        <?php if(!empty($nivel_patrocinio)) :?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nível</th>
                    <th>Quantidade de patrocinadores desse nível de patrocínio</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach ($nivel_patrocinio as $value) : ?>
                    <tr>
                        <td><?= $value->nome_patrocinio; ?></td>
                        <td><?= $value->qtd; ?></td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm delete_nivel_patrocinio" data-id="<?= $value->id; ?>" data-qtd="<?= $value->qtd; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
        <?php else : ?>
            <div class="card">
                <div class="card-body">
                    Nenhum nível de patrocínio cadastrado ainda.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>