<div class="container-fluid bg-light w-100 p-5 page">
    <div class="">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h2>Gerenciar patrocinadores</h2>
                    <div class="d-flex gap-4">
                        <a id="create_data" href="#" class="btn btn-outline-primary d-flex flex-row align-items-center gap-2"><i data-feather="plus-circle"></i> <span>Adicionar novo</span></a>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="settings_grupo" class="btn btn-outline-dark d-flex flex-row align-items-center gap-2"> <i data-feather="settings"></i> <span>Grupo</span></button>
                            <button type="button" id="settings_origem_verba" class="btn btn-outline-dark d-flex flex-row align-items-center gap-2"> <i data-feather="settings"></i> <span>Origem da Verba</span></button>
                            <button type="button" id="settings_nivel_patrocinio" class="btn btn-outline-dark d-flex flex-row align-items-center gap-2"><i data-feather="settings"></i> <span>Nível de Patrocínio</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php

use LuaSpk\Classes\SPKTM_Entity;

 if (!empty($data_spk)) : ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Patrocinador</th>
                            <th>Origem da Verba</th>
                            <th>Grupo</th>
                            <th>Nível de Patrocínio</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($data_spk as $value) : ?>
                            <tr>
                                <td>
                                    <?= SPKTM_Entity::get_image($value->logo); ?>
                                </td>
                                <td><?= $value->patrocinador; ?></td>
                                <td><?= $value->origem_verba .' - '. $value->desc_origem_verba; ?></td>
                                <td><?= $value->grupo; ?></td>
                                <td><?= $value->nivel_patrocinio; ?></td>
                                <td>
                                    <a href="#" class="delete_patrocinador btn btn-danger btn-sm delete" data-nome="<?= $value->patrocinador; ?>" data-id="<?= $value->id; ?>">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            <?php else : ?>
                <div class="card">
                    <div class="card-body">
                        Nenhum dado cadastrado ainda.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>