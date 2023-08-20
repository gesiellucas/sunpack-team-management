<form method="post" id="create_form">
    <div id="form_patrocinio" class="container-fluid">
        <header class="d-flex flex-row gap-3 align-items-center">
            <button class="btn btn-outline-primary btn-sm" onClick="window.location.reload();">Voltar</button>
            <h2>Adicionar patrocinador</h2>
        </header>
        <section id="form-group" class="w-50 d-flex gap-2 flex-column p-4">

            <div id="form_new_patrocinador" class="row">
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Novo Patrocinador</label>
                </div>

                <div class="col-6">
                    <input type="text" class="form-control" id="projeto" name="projeto" placeholder="Novo patrocinador">
                </div>
            </div>

            <div id="form_logo" class="row">
                <div class="col-6">
                    Logo
                </div>
                <div class="col-6">
                    <label id="button_logo" for="image-upload" class="form-label bg-dark d-flex align-items-center justify-content-center rounded-2 align-content-center w-100" style="height:30px;">
                        <input type="file" id="image-upload" name="image-upload[]" accept=".png, .PNG, .jpeg, .JPEG, .jpg, .JPG" class="d-none">
                        <p id="text_logo" class="text-center text-white align-self-center m-0 p-0">Enviar Logo</p>
                    </label>
                    <p class="p-0 m-0 name_logo"><small>Selecione imagem</small></p>
                </div>
            </div>

            <hr>

            <div id="form_patrocinador" class="row">
            <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Patrocinador</label>
                </div>
                <div class="col-6">
                    <select class="form-select" aria-label="selecione" id="patrocinador" name="patrocinador" required>
                        <option value="-1" selected>Selecione</option>
                        <?php foreach ($patrocinadores as $value) : ?>
                            <option value="<?= $value->id; ?>"><?= $value->nome; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="form_origem_verba" class="row">
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Origem da verba</label>
                </div>
                <div class="col-6">
                <select class="form-select" aria-label="selecione" id="origem_verba" name="origem_verba" required>
                        <option value="-1" selected>Selecione</option>                    
                        <?php foreach ($origem_verba as $value) : ?>
                            <option value="<?= $value->id; ?>"><?= $value->origem_verba .' - ' .$value->descricao ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="form_grupo" class="row">
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Grupo</label>
                </div>
                <div class="col-6">
                    <select class="form-select" aria-label="selecione" id="grupo" name="grupo" required>
                        <option value="-1" selected>Selecione</option>
                        <?php foreach ($grupos as $value) : ?>
                            <option value="<?= $value->id; ?>"><?= $value->grupo; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="form_nivel_patrocinio" class="row">
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Nivel de Patrocinio</label>
                </div>

                <div class="col-6">
                    <select class="form-select" aria-label="selecione" id="nivel_patrocinio" name="nivel_patrocinio" required>
                        <option value="-1" selected>Selecione</option>
                        <?php foreach ($nivel_patrocinio as $value) : ?>
                            <option value="<?= $value->id; ?>"><?= $value->nome_patrocinio; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div id="form_submit">
                <button type="submit" id="create_patrocinador" class="btn btn-success d-flex flex-row align-items-center gap-2">+ <span>Cadastrar patrocinador</span></button>
            </div>
        </section>
    </div>
</form>