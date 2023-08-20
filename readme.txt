## Relacionamento do banco de dados

Tabela "patrocinador":

    id (chave primária)
    nome
    email
    logo

Tabela "grupo":

    id (chave primária)
    nome

Tabela "origem_verba":

    id (chave primária)
    nome
    descricao
    grupo_id (chave estrangeira referenciando a tabela "grupo")

Tabela "nivel_patrocinio":

    id (chave primária)
    nome
    origem_verba_id (chave estrangeira referenciando a tabela "origem_verba")

Relacionamentos:

    A tabela "patrocinador" tem um relacionamento de muitos para muitos com a tabela "grupo" por meio de uma tabela de junção chamada "patrocinador_grupo". Essa tabela teria as colunas "patrocinador_id" (chave estrangeira referenciando a tabela "patrocinador") e "grupo_id" (chave estrangeira referenciando a tabela "grupo").
    A tabela "origem_verba" tem um relacionamento de um para muitos com a tabela "grupo". A coluna "grupo_id" na tabela "origem_verba" representa essa relação.
    A tabela "origem_verba" tem um relacionamento de um para muitos com a tabela "nivel_patrocinio". A coluna "origem_verba_id" na tabela "nivel_patrocinio" representa essa relação.