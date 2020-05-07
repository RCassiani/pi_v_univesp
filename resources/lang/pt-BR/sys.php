<?php

return [
    // ------------------------------------------------------------------
    // Messages
    // ------------------------------------------------------------------

    'msg' => [

        'alert-error'   => 'ERRO',
        'alert-info'    => 'INFORMAÇÃO',
        'alert-success' => 'SUCESSO',
        'alert-warning' => 'ATENÇÃO',

        'permission_denied' => 'Sem permissão para executar essa ação.',

        'not_found' => 'Registro não encontrado.',

        'not_found_all' => 'Nenhum registro encontrado.',

        'success' => [
            'save'   => 'Registro cadastrado com sucesso.',
            'update' => 'Registro atualizado com sucesso.',
            'delete' => 'Registro excluído com sucesso.',

            'update_password' => 'Senha alterada com sucesso.',

            'comment' => [
                'insert'   => 'Comentário adicionado com sucesso.',
                'delete' => 'Comentário excluído com sucesso.',
            ]
        ],

        'error' => [
            'save'   => 'Não foi possível salvar as informações.',
            'update' => 'Não foi possível atualizar as informações.',
            'delete' => 'Não foi possível excluir as informações.',
        ],

        'extrato' => [

            'nenhuma_movimentacao_encontrada' => 'Nenhuma movimentação encontrada.',
            'selecione_um_cliente' => 'Selecione um cliente.',
            'selecione_uma_loja' => 'Selecione uma Loja.',
        ],

    ],

    // ------------------------------------------------------------------
    // Buttons
    // ------------------------------------------------------------------

    'btn' => [

        'new'    => 'Novo',
        'filter' => 'Filtrar',
        'clean'  => 'Limpar',
        'edit'   => 'Editar',
        'delete' => 'Deletar',
        'cancel' => 'Cancelar',
        'save'   => 'Salvar',
        'Anterior' => 'Anterior',
        'Proximo'  => 'Próximo',
        'treat' => 'Tratar',
        'clean_data' => 'Limpar Dados',
        'continue' => 'Continuar',
        'list' => 'Listagem'
    ],

    // ------------------------------------------------------------------
    // Alerts
    // ------------------------------------------------------------------

    'alert' => [

        'delete' => [

            'sa_title'              => 'Tem certeza que deseja excluir este registro?',
            'sa_message'            => 'Essa operação não poderá ser desfeita.',
            'sa_confirmButtonText'  => 'Confirmar',
            'sa_cancelButtonText'   => 'Cancelar',
            'sa_popupTitleCancel'   => 'Operação cancelada com sucesso.',

        ],

        'cancel' => [

            'sa_title'              => 'Tem certeza que deseja cancelar?',
            'sa_message'            => 'O registro não será salvo.',
            'sa_message_edit'       => 'As alterações feitas não serão salvas.',
            'sa_confirmButtonText'  => 'Sim',
            'sa_cancelButtonText'   => 'Não',
            'sa_popupTitleCancel'   => 'Operação cancelada com sucesso.',

        ],

        'fixed_site_shortcuts' => [
            'site A'    => 'www.terra.com.br',
            'Artit'     => 'www.artit.com.br'
        ]
    ],
];
